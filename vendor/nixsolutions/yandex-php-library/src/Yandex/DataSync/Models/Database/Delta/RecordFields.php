<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\DataSync\Models\Database\Delta;

use Yandex\Common\ObjectModel;
use Yandex\DataSync\Models\Database\Delta\RecordField;

/**
 * Class RecordFields
 *
 * @package  Yandex\DataSync\Models\Databas\Delta
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class RecordFields extends ObjectModel
{
    /**
     * @param $items
     *
     * @return $this
     */
    public function add($items)
    {
        if (is_array($items)) {
            $this->collection[] = new RecordField($items);
        } elseif (is_object($items) && $items instanceof RecordField) {
            $this->collection[] = $items;
        }

        return $this;
    }

    /**
     * @return RecordField[]
     */
    public function getAll()
    {
        return $this->collection;
    }
}
