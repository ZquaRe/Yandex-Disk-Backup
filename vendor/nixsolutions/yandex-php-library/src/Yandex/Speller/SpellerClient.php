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
namespace Yandex\Speller;

use Yandex\Common\AbstractServiceClient;

/**
 * Class SpellerClient implements Yandex Speller Api
 *
 * @category Yandex
 * @package  Speller
 *
 * @author   Dmitriy Savchenko <login.was.here@gmail.com>
 * @created  06.11.15 11:49
 */
class SpellerClient extends AbstractServiceClient
{
    const CHECK_TEXT_FORMAT_PLAIN = 'plain';
    const CHECK_TEXT_FORMAT_HTML = 'html';

    const OPTION_IGNORE_UPPERCASE = 1;
    const OPTION_IGNORE_DIGITS = 2;
    const OPTION_IGNORE_URLS = 4;
    const OPTION_FIND_REPEAT_WORDS = 8;
    const OPTION_IGNORE_LATIN = 16;
    const OPTION_NO_SUGGEST = 32;
    const OPTION_FLAG_LATIN = 128;
    const OPTION_BY_WORDS = 256;
    const OPTION_IGNORE_CAPITALIZATION = 512;
    const OPTION_IGNORE_ROMAN_NUMERALS = 2048;
    const OPTION_DEFAULT = 0;

    const LANGUAGE_RU = 'ru';
    const LANGUAGE_EN = 'en';
    const LANGUAGE_UK = 'uk';
    const LANGUAGE_DEFAULT = "ru,en";

    const ERROR_UNKNOWN_WORD = 1;
    const ERROR_REPEAT_WORD = 2;
    const ERROR_CAPITALIZATION = 3;
    const ERROR_TOO_MANY_ERRORS = 4;

    protected $serviceDomain = 'speller.yandex.net';

    /**
     * @param string $text
     * @param array $params
     *
     * @return mixed|\SimpleXMLElement
     *
     * @throws \Yandex\Common\Exception\MissedArgumentException
     * @throws \Yandex\Common\Exception\ProfileNotFoundException
     * @throws \Yandex\Common\Exception\YandexException
     */
    public function checkText($text, array $params = [])
    {
        $query = $this->mergeParams($this->getDefaultParams(), $params);

        $query['text'] = $text;

        $response = $this->sendRequest(
            'POST',
            '/services/spellservice.json/checkText',
            [
                'form_params' => $query
            ]
        );

        if (!empty($query['callback'])) {
            return (string) $response->getBody();
        }

        return $this->getDecodedBody($response->getBody());
    }

    /**
     * @param string[] $texts
     * @param array $params
     *
     * @return mixed|\SimpleXMLElement
     *
     * @throws \Yandex\Common\Exception\MissedArgumentException
     * @throws \Yandex\Common\Exception\ProfileNotFoundException
     * @throws \Yandex\Common\Exception\YandexException
     */
    public function checkTexts(array $texts, array $params = [])
    {
        $mergedParams = $this->mergeParams($this->getDefaultParams(), $params);

        $query = [];
        foreach ($texts as $text) {
            $query[] = 'text=' . rawurlencode($text);
        }

        foreach ($mergedParams as $key => $value) {
            if (!empty($value)) {
                $query[] = $key . '=' . rawurlencode($value);
            }
        }

        $response = $this->sendRequest(
            'POST',
            '/services/spellservice.json/checkTexts',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => join('&', $query)
            ]
        );

        if (!empty($mergedParams['callback'])) {
            return (string) $response->getBody();
        }

        return $this->getDecodedBody($response->getBody());
    }

    /**
     * @return array
     */
    protected function getDefaultParams()
    {
        return [
            'lang' => self::LANGUAGE_DEFAULT,
            'options' => self::OPTION_DEFAULT,
            'format' => self::CHECK_TEXT_FORMAT_PLAIN,
            'callback' => null,
            'ie' => 'utf-8'
        ];
    }

    /**
     * @param $defaultParams
     * @param $params
     * @return array
     */
    protected function mergeParams($defaultParams, $params)
    {
        return array_replace_recursive($defaultParams, $params);
    }
}
