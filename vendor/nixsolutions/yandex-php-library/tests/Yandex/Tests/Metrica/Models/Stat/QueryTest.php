<?php
namespace Yandex\Tests\Metrica\Models\Stat;

use Yandex\Tests\Metrica\Fixtures\Stat;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Stat\Models;

class QueryTest extends TestCase
{

    public function testGet()
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

        $this->assertEquals($fixtures["query"]["id"], $query->getId());
        $this->assertEquals($fixtures["query"]["dimensions"], $query->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $query->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $query->getSort());
        $this->assertEquals($fixtures["query"]["limit"], $query->getLimit());
        $this->assertEquals($fixtures["query"]["offset"], $query->getOffset());
        $this->assertEquals($fixtures["query"]["date1"], $query->getDate1());
        $this->assertEquals($fixtures["query"]["date2"], $query->getDate2());
    }
}
 