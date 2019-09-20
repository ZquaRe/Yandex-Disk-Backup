<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\GeoRegionClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  08.01.2016 02:20
 */
class GeoRegionClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetList()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/georegion-list.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $geoRegionClientMock = $this->getMockBuilder(GeoRegionClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $geoRegionClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $geoRegionsResponse = $geoRegionClientMock->getList();
        $this->assertEquals(
            $jsonObj->georegions->total,
            $geoRegionsResponse->getTotal()
        );
        $this->assertEquals(
            $jsonObj->georegions->page,
            $geoRegionsResponse->getPage()
        );
        $this->assertEquals(
            $jsonObj->georegions->count,
            $geoRegionsResponse->getCount()
        );

        /** @var GeoRegions $regions */
        $regions = $geoRegionsResponse->getItems();

        /** @var GeoRegion $region0 */
        $region0 = $regions->current();
        $this->assertEquals(
            $jsonObj->georegions->items[0]->id,
            $region0->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->parentId,
            $region0->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->type,
            $region0->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->name,
            $region0->getName()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->childrenCount,
            $region0->getChildrenCount()
        );

        /** @var GeoRegion $region1 */
        $region1 = $regions->next();
        $this->assertEquals(
            $jsonObj->georegions->items[1]->id,
            $region1->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->parentId,
            $region1->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->type,
            $region1->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->name,
            $region1->getName()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->childrenCount,
            $region1->getChildrenCount()
        );
    }

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/georegion.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $geoRegionClientMock = $this->getMockBuilder(GeoRegionClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $geoRegionClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $geoRegionResponse = $geoRegionClientMock->get(213);

        /** @var GeoRegion $region */
        $region = $geoRegionResponse->getGeoRegion();
        $this->assertEquals(
            $jsonObj->georegion->id,
            $region->getId()
        );
        $this->assertEquals(
            $jsonObj->georegion->parentId,
            $region->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegion->type,
            $region->getType()
        );
        $this->assertEquals(
            $jsonObj->georegion->name,
            $region->getName()
        );
        $this->assertEquals(
            $jsonObj->georegion->childrenCount,
            $region->getChildrenCount()
        );
    }

    function testGetChildren()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/georegion-children.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $geoRegionClientMock = $this->getMockBuilder(GeoRegionClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $geoRegionClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $geoRegionsResponse = $geoRegionClientMock->getChildren(213);

        $this->assertEquals(
            $jsonObj->georegions->total,
            $geoRegionsResponse->getTotal()
        );
        $this->assertEquals(
            $jsonObj->georegions->page,
            $geoRegionsResponse->getPage()
        );
        $this->assertEquals(
            $jsonObj->georegions->count,
            $geoRegionsResponse->getCount()
        );

        /** @var GeoRegions $regions */
        $regions = $geoRegionsResponse->getItems();

        /** @var GeoRegion $region0 */
        $region0 = $regions->current();
        $this->assertEquals(
            $jsonObj->georegions->items[0]->id,
            $region0->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->parentId,
            $region0->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->type,
            $region0->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->name,
            $region0->getName()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->childrenCount,
            $region0->getChildrenCount()
        );

        /** @var GeoRegion $region1 */
        $region1 = $regions->next();
        $this->assertEquals(
            $jsonObj->georegions->items[1]->id,
            $region1->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->parentId,
            $region1->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->type,
            $region1->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->name,
            $region1->getName()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->childrenCount,
            $region1->getChildrenCount()
        );
    }

    function testGetMatch()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/georegion-match.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $geoRegionClientMock = $this->getMockBuilder(GeoRegionClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $geoRegionClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $geoRegionsMatch = $geoRegionClientMock->getMatch(array('part_name' => 'мос'));

        $this->assertEquals(
            $jsonObj->georegions->total,
            $geoRegionsMatch->getTotal()
        );
        $this->assertEquals(
            $jsonObj->georegions->page,
            $geoRegionsMatch->getPage()
        );
        $this->assertEquals(
            $jsonObj->georegions->count,
            $geoRegionsMatch->getCount()
        );

        /** @var GeoRegions $regions */
        $regions = $geoRegionsMatch->getItems();

        /** @var GeoRegion $region0 */
        $region0 = $regions->current();
        $this->assertEquals(
            $jsonObj->georegions->items[0]->id,
            $region0->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->parentId,
            $region0->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->type,
            $region0->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[0]->name,
            $region0->getName()
        );

        /** @var GeoRegion $region1 */
        $region1 = $regions->next();
        $this->assertEquals(
            $jsonObj->georegions->items[1]->id,
            $region1->getId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->parentId,
            $region1->getParentId()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->type,
            $region1->getType()
        );
        $this->assertEquals(
            $jsonObj->georegions->items[1]->name,
            $region1->getName()
        );
    }

    function testGetShopsSummary()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/georegion-shops-summary.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $geoRegionClientMock = $this->getMockBuilder(GeoRegionClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $geoRegionClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $geoRegionShopsSummary = $geoRegionClientMock->getShopsSummary(44, ['fields'=>'delivery_count,home_count,total_count']);

        $this->assertEquals(
            $jsonObj->homeCount,
            $geoRegionShopsSummary->getHomeCount()
        );
        $this->assertEquals(
            $jsonObj->deliveryCount,
            $geoRegionShopsSummary->getDeliveryCount()
        );
        $this->assertEquals(
            $jsonObj->totalCount,
            $geoRegionShopsSummary->getTotalCount()
        );
    }
}
