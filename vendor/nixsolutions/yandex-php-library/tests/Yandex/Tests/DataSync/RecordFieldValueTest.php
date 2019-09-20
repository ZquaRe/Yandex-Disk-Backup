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

use Yandex\DataSync\Exception\EmptyRecordFieldValueTypeException;
use Yandex\DataSync\Models\Database\Delta\RecordFieldValue;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  03.03.16 17:09
 */
class RecordFieldValueTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testEmptyTypes()
    {
        //Check is integer
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(1);
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_INTEGER);

        //Check is boolean
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(true);
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_BOOLEAN);

        //Check is string
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue('test');
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_STRING);

        //Check is null
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(null);
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_NULL);

        //Check is double
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(3.14159);
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_DOUBLE);

        //Check is list
        $testValue       = 'value_2';
        $listFieldValue1 = new RecordFieldValue();
        $listFieldValue1->setValue(1);
        $listFieldValue1->setType(RecordFieldValue::TYPE_INTEGER);

        $listFieldValue2 = new RecordFieldValue();
        $listFieldValue2->setValue($testValue);

        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(array($listFieldValue1, $listFieldValue2));
        $this->assertEquals($recordFieldValue->getType(), RecordFieldValue::TYPE_LIST);

        $this->assertEquals($recordFieldValue->getValue()[1]->getValue(), $testValue);
        $this->assertEquals($recordFieldValue->getValue()[1]->getType(), RecordFieldValue::TYPE_STRING);

        $array = $recordFieldValue->toArray();
        $this->assertEquals($array['type'], $recordFieldValue->getType());

        $this->assertEquals($array[RecordFieldValue::TYPE_LIST][1]['type'],
            $recordFieldValue->getValue()[1]->getType());

        $this->assertEquals(
            $array[RecordFieldValue::TYPE_LIST][1][RecordFieldValue::TYPE_STRING],
            $recordFieldValue->getValue()[1]->getValue()
        );
    }

    function testEmptyRecordFieldValueTypeException()
    {
        //Check is Exception
        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue(new RecordFieldValue());
        $this->expectException(EmptyRecordFieldValueTypeException::class);
        $recordFieldValue->toArray();//throw Exception
    }
}
