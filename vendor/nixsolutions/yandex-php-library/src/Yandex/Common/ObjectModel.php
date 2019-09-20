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
namespace Yandex\Common;

/**
 * Class ObjectModel
 * @package Yandex\Common
 */
class ObjectModel extends Model implements \Iterator, \Countable
{
    protected $collection = [];
    protected $innerCounter = -1;

    public function current()
    {
        if (is_array(current($this->collection))) {
            return new ObjectModel(current($this->collection));
        }

        return current($this->collection);
    }

    public function next()
    {
        $this->innerCounter++;
        return next($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function valid()
    {
        return $this->innerCounter < count($this->collection);
    }

    public function rewind()
    {
        $this->innerCounter = 0;
        reset($this->collection);
        return;
    }

    public function count()
    {
        return count($this->collection);
    }
}
