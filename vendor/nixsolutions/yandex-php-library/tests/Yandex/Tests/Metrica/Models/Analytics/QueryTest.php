<?php
namespace Yandex\Tests\Metrica\Models\Analytics;

use Yandex\Tests\Metrica\Fixtures\Analytics;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Analytics\Models;

class QueryTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Analytics::$analyticsFixtures;

        $query = new Models\Query();
        $query
            ->setIds($fixtures['query']['ids'])
            ->setDimensions($fixtures['query']['dimensions'])
            ->setMetrics($fixtures['query']['metrics'])
            ->setSort($fixtures['query']['sort'])
            ->setFilters($fixtures['query']['filters'])
            ->setStartDate($fixtures['query']['start-date'])
            ->setEndDate($fixtures['query']['end-date'])
            ->setStartIndex($fixtures['query']['start-index'])
            ->setMaxResults($fixtures['query']['max-results']);

        $this->assertEquals($fixtures["query"]["ids"], $query->getIds());
        $this->assertEquals($fixtures["query"]["dimensions"], $query->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $query->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $query->getSort());
        $this->assertEquals($fixtures["query"]["filters"], $query->getFilters());
        $this->assertEquals($fixtures["query"]["start-date"], $query->getStartDate());
        $this->assertEquals($fixtures["query"]["end-date"], $query->getEndDate());
        $this->assertEquals($fixtures["query"]["start-index"], $query->getStartIndex());
        $this->assertEquals($fixtures["query"]["max-results"], $query->getMaxResults());
    }
}
 