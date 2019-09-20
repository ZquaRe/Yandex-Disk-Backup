<?php
namespace Yandex\Tests\Metrica\Models\Analytics;

use Yandex\Tests\Metrica\Fixtures\Analytics;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Analytics\Models;

class GaTest extends TestCase
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
            ->setStartDate($fixtures['query']['start-date'])
            ->setEndDate($fixtures['query']['end-date'])
            ->setStartIndex($fixtures['query']['start-index'])
            ->setMaxResults($fixtures['query']['max-results']);

        $header = new Models\Header();
        $header
            ->setName($fixtures['columnHeaders'][0]['name'])
            ->setDataType($fixtures['columnHeaders'][0]['dataType'])
            ->setColumnType($fixtures['columnHeaders'][0]['columnType']);
        
        $headers = new Models\ColumnHeaders();
        $headers->add($header);
        
        $ga = new Models\Ga();
        $ga->setKind($fixtures['kind'])
            ->setId($fixtures['id'])
            ->setSelfLink($fixtures['selfLink'])
            ->setContainsSampledData($fixtures['containsSampledData'])
            ->setSampleSize($fixtures['sampleSize'])
            ->setSampleSpace($fixtures['sampleSpace'])
            ->setQuery($query)
            ->setItemsPerPage($fixtures['itemsPerPage'])
            ->setTotalResults($fixtures['totalResults'])
            ->setColumnHeaders($headers)
            ->setTotalsForAllResults($fixtures['totalsForAllResults'])
            ->setRows($fixtures['rows']);
            

        $this->assertEquals($fixtures["kind"], $ga->getKind());
        $this->assertEquals($fixtures["id"], $ga->getId());
        $this->assertEquals($fixtures["selfLink"], $ga->getSelfLink());
        $this->assertEquals($fixtures["containsSampledData"], $ga->getContainsSampledData());
        $this->assertEquals($fixtures["sampleSize"], $ga->getSampleSize());
        $this->assertEquals($fixtures["sampleSpace"], $ga->getSampleSpace());

        $this->assertEquals($fixtures["itemsPerPage"], $ga->getItemsPerPage());
        $this->assertEquals($fixtures["totalResults"], $ga->getTotalResults());
        $this->assertEquals($fixtures["totalsForAllResults"], $ga->getTotalsForAllResults());

        $this->assertEquals($fixtures["query"]["ids"], $ga->getQuery()->getIds());
        $this->assertEquals($fixtures["query"]["dimensions"], $ga->getQuery()->getDimensions());
        $this->assertEquals($fixtures["query"]["metrics"], $ga->getQuery()->getMetrics());
        $this->assertEquals($fixtures["query"]["sort"], $ga->getQuery()->getSort());
        $this->assertEquals($fixtures["query"]["start-date"], $ga->getQuery()->getStartDate());
        $this->assertEquals($fixtures["query"]["end-date"], $ga->getQuery()->getEndDate());
        $this->assertEquals($fixtures["query"]["start-index"], $ga->getQuery()->getStartIndex());
        $this->assertEquals($fixtures["query"]["max-results"], $ga->getQuery()->getMaxResults());

        $columnHeaders = $ga->getColumnHeaders()->getAll();

        $this->assertEquals($fixtures["columnHeaders"][0]["name"], $columnHeaders[0]->getName());
        $this->assertEquals(
            $fixtures["columnHeaders"][0]["columnType"],
            $columnHeaders[0]->getColumnType()
        );
        $this->assertEquals(
            $fixtures["columnHeaders"][0]["dataType"],
            $columnHeaders[0]->getDataType()
        );

        $this->assertEquals($fixtures["rows"], $ga->getRows());
    }
}
 