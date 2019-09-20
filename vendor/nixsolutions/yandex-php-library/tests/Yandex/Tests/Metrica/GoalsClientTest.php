<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\GoalsClient;
use Yandex\Metrica\Management\Models\Goal;
use Yandex\Tests\Metrica\Fixtures\Goals;
use Yandex\Tests\TestCase;

class GoalsClientTest extends TestCase
{
    public function testGetGoals()
    {
        $fixtures = Goals::$goalsFixtures;
        $mock = $this->getMockBuilder(GoalsClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGoals(2215573);

        $this->assertEquals($fixtures["goals"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["goals"][0]["name"], $table->current()->getName());
        $this->assertEquals($fixtures["goals"][0]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["goals"][0]["class"], $table->current()->getClass());
        $this->assertEquals($fixtures["goals"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["goals"][1]["name"], $table->current()->getName());
        $this->assertEquals($fixtures["goals"][1]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["goals"][1]["flag"], $table->current()->getFlag());
        $this->assertEquals($fixtures["goals"][1]["class"], $table->current()->getClass());

        $conditions = $table->current()->getConditions();

        $this->assertEquals($fixtures["goals"][1]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goals"][1]["conditions"][0]["url"], $conditions->current()->getUrl());
    }

    public function testGetGoal()
    {
        $fixtures = Goals::$goalFixtures;
        $mock = $this->getMockBuilder(GoalsClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table      = $mock->getGoal(2215573, 334423);
        $conditions = $table->getConditions();

        $this->assertEquals($fixtures["goal"]["id"], $table->getId());
        $this->assertEquals($fixtures["goal"]["name"], $table->getName());
        $this->assertEquals($fixtures["goal"]["type"], $table->getType());
        $this->assertEquals($fixtures["goal"]["flag"], $table->getFlag());
        $this->assertEquals($fixtures["goal"]["class"], $table->getClass());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["url"], $conditions->current()->getUrl());
    }

    public function testAddGoal()
    {
        $fixtures             = Goals::$goalFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GoalsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $goal   = new Goal($fixtures);
        $result = $mock->addGoal(1, $goal);
        $this->assertTrue($result instanceof Goal);

        $conditions = $result->getConditions();
        $this->assertEquals($fixtures["goal"]["id"], $result->getId());
        $this->assertEquals($fixtures["goal"]["name"], $result->getName());
        $this->assertEquals($fixtures["goal"]["type"], $result->getType());
        $this->assertEquals($fixtures["goal"]["flag"], $result->getFlag());
        $this->assertEquals($fixtures["goal"]["class"], $result->getClass());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["url"], $conditions->current()->getUrl());
    }

    public function testUpdateGoal()
    {
        $fixtures             = Goals::$goalFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GoalsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $goal   = new Goal($fixtures);
        $result = $mock->updateGoal(1, 2, $goal);
        $this->assertTrue($result instanceof Goal);

        $conditions = $result->getConditions();
        $this->assertEquals($fixtures["goal"]["id"], $result->getId());
        $this->assertEquals($fixtures["goal"]["name"], $result->getName());
        $this->assertEquals($fixtures["goal"]["type"], $result->getType());
        $this->assertEquals($fixtures["goal"]["flag"], $result->getFlag());
        $this->assertEquals($fixtures["goal"]["class"], $result->getClass());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["url"], $conditions->current()->getUrl());
    }

    public function testDeleteGoal()
    {
        $fixtures             = Goals::$deleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $mock = $this->getMockBuilder(GoalsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $mock->deleteGoal(1, 2);
        $this->assertArrayHasKey('success', $result);
    }
}
