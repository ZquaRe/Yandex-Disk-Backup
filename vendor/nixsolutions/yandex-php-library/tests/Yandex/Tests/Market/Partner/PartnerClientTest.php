<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market\Partner;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Market\Partner\Exception\PartnerRequestException;
use Yandex\Market\Partner\Models\Delivery;
use Yandex\Market\Partner\Models\DeliveryRule;
use Yandex\Market\Partner\Models\Item;
use Yandex\Market\Partner\Models\MarketModel;
use Yandex\Market\Partner\Models\MarketModelOffer;
use Yandex\Market\Partner\Models\Order;
use Yandex\Market\Partner\PartnerClient;
use Yandex\Tests\TestCase;

/**
 * Created by PhpStorm.
 * User: kuzmenko
 * Date: 11.08.16
 * Time: 15:45
 */
class PartnerClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetCampaigns()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-campaigns.json');
        $campaignsJson = json_decode($json, true);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var \Yandex\Market\Partner\Models\Campaigns $campaignsResp */
        $campaignsResp = $marketPartnerMock->getCampaigns()->getAll();
        foreach ($campaignsJson['campaigns'] as $k => $campaignJson) {
            $this->assertEquals($campaignJson['id'], $campaignsResp[$k]->getId());
            $this->assertEquals($campaignJson['domain'], $campaignsResp[$k]->getDomain());
            $this->assertEquals($campaignJson['state'], $campaignsResp[$k]->getState());
            if (isset($campaignJson['stateReasons'])) {
                foreach ($campaignJson['stateReasons'] as $key => $stateReason) {
                    $this->assertEquals($stateReason, $campaignsResp[$k]->getStateReasons()[$key]);
                }
            }
        }
    }

    function testGetLoginsByCampaign()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-logins.json');
        $loginsJson = json_decode($json, true);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var \Yandex\common\StringCollection $loginsResp */
        $loginsResp = $marketPartnerMock->getLoginsByCampaign();

        $this->assertEquals($loginsJson['logins'], $loginsResp->asArray());
    }

    function testGetOrders()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-orders.json');
        $ordersJson = json_decode($json);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var \Yandex\Market\Partner\Models\Campaigns $campaignsResp */
        $campaignsResp = $marketPartnerMock->getOrders()->getAll();

        //order
        $order0 = $ordersJson->orders[0];
        $this->assertEquals($order0->id, $campaignsResp[0]->getId());
        $this->assertEquals($order0->creationDate, $campaignsResp[0]->getcreationDate());
        $this->assertEquals($order0->currency, $campaignsResp[0]->getCurrency());
        $this->assertEquals($order0->fake, $campaignsResp[0]->getFake());
        $this->assertEquals($order0->itemsTotal, $campaignsResp[0]->getItemsTotal());
        $this->assertEquals($order0->paymentType, $campaignsResp[0]->getPaymentType());
        $this->assertEquals($order0->paymentMethod, $campaignsResp[0]->getPaymentMethod());
        $this->assertEquals($order0->status, $campaignsResp[0]->getStatus());
        $this->assertEquals($order0->total, $campaignsResp[0]->getTotal());

        //buyer
        $buyer = $ordersJson->orders[0]->buyer;
        $this->assertEquals($buyer->id, $campaignsResp[0]->getBuyer()->getId());
        $this->assertEquals($buyer->lastName, $campaignsResp[0]->getBuyer()->getLastName());
        $this->assertEquals($buyer->firstName, $campaignsResp[0]->getBuyer()->getFirstName());
        $this->assertEquals($buyer->middleName, $campaignsResp[0]->getBuyer()->getMiddleName());
        $this->assertEquals($buyer->phone, $campaignsResp[0]->getBuyer()->getPhone());
        $this->assertEquals($buyer->email, $campaignsResp[0]->getBuyer()->getEmail());

        //delivery
        $delivery = $ordersJson->orders[0]->delivery;
        $this->assertEquals($delivery->type, $campaignsResp[0]->getDelivery()->getType());
        $this->assertEquals($delivery->serviceName, $campaignsResp[0]->getDelivery()->getServiceName());
        $this->assertEquals($delivery->price, $campaignsResp[0]->getDelivery()->getPrice());

        //delivery->address
        $deliveryAddress = $ordersJson->orders[0]->delivery->address;
        $this->assertEquals($deliveryAddress->country, $campaignsResp[0]->getDelivery()->getAddress()->getCountry());
        $this->assertEquals($deliveryAddress->postcode,  $campaignsResp[0]->getDelivery()->getAddress()->getPostcode());
        $this->assertEquals($deliveryAddress->city, $campaignsResp[0]->getDelivery()->getAddress()->getCity());
        $this->assertEquals($deliveryAddress->subway, $campaignsResp[0]->getDelivery()->getAddress()->getSubway());
        $this->assertEquals($deliveryAddress->street, $campaignsResp[0]->getDelivery()->getAddress()->getStreet());
        $this->assertEquals($deliveryAddress->house, $campaignsResp[0]->getDelivery()->getAddress()->getHouse());
        $this->assertEquals($deliveryAddress->entrance, $campaignsResp[0]->getDelivery()->getAddress()->getEntrance());
        $this->assertEquals($deliveryAddress->entryphone, $campaignsResp[0]->getDelivery()->getAddress()->getEntryphone());
        $this->assertEquals($deliveryAddress->floor, $campaignsResp[0]->getDelivery()->getAddress()->getFloor());
        $this->assertEquals($deliveryAddress->apartment, $campaignsResp[0]->getDelivery()->getAddress()->getApartment());
        $this->assertEquals($deliveryAddress->recipient, $campaignsResp[0]->getDelivery()->getAddress()->getRecipient());
        $this->assertEquals($deliveryAddress->phone, $campaignsResp[0]->getDelivery()->getAddress()->getPhone());

        //delivery->dates
        $deliveryDates = $ordersJson->orders[0]->delivery->dates;
        $this->assertEquals($deliveryDates->fromDate, $campaignsResp[0]->getDelivery()->getDates()->getFromDate());
        $this->assertEquals($deliveryDates->toDate, $campaignsResp[0]->getDelivery()->getDates()->getToDate());

        //delivery->region
        $deliveryRegion = $ordersJson->orders[0]->delivery->region;
        $this->assertEquals($deliveryRegion->id, $campaignsResp[0]->getDelivery()->getRegion()->getId());
        $this->assertEquals($deliveryRegion->name, $campaignsResp[0]->getDelivery()->getRegion()->getName());
        $this->assertEquals($deliveryRegion->type, $campaignsResp[0]->getDelivery()->getRegion()->getType());
        $this->assertEquals(
            $deliveryRegion->parent->id,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getId()
        );
        $this->assertEquals(
            $deliveryRegion->parent->name,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getName()
        );
        $this->assertEquals(
            $deliveryRegion->parent->type,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getType()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->id,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getId()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->name,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getName()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->type,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getType()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->parent->id,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getId()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->parent->name,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getName()
        );
        $this->assertEquals(
            $deliveryRegion->parent->parent->parent->type,
            $campaignsResp[0]->getDelivery()->getRegion()->getParent()->getParent()->getParent()->getType()
        );

        /** @var Item $item0 */
        $item0 = $campaignsResp[0]->getItems()->getAll()[0];
        $this->assertEquals($ordersJson->orders[0]->items[0]->feedId, $item0->getFeedId());
        $this->assertEquals($ordersJson->orders[0]->items[0]->offerId, $item0->getOfferId());
        $this->assertEquals($ordersJson->orders[0]->items[0]->feedCategoryId, $item0->getFeedCategoryId());
        $this->assertEquals($ordersJson->orders[0]->items[0]->offerName, $item0->getOfferName());
        $this->assertEquals($ordersJson->orders[0]->items[0]->price, $item0->getPrice());
        $this->assertEquals($ordersJson->orders[0]->items[0]->count, $item0->getCount());

        /** @var Item $item1 */
        $item1 = $campaignsResp[0]->getItems()->getAll()[1];
        $this->assertEquals($ordersJson->orders[0]->items[1]->feedId, $item1->getFeedId());
        $this->assertEquals($ordersJson->orders[0]->items[1]->offerId, $item1->getOfferId());
        $this->assertEquals($ordersJson->orders[0]->items[1]->feedCategoryId, $item1->getFeedCategoryId());
        $this->assertEquals($ordersJson->orders[0]->items[1]->offerName, $item1->getOfferName());
        $this->assertEquals($ordersJson->orders[0]->items[1]->price, $item1->getPrice());
        $this->assertEquals($ordersJson->orders[0]->items[1]->count, $item1->getCount());
    }

    public function testGetStats()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-stats.json');
        $statsJson = json_decode($json);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var \Yandex\Market\Partner\Models\Stats $statsResp */
        $statsResp = $marketPartnerMock->getStats('main', ['fromDate' => '06-02-2017', 'fields' => 'mobile,shows', 'toDate' => '08-02-2017'])->getAll();

        $stat0 = $statsJson->mainStats[0];
        $this->assertEquals($stat0->clicks, $statsResp[0]->getClicks());
        $this->assertEquals($stat0->date, $statsResp[0]->getDate());
        $this->assertEquals($stat0->placeGroup, $statsResp[0]->getPlaceGroup());
        $this->assertEquals($stat0->shows, $statsResp[0]->getShows());
        $this->assertEquals($stat0->spending, $statsResp[0]->getSpending());

        $detailedStatsStatsResp0 = $statsResp[0]->getDetailedStats();
        $this->assertEquals($stat0->detailedStats[0]->clicks, $detailedStatsStatsResp0[0]['clicks']);
        $this->assertEquals($stat0->detailedStats[0]->shows, $detailedStatsStatsResp0[0]['shows']);
        $this->assertEquals($stat0->detailedStats[0]->spending, $detailedStatsStatsResp0[0]['spending']);
        $this->assertEquals($stat0->detailedStats[0]->type, $detailedStatsStatsResp0[0]['type']);
    }

    public function testGetAccessToken()
    {
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClientId', 'getLogin'])
            ->getMock();
        $marketPartnerMock->setAccessToken('testAccessToken');
        $marketPartnerMock->expects($this->any())
            ->method('getClientId')
            ->will($this->returnValue(111));
        $marketPartnerMock->expects($this->any())
            ->method('getLogin')
            ->will($this->returnValue('testLogin'));

        $this->assertEquals(
            'oauth_token=testAccessToken, oauth_client_id=111, oauth_login=testLogin',
            $marketPartnerMock->getAccessToken()
        );
    }

    public function testGetBalance()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-balance.json');
        $jsonObj = json_decode($json);
        $balance = $jsonObj->balance;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var $balanceResp \Yandex\Market\Partner\Models\Balance */
        $balanceResp = $marketPartnerMock->getBalance();

        $this->assertEquals($balance->balance, $balanceResp->getBalance());
        $this->assertEquals($balance->daysLeft, $balanceResp->getDaysLeft());
        $this->assertEquals($balance->recommendedPayment, $balanceResp->getRecommendedPayment());
    }
    
    public function testGetPropertiesPartnerClient()
    {
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getAccessToken'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getAccessToken')
            ->will($this->returnValue('oauth_token=testAccessToken, oauth_client_id=222, oauth_login=testLogin2'));
        $marketPartnerMock->setClientId(222);
        $marketPartnerMock->setLogin('testLogin2');
        $marketPartnerMock->setCampaignId(111);

        $this->assertEquals(222, $marketPartnerMock->getClientId());
        $this->assertEquals('testLogin2', $marketPartnerMock->getLogin());
        $this->assertEquals(111, $marketPartnerMock->getCampaignId());
    }

    public function testGetSettings()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-settings.json');
        $settingsJson = json_decode($json);
        $settingsObj = $settingsJson->settings;
  
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var $settings \Yandex\Market\Partner\Models\Settings  */
        $settings = $marketPartnerMock->getSettings();

        $this->assertEquals($settingsObj->shopName, $settings->getShopName());
        $this->assertEquals($settingsObj->countryRegion, $settings->getCountryRegion());
        $this->assertEquals($settingsObj->isOnline, $settings->getIsOnline());
        $this->assertEquals($settingsObj->showInContext, $settings->getShowInContext());
        $this->assertEquals($settingsObj->showInSnippets, $settings->getShowInSnippets());
        $this->assertEquals($settingsObj->showInPremium, $settings->getShowInPremium());
        $this->assertEquals($settingsObj->useOpenStat, $settings->getUseOpenStat());
    }
  
    public function testGetOutlets()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-outlets.json');
        $outletsJson = json_decode($json);
        $outletsObj = $outletsJson->outlets;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /**
         * @var $marketPartnerMock \Yandex\Market\Partner\PartnerClient
         * @var $response \Yandex\Market\Partner\Models\GetOutletsResponse
         * @var $outlets \Yandex\Market\Partner\Models\Outlets
         * @var $firstOutlet \Yandex\Market\Partner\Models\Outlet
         * @var $pager \Yandex\Market\Partner\Models\Pager
         */
        $response = $marketPartnerMock->getOutletsResponse();
        $outlets = $response->getOutlets();
        $pager = $response->getPager();
        $allOutlets = $outlets->getAll();
        $firstOutlet = array_shift($allOutlets);

        $this->assertEquals(count($outletsObj), $outlets->count());

        $this->assertEquals($outletsObj[0]->id, $firstOutlet->getId());
        $this->assertEquals($outletsObj[0]->name, $firstOutlet->getName());
        $this->assertEquals($outletsObj[0]->isBookNow, $firstOutlet->getIsBookNow());
        $this->assertEquals($outletsObj[0]->isMain, $firstOutlet->getIsMain());
        $this->assertEquals($outletsObj[0]->shopOutletId, $firstOutlet->getShopOutletId());
        $this->assertEquals($outletsObj[0]->status, $firstOutlet->getStatus());
        $this->assertEquals($outletsObj[0]->type, $firstOutlet->getType());
        $this->assertEquals($outletsObj[0]->visibility, $firstOutlet->getVisibility());
        $this->assertEquals($outletsObj[0]->workingTime, $firstOutlet->getWorkingTime());
        $this->assertEquals($outletsObj[0]->emails, $firstOutlet->getEmails()->asArray());
        $this->assertEquals($outletsObj[0]->phones, $firstOutlet->getPhones()->asArray());

        $outletAddress = $firstOutlet->getAddress();
        $this->assertEquals($outletsObj[0]->address->city, $outletAddress->getCity());
        $this->assertEquals($outletsObj[0]->address->street, $outletAddress->getStreet());
        $this->assertEquals($outletsObj[0]->address->number, $outletAddress->getNumber());
        $this->assertEquals($outletsObj[0]->address->building, $outletAddress->getBuilding());
        $this->assertEquals($outletsObj[0]->address->estate, $outletAddress->getEstate());
        $this->assertEquals($outletsObj[0]->address->block, $outletAddress->getBlock());
        $this->assertEquals($outletsObj[0]->address->km, $outletAddress->getKm());
        $this->assertEquals($outletsObj[0]->address->additional, $outletAddress->getAdditional());

        if($outletsObj[0]->status == 'FAILED')
            $this->assertEquals($outletsObj[0]->reason, $firstOutlet->getReason());

        /**
         * @var $outletFirstDeliveryRule DeliveryRule
         */
        $outletDeliveryRules = $firstOutlet->getDeliveryRules()->getAll();
        $outletFirstDeliveryRule = array_shift($outletDeliveryRules);
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->cost, $outletFirstDeliveryRule->getCost());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->dateSwitchHour, $outletFirstDeliveryRule->getDateSwitchHour());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->minDeliveryDays, $outletFirstDeliveryRule->getMinDeliveryDays());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->maxDeliveryDays, $outletFirstDeliveryRule->getMaxDeliveryDays());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->priceFrom, $outletFirstDeliveryRule->getPriceFrom());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->priceTo, $outletFirstDeliveryRule->getPriceTo());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->shipperHumanReadableId, $outletFirstDeliveryRule->getShipperHumanReadableId());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->shipperId, $outletFirstDeliveryRule->getShipperId());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->shipperName, $outletFirstDeliveryRule->getShipperName());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->unspecifiedDeliveryInterval, $outletFirstDeliveryRule->getUnspecifiedDeliveryInterval());
        $this->assertEquals($outletsObj[0]->deliveryRules[0]->workInHoliday, $outletFirstDeliveryRule->getWorkInHoliday());

        $pagerObj = $outletsJson->pager;
        $this->assertEquals($pagerObj->currentPage, $pager->getCurrentPage());
        $this->assertEquals($pagerObj->from, $pager->getFrom());
        $this->assertEquals($pagerObj->pageSize, $pager->getPageSize());
        $this->assertEquals($pagerObj->to, $pager->getTo());
    }

    public function testGetOutlet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-outlet.json');
        $outletJson = json_decode($json);
        $outletObj = $outletJson->outlet;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /**
         * @var $marketPartnerMock \Yandex\Market\Partner\PartnerClient
         */
        $outlet = $marketPartnerMock->getOutlet(215634);

        $this->assertEquals($outletObj->id, $outlet->getId());
        $this->assertEquals($outletObj->name, $outlet->getName());
        $this->assertEquals($outletObj->isBookNow, $outlet->getIsBookNow());
        $this->assertEquals($outletObj->isMain, $outlet->getIsMain());
        $this->assertEquals($outletObj->shopOutletId, $outlet->getShopOutletId());
        $this->assertEquals($outletObj->status, $outlet->getStatus());
        $this->assertEquals($outletObj->type, $outlet->getType());
        $this->assertEquals($outletObj->visibility, $outlet->getVisibility());
        $this->assertEquals($outletObj->workingTime, $outlet->getWorkingTime());
        $this->assertEquals($outletObj->emails, $outlet->getEmails()->asArray());
        $this->assertEquals($outletObj->phones, $outlet->getPhones()->asArray());
    }

    public function testUpdateDelivery()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $jsonObj = json_decode($json);
        $address = $jsonObj->order->delivery->address;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $deliveryMock = $this->getMockBuilder(Delivery::class)
            ->setMethods(['getAddress'])
            ->getMock();
        $deliveryMock->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue($address));

        $updateDeliveryResp = $marketPartnerMock->updateDelivery(12345, $deliveryMock);

        //delivery->address
        $this->assertEquals($address->house, $updateDeliveryResp->getDelivery()->getAddress()->getHouse());
        $this->assertEquals($address->entrance, $updateDeliveryResp->getDelivery()->getAddress()->getEntrance());
        $this->assertEquals($address->entryphone, $updateDeliveryResp->getDelivery()->getAddress()->getEntryphone());
        $this->assertEquals($address->floor, $updateDeliveryResp->getDelivery()->getAddress()->getFloor());
        $this->assertEquals($address->apartment, $updateDeliveryResp->getDelivery()->getAddress()->getApartment());
        $this->assertEquals($address->recipient, $updateDeliveryResp->getDelivery()->getAddress()->getRecipient());
        $this->assertEquals($address->phone, $updateDeliveryResp->getDelivery()->getAddress()->getPhone());
    }

    public function testGetRegion()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-region.json');
        $jsonObj = json_decode($json);
        $region = $jsonObj->region;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var \Yandex\Market\Partner\Models\Region */
        $regionResp = $marketPartnerMock->getRegion();

        $this->assertEquals($region->id, $regionResp->getId());
        $this->assertEquals($region->name, $regionResp->getName());
        $this->assertEquals($region->type, $regionResp->getType());

        // parent
        $this->assertEquals($region->parent->id, $regionResp->getParent()->getId());
        $this->assertEquals($region->parent->name, $regionResp->getParent()->getName());
        $this->assertEquals($region->parent->type, $regionResp->getParent()->getType());
    }

    public function testSetOrderStatus()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/set-order-status-response.json');
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $orderStatusResp = $marketPartnerMock->setOrderStatus($orderId, 'CANCELLED', 'PROCESSING_EXPIRED');

        $this->assertEquals('CANCELLED', $orderStatusResp->getStatus());
        $this->assertEquals('PROCESSING_EXPIRED', $orderStatusResp->getSubStatus());
    }

    public  function testSendRequest()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));

        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $response = $marketPartnerMock->getOrder($orderId);
        $this->assertEquals($orderId, $response->getId());
    }

    public function testSendRequestForbiddenException()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $response             = new Response(403);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));

        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $this->expectException(ForbiddenException::class);

        $marketPartnerMock->getOrder($orderId);
    }

    function testSendRequestUnauthorizedException()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $response             = new Response(401);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));

        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $this->expectException(UnauthorizedException::class);

        $marketPartnerMock->getOrder($orderId);
    }

    public function testSendRequestPartnerRequestException()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $response             = new Response(402);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));

        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $this->expectException(PartnerRequestException::class);

        $marketPartnerMock->getOrder($orderId);
    }

    public function testSendRequestUnauthorizedExceptionWithTestMessage()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-order-for-update-delivery.json');
        $jsonObj = json_decode($json);
        $orderId = $jsonObj->order->id;

        $jsonStr = '{"error": {"message": "testUnauthorizedExceptionMessage"}}';

        $request              = new Request('GET', '');
        $response             = new Response(401, [], $jsonStr);
        $clientException      = new \GuzzleHttp\Exception\ClientException('', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($clientException));

        $marketPartnerMock = $this->getMockBuilder(PartnerClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $marketPartnerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $this->expectException(UnauthorizedException::class);

        $marketPartnerMock->getOrder($orderId);
    }

    function testGetModel()
    {
        $fixture = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-model.json');
        $fixtureJson = json_decode($fixture);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));
        $marketPartnerMock = $this->getMock(PartnerClient::class, ['sendRequest']);
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var MarketModel $model */
        $model = $marketPartnerMock->getModel(7012977, 213, 'RUR');

        $modelJson = $fixtureJson->models[0];
        $this->assertEquals($modelJson->id, $model->getId());
        $this->assertEquals($modelJson->name, $model->getName());
        $this->assertEquals($modelJson->prices->min, $model->getPrices()->getMin());
        $this->assertEquals($modelJson->prices->max, $model->getPrices()->getMax());
        $this->assertEquals($modelJson->prices->avg, $model->getPrices()->getAvg());
    }

    function testFindModel()
    {
        $fixture = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/find-models.json');
        $fixtureJson = json_decode($fixture);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));
        $marketPartnerMock = $this->getMock(PartnerClient::class, ['sendRequest']);
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $marketModelsResponse = $marketPartnerMock->findModels('Apple iPhone 4S', 2, 'RUR');
        $models = $marketModelsResponse->getModels();

        /** @var MarketModel $model */
        foreach ($models as $index => $model) {
            $modelJson = $fixtureJson->models[$index];
            $this->assertEquals($modelJson->id, $model->getId());
            $this->assertEquals($modelJson->name, $model->getName());
            $this->assertEquals($modelJson->prices->min, $model->getPrices()->getMin());
            $this->assertEquals($modelJson->prices->max, $model->getPrices()->getMax());
            $this->assertEquals($modelJson->prices->avg, $model->getPrices()->getAvg());
        }
    }

    function testGetModels()
    {
        $fixture = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-models.json');
        $fixtureJson = json_decode($fixture);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));
        $marketPartnerMock = $this->getMock(PartnerClient::class, ['sendRequest']);
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $models = $marketPartnerMock->getModels([7717706, 7717686, 7717687], 2, 'RUR');

        /** @var MarketModel $model */
        foreach ($models as $index => $model) {
            $modelJson = $fixtureJson->models[$index];
            $this->assertEquals($modelJson->id, $model->getId());
            $this->assertEquals($modelJson->name, $model->getName());
            $this->assertEquals($modelJson->prices->min, $model->getPrices()->getMin());
            $this->assertEquals($modelJson->prices->max, $model->getPrices()->getMax());
            $this->assertEquals($modelJson->prices->avg, $model->getPrices()->getAvg());
        }
    }

    function testGetModelOffers()
    {
        $fixture = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-model-offers.json');
        $fixtureJson = json_decode($fixture);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));
        $marketPartnerMock = $this->getMock(PartnerClient::class, ['sendRequest']);
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        /** @var MarketModel $model */
        $model = $marketPartnerMock->getModelOffers(11002659, 213, 'RUR');

        $modelJson = $fixtureJson->models[0];

        $this->assertEquals($modelJson->id, $model->getId());

        /** @var MarketModelOffer $offer */
        foreach ($model->getOffers() as $index => $offer) {
            $offerJson = $modelJson->offers[$index];
            $this->assertEquals($offerJson->inStock, $offer->getInStock());
            $this->assertEquals($offerJson->name, $offer->getName());
            $this->assertEquals($offerJson->pos, $offer->getPos());
            $this->assertEquals($offerJson->price, $offer->getPrice());
            $this->assertEquals($offerJson->regionId, $offer->getRegionId());
            $this->assertEquals($offerJson->shippingCost, $offer->getShippingCost());
            $this->assertEquals($offerJson->shopName, $offer->getShopName());
        }
    }

    function testGetModelsOffers()
    {
        $fixture = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-model-offers.json');
        $fixtureJson = json_decode($fixture);

        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));
        $marketPartnerMock = $this->getMock(PartnerClient::class, ['sendRequest']);
        $marketPartnerMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $models = $marketPartnerMock->getModelsOffers([11002659], 213, 'RUR');

        /** @var MarketModel $model */
        foreach ($models as $modelIndex => $model) {
            $modelJson = $fixtureJson->models[$modelIndex];
            $this->assertEquals($modelJson->id, $model->getId());

            /** @var MarketModelOffer $offer */
            foreach ($model->getOffers() as $offerIndex => $offer) {
                $offerJson = $modelJson->offers[$offerIndex];
                $this->assertEquals($offerJson->inStock, $offer->getInStock());
                $this->assertEquals($offerJson->name, $offer->getName());
                $this->assertEquals($offerJson->pos, $offer->getPos());
                $this->assertEquals($offerJson->price, $offer->getPrice());
                $this->assertEquals($offerJson->regionId, $offer->getRegionId());
                $this->assertEquals($offerJson->shippingCost, $offer->getShippingCost());
                $this->assertEquals($offerJson->shopName, $offer->getShopName());
            }
        }
    }
}
