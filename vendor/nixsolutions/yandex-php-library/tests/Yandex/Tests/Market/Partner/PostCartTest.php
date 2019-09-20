<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market\Partner;

use Yandex\Market\Partner\Models\CartResponse;
use Yandex\Market\Partner\Models\DatesRange;
use Yandex\Market\Partner\Models\DeliveryOption;
use Yandex\Market\Partner\Models\DeliveryOptions;
use Yandex\Market\Partner\Models\Item;
use Yandex\Market\Partner\Models\Items;
use Yandex\Market\Partner\Models\Outlet;
use Yandex\Market\Partner\Models\Outlets;
use Yandex\Market\Partner\Models\PostCartRequest;
use Yandex\Market\Partner\Models\PostCartResponse;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   naxel
 * @created  30.05.2014 13:58
 */
class PostCartTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testPostCartRequestFromMarket()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/post-cart-request-from-market.json');
        $cartRequest = new PostCartRequest();
        $cartRequest->fromJson($json);
        $jsonObj = json_decode($json);

        //cart->currency
        $this->assertEquals($jsonObj->cart->currency, $cartRequest->getCart()->getCurrency());

        //cart->delivery->address
        $this->assertEquals(
            $jsonObj->cart->delivery->address->country,
            $cartRequest->getCart()->getDelivery()->getAddress()->getCountry()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->postcode,
            $cartRequest->getCart()->getDelivery()->getAddress()->getPostcode()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->city,
            $cartRequest->getCart()->getDelivery()->getAddress()->getCity()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->subway,
            $cartRequest->getCart()->getDelivery()->getAddress()->getSubway()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->street,
            $cartRequest->getCart()->getDelivery()->getAddress()->getStreet()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->house,
            $cartRequest->getCart()->getDelivery()->getAddress()->getHouse()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->address->floor,
            $cartRequest->getCart()->getDelivery()->getAddress()->getFloor()
        );

        //cart->delivery->region
        $this->assertEquals(
            $jsonObj->cart->delivery->region->id,
            $cartRequest->getCart()->getDelivery()->getRegion()->getId()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->name,
            $cartRequest->getCart()->getDelivery()->getRegion()->getName()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->type,
            $cartRequest->getCart()->getDelivery()->getRegion()->getType()
        );

        //cart->delivery->region->parent
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->id,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getId()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->name,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getName()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->type,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getType()
        );

        //cart->delivery->region->parent->parent
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->parent->id,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getParent()->getId()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->parent->name,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getParent()->getName()
        );
        $this->assertEquals(
            $jsonObj->cart->delivery->region->parent->parent->type,
            $cartRequest->getCart()->getDelivery()->getRegion()->getParent()->getParent()->getType()
        );

        $items = $cartRequest->getCart()->getItems();
        /** @var Item $item1 */
        $item1 = $items->current();
        $this->assertEquals(
            $jsonObj->cart->items[0]->feedId,
            $item1->getFeedId()
        );
        $this->assertEquals(
            $jsonObj->cart->items[0]->offerId,
            $item1->getOfferId()
        );
        $this->assertEquals(
            $jsonObj->cart->items[0]->offerName,
            $item1->getOfferName()
        );
        $this->assertEquals(
            $jsonObj->cart->items[0]->count,
            $item1->getCount()
        );
        $this->assertEquals(
            $jsonObj->cart->items[0]->feedCategoryId,
            $item1->getFeedCategoryId()
        );
        /** @var Item $item2 */
        $item2 = $items->next();
        $this->assertEquals(
            $jsonObj->cart->items[1]->feedId,
            $item2->getFeedId()
        );
        $this->assertEquals(
            $jsonObj->cart->items[1]->offerId,
            $item2->getOfferId()
        );
        $this->assertEquals(
            $jsonObj->cart->items[1]->offerName,
            $item2->getOfferName()
        );
        $this->assertEquals(
            $jsonObj->cart->items[1]->count,
            $item2->getCount()
        );
        $this->assertEquals(
            $jsonObj->cart->items[1]->feedCategoryId,
            $item2->getFeedCategoryId()
        );
    }

    function testPostCartResponseToMarket()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/post-cart-response-to-market.json');
        $jsonArray = json_decode($json, true);

        $postCartResponse = new PostCartResponse();
        $cart = new CartResponse();
        $deliveryOptions = new DeliveryOptions();

        $deliveryOption1 = new DeliveryOption();
        $deliveryOption1->setType($jsonArray['cart']['deliveryOptions'][0]['type']);
        $datesRange1 = new DatesRange();
        $datesRange1->setFromDate($jsonArray['cart']['deliveryOptions'][0]['dates']['fromDate']);
        $datesRange1->setToDate($jsonArray['cart']['deliveryOptions'][0]['dates']['toDate']);
        $deliveryOption1->setDates($datesRange1);
        $deliveryOption1->setServiceName($jsonArray['cart']['deliveryOptions'][0]['serviceName']);
        $deliveryOption1->setPrice($jsonArray['cart']['deliveryOptions'][0]['price']);
        $outlets = new Outlets();
        $outlet1 = new Outlet();
        $outlet1->setId($jsonArray['cart']['deliveryOptions'][0]['outlets'][0]['id']);
        $outlet2 = new Outlet();
        $outlet2->setId($jsonArray['cart']['deliveryOptions'][0]['outlets'][1]['id']);
        $outlet3 = new Outlet();
        $outlet3->setId($jsonArray['cart']['deliveryOptions'][0]['outlets'][2]['id']);
        $outlets->add($outlet1);
        $outlets->add($outlet2);
        $outlets->add($outlet3);
        $deliveryOption1->setOutlets($outlets);


        $deliveryOption2 = new DeliveryOption();
        $deliveryOption2->setType($jsonArray['cart']['deliveryOptions'][1]['type']);
        $datesRange2 = new DatesRange();
        $datesRange2->setFromDate($jsonArray['cart']['deliveryOptions'][1]['dates']['fromDate']);
        $deliveryOption2->setDates($datesRange1);
        $deliveryOption2->setServiceName($jsonArray['cart']['deliveryOptions'][1]['serviceName']);
        $deliveryOption2->setPrice($jsonArray['cart']['deliveryOptions'][1]['price']);

        $deliveryOptions->add($deliveryOption1);
        $deliveryOptions->add($deliveryOption2);

        $cart->setDeliveryOptions($deliveryOptions);
        $cart->setPaymentMethods(
            [
                $jsonArray['cart']['paymentMethods'][0],
                $jsonArray['cart']['paymentMethods'][1]
            ]
        );

        $items = new Items();
        $item1 = new Item();
        $item1->setFeedId($jsonArray['cart']['items'][0]['feedId']);
        $item1->setOfferId($jsonArray['cart']['items'][0]['offerId']);
        $item1->setPrice($jsonArray['cart']['items'][0]['price']);
        $item1->setCount($jsonArray['cart']['items'][0]['count']);
        $item1->setDelivery($jsonArray['cart']['items'][0]['delivery']);
        $item2 = new Item();
        $item2->setFeedId($jsonArray['cart']['items'][1]['feedId']);
        $item2->setOfferId($jsonArray['cart']['items'][1]['offerId']);
        $item2->setPrice($jsonArray['cart']['items'][1]['price']);
        $item2->setCount($jsonArray['cart']['items'][1]['count']);
        $item2->setDelivery($jsonArray['cart']['items'][1]['delivery']);
        $items->add($item1);
        $items->add($item2);

        $cart->setItems($items);
        $postCartResponse->setCart($cart);
        $postCartResponseJson = json_decode($postCartResponse->toJson());


        //deliveryOptions
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['type'],
            $postCartResponseJson->cart->deliveryOptions[0]->type
        );
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['dates']['fromDate'],
            $postCartResponseJson->cart->deliveryOptions[0]->dates->fromDate
        );

        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['dates']['toDate'],
            $postCartResponseJson->cart->deliveryOptions[0]->dates->toDate
        );

        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['serviceName'],
            $postCartResponseJson->cart->deliveryOptions[0]->serviceName
        );
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['price'],
            $postCartResponseJson->cart->deliveryOptions[0]->price
        );
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['outlets'][0]['id'],
            $postCartResponseJson->cart->deliveryOptions[0]->outlets[0]->id
        );
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['outlets'][1]['id'],
            $postCartResponseJson->cart->deliveryOptions[0]->outlets[1]->id
        );
        $this->assertEquals(
            $jsonArray['cart']['deliveryOptions'][0]['outlets'][2]['id'],
            $postCartResponseJson->cart->deliveryOptions[0]->outlets[2]->id
        );

        //paymentMethods
        $this->assertEquals(
            $jsonArray['cart']['paymentMethods'][0],
            $postCartResponseJson->cart->paymentMethods[0]
        );
        $this->assertEquals(
            $jsonArray['cart']['paymentMethods'][1],
            $postCartResponseJson->cart->paymentMethods[1]
        );

        //items
        $this->assertEquals(
            $jsonArray['cart']['items'][0]['feedId'],
            $postCartResponseJson->cart->items[0]->feedId
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][0]['offerId'],
            $postCartResponseJson->cart->items[0]->offerId
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][0]['price'],
            $postCartResponseJson->cart->items[0]->price
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][0]['count'],
            $postCartResponseJson->cart->items[0]->count
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][0]['delivery'],
            $postCartResponseJson->cart->items[0]->delivery
        );

        $this->assertEquals(
            $jsonArray['cart']['items'][1]['feedId'],
            $postCartResponseJson->cart->items[1]->feedId
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][1]['offerId'],
            $postCartResponseJson->cart->items[1]->offerId
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][1]['price'],
            $postCartResponseJson->cart->items[1]->price
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][1]['count'],
            $postCartResponseJson->cart->items[1]->count
        );
        $this->assertEquals(
            $jsonArray['cart']['items'][1]['delivery'],
            $postCartResponseJson->cart->items[1]->delivery
        );
    }
}
