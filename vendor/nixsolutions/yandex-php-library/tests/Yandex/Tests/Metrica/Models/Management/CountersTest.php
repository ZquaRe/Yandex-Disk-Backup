<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Counters;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class CountersTest extends TestCase
{
    
    public function testGet()
    {
        $fixtures = Counters::$countersFixtures;
        $webvisor = new Models\Webvisor();
        $webvisor
            ->setArchType($fixtures['counters'][0]['webvisor']['arch_type'])
            ->setLoadPlayerType($fixtures['counters'][0]['webvisor']['load_player_type']);

        $informer = new Models\Informer();
        $informer
            ->setEnabled($fixtures['counters'][0]['code_options']['informer']['enabled'])
            ->setType($fixtures['counters'][0]['code_options']['informer']['type'])
            ->setSize($fixtures['counters'][0]['code_options']['informer']['size'])
            ->setIndicator($fixtures['counters'][0]['code_options']['informer']['indicator'])
            ->setColorStart($fixtures['counters'][0]['code_options']['informer']['color_start'])
            ->setColorEnd($fixtures['counters'][0]['code_options']['informer']['color_end'])
            ->setColorText($fixtures['counters'][0]['code_options']['informer']['color_text'])
            ->setColorArrow($fixtures['counters'][0]['code_options']['informer']['color_arrow']);

        $codeOptions = new Models\CodeOptions();
        $codeOptions
            ->setAsync($fixtures['counters'][0]['code_options']['async'])
            ->setInformer($informer)
            ->setVisor($fixtures['counters'][0]['code_options']['visor'])
            ->setUt($fixtures['counters'][0]['code_options']['ut'])
            ->setTrackHash($fixtures['counters'][0]['code_options']['track_hash'])
            ->setXmlSite($fixtures['counters'][0]['code_options']['xml_site'])
            ->setInOneLine($fixtures['counters'][0]['code_options']['in_one_line']);

        $counter = new Models\CounterItem();
        $counter
            ->setId($fixtures['counters'][0]['id'])
            ->setOwnerLogin($fixtures['counters'][0]['id'])
            ->setCodeOptions($codeOptions)
            ->setCodeStatus($fixtures['counters'][0]['code_status'])
            ->setFavorite($fixtures['counters'][0]['favorite'])
            ->setName($fixtures['counters'][0]['name'])
            ->setPartnerId($fixtures['counters'][0]['partner_id'])
            ->setPermission($fixtures['counters'][0]['permission'])
            ->setSite($fixtures['counters'][0]['site'])
            ->setType($fixtures['counters'][0]['type'])
            ->setWebvisor($webvisor);
        
        $counters = new Models\Counters();
        $counters
            ->add($counter);

        $this->assertEquals(1, count($counters->getAll()));
    }
}
 