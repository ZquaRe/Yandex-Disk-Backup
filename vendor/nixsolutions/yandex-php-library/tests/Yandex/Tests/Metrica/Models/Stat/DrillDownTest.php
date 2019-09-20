<?php
namespace Yandex\Tests\Metrica\Models\Stat;

use Yandex\Tests\Metrica\Fixtures\Stat;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Stat\Models;

class DrillDownTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Stat::$drillDownFixtures;

        $query = new Models\Query();
        $query
            ->setId($fixtures['query']['id'])
            ->setPreset($fixtures['query']['preset'])
            ->setDimensions($fixtures['query']['dimensions'])
            ->setMetrics($fixtures['query']['metrics'])
            ->setSort($fixtures['query']['sort'])
            ->setLimit($fixtures['query']['limit'])
            ->setOffset($fixtures['query']['offset'])
            ->setDate1($fixtures['query']['date1'])
            ->setDate2($fixtures['query']['date2']);

        $dimension = new Models\Dimension();
        $dimension
            ->setId($fixtures['data'][0]['dimension']['id'])
            ->setName($fixtures['data'][0]['dimension']['name']);

        $items = new Models\DrillDownItems();
        $items
            ->setMetrics($fixtures['data'][0]['metrics'])
            ->setDimension($dimension)
            ->setExpand($fixtures['data'][0]['expand']);

        $data = new Models\DrillDownData();
        $data->add($items);

        $drillDown = new Models\DrillDown();
        $drillDown->setQuery($query)
            ->setData($data)
            ->setTotalRows($fixtures['total_rows'])
            ->setSampled($fixtures['sampled'])
            ->setSampleShare($fixtures['sample_share'])
            ->setSampleSize($fixtures['sample_size'])
            ->setSampleSpace($fixtures['sample_space'])
            ->setDataLag($fixtures['data_lag'])
            ->setTotals($fixtures['totals'])
            ->setMin($fixtures['min'])
            ->setMax($fixtures['max']);

        $this->assertEquals($fixtures["query"]["id"], $drillDown->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["preset"], $drillDown->getQuery()->getPreset());
        $this->assertEquals($fixtures["query"]["dimensions"], $drillDown->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $drillDown->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $drillDown->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $drillDown->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $drillDown->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1"], $drillDown->getQuery()->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $drillDown->getQuery()->getDate2());

        $getData = $drillDown->getData()->getAll();

        $this->assertEquals($fixtures["data"][0]["dimension"]["name"], $getData[0]->getDimension()->getName());
        $this->assertEquals($fixtures["data"][0]["dimension"]["id"], $getData[0]->getDimension()->getId());
        $this->assertEquals($fixtures["data"][0]["metrics"], $getData[0]->getMetrics());
        $this->assertEquals($fixtures["data"][0]["expand"], $getData[0]->getExpand());

        $this->assertEquals($fixtures["total_rows"], $drillDown->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $drillDown->getSampled());
        $this->assertEquals($fixtures["sample_share"], $drillDown->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $drillDown->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $drillDown->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $drillDown->getDataLag());
        $this->assertEquals($fixtures["totals"], $drillDown->getTotals());
        $this->assertEquals($fixtures["min"], $drillDown->getMin());
        $this->assertEquals($fixtures["max"], $drillDown->getMax());
    }
}
 