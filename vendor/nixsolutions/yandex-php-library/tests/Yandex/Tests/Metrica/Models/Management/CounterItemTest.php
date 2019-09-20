<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Counters;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class CounterItemTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Counters::$counterFixtures;

        $webvisor = new Models\Webvisor();
        $webvisor
            ->setArchType($fixtures['counter']['webvisor']['arch_type'])
            ->setLoadPlayerType($fixtures['counter']['webvisor']['load_player_type']);

        $informer = new Models\Informer();
        $informer
            ->setEnabled($fixtures['counter']['code_options']['informer']['enabled'])
            ->setType($fixtures['counter']['code_options']['informer']['type'])
            ->setSize($fixtures['counter']['code_options']['informer']['size'])
            ->setIndicator($fixtures['counter']['code_options']['informer']['indicator'])
            ->setColorStart($fixtures['counter']['code_options']['informer']['color_start'])
            ->setColorEnd($fixtures['counter']['code_options']['informer']['color_end'])
            ->setColorText($fixtures['counter']['code_options']['informer']['color_text'])
            ->setColorArrow($fixtures['counter']['code_options']['informer']['color_arrow']);
        
        $codeOptions = new Models\CodeOptions();
        $codeOptions
            ->setAsync($fixtures['counter']['code_options']['async'])
            ->setInformer($informer)
            ->setVisor($fixtures['counter']['code_options']['visor'])
            ->setUt($fixtures['counter']['code_options']['ut'])
            ->setTrackHash($fixtures['counter']['code_options']['track_hash'])
            ->setXmlSite($fixtures['counter']['code_options']['xml_site'])
            ->setInOneLine($fixtures['counter']['code_options']['in_one_line']);
        
        $counter = new Models\CounterItem();
        $counter
            ->setId($fixtures['counter']['id'])
            ->setOwnerLogin($fixtures['counter']['owner_login'])
            ->setCodeOptions($codeOptions)
            ->setCodeStatus($fixtures['counter']['code_status'])
            ->setFavorite($fixtures['counter']['favorite'])
            ->setName($fixtures['counter']['name'])
            ->setPartnerId($fixtures['counter']['partner_id'])
            ->setPermission($fixtures['counter']['permission'])
            ->setSite($fixtures['counter']['site'])
            ->setType($fixtures['counter']['type'])
            ->setWebvisor($webvisor);

        $this->assertEquals($fixtures['counter']['id'], $counter->getId());
        $this->assertEquals($fixtures['counter']['owner_login'], $counter->getOwnerLogin());
        $this->assertEquals($fixtures['counter']['code_status'], $counter->getCodeStatus());
        $this->assertEquals($fixtures['counter']['favorite'], $counter->getFavorite());
        $this->assertEquals($fixtures['counter']['name'], $counter->getName());
        $this->assertEquals($fixtures['counter']['partner_id'], $counter->getPartnerId());
        $this->assertEquals($fixtures['counter']['permission'], $counter->getPermission());
        $this->assertEquals($fixtures['counter']['site'], $counter->getSite());
        $this->assertEquals($fixtures['counter']['type'], $counter->getType());

        $this->assertEquals($fixtures['counter']['webvisor']['arch_type'], $counter->getWebvisor()->getArchType());
        $this->assertEquals($fixtures['counter']['webvisor']['load_player_type'], $counter->getWebvisor()->getLoadPlayerType());

        $this->assertEquals($fixtures['counter']['code_options']['async'], $counter->getCodeOptions()->getAsync());
        $this->assertEquals($fixtures['counter']['code_options']['visor'], $counter->getCodeOptions()->getVisor());
        $this->assertEquals($fixtures['counter']['code_options']['ut'],  $counter->getCodeOptions()->getUt());
        $this->assertEquals($fixtures['counter']['code_options']['track_hash'], $counter->getCodeOptions()->getTrackHash());
        $this->assertEquals($fixtures['counter']['code_options']['xml_site'], $counter->getCodeOptions()->getXmlSite());
        $this->assertEquals($fixtures['counter']['code_options']['in_one_line'], $counter->getCodeOptions()->getInOneLine());

        $this->assertEquals($fixtures['counter']['code_options']['informer']['enabled'], $counter->getCodeOptions()->getInformer()->getEnabled());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['type'], $counter->getCodeOptions()->getInformer()->getType());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['size'], $counter->getCodeOptions()->getInformer()->getSize());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['indicator'], $counter->getCodeOptions()->getInformer()->getIndicator());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['color_start'], $counter->getCodeOptions()->getInformer()->getColorStart());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['color_end'], $counter->getCodeOptions()->getInformer()->getColorEnd());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['color_text'], $counter->getCodeOptions()->getInformer()->getColorText());
        $this->assertEquals($fixtures['counter']['code_options']['informer']['color_arrow'], $counter->getCodeOptions()->getInformer()->getColorArrow());
    }
}
 