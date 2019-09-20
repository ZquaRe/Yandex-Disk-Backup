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

use Yandex\Common\Model;
use Yandex\DataSync\Models\Database\Delta\RecordFields;

/**
 * Class Record
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  02.03.16 11:35
 */
class Record extends Model
{
    protected $propNameMap = [
        'change_type'   => 'changeType',
        'collection_id' => 'collectionId',
        'record_id'     => 'recordId'
    ];

    protected $mappingClasses = [
        'changes' => 'Yandex\DataSync\Models\Database\Delta\RecordFields',
        'fields'  => 'Yandex\DataSync\Models\Database\Delta\RecordFields',
    ];

    /**
     * Adding a new record.
     * (only Database)
     */
    const CHANGE_TYPE_INSERT = 'insert';
    /**
     * Partial recording the change (change only the specified field, all existing fields of a record are saved).
     * (only Database)
     */
    const CHANGE_TYPE_UPDATE = 'update';
    /**
     * Complete change of recording (all existing fields are deleted).
     * Adding a new field or change existing values.
     * (Database & fields)
     */
    const CHANGE_TYPE_SET = 'set';
    /**
     * Deleting records or Deleting field.
     * (Database & fields)
     */
    const CHANGE_TYPE_DELETE = 'delete';

    /**
     * @var string
     */
    protected $changeType;

    /**
     * @var string
     */
    protected $collectionId;

    /**
     * @var string
     */
    protected $recordId;

    /**
     * @var RecordFields
     */
    protected $changes;

    /**
     * @var RecordFields
     */
    protected $fields;

    /**
     * The revision number after the latest changes to the current record.
     * @var string
     */
    protected $revision;

    /**
     * @return string
     */
    public function getChangeType()
    {
        return $this->changeType;
    }

    /**
     * @param string $changeType
     *
     * @return $this
     */
    public function setChangeType($changeType)
    {
        $this->changeType = $changeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param string $collectionId
     *
     * @return $this
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
        return $this;
    }

    /**
     * @return RecordFields
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param RecordFields|array $changes
     *
     * @return $this
     */
    public function setChanges($changes)
    {
        if ($changes instanceof RecordFields) {
            $this->changes = $changes;
        } elseif (is_array($changes)) {
            $recordFields = new RecordFields();
            foreach ($changes as $change) {
                $recordFields->add($change);
            }
            $this->changes = $recordFields;
        }
        return $this;
    }

    /**
     * @return RecordFields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param RecordFields|array $fields
     *
     * @return $this
     */
    public function setFields($fields)
    {
        if ($fields instanceof RecordFields) {
            $this->fields = $fields;
        } else {
            if (is_array($fields)) {
                $fields       = new RecordFields($fields);
                $this->fields = $fields;
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * @param $recordId
     *
     * @return $this
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @param string $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }
}
