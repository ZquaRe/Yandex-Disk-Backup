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
use Yandex\DataSync\Models\Database\Delta\Record;

/**
 * Class Records
 *
 * @package  Yandex\DataSync\Models\Databas\Delta
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class Records extends ObjectModel
{
    /**
     * @param $items
     *
     * @return $this
     */
    public function add($items)
    {
        if (is_array($items)) {
            $this->collection[] = new Record($items);
        } elseif (is_object($items) && $items instanceof Record) {
            $this->collection[] = $items;
        }

        return $this;
    }

    /**
     * @return Record[]
     */
    public function getAll()
    {
        return $this->collection;
    }
}
