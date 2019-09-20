<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Market\Content\Clients;

use Yandex\Market\Content\ContentClient;
use Yandex\Market\Content\Models;

/**
 * Class ShopClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 08.01.16 04:06
 */
class ShopClient extends ContentClient
{
    /**
     * Get Shop
     *
     * Returns shop of Yandex.Market service matched specified params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/shops-host-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseShopMatchGet
     */
    public function getMatch($params = array())
    {
        $resource = 'shops.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $shops = new Models\ResponseShopMatchGet($response);

        return $shops;
    }

    /**
     * Get shop information
     *
     * Returns shop of Yandex.Market.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/shop-id-docpage/
     *
     * @param int $shopId
     *
     * @return Models\Shop
     */
    public function get($shopId)
    {
        $resource = 'shop/' . $shopId . '.json';
        $response = $this->getServiceResponse($resource);

        $getShopResponse = new Models\ResponseShopGet($response);

        return $getShopResponse->getShop();
    }

    /**
     * Get outlets of shop
     *
     * Returns outlets of Yandex.Market service shop according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/shop-id-outlets-docpage/
     *
     * @param int   $shopId
     * @param array $params
     *
     * @return Models\ResponseShopOutletsGet
     */
    public function getOutlets($shopId, $params = array())
    {
        $resource = 'shop/' . $shopId . '/outlets.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $shopOutlets = new Models\ResponseShopOutletsGet($response);

        return $shopOutlets;
    }

    /**
     * Get opinions of shop
     *
     * Returns opinions list of Yandex.Market service shop.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/shop-id-opinion-docpage/
     *
     * @param int   $shopId
     * @param array $params
     *
     * @return Models\ResponseShopOpinionsGet
     */
    public function getOpinions($shopId, $params = array())
    {
        $resource = 'shop/' . $shopId . '/opinion.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $shopOpinions = new Models\ResponseShopOpinionsGet($response);

        return $shopOpinions;
    }
}
