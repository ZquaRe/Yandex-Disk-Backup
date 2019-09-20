<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Disk;

use Psr\Http\Message\UriInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\AbstractServiceClient;
use Yandex\Disk\Exception\DiskRequestException;

/**
 * Class DiskClient
 *
 * @category Yandex
 * @package Disk
 *
 * @author   Alexander Mitsura <mitsuraa@gmail.com>
 * @created  07.10.13 12:35
 *
 * @see https://tech.yandex.com/disk/doc/dg/concepts/api-methods-docpage/
 */
class DiskClient extends AbstractServiceClient
{
    const DECODE_TYPE_DEFAULT = self::DECODE_TYPE_XML;

    /**
     * @var string
     */
    private $version = 'v1';

    /**
     * @var string
     */
    protected $serviceDomain = 'webdav.yandex.ru';

    /**
     * @param string $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @inheritdoc
     */
    public function getServiceUrl($resource = '')
    {
        return parent::getServiceUrl($resource) . '/' . $this->version;
    }

    /**
     * @param $path
     * @return string
     */
    public function getRequestUrl($path)
    {
        return parent::getServiceUrl() . $path;
    }

    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }

    /**
     * Sends a request
     *
     * @param string              $method  HTTP method
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @throws \Exception|\GuzzleHttp\Exception\ClientException
     * @return Response
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

           /* throw new DiskRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
            */
        }

        return @$response;
    }

    /**
     * @param string $path
     * @return bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/mkcol-docpage/
     */
    public function createDirectory($path = '')
    {
        return (bool) $this->sendRequest('MKCOL', $path);
    }

    /**
     * @param string $path
     * @param null $offset
     * @param null $amount
     * @return array
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/propfind_contains-request-docpage/
     */
    public function directoryContents($path = '/', $offset = null, $amount = null)
    {
        $response = $this->sendRequest(
            'PROPFIND',
            $path,
            [
                'headers' => [
                    'Depth' => '1'
                ],
                'query' => [
                    'offset' => $offset,
                    'amount' => $amount
                ]
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $contents = [];
        foreach ($decodedResponseBody->children('DAV:') as $element) {
            array_push(
                $contents,
                [
                    'href' => $element->href->__toString(),
                    'status' => $element->propstat->status->__toString(),
                    'creationDate' => $element->propstat->prop->creationdate->__toString(),
                    'lastModified' => $element->propstat->prop->getlastmodified->__toString(),
                    'displayName' => $element->propstat->prop->displayname->__toString(),
                    'contentLength' => $element->propstat->prop->getcontentlength->__toString(),
                    'resourceType' => $element->propstat->prop->resourcetype->collection ? 'dir' : 'file',
                    'contentType' => $element->propstat->prop->getcontenttype->__toString()
                ]
            );
        }
        return $contents;
    }

    /**
     * @return array
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/propfind_space-request-docpage/
     */
    public function diskSpaceInfo()
    {
        $body = '<?xml version="1.0" encoding="utf-8" ?><D:propfind xmlns:D="DAV:">
            <D:prop><D:quota-available-bytes/><D:quota-used-bytes/></D:prop></D:propfind>';

        $response = $this->sendRequest(
            'PROPFIND',
            '/',
            [
                'headers' => [
                    'Depth' => '0'
                ],
                'body' => $body
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $info = (array) $decodedResponseBody->children('DAV:')->response->propstat->prop;
        return [
            'usedBytes' => $info['quota-used-bytes'],
            'availableBytes' => $info['quota-available-bytes']
        ];
    }

    /**
     * @param string $path
     * @param string $property
     * @param string $value
     * @param string $namespace
     * @return bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/proppatch-docpage/
     */
    public function setProperty($path = '', $property = '', $value = '', $namespace = 'default:namespace')
    {
        if (!empty($property) && !empty($value)) {
            $body = '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns="DAV:" xmlns:u="'
                . $namespace . '"><set><prop><u:' . $property . '>' . $value . '</u:'
                . $property . '></prop></set></propertyupdate>';

            $response = $this->sendRequest(
                'PROPPATCH',
                $path,
                [
                    'headers' => [
                        'Content-Length' => strlen($body),
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'body' => $body
                ]
            );

            $decodedResponseBody = $this->getDecodedBody($response->getBody());

            $resultStatus = $decodedResponseBody->children('DAV:')->response->propstat->status;
            if (strpos($resultStatus, '200 OK')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $path
     * @param string $property
     * @param string $namespace
     * @return string|false
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/propfind_property-request-docpage/
     */
    public function getProperty($path = '', $property = '', $namespace = 'default:namespace')
    {
        if (!empty($property)) {
            $body = '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns="DAV:"><prop><' . $property
                . ' xmlns="' . $namespace . '"/></prop></propfind>';

            $response = $this->sendRequest(
                'PROPFIND',
                $path,
                [
                    'headers' => [
                        'Depth' => '1',
                        'Content-Length' => strlen($body),
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'body' => $body
                ]
            );

            $decodedResponseBody = $this->getDecodedBody($response->getBody());

            $resultStatus = $decodedResponseBody->children('DAV:')->response->propstat->status;
            if (strpos($resultStatus, '200 OK')) {
                return (string)$decodedResponseBody->children('DAV:')->response->propstat->prop->children();
            }
        }

        return false;
    }

    /**
     * @return string
     * @see https://tech.yandex.com/disk/doc/dg/reference/userinfo-docpage/
     */
    public function getLogin()
    {
        $response = $this->sendRequest(
            'GET',
            '/?userinfo'
        );
        $result = explode(":", $response->getBody());
        array_shift($result);
        return implode(':', $result);
    }

    /**
     * @param string $path
     * @return array
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/get-docpage/
     */
    public function getFile($path = '')
    {
        $response = $this->sendRequest('GET', $path);

        $result = [];
        foreach ($response->getHeaders() as $key => $value) {
            $result['headers'][strtolower($key)] = $value[0];
        }
        $result['body'] = $response->getBody();
        return $result;
    }

    /**
     * @param string $path
     * @param string $destination
     * @param string $name
     * @return string|false
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/get-docpage/
     */
    public function downloadFile($path = '', $destination = '', $name = '')
    {
        $response = $this->sendRequest('GET', $path);
        if ($name === '' && $response->getHeader('Content-Disposition')
            && is_array($response->getHeader('Content-Disposition'))
            && count($response->getHeader('Content-Disposition')) > 0
        ) {
            $matchResults = [];
            preg_match(
                "/.*?filename=\"(.*?)\".*?/",
                $response->getHeader('Content-Disposition')[0],
                $matchResults
            );
            $name = urldecode($matchResults[1]);
        }

        $file = $destination . $name;

        $result = file_put_contents($file, $response->getBody()) ? $file : false;

        return $result;
    }

    /**
     * @param string $path
     * @param array $file
     * @param array $extraHeaders
     * @return Response
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/put-docpage/
     */
    public function uploadFile($path = '', $file = null, $extraHeaders = null)
    {
        if (file_exists($file['path'])) {
            $headers = [
                'Content-Length' => (string)$file['size']
            ];
            $finfo = finfo_open(FILEINFO_MIME);
            $mime = finfo_file($finfo, $file['path']);
            $parts = explode(";", $mime);
            $headers['Content-Type'] = $parts[0];
            $headers['Etag'] = md5_file($file['path']);
            $headers['Sha256'] = hash_file('sha256', $file['path']);
            $headers = isset($extraHeaders) ? array_merge($headers, $extraHeaders) : $headers;

            return $this->sendRequest(
                'PUT',
                $path . $file['name'],
                [
                    'headers' => $headers,
                    'body' => fopen($file['path'], 'rb'),
                    'expect' => true
                ]
            );
        }
    }

    /**
     * @param $path
     * @param $size
     * @return array
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/preview-docpage/
     */
    public function getImagePreview($path, $size)
    {
        $response = $this->sendRequest(
            'GET',
            $path,
            [
                'query' => [
                    'preview' => '',
                    'size' => $size
                ]
            ]
        );

        $result = [];
        foreach ($response->getHeaders() as $key => $value) {
            $result['headers'][strtolower($key)] = $value[0];
        }

        $result['body'] = $response->getBody();
        return $result;
    }

    /**
     * @param string $target
     * @param string $destination
     * @return bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/copy-docpage/
     */
    public function copy($target = '', $destination = '')
    {
        return (bool) $this->sendRequest(
            'COPY',
            $target,
            [
                'headers' => [
                    'Destination' => $destination
                ]
            ]
        );
    }

    /**
     * @param string $path
     * @param string $destination
     * @return bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/move-docpage/
     */
    public function move($path = '', $destination = '')
    {
        return (bool) $this->sendRequest(
            'MOVE',
            $path,
            [
                'headers' => [
                    'Destination' => $destination
                ]
            ]
        );
    }

    /**
     * @param string $path
     * @return bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/delete-docpage/
     */
    public function delete($path = '')
    {
        return (bool) $this->sendRequest('DELETE', $path);
    }

    /**
     * @param string $path
     * @return string
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/publish-docpage/#publish-s_1
     * @see https://tech.yandex.com/disk/doc/dg/reference/publish-docpage/#publish-s
     */
    public function startPublishing($path = '')
    {
        $body = '<propertyupdate xmlns="DAV:"><set><prop>
            <public_url xmlns="urn:yandex:disk:meta">true</public_url>
            </prop></set></propertyupdate>';

        $response = $this->sendRequest(
            'PROPPATCH',
            $path,
            [
                'headers' => [
                    'Content-Length' => strlen($body)
                ],
                'body' => $body
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $publicUrl = $decodedResponseBody->children('DAV:')->response->propstat->prop->children()->public_url;
        return (string)$publicUrl;
    }

    /**
     * @param string $path
     * @return void
     *
     * @see @https://tech.yandex.com/disk/doc/dg/reference/publish-docpage/#unpublish
     */
    public function stopPublishing($path = '')
    {
        $body = '<propertyupdate xmlns="DAV:"><remove><prop>
            <public_url xmlns="urn:yandex:disk:meta" />
            </prop></remove></propertyupdate>';

        $this->sendRequest(
            'PROPPATCH',
            $path,
            [
                'headers' => [
                    'Content-Length' => strlen($body)
                ],
                'body' => $body
            ]
        );
    }

    /**
     * @param string $path
     * @return string|bool
     *
     * @see https://tech.yandex.com/disk/doc/dg/reference/publish-docpage/#unpublish_1
     */
    public function checkPublishing($path = '')
    {
        $body = '<propfind xmlns="DAV:"><prop><public_url xmlns="urn:yandex:disk:meta"/></prop></propfind>';

        $response = $this->sendRequest(
            'PROPFIND',
            $path,
            [
                'headers' => [
                    'Content-Length' => strlen($body),
                    'Depth' => '0'
                ],
                'body' => $body
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $propArray = (array) $decodedResponseBody->children('DAV:')->response->propstat->prop->children();
        return empty($propArray['public_url']) ? (bool)false : (string)$propArray['public_url'];
    }
}
