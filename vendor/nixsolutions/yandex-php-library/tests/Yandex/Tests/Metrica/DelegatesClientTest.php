<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\DelegatesClient;
use Yandex\Metrica\Management\Models;
use Yandex\Tests\Metrica\Fixtures\Delegates;
use Yandex\Tests\TestCase;

class DelegatesClientTest extends TestCase
{
    public function testGetDelegates()
    {
        $fixtures = Delegates::$delegatesFixtures;

        $mock = $this->getMockBuilder(DelegatesClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getDelegates();

        $this->assertEquals($fixtures["delegates"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["delegates"][0]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["delegates"][0]["comment"], $table->current()->getComment());
    }

    public function testUpdateDelegates()
    {
        $fixtures             = Delegates::$delegatesFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $delegatesClientMock = $this->getMockBuilder(DelegatesClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $delegatesClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $delegates = new Models\Delegates($fixtures);
        $result    = $delegatesClientMock->updateDelegates($delegates);
        $this->assertTrue($result instanceof Models\Delegates);

        $this->assertEquals($fixtures["delegates"][0]["user_login"], $result->current()->getUserLogin());
        $this->assertEquals($fixtures["delegates"][0]["created_at"], $result->current()->getCreatedAt());
        $this->assertEquals($fixtures["delegates"][0]["comment"], $result->current()->getComment());
    }

    public function testAddDelegates()
    {
        $fixtures             = Delegates::$delegatesFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $delegatesClientMock = $this->getMockBuilder(DelegatesClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $delegatesClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $delegatesClientMock->addDelegates('login', 'comment');
        $this->assertTrue($result instanceof Models\Delegates);

        $this->assertEquals($fixtures["delegates"][0]["user_login"], $result->current()->getUserLogin());
        $this->assertEquals($fixtures["delegates"][0]["created_at"], $result->current()->getCreatedAt());
        $this->assertEquals($fixtures["delegates"][0]["comment"], $result->current()->getComment());
    }

    public function testDeleteDelegate()
    {
        $fixtures             = Delegates::$delegateDeleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $delegatesClientMock = $this->getMockBuilder(DelegatesClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $delegatesClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $delegatesClientMock->deleteDelegate('login');
        $this->assertArrayHasKey('success', $result);
    }
}
