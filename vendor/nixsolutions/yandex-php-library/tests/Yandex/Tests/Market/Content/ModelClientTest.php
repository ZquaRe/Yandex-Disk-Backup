<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\ModelClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  05.01.2016 19:12
 */
class ModelClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-single.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $model = $modelClientMock->get(12796745, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->model->id,
            $model->getId()
        );
        $this->assertEquals(
            $jsonObj->model->name,
            $model->getName()
        );
        $this->assertEquals(
            $jsonObj->model->description,
            $model->getDescription()
        );
        $this->assertEquals(
            $jsonObj->model->categoryId,
            $model->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->model->link,
            $model->getLink()
        );
        $this->assertEquals(
            $jsonObj->model->vendorId,
            $model->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->model->isGroup,
            $model->getIsGroup()
        );
        $this->assertEquals(
            $jsonObj->model->vendor,
            $model->getVendorName()
        );
        $this->assertEquals(
            $jsonObj->model->offersCount,
            $model->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->model->isNew,
            $model->getIsNew()
        );
        $this->assertEquals(
            $jsonObj->model->rating,
            $model->getRating()
        );
        $this->assertEquals(
            $jsonObj->model->gradeCount,
            $model->getGradesCount()
        );
        $this->assertEquals(
            $jsonObj->model->reviewsCount,
            $model->getReviewsCount()
        );
        $this->assertEquals(
            $jsonObj->model->articlesCount,
            $model->getArticlesCount()
        );

        // Prices
        $this->assertEquals(
            $jsonObj->model->prices->min,
            $model->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->prices->max,
            $model->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->prices->avg,
            $model->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curCode,
            $model->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curName,
            $model->getPrices()->getCurrencyName()
        );

        // Main photo
        $this->assertEquals(
            $jsonObj->model->mainPhoto->url,
            $model->getMainPhoto()->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->width,
            $model->getMainPhoto()->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->height,
            $model->getMainPhoto()->getHeight()
        );

        // Facts
        // @todo test of facts.

        // Photos
        $photos = $model->getPhotos();

        /** @var Photo $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->height,
            $photo0->getHeight()
        );

        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-parent.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $model = $modelClientMock->get(10452984, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->model->id,
            $model->getId()
        );
        $this->assertEquals(
            $jsonObj->model->name,
            $model->getName()
        );
        $this->assertEquals(
            $jsonObj->model->description,
            $model->getDescription()
        );
        $this->assertEquals(
            $jsonObj->model->categoryId,
            $model->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->model->link,
            $model->getLink()
        );
        $this->assertEquals(
            $jsonObj->model->vendorId,
            $model->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->model->isGroup,
            $model->getIsGroup()
        );
        $this->assertEquals(
            $jsonObj->model->vendor,
            $model->getVendorName()
        );
        $this->assertEquals(
            $jsonObj->model->offersCount,
            $model->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->model->isNew,
            $model->getIsNew()
        );
        $this->assertEquals(
            $jsonObj->model->rating,
            $model->getRating()
        );
        $this->assertEquals(
            $jsonObj->model->gradeCount,
            $model->getGradesCount()
        );
        $this->assertEquals(
            $jsonObj->model->reviewsCount,
            $model->getReviewsCount()
        );
        $this->assertEquals(
            $jsonObj->model->articlesCount,
            $model->getArticlesCount()
        );

        // Prices
        $this->assertEquals(
            $jsonObj->model->prices->min,
            $model->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->prices->max,
            $model->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->prices->avg,
            $model->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curCode,
            $model->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curName,
            $model->getPrices()->getCurrencyName()
        );

        // Main photo
        $this->assertEquals(
            $jsonObj->model->mainPhoto->url,
            $model->getMainPhoto()->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->width,
            $model->getMainPhoto()->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->height,
            $model->getMainPhoto()->getHeight()
        );

        // Facts
        // @todo test of facts.

        // Photos
        $photos = $model->getPhotos();

        /** @var Photo $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->height,
            $photo0->getHeight()
        );

        // Children
        $children = $model->getChildren();

        /** @var ModelChild $child0 */
        $child0 = $children->current();

        $this->assertEquals(
            $jsonObj->model->children->models[0]->id,
            $child0->getId()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->name,
            $child0->getName()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->popularity,
            $child0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->offersCount,
            $child0->getOffersCount()
        );

        // Child prices
        $this->assertEquals(
            $jsonObj->model->children->models[0]->prices->min,
            $child0->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->prices->max,
            $child0->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->prices->avg,
            $child0->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->prices->curCode,
            $child0->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[0]->prices->curName,
            $child0->getPrices()->getCurrencyName()
        );

        /** @var ModelChild $child1 */
        $child1 = $children->next();

        $this->assertEquals(
            $jsonObj->model->children->models[1]->id,
            $child1->getId()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->name,
            $child1->getName()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->popularity,
            $child1->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->offersCount,
            $child1->getOffersCount()
        );

        // Child prices
        $this->assertEquals(
            $jsonObj->model->children->models[1]->prices->min,
            $child1->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->prices->max,
            $child1->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->prices->avg,
            $child1->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->prices->curCode,
            $child1->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->children->models[1]->prices->curName,
            $child1->getPrices()->getCurrencyName()
        );


        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-child.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $model = $modelClientMock->get(10546667, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->model->id,
            $model->getId()
        );
        $this->assertEquals(
            $jsonObj->model->name,
            $model->getName()
        );
        $this->assertEquals(
            $jsonObj->model->description,
            $model->getDescription()
        );
        $this->assertEquals(
            $jsonObj->model->categoryId,
            $model->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->model->link,
            $model->getLink()
        );
        $this->assertEquals(
            $jsonObj->model->vendorId,
            $model->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->model->isGroup,
            $model->getIsGroup()
        );
        $this->assertEquals(
            $jsonObj->model->vendor,
            $model->getVendorName()
        );
        $this->assertEquals(
            $jsonObj->model->offersCount,
            $model->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->model->isNew,
            $model->getIsNew()
        );
        $this->assertEquals(
            $jsonObj->model->rating,
            $model->getRating()
        );
        $this->assertEquals(
            $jsonObj->model->gradeCount,
            $model->getGradesCount()
        );
        $this->assertEquals(
            $jsonObj->model->reviewsCount,
            $model->getReviewsCount()
        );
        $this->assertEquals(
            $jsonObj->model->articlesCount,
            $model->getArticlesCount()
        );

        // Prices
        $this->assertEquals(
            $jsonObj->model->prices->min,
            $model->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->prices->max,
            $model->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->prices->avg,
            $model->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curCode,
            $model->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curName,
            $model->getPrices()->getCurrencyName()
        );

        // Main photo
        $this->assertEquals(
            $jsonObj->model->mainPhoto->url,
            $model->getMainPhoto()->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->width,
            $model->getMainPhoto()->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->mainPhoto->height,
            $model->getMainPhoto()->getHeight()
        );

        // Facts
        // @todo test of facts.

        // Photos
        $photos = $model->getPhotos();

        /** @var Photo $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->photos->photo[0]->height,
            $photo0->getHeight()
        );

        // Parent Model
        $this->assertEquals(
            $jsonObj->model->parentModel->id,
            $model->getParent()->getId()
        );

        // visual model
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-visual.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $model = $modelClientMock->get(1598996536, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->model->id,
            $model->getId()
        );
        $this->assertEquals(
            $jsonObj->model->name,
            $model->getName()
        );
        $this->assertEquals(
            $jsonObj->model->description,
            $model->getDescription()
        );
        $this->assertEquals(
            $jsonObj->model->categoryId,
            $model->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->model->link,
            $model->getLink()
        );
        $this->assertEquals(
            $jsonObj->model->vendorId,
            $model->getVendorId()
        );
        $this->assertEquals(
            $jsonObj->model->offersCount,
            $model->getOffersCount()
        );

        // Prices
        $this->assertEquals(
            $jsonObj->model->prices->min,
            $model->getPrices()->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->prices->max,
            $model->getPrices()->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->prices->avg,
            $model->getPrices()->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curCode,
            $model->getPrices()->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->prices->curName,
            $model->getPrices()->getCurrencyName()
        );

        // Filters
        $filters = $model->getFilters();

        /** @var Filter $filter0 */
        $filter0 = $filters->current();
        $this->assertEquals(
            $jsonObj->model->filters[0]->id,
            $filter0->getId()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->name,
            $filter0->getName()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->shortname,
            $filter0->getShortName()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->type,
            $filter0->getType()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->unit,
            $filter0->getUnit()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->enumFilterType,
            $filter0->getEnumFilterType()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->exactly,
            $filter0->getExactly()
        );

        // Filter Options
        $options = $filter0->getOptions();

        /** @var Option $option0 */
        $option0 = $options->current();

        $this->assertEquals(
            $jsonObj->model->filters[0]->options[0]->valueId,
            $option0->getValueId()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[0]->valueText,
            $option0->getValueText()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[0]->tag,
            $option0->getTag()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[0]->code,
            $option0->getCode()
        );

        /** @var Option $option1 */
        $option1 = $options->next();

        $this->assertEquals(
            $jsonObj->model->filters[0]->options[1]->valueId,
            $option1->getValueId()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[1]->valueText,
            $option1->getValueText()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[1]->tag,
            $option1->getTag()
        );
        $this->assertEquals(
            $jsonObj->model->filters[0]->options[1]->code,
            $option1->getCode()
        );

        // Photos
        $photos = $model->getPhotos();

        /** @var Photo $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->model->photos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->photos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->photos[0]->height,
            $photo0->getHeight()
        );
        $this->assertEquals(
            $jsonObj->model->photos[0]->offerId,
            $photo0->getOfferId()
        );

        /** @var Photo $photo1 */
        $photo1 = $photos->next();

        $this->assertEquals(
            $jsonObj->model->photos[1]->url,
            $photo1->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->photos[1]->width,
            $photo1->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->photos[1]->height,
            $photo1->getHeight()
        );
        $this->assertEquals(
            $jsonObj->model->photos[1]->offerId,
            $photo1->getOfferId()
        );

        // Preview photos
        $photos = $model->getPreviewPhotos();

        /** @var Photo $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->model->previewPhotos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[0]->height,
            $photo0->getHeight()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[0]->offerId,
            $photo0->getOfferId()
        );

        /** @var Photo $photo1 */
        $photo1 = $photos->next();

        $this->assertEquals(
            $jsonObj->model->previewPhotos[1]->url,
            $photo1->getUrl()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[1]->width,
            $photo1->getWidth()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[1]->height,
            $photo1->getHeight()
        );
        $this->assertEquals(
            $jsonObj->model->previewPhotos[1]->offerId,
            $photo1->getOfferId()
        );

        // Offers
        $offers = $model->getOffers();

        /** @var Offer $offer0 */
        $offer0 = $offers->current();

        $this->assertEquals(
            $jsonObj->model->offers[0]->offerId,
            $offer0->getId()
        );

        /////

        $filters = $offer0->getFilters();

        /** @var Filter $filter0 */
        $filter0 = $filters->current();
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->id,
            $filter0->getId()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->name,
            $filter0->getName()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->type,
            $filter0->getType()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->unit,
            $filter0->getUnit()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->enumFilterType,
            $filter0->getEnumFilterType()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->exactly,
            $filter0->getExactly()
        );

        // Filter Options
        $options = $filter0->getOptions();

        /** @var Option $option0 */
        $option0 = $options->current();

        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->options[0]->valueId,
            $option0->getValueId()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->options[0]->valueText,
            $option0->getValueText()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->options[0]->tag,
            $option0->getTag()
        );
        $this->assertEquals(
            $jsonObj->model->offers[0]->filters[0]->options[0]->code,
            $option0->getCode()
        );
    }

    function testGetInfo()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-info.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $modelInfo = $modelClientMock->getInfo(7348501, [
            'geo_id' => 44,
            'fields' => 'category,discounts,facts,media,photo,price,rating,offers,vendor'
        ]);

        $this->assertEquals(
            $jsonObj->time,
            $modelInfo->getTime()
        );
        // Model
        $model = $modelInfo->getModel();

        $this->assertEquals(
            $jsonObj->model->id,
            $model->getId()
        );
        $this->assertEquals(
            $jsonObj->model->name,
            $model->getName()
        );
        $this->assertEquals(
            $jsonObj->model->type,
            $model->getType()
        );
        $this->assertEquals(
            $jsonObj->model->offerCount,
            $model->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->model->photo,
            $model->getPhotoUrl()
        );

        // Category
        $category = $model->getCategory();

        $this->assertEquals(
            $jsonObj->model->category->id,
            $category->getId()
        );
        $this->assertEquals(
            $jsonObj->model->category->name,
            $category->getName()
        );

        // Prices
        $prices = $model->getPrices();

        $this->assertEquals(
            $jsonObj->model->price->max,
            $prices->getMax()
        );
        $this->assertEquals(
            $jsonObj->model->price->min,
            $prices->getMin()
        );
        $this->assertEquals(
            $jsonObj->model->price->avg,
            $prices->getAvg()
        );

        $this->assertEquals(
            $jsonObj->model->price->currencyCode,
            $prices->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model->price->currencyName,
            $prices->getCurrencyName()
        );

        // Vendor
        $vendor = $model->getVendor();

        $this->assertEquals(
            $jsonObj->model->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->model->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->model->vendor->site,
            $vendor->getSite()
        );
        $this->assertEquals(
            $jsonObj->model->vendor->picture,
            $vendor->getPictureUrl()
        );

        // Rating
        $rating = $model->getRating();

        $this->assertEquals(
            $jsonObj->model->rating->value,
            $rating->getValue()
        );
        $this->assertEquals(
            $jsonObj->model->rating->count,
            $rating->getCount()
        );

        // Media
        $media = $model->getMedia();

        $this->assertEquals(
            $jsonObj->model->media->articles,
            $media->getArticlesCount()
        );
        $this->assertEquals(
            $jsonObj->model->media->reviews,
            $media->getReviewsCount()
        );

        // Facts
        $facts = $model->getFacts();

        $pro0 = $facts->getPros()->current();
        $contra0 = $facts->getContras()->current();

        $this->assertEquals(
            $jsonObj->model->facts->pros[0],
            (string)$pro0
        );
        $this->assertEquals(
            $jsonObj->model->facts->contras[0],
            (string)$contra0
        );
    }

    function testGetOffers()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-offers.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $modelOffers = $modelClientMock->getOffers(12796745, ['geo_id' => 213]);

        $this->assertEquals(
            $jsonObj->offers->count,
            $modelOffers->getCount()
        );
        $this->assertEquals(
            $jsonObj->offers->total,
            $modelOffers->getTotal()
        );
        $this->assertEquals(
            $jsonObj->offers->page,
            $modelOffers->getPage()
        );
        $this->assertEquals(
            $jsonObj->offers->regionDelimiterPosition,
            $modelOffers->getRegionDelimiterPosition()
        );

        $items = $modelOffers->getItems();

        /** @var Offer $item0 */
        $item0 = $items->current();
        $this->assertEquals(
            $jsonObj->offers->items[0]->id,
            $item0->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->modelId,
            $item0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->name,
            $item0->getName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->onStock,
            $item0->getOnStock()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->url,
            $item0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->warranty,
            $item0->getWarranty()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->variations,
            $item0->getVariationsCount()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->categoryId,
            $item0->getCategoryId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->vendorId,
            $item0->getVendorId()
        );

        // Price
        $this->assertEquals(
            $jsonObj->offers->items[0]->price->value,
            $item0->getPrice()->getValue()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->price->currencyName,
            $item0->getPrice()->getCurrencyName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->price->currencyCode,
            $item0->getPrice()->getCurrencyCode()
        );

        // Shop Info
        $this->assertEquals(
            $jsonObj->offers->items[0]->shopInfo->id,
            $item0->getShopInfo()->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->shopInfo->name,
            $item0->getShopInfo()->getName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->shopInfo->status,
            $item0->getShopInfo()->getStatus()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->shopInfo->rating,
            $item0->getShopInfo()->getRating()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->shopInfo->gradeTotal,
            $item0->getShopInfo()->getGradeTotal()
        );

        // Phone
        $this->assertEquals(
            $jsonObj->offers->items[0]->phone->number,
            $item0->getPhone()->getNumber()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->phone->sanitizedNumber,
            $item0->getPhone()->getSanitizedNumber()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->phone->call,
            $item0->getPhone()->getCall()
        );

        // Delivery
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->description,
            $item0->getDelivery()->getDescription()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->priorityRegion,
            $item0->getDelivery()->getPriorityRegionId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->regionName,
            $item0->getDelivery()->getRegionName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->userRegionName,
            $item0->getDelivery()->getUserRegionName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->pickup,
            $item0->getDelivery()->getPickup()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->store,
            $item0->getDelivery()->getStore()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->delivery,
            $item0->getDelivery()->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->free,
            $item0->getDelivery()->getFree()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->deliveryIncluded,
            $item0->getDelivery()->getDeliveryIncluded()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->downloadable,
            $item0->getDelivery()->getDownloadable()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->priority,
            $item0->getDelivery()->getPriority()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->brief,
            $item0->getDelivery()->getBrief()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->full,
            $item0->getDelivery()->getFull()
        );

        // Delivery methods
        $deliveryMethods = $item0->getDelivery()->getMethods();

        /** @var DeliveryMethod $method0 */
        $method0 = $deliveryMethods->current();

        $this->assertEquals(
            $jsonObj->offers->items[0]->delivery->methods[0]->serviceName,
            $method0->getServiceName()
        );

        // Big photo
        $this->assertEquals(
            $jsonObj->offers->items[0]->bigPhoto->id,
            $item0->getBigPhoto()->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->bigPhoto->url,
            $item0->getBigPhoto()->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->bigPhoto->width,
            $item0->getBigPhoto()->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->bigPhoto->height,
            $item0->getBigPhoto()->getHeight()
        );

        // Offer photos
        $photos = $item0->getPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $photos->current();

        $this->assertEquals(
            $jsonObj->offers->items[0]->photos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->photos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->photos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->photos[0]->height,
            $photo0->getHeight()
        );

        // Preview photos
        $previewPhotos = $item0->getPreviewPhotos();

        /** @var OfferPhoto $photo0 */
        $photo0 = $previewPhotos->current();

        $this->assertEquals(
            $jsonObj->offers->items[0]->previewPhotos[0]->id,
            $photo0->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->previewPhotos[0]->url,
            $photo0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->previewPhotos[0]->width,
            $photo0->getWidth()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->previewPhotos[0]->height,
            $photo0->getHeight()
        );

        // Vendor
        $this->assertEquals(
            $jsonObj->offers->items[0]->vendor->id,
            $item0->getVendor()->getId()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->vendor->name,
            $item0->getVendor()->getName()
        );
        $this->assertEquals(
            $jsonObj->offers->items[0]->vendor->site,
            $item0->getVendor()->getSite()
        );
    }

    function testGetOutlets()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-outlets.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $modelOutlets = $modelClientMock->getOutlets(5086952, ['geo_id' => 213]);

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
            $jsonObj->outlets->outlet[0]->shopName,
            $outlet0->getShopName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->building,
            $outlet0->getBuilding()
        );

        // Offer
        $offer = $outlet0->getOffer();
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->id,
            $offer->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->name,
            $offer->getName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->onStock,
            $offer->getOnStock()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->url,
            $offer->getUrl()
        );

        // Offer price
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->price->value,
            $offer->getPrice()->getValue()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->price->currencyName,
            $offer->getPrice()->getCurrencyName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->price->currencyCode,
            $offer->getPrice()->getCurrencyCode()
        );

        // Offer shop Info
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->shopInfo->id,
            $offer->getShopInfo()->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->shopInfo->name,
            $offer->getShopInfo()->getName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->shopInfo->status,
            $offer->getShopInfo()->getStatus()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->shopInfo->rating,
            $offer->getShopInfo()->getRating()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->shopInfo->gradeTotal,
            $offer->getShopInfo()->getGradeTotal()
        );

        // Offer phone
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->phone->number,
            $offer->getPhone()->getNumber()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->phone->sanitizedNumber,
            $offer->getPhone()->getSanitizedNumber()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->phone->call,
            $offer->getPhone()->getCall()
        );

        // Offer Delivery
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->priorityRegion,
            $offer->getDelivery()->getPriorityRegionId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->regionName,
            $offer->getDelivery()->getRegionName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->userRegionName,
            $offer->getDelivery()->getUserRegionName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->pickup,
            $offer->getDelivery()->getPickup()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->store,
            $offer->getDelivery()->getStore()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->delivery,
            $offer->getDelivery()->getDelivery()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->free,
            $offer->getDelivery()->getFree()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->deliveryIncluded,
            $offer->getDelivery()->getDeliveryIncluded()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->downloadable,
            $offer->getDelivery()->getDownloadable()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->priority,
            $offer->getDelivery()->getPriority()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->brief,
            $offer->getDelivery()->getBrief()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->delivery->full,
            $offer->getDelivery()->getFull()
        );

        // Offer Big photo
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->bigPhoto->id,
            $offer->getBigPhoto()->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->bigPhoto->url,
            $offer->getBigPhoto()->getUrl()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->bigPhoto->width,
            $offer->getBigPhoto()->getWidth()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->bigPhoto->height,
            $offer->getBigPhoto()->getHeight()
        );

        // Offer vendor
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->vendor->id,
            $offer->getVendor()->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->vendor->name,
            $offer->getVendor()->getName()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->offer->vendor->site,
            $offer->getVendor()->getSite()
        );

        // Phone
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->country,
            $outlet0->getPhone()->getCountry()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->city,
            $outlet0->getPhone()->getCity()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->phone->number,
            $outlet0->getPhone()->getNumber()
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
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->geoId,
            $outlet0->getGeo()->getId()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->longitude,
            $outlet0->getGeo()->getLongitude()
        );
        $this->assertEquals(
            $jsonObj->outlets->outlet[0]->geo->latitude,
            $outlet0->getGeo()->getLatitude()
        );
    }

    function testGetReviews()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-reviews.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $modelReviews = $modelClientMock->getReviews(5086952, []);

        $this->assertEquals(
            $jsonObj->modelReviews->count,
            $modelReviews->getCount()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->total,
            $modelReviews->getTotal()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->page,
            $modelReviews->getPage()
        );

        // Reviews
        $reviews = $modelReviews->getItems();

        /** @var Review $review0 */
        $review0 = $reviews->current();

        $this->assertEquals(
            $jsonObj->modelReviews->reviews[0]->url,
            $review0->getUrl()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->reviews[0]->title,
            $review0->getTitle()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->reviews[0]->favIcon,
            $review0->getFavIcon()
        );

        /** @var Review $review1 */
        $review1 = $reviews->next();

        $this->assertEquals(
            $jsonObj->modelReviews->reviews[1]->url,
            $review1->getUrl()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->reviews[1]->title,
            $review1->getTitle()
        );
        $this->assertEquals(
            $jsonObj->modelReviews->reviews[1]->favIcon,
            $review1->getFavIcon()
        );
    }

    function testGetMatch()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-match.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $matchedModels = $modelClientMock->getMatch([
            'geo_id' => 213,
            'many' => 'many',
            'name' => 'Apple iPhone 5S 16Gb Apple iPhone 5S 32Gb',
            'fields' => 'category,discounts,facts,media,photo,price,rating,offers,vendor'
        ]);

        $this->assertEquals(
            $jsonObj->time,
            $matchedModels->getTime()
        );

        $models = $matchedModels->getModels();

        /** @var ModelInfo $model0 */
        $model0 = $models->current();

        $this->assertEquals(
            $jsonObj->model[0]->id,
            $model0->getId()
        );
        $this->assertEquals(
            $jsonObj->model[0]->name,
            $model0->getName()
        );
        $this->assertEquals(
            $jsonObj->model[0]->type,
            $model0->getType()
        );
        $this->assertEquals(
            $jsonObj->model[0]->offerCount,
            $model0->getOffersCount()
        );
        $this->assertEquals(
            $jsonObj->model[0]->photo,
            $model0->getPhotoUrl()
        );

        // Category
        $category = $model0->getCategory();

        $this->assertEquals(
            $jsonObj->model[0]->category->id,
            $category->getId()
        );
        $this->assertEquals(
            $jsonObj->model[0]->category->name,
            $category->getName()
        );

        // Prices
        $prices = $model0->getPrices();

        $this->assertEquals(
            $jsonObj->model[0]->price->max,
            $prices->getMax()
        );
        $this->assertEquals(
            $jsonObj->model[0]->price->min,
            $prices->getMin()
        );
        $this->assertEquals(
            $jsonObj->model[0]->price->avg,
            $prices->getAvg()
        );
        $this->assertEquals(
            $jsonObj->model[0]->price->currencyCode,
            $prices->getCurrencyCode()
        );
        $this->assertEquals(
            $jsonObj->model[0]->price->currencyName,
            $prices->getCurrencyName()
        );

        // Vendor
        $vendor = $model0->getVendor();

        $this->assertEquals(
            $jsonObj->model[0]->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->model[0]->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->model[0]->vendor->site,
            $vendor->getSite()
        );
        $this->assertEquals(
            $jsonObj->model[0]->vendor->picture,
            $vendor->getPictureUrl()
        );

        // Rating
        $rating = $model0->getRating();

        $this->assertEquals(
            $jsonObj->model[0]->rating->value,
            $rating->getValue()
        );
        $this->assertEquals(
            $jsonObj->model[0]->rating->count,
            $rating->getCount()
        );

        // Media
        $media = $model0->getMedia();

        $this->assertEquals(
            $jsonObj->model[0]->media->articles,
            $media->getArticlesCount()
        );
        $this->assertEquals(
            $jsonObj->model[0]->media->reviews,
            $media->getReviewsCount()
        );

        // Facts
        $facts = $model0->getFacts();

        $pro0 = $facts->getPros()->current();
        $contra0 = $facts->getContras()->current();

        $this->assertEquals(
            $jsonObj->model[0]->facts->pros[0],
            (string)$pro0
        );
        $this->assertEquals(
            $jsonObj->model[0]->facts->contras[0],
            (string)$contra0
        );
    }

    function testGetOpinions()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/model-opinions.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $modelClientMock = $this->getMockBuilder(ModelClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $modelClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $opinionsResponse = $modelClientMock->getOpinions(10498476, ['count' => 2]);

        $this->assertEquals(
            $jsonObj->modelOpinions->count,
            $opinionsResponse->getCount()
        );

        $this->assertEquals(
            $jsonObj->modelOpinions->total,
            $opinionsResponse->getTotal()
        );

        $this->assertEquals(
            $jsonObj->modelOpinions->page,
            $opinionsResponse->getPage()
        );

        $opinions = $opinionsResponse->getItems();

        /** @var ModelOpinion $opinion0 */
        $opinion0 = $opinions->current();

        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->id,
            $opinion0->getId()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->date,
            $opinion0->getDate()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->grade,
            $opinion0->getGrade()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->text,
            $opinion0->getText()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->agree,
            $opinion0->getAgree()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->reject,
            $opinion0->getReject()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->visibility,
            $opinion0->getVisibility()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->author,
            $opinion0->getAuthor()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->authorInfo->grades,
            $opinion0->getAuthorInfo()->getGrades()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->pro,
            (string) $opinion0->getPro()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->contra,
            (string) $opinion0->getContra()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->usageTime,
            $opinion0->getUsageTime()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[0]->anonymous,
            $opinion0->getAnonymous()
        );

        /** @var ModelOpinion $opinion1 */
        $opinion1 = $opinions->next();

        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->id,
            $opinion1->getId()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->date,
            $opinion1->getDate()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->grade,
            $opinion1->getGrade()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->text,
            $opinion1->getText()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->agree,
            $opinion1->getAgree()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->reject,
            $opinion1->getReject()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->visibility,
            $opinion1->getVisibility()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->author,
            $opinion1->getAuthor()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->authorInfo->grades,
            $opinion1->getAuthorInfo()->getGrades()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->pro,
            (string) $opinion1->getPro()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->contra,
            (string) $opinion1->getContra()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->usageTime,
            $opinion1->getUsageTime()
        );
        $this->assertEquals(
            $jsonObj->modelOpinions->opinion[1]->anonymous,
            $opinion1->getAnonymous()
        );
    }
}
