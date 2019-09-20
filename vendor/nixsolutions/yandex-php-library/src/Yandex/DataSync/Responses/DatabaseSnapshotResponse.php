<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */
namespace Yandex\DataSync\Responses;

use Yandex\Common\Model;
use Yandex\DataSync\Models\DatabaseSnapshotRecords;

/**
 * Class DatabaseSnapshotResponse
 *
 * @package  Yandex\DataSync\Responses
 * @author   Alexander Khaylo <naxel@land.ru>
 */
class DatabaseSnapshotResponse extends Model
{
    protected $propNameMap = [
        'records_count' => 'recordsCount',
        'database_id'   => 'databaseId'
    ];

    protected $mappingClasses = [
        'records' => 'Yandex\DataSync\Models\DatabaseSnapshotRecords',
    ];

    /**
     * The number of entries in the database.
     *
     * @var int
     */
    protected $recordsCount;

    /**
     * Date of creation database.
     *
     * @var int
     */
    protected $created;

    /**
     * Date of last modification.
     *
     * @var int
     */
    protected $modified;

    /**
     * ID of the database.
     *
     * @var string
     */
    protected $databaseId;

    /**
     * Number of the current revision.
     *
     * @var integer
     */
    protected $revision;

    /**
     * Database Size in bytes.
     *
     * @var integer
     */
    protected $size;

    /**
     * @var DatabaseSnapshotRecords
     */
    protected $records;

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getDatabaseId()
    {
        return $this->databaseId;
    }

    /**
     * @param string $databaseId
     */
    public function setDatabaseId($databaseId)
    {
        $this->databaseId = $databaseId;
    }

    /**
     * @return int
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param int $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return DatabaseSnapshotRecords
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param DatabaseSnapshotRecords $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }

    /**
     * @return int
     */
    public function getRecordsCount()
    {
        return $this->recordsCount;
    }

    /**
     * @param int $recordsCount
     */
    public function setRecordsCount($recordsCount)
    {
        $this->recordsCount = $recordsCount;
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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}
