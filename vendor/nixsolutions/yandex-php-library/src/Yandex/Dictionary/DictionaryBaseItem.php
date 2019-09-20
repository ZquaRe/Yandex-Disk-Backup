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

/**
 * Class DictionaryBaseItem
 *
 * @category Yandex
 * @package  Dictionary
 *
 * @author   Nikolay Oleynikov <oleynikovny@mail.ru>
 * @created  07.11.14 20:38
 */
class DictionaryBaseItem
{
    /**
     * @var
     */
    protected $text;

    /**
     * @var
     */
    protected $partOfSpeech;

    /**
     *
     */
    public function __construct($item)
    {
        if (isset($item->text)) {
            $this->text = $item->text;
        }

        if (isset($item->pos)) {
            $this->partOfSpeech = $item->pos;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getText();
    }

    /**
     *  @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     *  @return string
     */
    public function getPartOfSpeech()
    {
        return $this->partOfSpeech;
    }
}
