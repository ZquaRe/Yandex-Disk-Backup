<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Market\Partner;

use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\StringCollection;
use Yandex\Market\Partner\Exception\PartnerRequestException;
use Yandex\Market\Partner\Models\Delivery;
use Yandex\Market\Partner\Models\GetCampaignsResponse;
use Yandex\Market\Partner\Models\GetMarketModelsResponse;
use Yandex\Market\Partner\Models\GetOrderResponse;
use Yandex\Market\Partner\Models\GetOrdersResponse;
use Yandex\Market\Partner\Models\MarketModel;
use Yandex\Market\Partner\Models\MarketModels;
use Yandex\Market\Partner\Models\Order;
use Yandex\Market\Partner\Models\Orders;
use Yandex\Market\Partner\Models\UpdateOrderDeliveryResponse;
use Yandex\Market\Partner\Models\UpdateOrderStatusResponse;

/**
 * Class PartnerClient
 *
 * @category Yandex
 * @package Market
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  04.11.13 12:48
 */
class PartnerClient extends AbstractServiceClient
{

    /**
     * Order is being processed
     */
    const ORDER_STATUS_PROCESSING = 'PROCESSING';

    /**
     * Order submitted to the delivery
     */
    const ORDER_STATUS_DELIVERY = 'DELIVERY';

    /**
     *  Order delivered to the point of self-delivery
     */
    const ORDER_STATUS_PICKUP = 'PICKUP';

    /**
     * The order is received by the buyer
     */
    const ORDER_STATUS_DELIVERED = 'DELIVERED';

    /**
     * Order canceled.
     */
    const ORDER_STATUS_CANCELLED = 'CANCELLED';

    //Sub-statuses for status CANCELLED
    // - the buyer is not finalized the reserved order on time
    const ORDER_SUBSTATUS_RESERVATION_EXPIRED = 'RESERVATION_EXPIRED';
    // - the buyer did not pay for the order ( for the type of payment PREPAID)
    const ORDER_SUBSTATUS_USER_NOT_PAID = 'USER_NOT_PAID';
    // - failed to communicate with the buyer
    const ORDER_SUBSTATUS_USER_UNREACHABLE = 'USER_UNREACHABLE';
    // - buyer canceled the order for cause
    const ORDER_SUBSTATUS_USER_CHANGED_MIND = 'USER_CHANGED_MIND';
    // - the buyer is not satisfied with the terms of delivery
    const ORDER_SUBSTATUS_USER_REFUSED_DELIVERY = 'USER_REFUSED_DELIVERY';
    // - the buyer did not fit the goods
    const ORDER_SUBSTATUS_USER_REFUSED_PRODUCT = 'USER_REFUSED_PRODUCT';
    // - shop can not fulfill the order
    const ORDER_SUBSTATUS_SHOP_FAILED = 'SHOP_FAILED';
    // - the buyer is not satisfied with the quality of the goods
    const ORDER_SUBSTATUS_USER_REFUSED_QUALITY = 'USER_REFUSED_QUALITY';
    // - buyer changes the composition of the order
    const ORDER_SUBSTATUS_REPLACING_ORDER = 'REPLACING_ORDER';
    //- store does not process orders on time
    const ORDER_SUBSTATUS_PROCESSING_EXPIRED = 'PROCESSING_EXPIRED';

    //Способ оплаты заказа
    //предоплата через Яндекс;
    const PAYMENT_METHOD_YANDEX = 'YANDEX';
    //предоплата напрямую магазину,
    //не принимающему предоплату через Яндекс.
    const PAYMENT_METHOD_SHOP_PREPAID = 'SHOP_PREPAID';
    // наличный расчет при получении заказа;
    const PAYMENT_METHOD_CASH_ON_DELIVERY = 'CASH_ON_DELIVERY';
    // оплата банковской картой при получении заказа.
    const PAYMENT_METHOD_CARD_ON_DELIVERY = 'CARD_ON_DELIVERY';

    //Типы доставки
    //курьерская доставка
    const DELIVERY_TYPE_DELIVERY = 'DELIVERY';
    //самовывоз
    const DELIVERY_TYPE_PICKUP = 'PICKUP';
    //почта
    const DELIVERY_TYPE_POST = 'POST';

    const ORDER_DECLINE_REASON_OUT_OF_DATE = 'OUT_OF_DATE';

    /**
     * Requested version of API
     * @var string
     */
    private $version = 'v2';

    /**
     * Application id
     *
     * @var string
     */
    protected $clientId;

    /**
     * User login
     *
     * @var string
     */
    protected $login;

    /**
     * Campaign Id
     *
     * @var string
     */
    protected $campaignId;

    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api.partner.market.yandex.ru';

    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @see http://api.yandex.ru/market/partner/doc/dg/concepts/method-call.xml
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . $this->version . '/' . $resource;
    }

    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $campaignId
     */
    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sends a request
     *
     * @param string $method HTTP method
     * @param string $uri URI object or string.
     * @param array $options Request options to apply.
     *
     * @return Response
     *
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws PartnerRequestException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            $body = $result->getBody();
            if ($body) {
                $jsonBody = json_decode($body);
                if ($jsonBody && isset($jsonBody->error) && isset($jsonBody->error->message)) {
                    $message = $jsonBody->error->message;
                }
            }

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            if ($code === 401) {
                throw new UnauthorizedException($message);
            }

            throw new PartnerRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }

    /**
     * Get OAuth data for header request
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/concepts/authorization.xml
     *
     * @return string
     */
    public function getAccessToken()
    {
        return 'oauth_token=' . parent::getAccessToken() . ', oauth_client_id=' . $this->getClientId()
        . ', oauth_login=' . $this->getLogin();
    }

    /**
     * Get Balance Campaign
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-balance-docpage/
     *
     * @return Models\Balance
     */
    public function getBalance()
    {
        $resource = 'campaigns/' . $this->campaignId . '/balance.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getBalanceResponse = new Models\GetBalanceResponse($decodedResponseBody);
        return $getBalanceResponse->getBalance();
    }

    /**
     * Get User Campaigns
     *
     * Returns the user to the list of campaigns Yandex.market.
     * The list coincides with the list of campaigns
     * that are displayed in the partner interface Yandex.Market on page "My shops."
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns.xml
     *
     * @return Campaigns
     */
    public function getCampaigns()
    {
        $resource = 'campaigns.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getCampaignsResponse = new GetCampaignsResponse($decodedResponseBody);
        return $getCampaignsResponse->getCampaigns();
    }
    
    /**
     * Get User Campaigns by Login
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-by-login-docpage/
     *
     * @return Models\Campaigns
     */
    public function getCampaignsByLogin($login)
    {
        $resource = 'campaigns/by_login/' . $login . '.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getCampaignsResponse = new Models\GetCampaignsResponse($decodedResponseBody);
        return $getCampaignsResponse->getCampaigns();
    }

    /**
     * Get logins by campaign id
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-logins-docpage/
     *
     * @return StringCollection
     */
    public function getLoginsByCampaign()
    {
        $resource = 'campaigns/' . $this->campaignId . '/logins.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        return StringCollection::init($decodedResponseBody['logins']);
    }

    /**
     * Get outlets by campaign id
     * @param array $params ['page' => (int) 0-100, 'pageSize' => (int) 50]
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-outlets-docpage/
     *
     * @return Models\GetOutletsResponse
     */
    public function getOutletsResponse($params = [])
    {
        $resource = 'campaigns/' . $this->campaignId . '/outlets.json';
        $resource .= '?' . http_build_query($params);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        return new Models\GetOutletsResponse($decodedResponseBody);
    }

    /**
     * Get only outlets data without pagination
     *
     * @param array $params
     * @return null|Models\Outlets
     */
    public function getOutlets($params = [])
    {
        return $this->getOutletsResponse($params)->getOutlets();
    }

    /**
     * Get outlet info
     *
     * @param $outletId
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-outlets-id-docpage/
     *
     * @return null|Models\Outlet
     */
    public function getOutlet($outletId)
    {
        $resource = 'campaigns/' . $this->campaignId . '/outlets/' . $outletId . '.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getOrderResponse = new Models\GetOutletResponse($decodedResponseBody);
        return $getOrderResponse->getOutlet();
    }


    /**
     * Get information about orders by campaign id
     *
     * @param array $params
     *
     * Returns information on the requested orders.
     * Available filtering by date ordering and order status.
     * The maximum range of dates in a single request for a resource - 30 days.
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-orders.xml
     *
     * @return GetOrdersResponse
     */
    public function getOrdersResponse($params = [])
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders.json';
        $resource .= '?' . http_build_query($params);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        return new GetOrdersResponse($decodedResponseBody);
    }

    /**
     * Get only orders data without pagination
     *
     * @param array $params
     * @return null|Orders
     */
    public function getOrders($params = [])
    {
        return $this->getOrdersResponse($params)->getOrders();
    }

    /**
     * Get order info
     *
     * @param int $orderId
     * @return Order
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-orders-id.xml
     */
    public function getOrder($orderId)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getOrderResponse = new GetOrderResponse($decodedResponseBody);
        return $getOrderResponse->getOrder();
    }

    /**
     * Get Region
     *
     * @return Models\Region
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-region-docpage/
     */
    public function getRegion()
    {
        $resource = 'campaigns/' . $this->campaignId . '/region.json';

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $getRegionResponse = new Models\GetRegionResponse($decodedResponseBody);
        return $getRegionResponse->getRegion();
    }

    /**
     * Get Campaign settings
     *
     * @retun Models\Settings
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-settings-docpage/
     */
    public function getSettings()
    {
        $resource = 'campaigns/' . $this->campaignId . '/settings.json';
       
        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());
       
        $getSettingsResponse = new Models\GetSettingsResponse($decodedResponseBody);
        return $getSettingsResponse->getSettings();
    }
  
    /**
     * @param $method [main | main-daily | main-weekly | main-monthly]
     * @param array $params
     * @return Models\Stats
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-stats-main-docpage/
     */
    public function getStats($method, $params = [])
    {
        $resource = 'campaigns/' . $this->campaignId . '/stats/' . $method . '.json';
        $resource .= '?' . http_build_query($params);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource));

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $getStatsResponse = new Models\GetStatsResponse($decodedResponseBody);
        return $getStatsResponse->getMainStats();
    }

    /**
     * Send changed status to Yandex.Market
     *
     * @param int $orderId
     * @param string $status
     * @param null|string $subStatus
     * @return Order
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/put-campaigns-id-orders-id-status.xml
     */
    public function setOrderStatus($orderId, $status, $subStatus = null)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '/status.json';

        $data = [
            "order" => [
                "status" => $status
            ]
        ];
        if ($subStatus) {
            $data['order']['substatus'] = $subStatus;
        }

        $response = $this->sendRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'json' => $data
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $updateOrderStatusResponse = new UpdateOrderStatusResponse($decodedResponseBody);
        return $updateOrderStatusResponse->getOrder();
    }


    /**
     * Update changed delivery parameters
     *
     * @param int $orderId
     * @param Delivery $delivery
     * @return Order
     *
     * Example:
     * PUT /v2/campaigns/10003/order/12345/delivery.json HTTP/1.1
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/put-campaigns-id-orders-id-delivery.xml
     */
    public function updateDelivery($orderId, Delivery $delivery)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '/delivery.json';

        $response = $this->sendRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'json' => [
                    'delivery' => $delivery->toArray()
                ]
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $updateOrderDeliveryResponse = new UpdateOrderDeliveryResponse($decodedResponseBody);
        return $updateOrderDeliveryResponse->getOrder();
    }

    /**
     * Filter query params
     *
     * @param array $params
     * @return array
     */
    private function filterParams(array $params)
    {
        return array_filter($params, function ($param) {
            return !empty($param);
        });
    }

    /**
     * Get product model by ID
     *
     * @param int $modelId
     * @param int $regionId
     * @param string $currency
     * @return MarketModel
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-models-id-docpage/
     */
    public function getModel($modelId, $regionId, $currency = null)
    {
        $resource = sprintf('models/%s.%s', $modelId, self::DECODE_TYPE_DEFAULT);
        $queryParams = $this->filterParams([
            'regionId' => $regionId,
            'currency' => $currency,
        ]);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource), ['query' => $queryParams]);
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $marketModelsResponse = new GetMarketModelsResponse($decodedResponseBody);

        return $marketModelsResponse->getModels()->current();
    }

    /**
     * Find models by query
     *
     * @param string $searchQuery
     * @param int $regionId
     * @param int $page
     * @param int $pageSize
     * @param string $currency
     * @return GetMarketModelsResponse
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-models-docpage/
     */
    public function findModels($searchQuery, $regionId, $page = null, $pageSize = null, $currency = null)
    {
        $resource = sprintf('models.%s', self::DECODE_TYPE_DEFAULT);
        $queryParams = $this->filterParams([
            'query' => $searchQuery,
            'regionId' => $regionId,
            'page' => $page,
            'pageSize' => $pageSize,
            'currency' => $currency,
        ]);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource), ['query' => $queryParams]);
        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        return new GetMarketModelsResponse($decodedResponseBody);
    }

    /**
     * Get multiple models by ids
     *
     * @param array $modelIds
     * @param int $regionId
     * @param string $currency
     * @return MarketModels
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/post-models-docpage/
     */
    public function getModels(array $modelIds, $regionId, $currency = null)
    {
        $resource = sprintf('models.%s', self::DECODE_TYPE_DEFAULT);
        $queryParams = $this->filterParams([
            'regionId' => $regionId,
            'currency' => $currency,
        ]);

        $response = $this->sendRequest('POST', $this->getServiceUrl($resource), [
            'query' => $queryParams,
            'json' => [
                'models' => $modelIds
            ],
        ]);
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $marketModelsResponse = new GetMarketModelsResponse($decodedResponseBody);

        return $marketModelsResponse->getModels();
    }

    /**
     * Get model offers
     *
     * @param int $modelId
     * @param int $regionId
     * @param string $currency
     * @param string $orderByPrice
     * @return MarketModel
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/get-models-id-offers-docpage/
     */
    public function getModelOffers($modelId, $regionId, $currency = null, $orderByPrice = null)
    {
        $resource = sprintf('models/%s/offers.%s', $modelId, self::DECODE_TYPE_DEFAULT);
        $queryParams = $this->filterParams([
            'regionId' => $regionId,
            'currency' => $currency,
            'orderByPrice' => $orderByPrice,
        ]);

        $response = $this->sendRequest('GET', $this->getServiceUrl($resource), ['query' => $queryParams]);
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $marketModelsResponse = new GetMarketModelsResponse($decodedResponseBody);

        return $marketModelsResponse->getModels()->current();
    }

    /**
     * Get multiple models offers
     *
     * @param array $modelIds
     * @param int $regionId
     * @param string $currency
     * @return MarketModels
     *
     * @link https://tech.yandex.ru/market/partner/doc/dg/reference/post-models-offers-docpage/
     */
    public function getModelsOffers(array $modelIds, $regionId, $currency = null)
    {
        $resource = sprintf('models/offers.%s', self::DECODE_TYPE_DEFAULT);
        $queryParams = $this->filterParams([
            'regionId' => $regionId,
            'currency' => $currency,
        ]);

        $response = $this->sendRequest('POST', $this->getServiceUrl($resource), [
            'query' => $queryParams,
            'json' => [
                'models' => $modelIds
            ],
        ]);
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $marketModelsResponse = new GetMarketModelsResponse($decodedResponseBody);

        return $marketModelsResponse->getModels();
    }
}
