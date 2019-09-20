<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */
namespace Yandex\DataSync\Models;

use Yandex\Common\ObjectModel;
use Yandex\DataSync\Models\Database;

/**
 * Class Databases
 *
 * @package  Yandex\DataSync\Models
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class Databases extends ObjectModel
{
    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * @return Database
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param $items
     *
     * @return $this
     */
    public function add($items)
    {
        if (is_array($items)) {
            $this->collection[] = new Database($items);
        } elseif (is_object($items) && $items instanceof Database) {
            $this->collection[] = $items;
        }

        return $this;
    }

    /**
     * @return Database[]
     */
    public function getAll()
    {
        return $this->collection;
    }
}
