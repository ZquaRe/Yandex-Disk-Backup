<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\FiltersClient;
use Yandex\Metrica\Management\Models\Filter;
use Yandex\Tests\Metrica\Fixtures\Filters;
use Yandex\Tests\TestCase;

class FiltersClientTest extends TestCase
{

    public function testGetFilters()
    {
        $fixtures = Filters::$filtersFixtures;

        $mock = $this->getMockBuilder(FiltersClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getFilters(2215573);

        $this->assertEquals($fixtures["filters"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["filters"][0]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["filters"][0]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["filters"][0]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["filters"][0]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["filters"][0]["status"], $table->current()->getStatus());
        $this->assertEquals($fixtures["filters"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["filters"][1]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["filters"][1]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["filters"][1]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["filters"][1]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["filters"][1]["status"], $table->current()->getStatus());
    }

    public function testGetFilter()
    {
        $fixtures = Filters::$filterFixtures;

        $mock = $this->getMockBuilder(FiltersClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getFilter(2215573, 66943);

        $this->assertEquals($fixtures["filter"]["id"], $table->getId());
        $this->assertEquals($fixtures["filter"]["attr"], $table->getAttr());
        $this->assertEquals($fixtures["filter"]["type"], $table->getType());
        $this->assertEquals($fixtures["filter"]["value"], $table->getValue());
        $this->assertEquals($fixtures["filter"]["action"], $table->getAction());
        $this->assertEquals($fixtures["filter"]["status"], $table->getStatus());
        $this->assertEquals($fixtures["filter"]["start_ip"], $table->getStartIp());
        $this->assertEquals($fixtures["filter"]["end_ip"], $table->getEndIp());
    }

    public function testAddFilter()
    {
        $fixtures             = Filters::$filterFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(FiltersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $filter = new Filter($fixtures);
        $result = $mock->addFilter(1, $filter);
        $this->assertTrue($result instanceof Filter);

        $this->assertEquals($fixtures["filter"]["id"], $result->getId());
        $this->assertEquals($fixtures["filter"]["attr"], $result->getAttr());
        $this->assertEquals($fixtures["filter"]["type"], $result->getType());
        $this->assertEquals($fixtures["filter"]["value"], $result->getValue());
        $this->assertEquals($fixtures["filter"]["action"], $result->getAction());
        $this->assertEquals($fixtures["filter"]["status"], $result->getStatus());
        $this->assertEquals($fixtures["filter"]["start_ip"], $result->getStartIp());
        $this->assertEquals($fixtures["filter"]["end_ip"], $result->getEndIp());
    }

    public function testUpdateFilter()
    {
        $fixtures             = Filters::$filterFixtures;
        $token                = 'test';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(FiltersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $filter = new Filter($fixtures);
        $result = $mock->updateFilter(1, 2, $filter);
        $this->assertTrue($result instanceof Filter);

        $this->assertEquals($fixtures["filter"]["id"], $result->getId());
        $this->assertEquals($fixtures["filter"]["attr"], $result->getAttr());
        $this->assertEquals($fixtures["filter"]["type"], $result->getType());
        $this->assertEquals($fixtures["filter"]["value"], $result->getValue());
        $this->assertEquals($fixtures["filter"]["action"], $result->getAction());
        $this->assertEquals($fixtures["filter"]["status"], $result->getStatus());
        $this->assertEquals($fixtures["filter"]["start_ip"], $result->getStartIp());
        $this->assertEquals($fixtures["filter"]["end_ip"], $result->getEndIp());
    }

    public function testDeleteFilter()
    {
        $fixtures             = Filters::$deleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(FiltersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $mock->deleteFilter(1, 2);
        $this->assertArrayHasKey('success', $result);
    }
}
