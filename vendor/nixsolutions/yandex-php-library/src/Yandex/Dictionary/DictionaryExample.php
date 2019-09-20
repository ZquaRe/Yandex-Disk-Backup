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
 * Class DictionaryExample
 *
 * @category Yandex
 * @package  Dictionary
 *
 * @author   Nikolay Oleynikov <oleynikovny@mail.ru>
 * @created  07.11.14 20:21
 */
class DictionaryExample extends DictionaryBaseItem
{
    /**
     * @var
     */
    protected $translations = [];

    /**
     *
     */
    public function __construct($example)
    {
        parent::__construct($example);

        if (isset($example->tr)) {
            foreach ($example->tr as $translation) {
                $this->translations[] = $translation->text;
            }
        }
    }

    /**
     *  @return array
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
