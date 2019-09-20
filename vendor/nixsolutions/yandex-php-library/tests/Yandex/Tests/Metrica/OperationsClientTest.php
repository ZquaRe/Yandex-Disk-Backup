<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\Models\Operation;
use Yandex\Metrica\Management\OperationsClient;
use Yandex\Tests\Metrica\Fixtures\Operations;
use Yandex\Tests\TestCase;

class OperationsClientTest extends TestCase
{
    public function testGetOperations()
    {
        $fixtures = Operations::$operationsFixtures;

        $mock = $this->getMockBuilder(OperationsClient::class)->setMethods(['sendGetRequest'])->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getOperations(2215573);

        $this->assertEquals($fixtures["operations"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["operations"][0]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["operations"][0]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["operations"][0]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["operations"][0]["status"], $table->current()->getStatus());
        $this->assertEquals($fixtures["operations"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["operations"][1]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["operations"][1]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["operations"][1]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["operations"][1]["status"], $table->current()->getStatus());
    }

    public function testGetOperation()
    {
        $fixtures = Operations::$operationFixtures;

        $mock = $this->getMockBuilder(OperationsClient::class)->setMethods(['sendGetRequest'])->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getOperation(2215573, 66955);

        $this->assertEquals($fixtures["operation"]["id"], $table->getId());
        $this->assertEquals($fixtures["operation"]["action"], $table->getAction());
        $this->assertEquals($fixtures["operation"]["attr"], $table->getAttr());
        $this->assertEquals($fixtures["operation"]["value"], $table->getValue());
        $this->assertEquals($fixtures["operation"]["status"], $table->getStatus());
    }

    public function testAddOperation()
    {
        $fixtures             = Operations::$operationFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)->setMethods(['request'])->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(OperationsClient::class)->setMethods(['getClient'])->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $operation = new Operation($fixtures);
        $result    = $mock->addOperation(1, $operation);
        $this->assertTrue($result instanceof Operation);

        $this->assertEquals($fixtures["operation"]["id"], $result->getId());
        $this->assertEquals($fixtures["operation"]["action"], $result->getAction());
        $this->assertEquals($fixtures["operation"]["attr"], $result->getAttr());
        $this->assertEquals($fixtures["operation"]["value"], $result->getValue());
        $this->assertEquals($fixtures["operation"]["status"], $result->getStatus());
    }

    public function testUpdateOperation()
    {
        $fixtures             = Operations::$operationFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)->setMethods(['request'])->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(OperationsClient::class)->setMethods(['getClient'])->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $operation = new Operation($fixtures);
        $result    = $mock->updateOperation(1, 2, $operation);
        $this->assertTrue($result instanceof Operation);

        $this->assertEquals($fixtures["operation"]["id"], $result->getId());
        $this->assertEquals($fixtures["operation"]["action"], $result->getAction());
        $this->assertEquals($fixtures["operation"]["attr"], $result->getAttr());
        $this->assertEquals($fixtures["operation"]["value"], $result->getValue());
        $this->assertEquals($fixtures["operation"]["status"], $result->getStatus());
    }

    public function testDeleteCounterOperation()
    {
        $fixtures             = Operations::$deleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)->setMethods(['request'])->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(OperationsClient::class)->setMethods(['getClient'])->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $mock->deleteCounterOperation(1, 2);
        $this->assertArrayHasKey('success', $result);
    }
}
