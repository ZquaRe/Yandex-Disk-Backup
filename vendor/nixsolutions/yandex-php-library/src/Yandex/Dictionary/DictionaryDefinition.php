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
 * Class DictionaryDefinition
 *
 * @category Yandex
 * @package  Dictionary
 *
 * @author   Nikolay Oleynikov <oleynikovny@mail.ru>
 * @created  07.11.14 19:55
 */
class DictionaryDefinition extends DictionaryBaseItem
{
    /**
     * @var
     */
    protected $transcription;

    /**
     * @var
     */
    protected $translations = [];

    /**
     *
     */
    public function __construct($definition)
    {
        parent::__construct($definition);

        if (isset($definition->ts)) {
            $this->transcription = $definition->ts;
        }

        if (isset($definition->tr)) {
            foreach ($definition->tr as $translation) {
                $this->translations[] = new DictionaryTranslation($translation);
            }
        }
    }

    /**
     *  @return string
     */
    public function getTranscription()
    {
        return $this->transcription;
    }

    /**
     *  @return array
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
