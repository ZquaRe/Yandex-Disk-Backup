<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\SearchClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  09.01.2016 15:38
 */
class SearchClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/search.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $searchClientMock = $this->getMockBuilder(SearchClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $searchClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $searchResponse = $searchClientMock->get(['geo_id' => 44, 'text' => 'Motul 8100 X-cess 5W-40']);

        $this->assertEquals(
            $jsonObj->searchResult->count,
            $searchResponse->getCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->total,
            $searchResponse->getTotal()
        );
        $this->assertEquals(
            $jsonObj->searchResult->page,
            $searchResponse->getPage()
        );

        /** @var SearchResults $searchResults */
        $searchResults = $searchResponse->getItems();

        /** @var ModelSingle $model0 */
        $model0 = $searchResults->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->id,
            $model0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->name,
            $model0->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->description,
            $model0->getDescription()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->categoryId,
            $model0->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->link,
            $model0->getLink()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->vendorId,
            $model0->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->offersCount,
            $model0->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->rating,
            $model0->getRating()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->reviewsCount,
            $model0->getReviewsCount()
        );

        /** @var Prices $prices */
        $prices = $model0->getPrices();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->min,
            $prices->getMin()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->max,
            $prices->getMax()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->avg,
            $prices->getAvg()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->curCode,
            $prices->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->curName,
            $prices->getCurrencyName()
        );


        /** @var Photo $mainPhoto */
        $mainPhoto = $model0->getMainPhoto();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->url,
            $mainPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->width,
            $mainPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->height,
            $mainPhoto->getHeight()
        );

        /** @var Photo $bigPhoto */
        $bigPhoto = $model0->getMainPhoto();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->bigPhoto->url,
            $bigPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->bigPhoto->width,
            $bigPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->bigPhoto->height,
            $bigPhoto->getHeight()
        );

        /** @var Photo $previewPhoto */
        $previewPhoto = $model0->getPreviewPhoto();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->previewPhoto->url,
            $previewPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->previewPhoto->width,
            $previewPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->previewPhoto->height,
            $previewPhoto->getHeight()
        );

        /** @var Offer $offer0 */
        $offer0 = $searchResults->next();

        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->id,
            $offer0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->modelId,
            $offer0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->categoryId,
            $offer0->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->vendorId,
            $offer0->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->name,
            $offer0->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->onStock,
            $offer0->getOnStock()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->url,
            $offer0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->warranty,
            $offer0->getWarranty()
        );

        /** @var Price $price */
        $price = $offer0->getPrice();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->price->value,
            $price->getValue()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->price->currencyCode,
            $price->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->price->currencyName,
            $price->getCurrencyName()
        );

        /** @var ShopInfo $shop */
        $shop = $offer0->getShopInfo();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->shopInfo->id,
            $shop->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->shopInfo->name,
            $shop->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->shopInfo->status,
            $shop->getStatus()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->shopInfo->rating,
            $shop->getRating()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->shopInfo->gradeTotal,
            $shop->getGradeTotal()
        );

        /** @var Phone $phone */
        $phone = $offer0->getPhone();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->phone->number,
            $phone->getNumber()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->phone->sanitizedNumber,
            $phone->getSanitizedNumber()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->phone->call,
            $phone->getCall()
        );

        /** @var Delivery $delivery */
        $delivery = $offer0->getDelivery();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->description,
            $delivery->getDescription()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->priorityRegion,
            $delivery->getPriorityRegionId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->regionName,
            $delivery->getRegionName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->userRegionName,
            $delivery->getUserRegionName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->pickup,
            $delivery->getPickup()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->store,
            $delivery->getStore()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->delivery,
            $delivery->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->free,
            $delivery->getFree()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->deliveryIncluded,
            $delivery->getDeliveryIncluded()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->downloadable,
            $delivery->getDownloadable()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->priority,
            $delivery->getPriority()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->brief,
            $delivery->getBrief()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->full,
            $delivery->getFull()
        );

        /** @var Price $deliveryPrice */
        $deliveryPrice = $delivery->getPrice();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->price->value,
            $deliveryPrice->getValue()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->price->currencyCode,
            $deliveryPrice->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->delivery->price->currencyName,
            $deliveryPrice->getCurrencyName()
        );

        /** @var OfferPhotos $photos */
        $photos = $offer0->getPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[0]->height,
            $photo0->getHeight()
        );

        /** @var OfferPhoto $photo1 */
        $photo1 = $photos->next();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[1]->id,
            $photo1->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[1]->url,
            $photo1->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[1]->width,
            $photo1->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->photos[1]->height,
            $photo1->getHeight()
        );

        /** @var OfferPhoto $bigPhoto */
        $bigPhoto = $offer0->getBigPhoto();

        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->bigPhoto->id,
            $bigPhoto->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->bigPhoto->url,
            $bigPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->bigPhoto->width,
            $bigPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->bigPhoto->height,
            $bigPhoto->getHeight()
        );

        /** @var OfferPhotos $previewPhotos */
        $previewPhotos = $offer0->getPreviewPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $previewPhotos->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[0]->height,
            $photo0->getHeight()
        );

        /** @var OfferPhoto $photo1 */
        $photo1 = $previewPhotos->next();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[1]->id,
            $photo1->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[1]->url,
            $photo1->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[1]->width,
            $photo1->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->previewPhotos[1]->height,
            $photo1->getHeight()
        );

        /** @var Outlet $outlet */
        $outlet = $offer0->getOutlet();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->pointId,
            $outlet->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->pointName,
            $outlet->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->pointType,
            $outlet->getType()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->localityName,
            $outlet->getLocalityName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->thoroughfareName,
            $outlet->getThoroughfareName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->premiseNumber,
            $outlet->getPremiseNumber()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->shopId,
            $outlet->getShopId()
        );

        /** @var Phone $outletPhone */
        $outletPhone = $outlet->getPhone();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->phone->country,
            $outletPhone->getCountry()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->phone->city,
            $outletPhone->getCity()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->phone->number,
            $outletPhone->getNumber()
        );

        /** @var Schedules $schedules */
        $schedules = $outlet->getSchedules();

        /** @var Schedule $schedule0 */
        $schedule0 = $schedules->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->schedule[0]->workingDaysFrom,
            $schedule0->getWorkingDaysFrom()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->schedule[0]->workingDaysTill,
            $schedule0->getWorkingDaysTill()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->schedule[0]->workingHoursFrom,
            $schedule0->getWorkingHoursFrom()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->schedule[0]->workingHoursTill,
            $schedule0->getWorkingHoursTill()
        );

        /** @var Geo $outletGeo */
        $outletGeo = $outlet->getGeo();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->geo->geoId,
            $outletGeo->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->geo->longitude,
            $outletGeo->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->outlet->geo->latitude,
            $outletGeo->getLatitude()
        );

        /** @var Vendor $vendor */
        $vendor = $offer0->getVendor();
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[1]->offer->vendor->site,
            $vendor->getSite()
        );

        $this->assertEquals(
            $jsonObj->searchResult->regionDelimiterPosition,
            $searchResponse->getRegionDelimiterPosition()
        );

        /** @var SearchRequestParams $requestParams */
        $requestParams = $searchResponse->getRequestParams();
        $this->assertEquals(
            $jsonObj->searchResult->requestParams->text,
            $requestParams->getText()
        );
        $this->assertEquals(
            $jsonObj->searchResult->requestParams->actualText,
            $requestParams->getActualText()
        );
        $this->assertEquals(
            $jsonObj->searchResult->requestParams->checkSpelling,
            $requestParams->getCheckSpelling()
        );

        /** @var Categories $categories */
        $categories = $searchResponse->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();
        $this->assertEquals(
            $jsonObj->searchResult->categories[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->categories[0]->name,
            $category0->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->categories[0]->count,
            $category0->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->categories[0]->visual,
            $category0->getIsVisual()
        );
        $this->assertEquals(
            $jsonObj->searchResult->categories[0]->uniq_name,
            $category0->getUniqueName()
        );
    }

    function testGetFilterCategory()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/search-filter-category-models.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $searchClientMock = $this->getMockBuilder(SearchClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $searchClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $searchFilterCategoryResponse = $searchClientMock->getFilterCategory(90478, ['geo_id' => 44, 'count' => 1]);

        $this->assertEquals(
            $jsonObj->searchResult->count,
            $searchFilterCategoryResponse->getCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->total,
            $searchFilterCategoryResponse->getTotal()
        );
        $this->assertEquals(
            $jsonObj->searchResult->page,
            $searchFilterCategoryResponse->getPage()
        );

        /** @var SearchResults $searchResults */
        $searchResults = $searchFilterCategoryResponse->getItems();

        /** @var ModelSingle $model0 */
        $model0 = $searchResults->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->id,
            $model0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->name,
            $model0->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->description,
            $model0->getDescription()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->categoryId,
            $model0->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->link,
            $model0->getLink()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->vendorId,
            $model0->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->isGroup,
            $model0->getIsGroup()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->vendor,
            $model0->getVendorName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->offersCount,
            $model0->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->isNew,
            $model0->getIsNew()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->rating,
            $model0->getRating()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->gradeCount,
            $model0->getGradesCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->reviewsCount,
            $model0->getReviewsCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->articlesCount,
            $model0->getArticlesCount()
        );

        /** @var Prices $prices */
        $prices = $model0->getPrices();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->min,
            $prices->getMin()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->max,
            $prices->getMax()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->avg,
            $prices->getAvg()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->curCode,
            $prices->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->prices->curName,
            $prices->getCurrencyName()
        );

        /** @var Photo $mainPhoto */
        $mainPhoto = $model0->getMainPhoto();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->url,
            $mainPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->width,
            $mainPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->model->mainPhoto->height,
            $mainPhoto->getHeight()
        );

        // Test offers result (non-guru category)
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/search-filter-category-offers.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $searchClientMock = $this->getMockBuilder(SearchClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $searchClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $searchFilterCategoryResponse = $searchClientMock->getFilterCategory(90478, ['geo_id' => 44, 'count' => 1]);

        $this->assertEquals(
            $jsonObj->searchResult->count,
            $searchFilterCategoryResponse->getCount()
        );
        $this->assertEquals(
            $jsonObj->searchResult->total,
            $searchFilterCategoryResponse->getTotal()
        );
        $this->assertEquals(
            $jsonObj->searchResult->page,
            $searchFilterCategoryResponse->getPage()
        );

        /** @var SearchResults $searchResults */
        $searchResults = $searchFilterCategoryResponse->getItems();

        /** @var Offer $offer0 */
        $offer0 = $searchResults->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->id,
            $offer0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->categoryId,
            $offer0->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->vendorId,
            $offer0->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->name,
            $offer0->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->onStock,
            $offer0->getOnStock()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->url,
            $offer0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->warranty,
            $offer0->getWarranty()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->description,
            $offer0->getDescription()
        );

        /** @var Price $price */
        $price = $offer0->getPrice();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->price->value,
            $price->getValue()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->price->currencyCode,
            $price->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->price->currencyName,
            $price->getCurrencyName()
        );

        /** @var ShopInfo $shop */
        $shop = $offer0->getShopInfo();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->shopInfo->id,
            $shop->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->shopInfo->name,
            $shop->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->shopInfo->status,
            $shop->getStatus()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->shopInfo->rating,
            $shop->getRating()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->shopInfo->gradeTotal,
            $shop->getGradeTotal()
        );

        /** @var Phone $phone */
        $phone = $offer0->getPhone();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->phone->number,
            $phone->getNumber()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->phone->sanitizedNumber,
            $phone->getSanitizedNumber()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->phone->call,
            $phone->getCall()
        );

        /** @var Delivery $delivery */
        $delivery = $offer0->getDelivery();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->description,
            $delivery->getDescription()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->priorityRegion,
            $delivery->getPriorityRegionId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->regionName,
            $delivery->getRegionName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->userRegionName,
            $delivery->getUserRegionName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->pickup,
            $delivery->getPickup()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->store,
            $delivery->getStore()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->delivery,
            $delivery->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->free,
            $delivery->getFree()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->deliveryIncluded,
            $delivery->getDeliveryIncluded()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->downloadable,
            $delivery->getDownloadable()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->priority,
            $delivery->getPriority()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->brief,
            $delivery->getBrief()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->full,
            $delivery->getFull()
        );

        /** @var Price $deliveryPrice */
        $deliveryPrice = $delivery->getPrice();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->price->value,
            $deliveryPrice->getValue()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->price->currencyCode,
            $deliveryPrice->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->price->currencyName,
            $deliveryPrice->getCurrencyName()
        );

        /** @var DeliveryMethods $method0 */
        $deliveryMethods = $delivery->getMethods();

        /** @var DeliveryMethod $method0 */
        $method0 = $deliveryMethods->current();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->delivery->methods[0]->serviceName,
            $method0->getServiceName()
        );

        /** @var OfferPhotos $photos */
        $photos = $offer0->getPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->photos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->photos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->photos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->photos[0]->height,
            $photo0->getHeight()
        );

        /** @var OfferPhoto $bigPhoto */
        $bigPhoto = $offer0->getBigPhoto();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->bigPhoto->id,
            $bigPhoto->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->bigPhoto->url,
            $bigPhoto->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->bigPhoto->width,
            $bigPhoto->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->bigPhoto->height,
            $bigPhoto->getHeight()
        );

        /** @var OfferPhotos $previewPhotos */
        $previewPhotos = $offer0->getPreviewPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $previewPhotos->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->previewPhotos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->previewPhotos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->previewPhotos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->previewPhotos[0]->height,
            $photo0->getHeight()
        );

        /** @var Outlet $outlet */
        $outlet = $offer0->getOutlet();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->pointId,
            $outlet->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->pointName,
            $outlet->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->pointType,
            $outlet->getType()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->localityName,
            $outlet->getLocalityName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->thoroughfareName,
            $outlet->getThoroughfareName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->shopId,
            $outlet->getShopId()
        );

        /** @var Phone $outletPhone */
        $outletPhone = $outlet->getPhone();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->phone->country,
            $outletPhone->getCountry()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->phone->city,
            $outletPhone->getCity()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->phone->number,
            $outletPhone->getNumber()
        );

        /** @var Schedules $schedules */
        $schedules = $outlet->getSchedules();

        /** @var Schedule $schedule0 */
        $schedule0 = $schedules->current();

        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->schedule[0]->workingDaysFrom,
            $schedule0->getWorkingDaysFrom()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->schedule[0]->workingDaysTill,
            $schedule0->getWorkingDaysTill()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->schedule[0]->workingHoursFrom,
            $schedule0->getWorkingHoursFrom()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->schedule[0]->workingHoursTill,
            $schedule0->getWorkingHoursTill()
        );

        /** @var Geo $outletGeo */
        $outletGeo = $outlet->getGeo();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->geo->geoId,
            $outletGeo->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->geo->longitude,
            $outletGeo->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->outlet->geo->latitude,
            $outletGeo->getLatitude()
        );

        /** @var Vendor $vendor */
        $vendor = $offer0->getVendor();
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->vendor->site,
            $vendor->getSite()
        );
        $this->assertEquals(
            $jsonObj->searchResult->results[0]->offer->vendor->picture,
            $vendor->getPictureUrl()
        );
    }
}
