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

/**
 * Class RecordField
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  02.03.16 12:38
 */
class RecordField extends Model
{
    protected $propNameMap = [
        'change_type'    => 'changeType',
        'field_id'       => 'fieldId',
        'list_item'      => 'listItem',
        'list_item_dest' => 'listItemDest'
    ];

    protected $mappingClasses = [
        'value' => 'Yandex\DataSync\Models\Database\Delta\RecordFieldValue'
    ];

    /**
     * Adding a new field or change existing values.
     */
    const CHANGE_TYPE_SET = 'set';
    /**
     * Deleting field.
     */
    const CHANGE_TYPE_DELETE = 'delete';

    //this change is only available for the field, which has a data type list ( DATA_TYPE_LIST ).
    /**
     * Add a new item to the list.
     */
    const CHANGE_TYPE_LIST_ITEM_INSERT = 'list_item_insert';
    /**
     * Set the value for the element at the specified index.
     */
    const CHANGE_TYPE_LIST_ITEM_SET = 'list_item_set';
    /**
     * Move element of the array.
     */
    const CHANGE_TYPE_LIST_ITEM_MOVE = 'list_item_move';
    /**
     * Delete a list item.
     */
    const CHANGE_TYPE_LIST_ITEM_DELETE = 'list_item_delete';

    /**
     * @var string
     */
    protected $changeType;

    /**
     * @var string
     */
    protected $fieldId;

    /**
     * The index of the list, to which is applied the change.
     * This field is specified with any change, starting with "list_item".
     *
     * @var int
     */
    protected $listItem;

    /**
     * The new list item index. It specifies the type of change at the list item move.
     *
     * @var int
     */
    protected $listItemDest;

    /**
     * @var RecordFieldValue
     */
    protected $value;

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
    public function getFieldId()
    {
        return $this->fieldId;
    }

    /**
     * @param string $fieldId
     *
     * @return $this
     */
    public function setFieldId($fieldId)
    {
        $this->fieldId = $fieldId;
        return $this;
    }

    /**
     * @return int
     */
    public function getListItem()
    {
        return $this->listItem;
    }

    /**
     * @param int $listItem
     *
     * @return $this
     */
    public function setListItem($listItem)
    {
        $this->listItem = $listItem;
        return $this;
    }

    /**
     * @return int
     */
    public function getListItemDest()
    {
        return $this->listItemDest;
    }

    /**
     * @param int $listItemDest
     *
     * @return $this
     */
    public function setListItemDest($listItemDest)
    {
        $this->listItemDest = $listItemDest;
        return $this;
    }

    /**
     * @return RecordFieldValue
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param RecordFieldValue $value
     *
     * @return $this
     */
    public function setValue(RecordFieldValue $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get array from object
     *
     * @param array|object $data
     *
     * @return array
     */
    protected function toArrayRecursive($data)
    {

        if ($data instanceof RecordFieldValue) {
            return $data->toArrayRecursive($data);
        } else {
            return parent::toArrayRecursive($data);
        }
    }
}
