<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market\Partner;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Partner\PartnerClient;
use Yandex\Market\Partner\Models\Item;
use Yandex\Market\Partner\Models\Order;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   naxel
 * @created  30.05.2014 17:54
 */
class GetOrderTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetOrderResponse()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-campaigns-id-orders-id.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var Order $order */
        $order = $marketPartnerMock->getOrder('124');
        $this->assertEquals($jsonObj->order->id, $order->getId());
        $this->assertEquals($jsonObj->order->status, $order->getStatus());
        $this->assertEquals($jsonObj->order->creationDate, $order->getCreationDate());
        $this->assertEquals($jsonObj->order->currency, $order->getCurrency());
        $this->assertEquals($jsonObj->order->itemsTotal, $order->getItemsTotal());
        $this->assertEquals($jsonObj->order->total, $order->getTotal());
        $this->assertEquals($jsonObj->order->paymentType, $order->getPaymentType());
        $this->assertEquals($jsonObj->order->paymentMethod, $order->getPaymentMethod());
        $this->assertEquals($jsonObj->order->fake, $order->getFake());
        //items
        $items = $order->getItems();
        /** @var Item $item0 */
        $item0 = $items->current();
        $this->assertEquals($jsonObj->order->items[0]->feedId, $item0->getFeedId());
        $this->assertEquals($jsonObj->order->items[0]->offerId, $item0->getOfferId());
        $this->assertEquals($jsonObj->order->items[0]->feedCategoryId, $item0->getFeedCategoryId());
        $this->assertEquals($jsonObj->order->items[0]->offerName, $item0->getOfferName());
        $this->assertEquals($jsonObj->order->items[0]->price, $item0->getPrice());
        $this->assertEquals($jsonObj->order->items[0]->count, $item0->getCount());

        /** @var Item $item1 */
        $item1 = $items->next();
        $this->assertEquals($jsonObj->order->items[1]->feedId, $item1->getFeedId());
        $this->assertEquals($jsonObj->order->items[1]->offerId, $item1->getOfferId());
        $this->assertEquals($jsonObj->order->items[1]->feedCategoryId, $item1->getFeedCategoryId());
        $this->assertEquals($jsonObj->order->items[1]->offerName, $item1->getOfferName());
        $this->assertEquals($jsonObj->order->items[1]->price, $item1->getPrice());
        $this->assertEquals($jsonObj->order->items[1]->count, $item1->getCount());

        //delivery
        $this->assertEquals($jsonObj->order->delivery->type, $order->getDelivery()->getType());
        $this->assertEquals($jsonObj->order->delivery->serviceName, $order->getDelivery()->getServiceName());
        $this->assertEquals($jsonObj->order->delivery->price, $order->getDelivery()->getPrice());

        //delivery->region
        $this->assertEquals($jsonObj->order->delivery->region->id, $order->getDelivery()->getRegion()->getId());
        $this->assertEquals($jsonObj->order->delivery->region->name, $order->getDelivery()->getRegion()->getName());
        $this->assertEquals($jsonObj->order->delivery->region->type, $order->getDelivery()->getRegion()->getType());

        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->id,
            $order->getDelivery()->getRegion()->getParent()->getId()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->name,
            $order->getDelivery()->getRegion()->getParent()->getName()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->type,
            $order->getDelivery()->getRegion()->getParent()->getType()
        );

        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->id,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getId()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->name,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getName()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->type,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getType()
        );

        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->parent->id,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getId()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->parent->name,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getName()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->region->parent->parent->parent->type,
            $order->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getType()
        );

        //delivery->address
        $this->assertEquals(
            $jsonObj->order->delivery->address->country,
            $order->getDelivery()->getAddress()->getCountry()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->postcode,
            $order->getDelivery()->getAddress()->getPostcode()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->city,
            $order->getDelivery()->getAddress()->getCity()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->subway,
            $order->getDelivery()->getAddress()->getSubway()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->street,
            $order->getDelivery()->getAddress()->getStreet()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->house,
            $order->getDelivery()->getAddress()->getHouse()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->entrance,
            $order->getDelivery()->getAddress()->getEntrance()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->entryphone,
            $order->getDelivery()->getAddress()->getEntryphone()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->floor,
            $order->getDelivery()->getAddress()->getFloor()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->apartment,
            $order->getDelivery()->getAddress()->getApartment()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->recipient,
            $order->getDelivery()->getAddress()->getRecipient()
        );
        $this->assertEquals(
            $jsonObj->order->delivery->address->phone,
            $order->getDelivery()->getAddress()->getPhone()
        );

        //buyer
        $this->assertEquals($jsonObj->order->buyer->id, $order->getBuyer()->getId());
        $this->assertEquals($jsonObj->order->buyer->lastName, $order->getBuyer()->getLastName());
        $this->assertEquals($jsonObj->order->buyer->firstName, $order->getBuyer()->getFirstName());
        $this->assertEquals($jsonObj->order->buyer->middleName, $order->getBuyer()->getMiddleName());
        $this->assertEquals($jsonObj->order->buyer->phone, $order->getBuyer()->getPhone());
        $this->assertEquals($jsonObj->order->buyer->email, $order->getBuyer()->getEmail());
    }
}
