<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market\Content;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\ShopClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  08.01.2016 14:01
 */
class ShopClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/shop.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $shopClientMock = $this->getMockBuilder(ShopClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $shopClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $shop = $shopClientMock->get(30297);

        $this->assertEquals(
            $jsonObj->shop->id,
            $shop->getId()
        );
        $this->assertEquals(
            $jsonObj->shop->name,
            $shop->getName()
        );
        $this->assertEquals(
            $jsonObj->shop->shopName,
            $shop->getShopName()
        );
        $this->assertEquals(
            $jsonObj->shop->url,
            $shop->getUrl()
        );
        $this->assertEquals(
            $jsonObj->shop->ogrn,
            $shop->getOgrn()
        );
        $this->assertEquals(
            $jsonObj->shop->juridicalAddress,
            $shop->getJuridicalAddress()
        );
        $this->assertEquals(
            $jsonObj->shop->factAddress,
            $shop->getFactAddress()
        );
        $this->assertEquals(
            $jsonObj->shop->type,
            $shop->getType()
        );
        $this->assertEquals(
            $jsonObj->shop->status,
            $shop->getStatus()
        );
        $this->assertEquals(
            $jsonObj->shop->rating,
            $shop->getRating()
        );
        $this->assertEquals(
            $jsonObj->shop->gradeTotal,
            $shop->getGradeTotal()
        );
    }

    function testGetMatch()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/shop-match.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $shopClientMock = $this->getMockBuilder(ShopClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $shopClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $shopMatch = $shopClientMock->getMatch(['host' => 'proxenum.ru', 'fields' => 'juridical,rating']);

        $shop = $shopMatch->getShop();

        $this->assertEquals(
            $jsonObj->shops[0]->id,
            $shop->getId()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->name,
            $shop->getName()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->shopName,
            $shop->getShopName()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->url,
            $shop->getUrl()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->ogrn,
            $shop->getOgrn()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->juridicalAddress,
            $shop->getJuridicalAddress()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->factAddress,
            $shop->getFactAddress()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->type,
            $shop->getType()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->rating,
            $shop->getRating()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->gradeTotal,
            $shop->getGradeTotal()
        );
        $this->assertEquals(
            $jsonObj->shops[0]->regionId,
            $shop->getRegionId()
        );
    }

    function testGetOutlets()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/shop-outlets.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $shopClientMock = $this->getMockBuilder(ShopClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $shopClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $modelOutlets = $shopClientMock->getOutlets(4779, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->outlets->count,
            $modelOutlets->getCount()
        );
        $this->assertEquals(
            $jsonObj->outlets->total,
            $modelOutlets->getTotal()
        );
        $this->assertEquals(
            $jsonObj->outlets->page,
            $modelOutlets->getPage()
        );

        // Outlets
        $outlets = $modelOutlets->getItems();

        /** @var Outlet $outlet0 */
        $outlet0 = $outlets->current();

        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->pointId,
            $outlet0->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->pointName,
            $outlet0->getName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->pointType,
            $outlet0->getType()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->localityName,
            $outlet0->getLocalityName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->thoroughfareName,
            $outlet0->getThoroughfareName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->premiseNumber,
            $outlet0->getPremiseNumber()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->shopId,
            $outlet0->getShopId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->block,
            $outlet0->getBlock()
        );

        // Phone
        $phone = $outlet0->getPhone();
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->country,
            $phone->getCountry()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->city,
            $phone->getCity()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->number,
            $phone->getNumber()
        );

        // Schedules
        $schedules = $outlet0->getSchedules();

        /** @var Schedule $schedule0 */
        $schedule0 = $schedules->current();

        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->schedule[0]->workingDaysFrom,
            $schedule0->getWorkingDaysFrom()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->schedule[0]->workingDaysTill,
            $schedule0->getWorkingDaysTill()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->schedule[0]->workingHoursFrom,
            $schedule0->getWorkingHoursFrom()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->schedule[0]->workingHoursTill,
            $schedule0->getWorkingHoursTill()
        );

        // Geo
        $geo = $outlet0->getGeo();
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->geoId,
            $geo->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->longitude,
            $geo->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->latitude,
            $geo->getLatitude()
        );


        /** @var Outlet $outlet1 */
        $outlet1 = $outlets->next();

        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->pointId,
            $outlet1->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->pointName,
            $outlet1->getName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->pointType,
            $outlet1->getType()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->localityName,
            $outlet1->getLocalityName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->thoroughfareName,
            $outlet1->getThoroughfareName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->premiseNumber,
            $outlet1->getPremiseNumber()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->shopId,
            $outlet1->getShopId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->block,
            $outlet1->getBlock()
        );

        // Phone
        $phone = $outlet1->getPhone();
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->phone->country,
            $phone->getCountry()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->phone->city,
            $phone->getCity()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->phone->number,
            $phone->getNumber()
        );

        // Schedules
        $schedules = $outlet1->getSchedules();

        /** @var Schedule $schedule0 */
        $schedule0 = $schedules->current();

        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->schedule[0]->workingDaysFrom,
            $schedule0->getWorkingDaysFrom()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->schedule[0]->workingDaysTill,
            $schedule0->getWorkingDaysTill()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->schedule[0]->workingHoursFrom,
            $schedule0->getWorkingHoursFrom()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->schedule[0]->workingHoursTill,
            $schedule0->getWorkingHoursTill()
        );

        // Geo
        $geo = $outlet1->getGeo();

        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->geo->geoId,
            $geo->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->geo->longitude,
            $geo->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[1]->geo->latitude,
            $geo->getLatitude()
        );
    }

    function testGetOpinions()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/shop-opinions.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $shopClientMock = $this->getMockBuilder(ShopClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $shopClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $responseOpinions = $shopClientMock->getOpinions(4779, ['sort' => 'rank', 'max_comments' => 10]);

        $this->assertEquals(
            $jsonObj->shopOpinions->total,
            $responseOpinions->getTotal()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->page,
            $responseOpinions->getPage()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->count,
            $responseOpinions->getCount()
        );

        /** @var ShopOpinions $opinions */
        $opinions = $responseOpinions->getItems();

        /** @var ShopOpinion $opinion0 */
        $opinion0 = $opinions->current();
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->id,
            $opinion0->getId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->date,
            $opinion0->getDate()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->grade,
            $opinion0->getGrade()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->agree,
            $opinion0->getAgree()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->reject,
            $opinion0->getReject()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->visibility,
            $opinion0->getVisibility()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->pro,
            (string)$opinion0->getPro()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->contra,
            (string)$opinion0->getContra()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->region,
            $opinion0->getRegion()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->shopOrderId,
            $opinion0->getShopOrderId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->delivery,
            $opinion0->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->problem,
            $opinion0->getProblem()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->anonymous,
            $opinion0->getAnonymous()
        );

        // Opinion Shop
        /** @var Shop $opinionShop */
        $opinionShop = $opinion0->getShop();

        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->shop->id,
            $opinionShop->getId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->shop->name,
            $opinionShop->getName()
        );

        // Opinion Comments
        /** @var Comments $opinionComments */
        $opinionComments = $opinion0->getComments();

        /** @var Comment $opinionComment0 */
        $opinionComment0 = $opinionComments->current();
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->id,
            $opinionComment0->getId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->rootId,
            $opinionComment0->getRootId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->parentId,
            $opinionComment0->getParentId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->title,
            $opinionComment0->getTitle()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->body,
            $opinionComment0->getBody()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->updateTimestamp,
            $opinionComment0->getUpdateTimestamp()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->valid,
            $opinionComment0->getIsValid()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->deleted,
            $opinionComment0->getIsDeleted()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->blocked,
            $opinionComment0->getIsBlocked()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->sticky,
            $opinionComment0->getIsSticky()
        );

        // Comment user
        /** @var User $opinionCommentUser */
        $opinionCommentUser = $opinionComment0->getUser();
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->user->id,
            $opinionCommentUser->getId()
        );

        // Children comments
        /** @var Comments $opinionChildrenComments */
        $opinionChildrenComments = $opinionComment0->getChildren();
        /** @var Comment $opinionChildrenComment0 */
        $opinionChildrenComment0 = $opinionChildrenComments->current();
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->id,
            $opinionChildrenComment0->getId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->rootId,
            $opinionChildrenComment0->getRootId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->parentId,
            $opinionChildrenComment0->getParentId()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->title,
            $opinionChildrenComment0->getTitle()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->body,
            $opinionChildrenComment0->getBody()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->updateTimestamp,
            $opinionChildrenComment0->getUpdateTimestamp()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->valid,
            $opinionChildrenComment0->getIsValid()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->deleted,
            $opinionChildrenComment0->getIsDeleted()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->blocked,
            $opinionChildrenComment0->getIsBlocked()
        );
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->sticky,
            $opinionChildrenComment0->getIsSticky()
        );

        // Comment user
        /** @var User $opinionChildrenCommentUser */
        $opinionChildrenCommentUser = $opinionChildrenComment0->getUser();
        $this->assertEquals(
            $jsonObj->shopOpinions->opinion[0]->comments[0]->children[0]->user->id,
            $opinionChildrenCommentUser->getId()
        );
    }
}
