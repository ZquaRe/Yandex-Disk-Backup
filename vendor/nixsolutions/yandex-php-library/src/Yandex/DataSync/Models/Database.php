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
namespace Yandex\DataSync\Models;

use Yandex\Market\Partner\Models;

/**
 * Class Database
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  01.03.16 12:03
 */
use Yandex\Common\Model;

class Database extends Model
{
    protected $propNameMap = [
        'records_count' => 'recordsCount',
        'database_id'   => 'databaseId'
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
     * Description of the database.
     *
     * @var string
     */
    protected $title;

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
     * Database context.
     *
     * @var string
     */
    protected $context;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
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
     *
     * @return $this
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
        return $this;
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
     *
     * @return $this
     */
    public function setRecordsCount($recordsCount)
    {
        $this->recordsCount = $recordsCount;
        return $this;
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
     *
     * @return $this
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
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
     *
     * @return $this
     */
    public function setDatabaseId($databaseId)
    {
        $this->databaseId = $databaseId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     *
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }
}
