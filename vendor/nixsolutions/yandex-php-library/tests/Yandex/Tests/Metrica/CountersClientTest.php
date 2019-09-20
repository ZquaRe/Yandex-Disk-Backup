<?php

namespace Yandex\Tests\Metrica;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Yandex\Metrica\Management\CountersClient;
use Yandex\Metrica\Management\Models;
use Yandex\Tests\Metrica\Fixtures\Counters;
use Yandex\Tests\TestCase;

class CountersClientTest extends TestCase
{

    public function testGetCounters()
    {
        $fixtures = Counters::$countersFixtures;

        $mock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $response = $mock->getCounters(new Models\CountersParams());

        $this->assertEquals($fixtures["rows"], $response->getRows());

        $counters = $response->getCounters();

        $this->assertEquals($fixtures["counters"][0]["id"], $counters->current()->getId());
        $this->assertEquals($fixtures["counters"][0]["owner_login"], $counters->current()->getOwnerLogin());
        $this->assertEquals($fixtures["counters"][0]["code_status"], $counters->current()->getCodeStatus());
        $this->assertEquals($fixtures["counters"][0]["name"], $counters->current()->getName());
        $this->assertEquals($fixtures["counters"][0]["site"], $counters->current()->getSite());
        $this->assertEquals($fixtures["counters"][0]["type"], $counters->current()->getType());
        $this->assertEquals($fixtures["counters"][0]["favorite"], $counters->current()->getFavorite());
        $this->assertEquals($fixtures["counters"][0]["permission"], $counters->current()->getPermission());
        $this->assertEquals($fixtures["counters"][0]["partner_id"], $counters->current()->getPartnerId());

        $this->assertEquals(
            $fixtures["counters"][0]["webvisor"]["arch_type"],
            $counters->current()->getWebvisor()->getArchType()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["webvisor"]["load_player_type"],
            $counters->current()->getWebvisor()->getLoadPlayerType()
        );

        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["async"],
            $counters->current()->getCodeOptions()->getAsync()
        );

        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["enabled"],
            $counters->current()->getCodeOptions()->getInformer()->getEnabled()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["type"],
            $counters->current()->getCodeOptions()->getInformer()->getType()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["size"],
            $counters->current()->getCodeOptions()->getInformer()->getSize()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["indicator"],
            $counters->current()->getCodeOptions()->getInformer()->getIndicator()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["color_start"],
            $counters->current()->getCodeOptions()->getInformer()->getColorStart()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["color_end"],
            $counters->current()->getCodeOptions()->getInformer()->getColorEnd()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["color_text"],
            $counters->current()->getCodeOptions()->getInformer()->getColorText()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["informer"]["color_arrow"],
            $counters->current()->getCodeOptions()->getInformer()->getColorArrow()
        );

        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["visor"],
            $counters->current()->getCodeOptions()->getVisor()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["ut"],
            $counters->current()->getCodeOptions()->getUt()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["track_hash"],
            $counters->current()->getCodeOptions()->getTrackHash()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["xml_site"],
            $counters->current()->getCodeOptions()->getXmlSite()
        );
        $this->assertEquals(
            $fixtures["counters"][0]["code_options"]["in_one_line"],
            $counters->current()->getCodeOptions()->getInOneLine()
        );
    }

    public function testGetCounter()
    {
        $fixtures = Counters::$counterFixtures;

        $mock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $response = $mock->getCounter(2215573, new Models\CounterParams());

        $this->assertEquals($fixtures["counter"]["id"], $response->getId());
        $this->assertEquals($fixtures["counter"]["owner_login"], $response->getOwnerLogin());
        $this->assertEquals($fixtures["counter"]["code_status"], $response->getCodeStatus());
        $this->assertEquals($fixtures["counter"]["name"], $response->getName());
        $this->assertEquals($fixtures["counter"]["site"], $response->getSite());
        $this->assertEquals($fixtures["counter"]["type"], $response->getType());
        $this->assertEquals($fixtures["counter"]["favorite"], $response->getFavorite());
        $this->assertEquals($fixtures["counter"]["permission"], $response->getPermission());

        $this->assertEquals($fixtures["counter"]["webvisor"]["arch_type"], $response->getWebvisor()->getArchType());
        $this->assertEquals(
            $fixtures["counter"]["webvisor"]["load_player_type"],
            $response->getWebvisor()->getLoadPlayerType()
        );

        $this->assertEquals($fixtures["counter"]["code_options"]["async"], $response->getCodeOptions()->getAsync());

        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["enabled"],
            $response->getCodeOptions()->getInformer()->getEnabled()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["type"],
            $response->getCodeOptions()->getInformer()->getType()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["size"],
            $response->getCodeOptions()->getInformer()->getSize()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["indicator"],
            $response->getCodeOptions()->getInformer()->getIndicator()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["color_start"],
            $response->getCodeOptions()->getInformer()->getColorStart()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["color_end"],
            $response->getCodeOptions()->getInformer()->getColorEnd()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["color_text"],
            $response->getCodeOptions()->getInformer()->getColorText()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["informer"]["color_arrow"],
            $response->getCodeOptions()->getInformer()->getColorArrow()
        );

        $this->assertEquals($fixtures["counter"]["code_options"]["visor"], $response->getCodeOptions()->getVisor());
        $this->assertEquals($fixtures["counter"]["code_options"]["ut"], $response->getCodeOptions()->getUt());
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["track_hash"],
            $response->getCodeOptions()->getTrackHash()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["xml_site"],
            $response->getCodeOptions()->getXmlSite()
        );
        $this->assertEquals(
            $fixtures["counter"]["code_options"]["in_one_line"],
            $response->getCodeOptions()->getInOneLine()
        );

        $this->assertEquals($fixtures["counter"]["partner_id"], $response->getPartnerId());
        $this->assertEquals($fixtures["counter"]["code"], $response->getCode());

        $this->assertEquals(
            $fixtures["counter"]["monitoring"]["enable_monitoring"],
            $response->getMonitoring()->getEnableMonitoring()
        );
        $this->assertEquals($fixtures["counter"]["monitoring"]["emails"], $response->getMonitoring()->getEmails());
        $this->assertEquals(
            $fixtures["counter"]["monitoring"]["sms_allowed"],
            $response->getMonitoring()->getSmsAllowed()
        );
        $this->assertEquals(
            $fixtures["counter"]["monitoring"]["enable_sms"],
            $response->getMonitoring()->getEnableSms()
        );
        $this->assertEquals($fixtures["counter"]["monitoring"]["sms_time"], $response->getMonitoring()->getSmsTime());

        $this->assertEquals($fixtures["counter"]["filter_robots"], $response->getFilterRobots());
        $this->assertEquals($fixtures["counter"]["time_zone_name"], $response->getTimeZoneName());
        $this->assertEquals($fixtures["counter"]["visit_threshold"], $response->getVisitThreshold());
        $this->assertEquals($fixtures["counter"]["max_goals"], $response->getMaxGoals());
        $this->assertEquals($fixtures["counter"]["max_detailed_goals"], $response->getMaxDetailedGoals());
        $this->assertEquals($fixtures["counter"]["max_retargeting_goals"], $response->getMaxRetargetingGoals());
    }

    public function testAddCounter()
    {
        $fixtures             = Counters::$counterFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $countersClientMock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $countersClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $counter = new Models\Counter($fixtures);
        $result  = $countersClientMock->addCounter($counter);
        $this->assertTrue($result instanceof Models\Counter);
    }

    public function testUpdateCounter()
    {
        $fixtures             = Counters::$counterFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $countersClientMock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $countersClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $counter = new Models\ExtendCounter($fixtures);
        $result  = $countersClientMock->updateCounter(1, $counter);
        $this->assertTrue($result instanceof Models\Counter);

        $this->assertEquals($fixtures["counter"]["id"], $result->getId());
        $this->assertEquals($fixtures["counter"]["owner_login"], $result->getOwnerLogin());
        $this->assertEquals($fixtures["counter"]["code_status"], $result->getCodeStatus());
        $this->assertEquals($fixtures["counter"]["name"], $result->getName());
        $this->assertEquals($fixtures["counter"]["site"], $result->getSite());
        $this->assertEquals($fixtures["counter"]["type"], $result->getType());
        $this->assertEquals($fixtures["counter"]["favorite"], $result->getFavorite());
        $this->assertEquals($fixtures["counter"]["permission"], $result->getPermission());
    }

    public function testDeleteCounter()
    {
        $fixtures             = Counters::$counterDeleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $countersClientMock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $countersClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $countersClientMock->deleteCounter(1);
        $this->assertArrayHasKey('success', $result);
    }

    public function testUnDeleteCounter()
    {
        $fixtures             = Counters::$counterDeleteResponseFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $countersClientMock = $this->getMockBuilder(CountersClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $countersClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $countersClientMock->undeleteCounter(1);
        $this->assertArrayHasKey('success', $result);
    }
}
