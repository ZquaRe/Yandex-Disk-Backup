<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\GrantsClient;
use Yandex\Metrica\Management\Models\Grant;
use Yandex\Tests\Metrica\Fixtures\Grants;
use Yandex\Tests\TestCase;

class GrantsClientTest extends TestCase
{
    public function testGetGrants()
    {
        $fixtures = Grants::$grantsFixtures;

        $mock = $this->getMockBuilder(GrantsClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGrants(2215573);

        $this->assertEquals($fixtures["grants"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["grants"][0]["perm"], $table->current()->getPerm());
        $this->assertEquals($fixtures["grants"][0]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["grants"][0]["comment"], $table->current()->getComment());
        $this->assertEquals($fixtures["grants"][1]["user_login"], $table->next()->getUserLogin());
        $this->assertEquals($fixtures["grants"][1]["perm"], $table->current()->getPerm());
        $this->assertEquals($fixtures["grants"][1]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["grants"][1]["comment"], $table->current()->getComment());
    }

    public function testGetGrant()
    {
        $fixtures = Grants::$grantFixtures;

        $mock = $this->getMockBuilder(GrantsClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGrant(2215573, "api-metrika2");

        $this->assertEquals($fixtures["grant"]["user_login"], $table->getUserLogin());
        $this->assertEquals($fixtures["grant"]["perm"], $table->getPerm());
        $this->assertEquals($fixtures["grant"]["created_at"], $table->getCreatedAt());
        $this->assertEquals($fixtures["grant"]["comment"], $table->getComment());
    }

    public function testAddGrant()
    {
        $fixtures             = Grants::$grantFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GrantsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $grant  = new Grant($fixtures);
        $result = $mock->addGrant(1, $grant);
        $this->assertTrue($result instanceof Grant);

        $this->assertEquals($fixtures["grant"]["user_login"], $result->getUserLogin());
        $this->assertEquals($fixtures["grant"]["perm"], $result->getPerm());
        $this->assertEquals($fixtures["grant"]["created_at"], $result->getCreatedAt());
        $this->assertEquals($fixtures["grant"]["comment"], $result->getComment());
    }

    public function testUpdateGrant()
    {
        $fixtures             = Grants::$grantFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GrantsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $grant  = new Grant($fixtures);
        $result = $mock->updateGrant(1, 2, $grant);
        $this->assertTrue($result instanceof Grant);

        $this->assertEquals($fixtures["grant"]["user_login"], $result->getUserLogin());
        $this->assertEquals($fixtures["grant"]["perm"], $result->getPerm());
        $this->assertEquals($fixtures["grant"]["created_at"], $result->getCreatedAt());
        $this->assertEquals($fixtures["grant"]["comment"], $result->getComment());
    }

    public function testDeleteGrant()
    {
        $fixtures             = Grants::$deleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GrantsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $mock->deleteGrant(1, 2);
        $this->assertArrayHasKey('success', $result);
    }
}
