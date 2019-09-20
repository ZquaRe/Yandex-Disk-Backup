<?php

namespace Yandex\Tests\Metrica\Models\Stat;

use Yandex\Tests\Metrica\Fixtures\Stat;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Stat\Models;

class TableTest extends TestCase {

    public function testSetTable()
    {
        $fixtures = Stat::$tableFixtures;

        $query = new Models\Query();
        $query
            ->setId($fixtures['query']['id'])
            ->setDimensions($fixtures['query']['dimensions'])
            ->setMetrics($fixtures['query']['metrics'])
            ->setSort($fixtures['query']['sort'])
            ->setLimit($fixtures['query']['limit'])
            ->setOffset($fixtures['query']['offset'])
            ->setDate1($fixtures['query']['date1'])
            ->setDate2($fixtures['query']['date2']);

        $items = new Models\Items();
        $items
            ->setDimensions($fixtures['data'][0]['dimensions'])
            ->setMetrics($fixtures['data'][0]['metrics']);

        $data = new Models\Data();
        $data->add($items);

        $table = new Models\Table();
        $table
            ->setQuery($query)
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

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $table->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $table->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1"], $table->getQuery()->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $table->getQuery()->getDate2());

        $getData = $table->getData()->getAll();

        $this->assertEquals($fixtures["data"][0]["dimensions"], $getData[0]->getDimensions());
        $this->assertEquals($fixtures["data"][0]["metrics"], $getData[0]->getMetrics());

        $this->assertEquals($fixtures["total_rows"], $table->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $table->getSampled());
        $this->assertEquals($fixtures["sample_share"], $table->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $table->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $table->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $table->getDataLag());
        $this->assertEquals($fixtures["totals"], $table->getTotals());
        $this->assertEquals($fixtures["min"], $table->getMin());
        $this->assertEquals($fixtures["max"], $table->getMax());
    }
}
 