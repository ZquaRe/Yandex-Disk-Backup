<?php

namespace Yandex\Tests\Common;

use PHPUnit\Framework\TestCase as PHPUnitFrameworkTestCase;
use Yandex\Common\StringCollection;
use Yandex\Metrica\Stat\Models\ByTimeParams;

class StringCollectionTest extends PHPUnitFrameworkTestCase
{

   public function testNullArgumentReceived()
   {
      $this->assertEquals(null, StringCollection::init(null));
   }

   public function testStringArgumentReceived()
   {
      $string = '12';
      $collection = StringCollection::init($string);
      $this->assertEquals([$string], $collection->asArray());
   }

   public function testStringListArgumentReceived()
   {
      $stringList = ['1', '2'];
      $collection = StringCollection::init($stringList);
      $this->assertEquals($stringList, $collection->asArray());
   }

   public function testJoinStrings()
   {
      $stringList = ['1', '2'];
      $collection = StringCollection::init($stringList);
      $this->assertEquals('1,2', $collection->getAll());
   }

   public function testCorrectObjectReceived()
   {
      $object = new ConvertibleObject();
      $collection = StringCollection::init($object);
      $this->assertEquals([$object], $collection->asArray());
   }

   public function testArrayHasCorrectObjectReceived()
   {
      $array = [new ConvertibleObject(), '1'];
      $collection = StringCollection::init($array);
      $this->assertEquals($array, $collection->asArray());
   }

   /**
    * @expectedException \Yandex\Common\Exception\InvalidArgumentException
    */
   public function testNonCorrectObjectReceived()
   {
      $object = new NonConvertibleObject();
      $collection = StringCollection::init($object);
      $this->assertEquals([$object], $collection->asArray());
   }

   /**
    * @expectedException \Yandex\Common\Exception\InvalidArgumentException
    */
   public function testArrayHasNonCorrectObjectReceived()
   {
      $array = [new NonConvertibleObject(), '1'];
      $collection = StringCollection::init($array);
      $this->assertEquals([$array], $collection->asArray());
   }

   public function testEmptyArrayReceived()
   {
      $this->assertEquals(null, StringCollection::init([]));
   }

   public function test1()
   {
      $param = new ByTimeParams();
      $param->setDimensions(['12', '13'])->setLimit(10);
      $expected = [
         'dimensions' => '12,13',
         'limit' => 10,
      ];
      $this->assertEquals($expected, $param->toArray());
   }
}

class ConvertibleObject
{
   public function __toString()
   {
      return '1';
   }
}

class NonConvertibleObject
{
}
