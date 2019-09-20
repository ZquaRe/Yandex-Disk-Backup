<?php

namespace Yandex\Tests\Metrica;

use Yandex\Metrica\Stat\DataClient;
use Yandex\Metrica\Stat\Models;
use Yandex\Tests\Metrica\Fixtures\Stat;
use Yandex\Tests\TestCase;

class DataClientTest extends TestCase
{

    public function testGetTable()
    {
        $fixtures = Stat::$tableFixtures;

        $mock = $this->getMockBuilder(DataClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getTable(new Models\TableParams);

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $table->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $table->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1"], $table->getQuery()->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $table->getQuery()->getDate2());

        $data = $table->getData();
        $this->assertEquals($fixtures["data"][0]["metrics"], $data->current()->getMetrics());

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

    public function testGetDrillDown()
    {
        $fixtures = Stat::$drillDownFixtures;

        $mock = $this->getMockBuilder(DataClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getDrillDown(new Models\TableParams, ['key' => 'value']);

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["preset"], $table->getQuery()->getPreset());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $table->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $table->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1"], $table->getQuery()->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $table->getQuery()->getDate2());

        $data = $table->getData();

        $this->assertEquals($fixtures["data"][0]["dimension"]["name"], $data->current()->getDimension()->getName());
        $this->assertEquals($fixtures["data"][0]["dimension"]["id"], $data->current()->getDimension()->getId());
        $this->assertEquals($fixtures["data"][0]["metrics"], $data->current()->getMetrics());
        $this->assertEquals($fixtures["data"][0]["expand"], $data->current()->getExpand());
        $this->assertEquals($fixtures["data"][1]["dimension"]["name"], $data->next()->getDimension()->getName());
        $this->assertEquals($fixtures["data"][1]["dimension"]["id"], $data->current()->getDimension()->getId());
        $this->assertEquals($fixtures["data"][1]["metrics"], $data->current()->getMetrics());
        $this->assertEquals($fixtures["data"][1]["expand"], $data->current()->getExpand());

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

    public function testGetByTime()
    {
        $fixtures = Stat::$byTimeFixtures;

        $mock = $this->getMockBuilder(DataClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getByTime(new Models\ByTimeParams());

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["date1"], $table->getQuery()->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $table->getQuery()->getDate2());

        $data = $table->getData();

        $this->assertEquals($fixtures["data"][0]["metrics"], $data->current()->getMetrics());

        $this->assertEquals($fixtures["total_rows"], $table->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $table->getSampled());
        $this->assertEquals($fixtures["sample_share"], $table->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $table->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $table->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $table->getDataLag());
        $this->assertEquals($fixtures["totals"], $table->getTotals());
    }

    public function testGetComparisonSegments()
    {
        $fixtures = Stat::$comparisonFixtures;

        $mock = $this->getMockBuilder(DataClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getComparisonSegments(new Models\ComparisonParams());

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $table->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $table->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1_a"], $table->getQuery()->getDate1A());
        $this->assertEquals($fixtures["query"]["date2_a"], $table->getQuery()->getDate2A());
        $this->assertEquals($fixtures["query"]["date1_b"], $table->getQuery()->getDate1B());
        $this->assertEquals($fixtures["query"]["date2_b"], $table->getQuery()->getDate2B());

        $data = $table->getData();

        $this->assertEquals($fixtures["data"][0]["metrics"]["a"], $data->current()->getMetrics()->getA());
        $this->assertEquals($fixtures["data"][0]["metrics"]["b"], $data->current()->getMetrics()->getB());

        $this->assertEquals($fixtures["total_rows"], $table->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $table->getSampled());
        $this->assertEquals($fixtures["sample_share"], $table->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $table->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $table->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $table->getDataLag());
        $this->assertEquals($fixtures["totals"]["a"], $table->getTotals()->getA());
        $this->assertEquals($fixtures["totals"]["b"], $table->getTotals()->getB());
    }

    public function testGetComparisonDrillDown()
    {
        $fixtures = Stat::$drillDownComparisonFixtures;

        $mock = $this->getMockBuilder(DataClient::class)
            ->setMethods(['sendGetRequest'])
            ->getMock();
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getComparisonDrillDown(new Models\DrillDownComparisonParams());

        $this->assertEquals($fixtures["query"]["id"], $table->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["preset"], $table->getQuery()->getPreset());
        $this->assertEquals($fixtures["query"]["dimensions"], $table->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $table->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $table->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $table->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $table->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1_a"], $table->getQuery()->getDate1A());
        $this->assertEquals($fixtures["query"]["date2_a"], $table->getQuery()->getDate2A());
        $this->assertEquals($fixtures["query"]["date1_b"], $table->getQuery()->getDate1B());
        $this->assertEquals($fixtures["query"]["date2_b"], $table->getQuery()->getDate2B());

        $data = $table->getData();

        $this->assertEquals($fixtures["data"][0]["dimension"]["name"], $data->current()->getDimension()->getName());
        $this->assertEquals($fixtures["data"][0]["dimension"]["id"], $data->current()->getDimension()->getId());
        $this->assertEquals($fixtures["data"][0]["metrics"]["a"], $data->current()->getMetrics()->getA());
        $this->assertEquals($fixtures["data"][0]["metrics"]["b"], $data->current()->getMetrics()->getB());
        $this->assertEquals($fixtures["data"][0]["expand"], $data->current()->getExpand());
        $this->assertEquals($fixtures["data"][1]["dimension"]["name"], $data->next()->getDimension()->getName());
        $this->assertEquals($fixtures["data"][1]["dimension"]["id"], $data->current()->getDimension()->getId());
        $this->assertEquals($fixtures["data"][1]["metrics"]["a"], $data->current()->getMetrics()->getA());
        $this->assertEquals($fixtures["data"][1]["metrics"]["b"], $data->current()->getMetrics()->getB());
        $this->assertEquals($fixtures["data"][1]["expand"], $data->current()->getExpand());

        $this->assertEquals($fixtures["total_rows"], $table->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $table->getSampled());
        $this->assertEquals($fixtures["sample_share"], $table->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $table->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $table->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $table->getDataLag());
        $this->assertEquals($fixtures["totals"]["a"], $table->getTotals()->getA());
        $this->assertEquals($fixtures["totals"]["b"], $table->getTotals()->getB());
    }

    public function testGenerateRequest()
    {
        $id = 123;
        $limit = 100;
        $dimensions = ['dimension1', 'deimension2'];
        $sort = 'sort';
        $filter = 'a<b';
        $byTimeParams = new Models\ByTimeParams();
        $byTimeParams->setId($id)
            ->setLimit($limit)
            ->setDimensions($dimensions)
            ->setSort($sort)
            ->setFilters($filter)
            ->setMetrics(null);
        $client = new DataClient();
        $url = $client->getServiceUrl('bytime', $byTimeParams->toArray());
        $expectedUrl = 'https://api-metrika.yandex.ru/stat/v1/data/bytime.json?oauth_token=&id=' . $id . '&dimensions='
              . urlencode(implode(',', $dimensions)) . '&sort=' . $sort . '&limit=' . $limit . '&filters=' . urlencode($filter);
        $this->assertEquals($expectedUrl, $url);
    }
}
