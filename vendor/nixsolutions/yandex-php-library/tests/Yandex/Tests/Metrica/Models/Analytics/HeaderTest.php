<?php
namespace Yandex\Tests\Metrica\Models\Analytics;

use Yandex\Tests\Metrica\Fixtures\Analytics;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Analytics\Models;

class HeaderTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Analytics::$analyticsFixtures;
        
        $header = new Models\Header();
        $header
            ->setName($fixtures['columnHeaders'][0]['name'])
            ->setDataType($fixtures['columnHeaders'][0]['dataType'])
            ->setColumnType($fixtures['columnHeaders'][0]['columnType']);

        $this->assertEquals($fixtures["columnHeaders"][0]["name"], $header->getName());
        $this->assertEquals($fixtures["columnHeaders"][0]["columnType"], $header->getColumnType());
        $this->assertEquals($fixtures["columnHeaders"][0]["dataType"], $header->getDataType());
    }
}
 