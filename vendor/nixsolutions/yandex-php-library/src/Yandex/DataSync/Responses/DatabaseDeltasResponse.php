<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */
namespace Yandex\DataSync\Responses;

use Yandex\Common\Model;
use Yandex\DataSync\Models\Database\Deltas;

/**
 * Class DatabaseDeltasResponse
 *
 * @package  Yandex\DataSync\Responses
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class DatabaseDeltasResponse extends Model
{
    protected $propNameMap = [
        'base_revision' => 'baseRevision'
    ];

    protected $mappingClasses = [
        'items' => 'Yandex\DataSync\Models\Database\Deltas',
    ];

    /**
     * @var int
     */
    protected $baseRevision;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $limit;

    /**
     * Number of the current revision.
     *
     * @var integer
     */
    protected $revision;

    /**
     * @var Deltas
     */
    protected $items;

    /**
     * @return int
     */
    public function getBaseRevision()
    {
        return $this->baseRevision;
    }

    /**
     * @param int $baseRevision
     */
    public function setBaseRevision($baseRevision)
    {
        $this->baseRevision = $baseRevision;
    }

    /**
     * @return Deltas
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Deltas $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @param int $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}
