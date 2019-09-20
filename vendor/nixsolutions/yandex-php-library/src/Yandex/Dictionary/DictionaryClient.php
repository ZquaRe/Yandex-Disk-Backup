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
namespace Yandex\Dictionary;

use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Dictionary\Exception\DictionaryException;

/**
 * Class DictionaryClient implements Yandex Dictionary protocol
 *
 * @category Yandex
 * @package  Dictionary
 *
 * @author   Nikolay Oleynikov <oleynikovny@mail.ru>
 * @created  07.11.14 18:43
 */
class DictionaryClient extends AbstractServiceClient
{
    /**
     * @const
     */
    const FAMILY_FLAG = 0x0001;

    /**
     * @const
     */
    const MORPHO_FLAG = 0x0004;

    /**
     * @const
     */
    const POSITION_FILTER_FLAG = 0x0008;

    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $serviceDomain = 'dictionary.yandex.net';

    /**
     * @var
     */
    protected $uiLanguage = 'en';

    /**
     * @var
     */
    protected $translateFrom = 'en';

    /**
     * @var
     */
    protected $translateTo = 'en';

    /**
     * @var
     */
    protected $flags = 0;

    /**
     * @param string $apiKey API key
     */
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param boolean $enabled optional boolean
     *
     * @return $this
     */
    public function setFamilyFlag($enabled = true)
    {
        $this->setFlag(self::FAMILY_FLAG, $enabled);

        return $this;
    }

    /**
     * @param boolean $enabled optional boolean
     *
     * @return $this
     */
    public function setMorphoFlag($enabled = true)
    {
        $this->setFlag(self::MORPHO_FLAG, $enabled);

        return $this;
    }

    /**
     * @param boolean $enabled optional boolean
     *
     * @return $this
     */
    public function setPositionFilterFlag($enabled = true)
    {
        $this->setFlag(self::POSITION_FILTER_FLAG, $enabled);

        return $this;
    }

    /**
     * @return integer
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param integer $flag
     * @param boolean $enabled optional boolean
     *
     * @return $this
     */
    public function setFlag($flag, $enabled = true)
    {
        if ($enabled) {
            $this->flags |= $flag;
        } else {
            $this->flags &= ~$flag;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $uiLanguage
     *
     * @return $this
     */
    public function setUiLanguage($uiLanguage)
    {
        $this->uiLanguage = $uiLanguage;

        return $this;
    }

    /**
     * @return string
     */
    public function getUiLanguage()
    {
        return $this->uiLanguage;
    }

    /**
     * @param string $translateFrom
     *
     * @return $this
     */
    public function setTranslateFrom($translateFrom)
    {
        $this->translateFrom = $translateFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslateFrom()
    {
        return $this->translateFrom;
    }

    /**
     * @param $translateTo
     *
     * @return $this
     */
    public function setTranslateTo($translateTo)
    {
        $this->translateTo = $translateTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslateTo()
    {
        return $this->translateTo;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->translateFrom . '-' . $this->translateTo;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function getLookupUrl($text)
    {
        $resource = 'api/v1/dicservice.json/lookup';
        $query = http_build_query(
            [
                'key' => $this->getApiKey(),
                'lang' => $this->getLanguage(),
                'ui' => $this->getUiLanguage(),
                'flags' => $this->getFlags(),
                'text' => $text
            ]
        );
        $url = $this->getServiceUrl($resource) . '?' . $query;

        return $url;
    }

    /**
     * @return string
     */
    public function getGetLanguagesUrl()
    {
        $resource = 'api/v1/dicservice.json/getLangs';
        $query = http_build_query(
            [
                'key' => $this->getApiKey()
            ]
        );
        $url = $this->getServiceUrl($resource) . '?' . $query;

        return $url;
    }

    /**
     * Looks up a text in the dictionary
     *
     * @param string $text
     *
     * @return array|bool
     *
     * @throws DictionaryException
     * @throws ForbiddenException
     */
    public function lookup($text)
    {
        $url = $this->getLookupUrl($text);
        $response = $this->sendRequest(
            'GET',
            $url,
            [
                'version' => $this->serviceProtocolVersion
            ]
        );
        if ($response->getStatusCode() === 200) {
            $definitions = $this->parseLookupResponse($response);
            return $definitions;
        }
        return false;
    }

    /**
     * @return array|bool
     *
     * @throws DictionaryException
     * @throws ForbiddenException
     */
    public function getLanguages()
    {
        $url = $this->getGetLanguagesUrl();
        $response = $this->sendRequest(
            'GET',
            $url,
            [
                'version' => $this->serviceProtocolVersion
            ]
        );
        if ($response->getStatusCode() === 200) {
            $languages = $this->parseGetLanguagesResponse($response);
            return $languages;
        }
        return false;
    }

    /**
     * @param Response $response
     *
     * @return array
     */
    protected function parseLookupResponse(Response $response)
    {
        $responseData = $response->getBody();
        $responseObject = json_decode($responseData);
        $definitionsData = $responseObject->def;
        $definitions = [];
        foreach ($definitionsData as $definitionData) {
            $definitions[] = new DictionaryDefinition($definitionData);
        }
        return $definitions;
    }

    /**
     * @param Response $response
     *
     * @return array
     */
    protected function parseGetLanguagesResponse(Response $response)
    {
        $responseBody = $response->getBody();
        $responseData = json_decode($responseBody);
        $languages = [];
        foreach ($responseData as $language) {
            $translation = explode('-', $language);
            $from = $translation[0];
            $to = $translation[1];
            $languages[] = [$from,$to];
        }
        return $languages;
    }

    /**
     * Sends a request
     *
     * @param string              $method  HTTP method
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @return Response
     *
     * @throws ForbiddenException
     * @throws DictionaryException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
            $code = $response->getStatusCode();
            $message = $response->getReasonPhrase();

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            throw new DictionaryException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }
}
