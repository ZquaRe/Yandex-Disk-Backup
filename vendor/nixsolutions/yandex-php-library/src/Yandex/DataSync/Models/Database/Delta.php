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

use Yandex\Common\Model;
use Yandex\DataSync\Models\Database\Delta\Records;

/**
 * Class Delta
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  02.03.16 11:29
 */
class Delta extends Model
{
    protected $propNameMap = [
        'delta_id'      => 'deltaId',
        'base_revision' => 'baseRevision'
    ];

    protected $mappingClasses = [
        'changes' => 'Yandex\DataSync\Models\Database\Delta\Records',
    ];

    /**
     * Explanatory comment on the change.
     *
     * @var string
     */
    protected $deltaId;

    /**
     * @var int
     */
    protected $baseRevision;

    /**
     * Changes in individual database records.
     *
     * @var Records
     */
    protected $changes;

    /**
     * @return Records
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param Records|array $changes
     *
     * @return $this
     */
    public function setChanges($changes)
    {
        if ($changes instanceof Records) {
            $this->changes = $changes;
        } else {
            if (is_array($changes)) {
                $changes       = new Records($changes);
                $this->changes = $changes;
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDeltaId()
    {
        return $this->deltaId;
    }

    /**
     * @param $deltaId
     *
     * @return $this
     */
    public function setDeltaId($deltaId)
    {
        $this->deltaId = $deltaId;
        return $this;
    }

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
}
