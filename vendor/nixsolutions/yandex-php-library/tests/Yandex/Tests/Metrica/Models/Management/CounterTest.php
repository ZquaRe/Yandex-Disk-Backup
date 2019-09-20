<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Counters;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class CounterTest extends TestCase
{

    public function testGet()
    {
        $fixture = Counters::$counterFixtures;
        $counter = new Models\Counter();

        $counter
            ->setId($fixture['counter']['id'])
            ->setOwnerLogin($fixture['counter']['owner_login'])
            ->setName($fixture['counter']['name'])
            ->setSite($fixture['counter']['site'])
            ->setType($fixture['counter']['type'])
            ->setFavorite($fixture['counter']['favorite'])
            ->setPermission($fixture['counter']['permission']);

        $webvisor = new Models\Webvisor();
        $webvisor
            ->setArchType($fixture['counter']['webvisor']['arch_type'])
            ->setLoadPlayerType($fixture['counter']['webvisor']['load_player_type']);

        $counter->setWebvisor($webvisor);

        $informer = new Models\Informer();
        $informer
            ->setEnabled($fixture['counter']['code_options']['informer']['enabled'])
            ->setType($fixture['counter']['code_options']['informer']['type'])
            ->setSize($fixture['counter']['code_options']['informer']['size'])
            ->setIndicator($fixture['counter']['code_options']['informer']['indicator'])
            ->setColorStart($fixture['counter']['code_options']['informer']['color_start'])
            ->setColorEnd($fixture['counter']['code_options']['informer']['color_end'])
            ->setColorText($fixture['counter']['code_options']['informer']['color_text'])
            ->setColorArrow($fixture['counter']['code_options']['informer']['color_arrow']);

        $codeOptions = new Models\CodeOptions();
        $codeOptions
            ->setAsync($fixture['counter']['code_options']['async'])
            ->setInformer($informer)
            ->setVisor($fixture['counter']['code_options']['visor'])
            ->setUt($fixture['counter']['code_options']['ut'])
            ->setTrackHash($fixture['counter']['code_options']['track_hash'])
            ->setXmlSite($fixture['counter']['code_options']['xml_site'])
            ->setInOneLine($fixture['counter']['code_options']['in_one_line']);

        $counter
            ->setCodeOptions($codeOptions)
            ->setPartnerId($fixture['counter']['partner_id']);

        $monitoring = new Models\Monitoring();
        $monitoring
            ->setEnableMonitoring($fixture['counter']['monitoring']['enable_monitoring'])
            ->setEmails($fixture['counter']['monitoring']['emails'])
            ->setSmsAllowed($fixture['counter']['monitoring']['sms_allowed'])
            ->setEnableSms($fixture['counter']['monitoring']['enable_sms'])
            ->setSmsTime($fixture['counter']['monitoring']['sms_time']);

        $counter
            ->setMonitoring($monitoring)
            ->setFilterRobots($fixture['counter']['filter_robots'])
            ->setTimeZoneName($fixture['counter']['time_zone_name'])
            ->setVisitThreshold($fixture['counter']['visit_threshold'])
            ->setMaxGoals($fixture['counter']['max_goals'])
            ->setMaxDetailedGoals($fixture['counter']['max_detailed_goals'])
            ->setMaxRetargetingGoals($fixture['counter']['max_retargeting_goals']);

        $this->assertEquals($fixture["counter"]["id"], $counter->getId());
        $this->assertEquals($fixture["counter"]["owner_login"], $counter->getOwnerLogin());
        $this->assertEquals($fixture["counter"]["name"], $counter->getName());
        $this->assertEquals($fixture["counter"]["site"], $counter->getSite());
        $this->assertEquals($fixture["counter"]["type"], $counter->getType());
        $this->assertEquals($fixture["counter"]["favorite"], $counter->getFavorite());
        $this->assertEquals($fixture["counter"]["permission"], $counter->getPermission());

        $this->assertEquals($fixture["counter"]["webvisor"]["arch_type"], $counter->getWebvisor()->getArchType());
        $this->assertEquals(
            $fixture["counter"]["webvisor"]["load_player_type"],
            $counter->getWebvisor()->getLoadPlayerType()
        );

        $this->assertEquals($fixture["counter"]["code_options"]["async"], $counter->getCodeOptions()->getAsync());

        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["enabled"],
            $counter->getCodeOptions()->getInformer()->getEnabled()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["type"],
            $counter->getCodeOptions()->getInformer()->getType()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["size"],
            $counter->getCodeOptions()->getInformer()->getSize()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["indicator"],
            $counter->getCodeOptions()->getInformer()->getIndicator()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["color_start"],
            $counter->getCodeOptions()->getInformer()->getColorStart()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["color_end"],
            $counter->getCodeOptions()->getInformer()->getColorEnd()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["color_text"],
            $counter->getCodeOptions()->getInformer()->getColorText()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["informer"]["color_arrow"],
            $counter->getCodeOptions()->getInformer()->getColorArrow()
        );

        $this->assertEquals($fixture["counter"]["code_options"]["visor"], $counter->getCodeOptions()->getVisor());
        $this->assertEquals($fixture["counter"]["code_options"]["ut"], $counter->getCodeOptions()->getUt());
        $this->assertEquals(
            $fixture["counter"]["code_options"]["track_hash"],
            $counter->getCodeOptions()->getTrackHash()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["xml_site"],
            $counter->getCodeOptions()->getXmlSite()
        );
        $this->assertEquals(
            $fixture["counter"]["code_options"]["in_one_line"],
            $counter->getCodeOptions()->getInOneLine()
        );

        $this->assertEquals($fixture["counter"]["partner_id"], $counter->getPartnerId());

        $this->assertEquals(
            $fixture["counter"]["monitoring"]["enable_monitoring"],
            $counter->getMonitoring()->getEnableMonitoring()
        );
        $this->assertEquals($fixture["counter"]["monitoring"]["emails"], $counter->getMonitoring()->getEmails());
        $this->assertEquals(
            $fixture["counter"]["monitoring"]["sms_allowed"],
            $counter->getMonitoring()->getSmsAllowed()
        );
        $this->assertEquals(
            $fixture["counter"]["monitoring"]["enable_sms"],
            $counter->getMonitoring()->getEnableSms()
        );
        $this->assertEquals($fixture["counter"]["monitoring"]["sms_time"], $counter->getMonitoring()->getSmsTime());

        $this->assertEquals($fixture["counter"]["filter_robots"], $counter->getFilterRobots());
        $this->assertEquals($fixture["counter"]["time_zone_name"], $counter->getTimeZoneName());
        $this->assertEquals($fixture["counter"]["visit_threshold"], $counter->getVisitThreshold());
        $this->assertEquals($fixture["counter"]["max_goals"], $counter->getMaxGoals());
        $this->assertEquals($fixture["counter"]["max_detailed_goals"], $counter->getMaxDetailedGoals());
        $this->assertEquals($fixture["counter"]["max_retargeting_goals"], $counter->getMaxRetargetingGoals());
    }
}
 