<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\OfferClient;
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
class OfferClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/offer.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $offerClientMock = $this->getMockBuilder(OfferClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $offerClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $offerResponse = $offerClientMock->get('P_mOdZYMfAYxuu2CdR0Kyg', array('geo_id'=>213));

        $offer = $offerResponse->getOffer();

        $this->assertEquals(
            $jsonObj->offer->id,
            $offer->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->modelId,
            $offer->getModelId()
        );
        $this->assertEquals(
            $jsonObj->offer->categoryId,
            $offer->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->offer->vendorId,
            $offer->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->offer->name,
            $offer->getName()
        );
        $this->assertEquals(
            $jsonObj->offer->onStock,
            $offer->getOnStock()
        );
        $this->assertEquals(
            $jsonObj->offer->url,
            $offer->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offer->warranty,
            $offer->getWarranty()
        );
        $this->assertEquals(
            $jsonObj->offer->description,
            $offer->getDescription()
        );
        $this->assertEquals(
            $jsonObj->offer->cpa,
            $offer->getCpa()
        );

        // Offer price
        $price = $offer->getPrice();

        $this->assertEquals(
            $jsonObj->offer->price->value,
            $price->getValue()
        );
        $this->assertEquals(
            $jsonObj->offer->price->currencyName,
            $price->getCurrencyName()
        );
        $this->assertEquals(
            $jsonObj->offer->price->currencyCode,
            $price->getCurrencyCode()
        );

        // Offer shop info
        $shop = $offer->getShopInfo();

        $this->assertEquals(
            $jsonObj->offer->shopInfo->id,
            $shop->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->shopInfo->name,
            $shop->getName()
        );
        $this->assertEquals(
            $jsonObj->offer->shopInfo->status,
            $shop->getStatus()
        );
        $this->assertEquals(
            $jsonObj->offer->shopInfo->rating,
            $shop->getRating()
        );
        $this->assertEquals(
            $jsonObj->offer->shopInfo->gradeTotal,
            $shop->getGradeTotal()
        );

        // Offer phone
        $phone = $offer->getPhone();

        $this->assertEquals(
            $jsonObj->offer->phone->number,
            $phone->getNumber()
        );
        $this->assertEquals(
            $jsonObj->offer->phone->sanitizedNumber,
            $phone->getSanitizedNumber()
        );
        $this->assertEquals(
            $jsonObj->offer->phone->call,
            $phone->getCall()
        );

        // Offer delivery
        $delivery = $offer->getDelivery();

        $this->assertEquals(
            $jsonObj->offer->delivery->description,
            $delivery->getDescription()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->priorityRegion,
            $delivery->getPriorityRegionId()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->regionName,
            $delivery->getRegionName()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->userRegionName,
            $delivery->getUserRegionName()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->pickup,
            $delivery->getPickup()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->store,
            $delivery->getStore()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->delivery,
            $delivery->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->free,
            $delivery->getFree()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->deliveryIncluded,
            $delivery->getDeliveryIncluded()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->downloadable,
            $delivery->getDownloadable()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->priority,
            $delivery->getPriority()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->brief,
            $delivery->getBrief()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->full,
            $delivery->getFull()
        );

        /** @var Price $deliveryPrice */
        $deliveryPrice = $delivery->getPrice();
        $this->assertEquals(
            $jsonObj->offer->delivery->price->value,
            $deliveryPrice->getValue()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->price->currencyCode,
            $deliveryPrice->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->offer->delivery->price->currencyName,
            $deliveryPrice->getCurrencyName()
        );

        // Offer Delivery methods
        $deliveryMethods = $delivery->getMethods();

        /** @var DeliveryMethod $method0 */
        $method0 = $deliveryMethods->current();

        $this->assertEquals(
            $jsonObj->offer->delivery->methods[0]->serviceName,
            $method0->getServiceName()
        );

        /** @var DeliveryMethod $method1 */
        $method1 = $deliveryMethods->next();

        $this->assertEquals(
            $jsonObj->offer->delivery->methods[1]->serviceName,
            $method1->getServiceName()
        );

        // Offer photos
        $photos = $offer->getPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->offer->photos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->photos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offer->photos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offer->photos[0]->height,
            $photo0->getHeight()
        );

        // Offer big photo
        $bigPhoto = $offer->getBigPhoto();


        // Big photo
        $this->assertEquals(
            $jsonObj->offer->bigPhoto->id,
            $bigPhoto->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->bigPhoto->url,
            $bigPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offer->bigPhoto->width,
            $bigPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offer->bigPhoto->height,
            $bigPhoto->getHeight()
        );

        // Preview photos
        $previewPhotos = $offer->getPreviewPhotos();

        /** @var OfferPhoto $photo0 */
        $previewPhoto0 = $previewPhotos->current();

        $this->assertEquals(
            $jsonObj->offer->previewPhotos[0]->id,
            $previewPhoto0->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->previewPhotos[0]->url,
            $previewPhoto0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offer->previewPhotos[0]->width,
            $previewPhoto0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offer->previewPhotos[0]->height,
            $previewPhoto0->getHeight()
        );


        // Outlet
        $outlet = $offer->getOutlet();

        $this->assertEquals(
            $jsonObj->offer->outlet->pointId,
            $outlet->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->pointName,
            $outlet->getName()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->pointType,
            $outlet->getType()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->localityName,
            $outlet->getLocalityName()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->thoroughfareName,
            $outlet->getThoroughfareName()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->premiseNumber,
            $outlet->getPremiseNumber()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->shopId,
            $outlet->getShopId()
        );

        // Outlet Phone
        $outletPhone = $outlet->getPhone();

        $this->assertEquals(
            $jsonObj->offer->outlet->phone->country,
            $outletPhone->getCountry()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->phone->city,
            $outletPhone->getCity()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->phone->number,
            $outletPhone->getNumber()
        );

        // Outlet Schedules
        $schedules = $outlet->getSchedules();

        /** @var Schedule $schedule0 */
        $schedule0=$schedules->current();

        $this->assertEquals(
            $jsonObj->offer->outlet->schedule[0]->workingDaysFrom,
            $schedule0->getWorkingDaysFrom()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->schedule[0]->workingDaysTill,
            $schedule0->getWorkingDaysTill()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->schedule[0]->workingHoursFrom,
            $schedule0->getWorkingHoursFrom()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->schedule[0]->workingHoursTill,
            $schedule0->getWorkingHoursTill()
        );

        // Outlet Geo
        $outletGeo = $outlet->getGeo();

        $this->assertEquals(
            $jsonObj->offer->outlet->geo->geoId,
            $outletGeo->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->geo->longitude,
            $outletGeo->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->offer->outlet->geo->latitude,
            $outletGeo->getLatitude()
        );

        // Vendor
        $vendor = $offer->getVendor();
        $this->assertEquals(
            $jsonObj->offer->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->offer->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->offer->vendor->site,
            $vendor->getSite()
        );
    }
}
