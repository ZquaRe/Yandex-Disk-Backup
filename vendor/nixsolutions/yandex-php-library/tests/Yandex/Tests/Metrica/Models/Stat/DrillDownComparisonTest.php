<?php
namespace Yandex\Tests\Metrica\Models\Stat;

use Yandex\Tests\Metrica\Fixtures\Stat;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Stat\Models;

class DrillDownComparisonTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Stat::$drillDownComparisonFixtures;

        $query = new Models\ComparisonQuery();
        $query
            ->setId($fixtures["query"]["id"])
            ->setPreset($fixtures["query"]["preset"])
            ->setDimensions($fixtures["query"]["dimensions"])
            ->setMetrics($fixtures["query"]["metrics"])
            ->setSort($fixtures["query"]["sort"])
            ->setLimit($fixtures["query"]["limit"])
            ->setOffset($fixtures["query"]["offset"])
            ->setDate1A($fixtures["query"]["date1_a"])
            ->setDate2A($fixtures["query"]["date2_a"])
            ->setDate1B($fixtures["query"]["date1_b"])
            ->setDate2B($fixtures["query"]["date2_b"]);


        $dimension = new Models\Dimension();
        $dimension
            ->setId($fixtures["data"][0]["dimension"]["id"])
            ->setName($fixtures["data"][0]["dimension"]["name"]);

        $metrics = new Models\ComparisonMetrics();
        $metrics
            ->setA($fixtures["data"][0]["metrics"]["a"])
            ->setB($fixtures["data"][0]["metrics"]["b"]);

        $items = new Models\DrillDownComparisonItems();
        $items
            ->setDimension($dimension)
            ->setMetrics($metrics)
            ->setExpand($fixtures["data"][0]["expand"]);

        $totals = new Models\ComparisonTotals();
        $totals
            ->setA($fixtures['totals']['a'])
            ->setB($fixtures['totals']['b']);

        $data = new Models\DrillDownComparisonData();
        $data->add($items);

        $comparison = new Models\DrillDownComparison();
        $comparison->setQuery($query)
            ->setData($data)
            ->setTotalRows($fixtures['total_rows'])
            ->setSampled($fixtures['sampled'])
            ->setSampleShare($fixtures['sample_share'])
            ->setSampleSize($fixtures['sample_size'])
            ->setSampleSpace($fixtures['sample_space'])
            ->setDataLag($fixtures['data_lag'])
            ->setTotals($totals);

        $this->assertEquals($fixtures["query"]["id"], $comparison->getQuery()->getId());
        $this->assertEquals($fixtures["query"]["preset"], $comparison->getQuery()->getPreset());
        $this->assertEquals($fixtures["query"]["dimensions"], $comparison->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $comparison->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $comparison->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $comparison->getQuery()->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $comparison->getQuery()->getOffset());
        $this->assertEquals($fixtures["query"]["date1_a"], $comparison->getQuery()->getDate1A());
        $this->assertEquals($fixtures["query"]["date2_a"], $comparison->getQuery()->getDate2A());
        $this->assertEquals($fixtures["query"]["date1_b"], $comparison->getQuery()->getDate1B());
        $this->assertEquals($fixtures["query"]["date2_b"], $comparison->getQuery()->getDate2B());

        $getData = $comparison->getData()->getAll();

        $this->assertEquals(
            $fixtures["data"][0]["dimension"]["name"],
            $getData[0]->getDimension()->getName()
        );
        $this->assertEquals(
            $fixtures["data"][0]["dimension"]["id"],
            $getData[0]->getDimension()->getId()
        );
        $this->assertEquals(
            $fixtures["data"][0]["metrics"]["a"],
            $getData[0]->getMetrics()->getA()
        );
        $this->assertEquals(
            $fixtures["data"][0]["metrics"]["b"],
            $getData[0]->getMetrics()->getB()
        );
        $this->assertEquals(
            $fixtures["data"][0]["expand"],
            $getData[0]->getExpand()
        );

        $this->assertEquals($fixtures["total_rows"], $comparison->getTotalRows());
        $this->assertEquals($fixtures["sampled"], $comparison->getSampled());
        $this->assertEquals($fixtures["sample_share"], $comparison->getSampleShare());
        $this->assertEquals($fixtures["sample_size"], $comparison->getSampleSize());
        $this->assertEquals($fixtures["sample_space"], $comparison->getSampleSpace());
        $this->assertEquals($fixtures["data_lag"], $comparison->getDataLag());
        $this->assertEquals($fixtures["totals"]["a"], $comparison->getTotals()->getA());
        $this->assertEquals($fixtures["totals"]["b"], $comparison->getTotals()->getB());
    }
}
 