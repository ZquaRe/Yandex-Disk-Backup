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
namespace Yandex\SafeBrowsing;

use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\NotFoundException;
use Yandex\Common\Exception\UnauthorizedException;

/**
 * Class SafeBrowsingClient
 *
 * @category Yandex
 * @package SafeBrowsing
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  31.01.14 17:32
 */
class SafeBrowsingClient extends AbstractServiceClient
{
    /**
     * @var string
     */
    protected $serviceDomain = 'sba.yandex.net';

    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $appVer = '2.3';

    /**
     * @var string
     */
    protected $pVer = '2.3';

    /**
     * @var array
     */
    protected $malwareShavars = [
        'ydx-malware-shavar',
        'ydx-phish-shavar',
        'goog-malware-shavar',
        'goog-phish-shavar'
    ];

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey = '')
    {
        $this->setApiKey($apiKey);
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param array $malwareShavars
     */
    public function setMalwareShavars($malwareShavars)
    {
        $this->malwareShavars = $malwareShavars;
    }

    /**
     * @return array
     */
    public function getMalwareShavars()
    {
        return $this->malwareShavars;
    }

    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . $resource . '?client=api&apikey=' . $this->apiKey . '&appver=' . $this->appVer . '&pver=' . $this->pVer;
    }

    /**
     * Get url to service Lookup resource with parameters
     *
     * @param string $url
     * @return string
     */
    public function getLookupUrl($url = '')
    {
        $pVer = '3.5'; //Specific version
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . 'lookup?client=api&apikey=' . $this->apiKey . '&pver=' . $pVer . '&url=' . $url;
    }

    /**
     * Get url to service Check Adult  resource with parameters
     *
     * @param string $url
     * @return string
     */
    public function getCheckAdultUrl($url = '')
    {
        $pVer = '4.0'; //Specific version
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . 'cp?client=api&pver=' . $pVer . '&url=' . $url;
    }

    /**
     * Sends a request
     *
     * @param string              $method  HTTP method
     * @param string $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @return Response
     *
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws SafeBrowsingException
     * @throws NotFoundException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            if ($code === 401) {
                throw new UnauthorizedException($message);
            }

            if ($code === 404) {
                throw new NotFoundException($message);
            }

            throw new SafeBrowsingException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }

    /**
     * @param string $bodyString
     * @see https://developers.google.com/safe-browsing/developers_guide_v2#HTTPRequestForHashes
     * @return array
     */
    public function checkHash($bodyString = '')
    {
        $resource = 'gethash';

        $response = $this->sendRequest(
            'POST',
            $this->getServiceUrl($resource),
            [
                'body' => $bodyString
            ]
        );

        return [
            'code' => $response->getStatusCode(),
            'data' => $response->getBody()
        ];
    }

    /**
     * @param string $bodyString
     * @see https://developers.google.com/safe-browsing/developers_guide_v2#HTTPRequestForData
     * @return array
     */
    public function getChunks($bodyString = '')
    {
        $resource = 'downloads';

        $response = $this->sendRequest(
            'POST',
            $this->getServiceUrl($resource),
            [
                'body' => $bodyString
            ]
        );

        return [
            'code' => $response->getStatusCode(),
            'data' => $response->getBody()
        ];
    }

    /**
     * @see https://developers.google.com/safe-browsing/developers_guide_v2#HTTPRequestForList
     * @return array
     */
    public function getShavarsList()
    {
        $resource = 'list';
        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));
        return explode("\n", trim($response->getBody()));
    }

    /**
     * @param string $url
     * @return string|false
     */
    public function lookup($url)
    {
        $response = $this->sendRequest('GET', $this->getLookupUrl($url));
        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        }
        return false;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function checkAdult($url)
    {
        $response = $this->sendRequest('GET', $this->getCheckAdultUrl($url));
        if ($response->getBody()->getContents() === 'adult') {
            return true;
        }
        return false;
    }

    /**
     * @param string $url
     * @return string
     */
    public function getChunkByUrl($url)
    {
        $client = $this->getClient();

        $host = parse_url($url, PHP_URL_HOST);
        $headers = $client->getConfig('headers');
        if ($host) {
            $headers['Host'] = $host;
        }

        $response = $this->sendRequest(
            'GET',
            $url,
            [
                'headers' => $headers
            ]
        );
        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @return bool|array
     * @throws \Exception
     */
    public function searchUrl($url)
    {
        $hashes = $this->getHashesByUrl($url);

        $clientMalwareShavars = $this->getMalwareShavars();

        foreach ($hashes as $hash) {
            $prefixPack = pack("H*", $hash['prefix']);
            $prefixSize = strlen($hash['prefix']) / 2;
            $length = count($prefixPack) * $prefixSize;
            $bodyString = "$prefixSize:$length\n" . $prefixPack;
            $result = $this->checkHash($bodyString);

            if ($result['code'] == 200 && !empty($result['data'])) {
                $responseMalwareShavars = $this->getFullHashes($result['data']);
                foreach ($responseMalwareShavars as $shavarName => $fullHashes) {
                    if (in_array($shavarName, $clientMalwareShavars)) {
                        foreach ($fullHashes as $fullHash) {
                            if ($fullHash === $hash['full']) {
                                return $hash;
                            }
                        }
                    }
                }
            } elseif ($result['code'] == 204 && strlen($result['data']) == 0) {
                //204 Means no match
            } else {
                throw new SafeBrowsingException(
                    "ERROR: Invalid response returned from Safe Browsing ({$result['code']})"
                );
            }
        }
        return false;
    }

    /**
     * @param string $responseData
     * @return array
     */
    public function getFullHashes($responseData)
    {
        $hashesData = [];
        while (strlen($responseData) > 0) {
            $splithead = explode("\n", $responseData, 2);

            list($listname, $malwareId, $length) = explode(':', $splithead[0]);
            $data = bin2hex(substr($splithead[1], 0, $length));
            while (strlen($data) > 0) {
                $hashesData[$listname][$malwareId] = substr($data, 0, 64);
                $data = substr($data, 64);
            }
            $responseData = substr($splithead[1], $length);
        }
        return $hashesData;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getHashesByUrl($url)
    {
        //Remove line feeds, return carriages, tabs, vertical tabs
        $url = trim(str_replace(["\x09", "\x0A", "\x0D", "\x0B"], '', $url));
        //extract hostname
        $parts = parse_url(strtolower($url));
        if (!isset($parts['scheme'])) {
            //Add default scheme
            $parts = parse_url('http://' . $url);
        }
        $host = $parts['host'];

        //const
        $maxCountDomains = 5;

        //Exact hostname in the url
        $hosts = [];
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $hosts[] = $host . '/';
        } else {
            $domains = explode('.', $host);
            $countDomains = count($domains);
            if ($countDomains > $maxCountDomains) {
                $domains = array_slice($domains, $countDomains - $maxCountDomains, $maxCountDomains);
            }

            while (count($domains) > 1) {
                $hosts[] = implode('.', $domains) . '/';
                array_shift($domains);
            }
        }

        $hosts = array_unique($hosts);
        return $this->getHashesByHosts($hosts);
    }

    /**
     * @param array $hosts
     * @return array
     */
    private function getHashesByHosts($hosts)
    {
        $hashes = [];
        foreach ($hosts as $host) {
            $hashes[] = $this->getHashByHost($host);
        }
        return $hashes;
    }

    /**
     * @param string $host
     * @return array
     */
    private function getHashByHost($host)
    {
        //SHA-256
        $hash = hash('sha256', $host);
        return ["host" => $host, "prefix" => substr($hash, 0, 8), "full" => $hash];
    }

    /**
     * @param array $savedChunks
     * @return string
     * @throws SafeBrowsingException
     */
    private function prepareDownloadsRequest($savedChunks = [])
    {
        $body = '';
        if (count($this->malwareShavars) < 1) {
            throw new SafeBrowsingException(
                'ERROR: Empty malware shavars'
            );
        }

        foreach ($this->malwareShavars as $malwareShavar) {
            if ($savedChunks && isset($savedChunks[$malwareShavar])) {
                //ydx-malware-shavar;s:18888-19061:a:21355-21687

                $range = '';
                if (isset($savedChunks[$malwareShavar]['removed'])
                    && isset($savedChunks[$malwareShavar]['removed']['min'])
                    && isset($savedChunks[$malwareShavar]['removed']['max'])
                    && $savedChunks[$malwareShavar]['removed']['min'] > 0
                    && $savedChunks[$malwareShavar]['removed']['max'] > 0
                ) {
                    $range .= 's:' . $savedChunks[$malwareShavar]['removed']['min']
                        . '-' . $savedChunks[$malwareShavar]['removed']['max'];
                }

                if (isset($savedChunks[$malwareShavar]['added'])
                    && isset($savedChunks[$malwareShavar]['added']['min'])
                    && isset($savedChunks[$malwareShavar]['added']['max'])
                    && $savedChunks[$malwareShavar]['added']['min'] > 0
                    && $savedChunks[$malwareShavar]['added']['max'] > 0
                ) {
                    if ($range) {
                        $range .= ':';
                    }
                    $range .= 'a:' . $savedChunks[$malwareShavar]['added']['min']
                        . '-' . $savedChunks[$malwareShavar]['added']['max'];

                    $body .= $malwareShavar . ';' . $range . "\n";
                }
            } else {
                $body .= $malwareShavar . ";\n";
            }
        }
        return $body;
    }

    /**
     * Get malwares prefixes data
     *
     * @param array $savedChunks
     * @return array
     * @throws SafeBrowsingException
     */
    public function getMalwaresData($savedChunks = [])
    {
        $body = $this->prepareDownloadsRequest($savedChunks);

        $response = $this->getChunks($body);
        $result = [];

        $response['data'] = (string) $response['data'];

        if (substr_count($response['data'], 'r:pleasereset') > 0) {
            return 'pleasereset';
        }

        $chunksList = [];
        if (substr_count($response['data'], 'i:') < 1) {
            throw new SafeBrowsingException(
                'ERROR: Incorrect data in list'
            );
        }

        $shavarsData = explode('i:', $response['data']);
        unset($shavarsData[0]);
        foreach ($shavarsData as $shavar) {
            $listData = explode("\n", trim($shavar));
            $chunksList[array_shift($listData)] = $listData;
        }
        foreach ($chunksList as $listName => $list) {
            $chunksByList = [];
            foreach ($list as $value) {
                if (substr_count($value, "u:") > 0) {
                    try {
                        $chunkData = $this->getChunkByUrl('http://' . trim(str_replace('u:', '', $value)));
                        $processed = $this->parseChunk($chunkData);
                        $chunksByList[$processed['type']][$processed['chunk_num']] = $processed['prefixes'];
                    } catch (NotFoundException $e) {
                        continue;
                    }
                } elseif (substr_count($value, "ad:") > 0) {
                    if (substr_count($value, ',') > 0) {
                        $ranges = explode(',', trim(str_replace("ad:", "", $value)));
                        $rangesData = [];
                        foreach ($ranges as $range) {
                            list($min, $max) = explode('-', $range);
                            $rangesData[] = [
                                'min' => $min,
                                'max' => $max
                            ];
                        }
                        $chunksByList['delete_added_ranges'] = $rangesData;
                    } else {
                        $range = trim(str_replace("sd:", "", $value));
                        list($min, $max) = explode('-', $range);
                        $chunksByList['delete_added_ranges'] = [
                            [
                                'min' => $min,
                                'max' => $max
                            ]
                        ];
                    }
                } elseif (substr_count($value, "sd:") > 0) {
                    if (substr_count($value, ',') > 0) {
                        $ranges = explode(',', trim(str_replace("sd:", "", $value)));
                        $rangesData = [];
                        foreach ($ranges as $range) {
                            list($min, $max) = explode('-', $range);
                            $rangesData[] = [
                                'min' => $min,
                                'max' => $max
                            ];
                        }
                        $chunksByList['delete_removed_ranges'] = $rangesData;
                    } else {
                        $range = trim(str_replace("sd:", "", $value));
                        list($min, $max) = explode('-', $range);
                        $chunksByList['delete_removed_ranges'] = [
                            [
                                'min' => $min,
                                'max' => $max
                            ]
                        ];
                    }
                }
            }

            $result[$listName] = $chunksByList;
        }

        return $result;
    }

    /**
     * Parsing chunk
     *
     * @param string $data
     * @return array
     * @throws SafeBrowsingException
     */
    private function parseChunk($data)
    {
        $data = trim($data);
        if (strlen($data) === 0) {
            throw new SafeBrowsingException(
                'ERROR: Incorrect chunk data "' . $data . '"'
            );
        }

        $splitHead = explode("\n", $data, 2);
        $chunkInfo = explode(':', $splitHead[0]);
        list($type, $chunkNum, $hashLen, $chunkLen) = $chunkInfo;

        if ($chunkLen > 0) {
            //Convert to hex for easy processing
            //First get chunkData according to length
            $chunkData = bin2hex(substr($splitHead[1], 0, $chunkLen));
        } else {
            //No ChunkData, Still Parse
            $chunkData = '';
        }

        if ($type == 'a') {
            $prefixes = [];
            while (strlen($chunkData) > 0) {
                $prefixes[] = substr($chunkData, 0, 8);
                $count = hexdec(substr($chunkData, 8, 2));
                $chunkData = substr($chunkData, 10);
                for ($i = 0; $i < $count; $i++) {
                    $chunkData = substr($chunkData, (($hashLen * 2)));
                }
            }

            return [
                'type' => 'added',
                'chunk_num' => $chunkNum,
                'prefixes' => $prefixes
            ];
        } elseif ($type == 's') {
            $prefixes = [];
            while (strlen($chunkData) > 0) {
                $prefixes[] = substr($chunkData, 0, 8);
                $count = hexdec(substr($chunkData, 8, 2));
                $chunkData = substr($chunkData, 10);
                if ($count > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $chunkData = substr($chunkData, (($hashLen * 2) + 8));
                    }
                } else {
                    $chunkData = substr($chunkData, 8);
                }
            }

            return [
                'type' => 'removed',
                'chunk_num' => $chunkNum,
                'prefixes' => $prefixes
            ];
        } else {
            throw new SafeBrowsingException(
                'ERROR: In chunkNum "' . $chunkNum . '" incorrect type "' . $type . '"'
            );
        }
    }
}
