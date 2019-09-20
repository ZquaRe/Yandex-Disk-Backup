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
 * Class VendorClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 08.01.16 02:10
 */
class VendorClient extends ContentClient
{
    /**
     * Get Vendors
     *
     * Returns vindors list of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseVendorsListGet
     */
    public function getList($params = array())
    {
        $resource = 'vendor.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getVendorsResponse = new Models\ResponseVendorsListGet($response);

        return $getVendorsResponse;
    }

    /**
     * Get vendor information
     *
     * Returns vendor of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/vendor-id-docpage/
     *
     * @param int $vendorId
     *
     * @return Models\ResponseVendorGet
     */
    public function get($vendorId)
    {
        $resource = 'vendor/' . $vendorId . '.json';
        $response = $this->getServiceResponse($resource);

        $getVendorResponse = new Models\ResponseVendorGet($response);

        return $getVendorResponse;
    }

    /**
     * Get vendor
     *
     * Returns vendor of Yandex.Market service matched specified params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/vendor-match-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseVendorMatchGet
     */
    public function getMatch($params = array())
    {
        $resource = 'vendor/match.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getVendorMatchResponse = new Models\ResponseVendorMatchGet($response);

        return $getVendorMatchResponse;
    }
}
