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
namespace Yandex\DataSync\Models\Database;

use Yandex\Common\ObjectModel;
use Yandex\DataSync\Models\Database\Delta;

/**
 * Class Deltas
 *
 * @package  Yandex\DataSync\Models\Databas\Delta
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class Deltas extends ObjectModel
{
    /**
     * @param $items
     *
     * @return $this
     */
    public function add($items)
    {
        if (is_array($items)) {
            $this->collection[] = new Delta($items);
        } elseif (is_object($items) && $items instanceof Delta) {
            $this->collection[] = $items;
        }

        return $this;
    }

    /**
     * @return Delta[]
     */
    public function getAll()
    {
        return $this->collection;
    }
}
