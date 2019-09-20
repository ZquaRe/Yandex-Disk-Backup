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
namespace Yandex\Tests\DataSync;

use Yandex\DataSync\Models\Database\Delta\RecordField;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  09.03.16 13:47
 */
class RecordFieldTest extends TestCase
{
    function testFillListItem()
    {
        $listItem     = 0;
        $listItemDest = 1;
        $recordField  = new RecordField();
        $recordField->setFieldId('work');
        $recordField->setChangeType(RecordField::CHANGE_TYPE_LIST_ITEM_MOVE);
        $recordField->setListItem($listItem);
        $recordField->setListItemDest($listItemDest);

        $this->assertEquals($listItem, $recordField->getListItem());
        $this->assertEquals($listItemDest, $recordField->getListItemDest());
    }
}
