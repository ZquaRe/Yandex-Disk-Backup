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
 * Class GeoRegionClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 08.01.16 18:44
 */
class GeoRegionClient extends ContentClient
{
    /**
     * Get geo regions
     *
     * Returns geo regions list of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/georegion-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseGeoRegionsGet
     */
    public function getList($params = array())
    {
        $resource = 'georegion.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $geoRegions = new Models\ResponseGeoRegionsGet($response);

        return $geoRegions;
    }

    /**
     * Get geo region information
     *
     * Returns geo region of Yandex.Market service.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/georegion-id-docpage/
     *
     * @param int $regionId
     *
     * @return Models\ResponseGeoRegionGet
     */
    public function get($regionId)
    {
        $resource = 'georegion/' . $regionId . '.json';
        $response = $this->getServiceResponse($resource);

        $geoRegion = new Models\ResponseGeoRegionGet($response);

        return $geoRegion;
    }

    /**
     * Get children of geo region
     *
     * Returns children list of Yandex.Market service geo region.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/georegion-id-children-docpage/
     *
     * @param int   $regionId
     * @param array $params
     *
     * @return Models\ResponseGeoRegionChildrenGet
     */
    public function getChildren($regionId, $params = array())
    {
        $resource = 'georegion/' . $regionId . '/children.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $geoRegionChildren = new Models\ResponseGeoRegionChildrenGet($response);

        return $geoRegionChildren;
    }

    /**
     * Get suggests of geo region
     *
     * Returns suggests list of geo region in Yandex.Market service.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/georegion-suggest-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseGeoRegionSuggestGet
     */
    public function getMatch($params = array())
    {
        $resource = 'georegion/suggest.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $geoRegionsSuggest = new Models\ResponseGeoRegionSuggestGet($response);

        return $geoRegionsSuggest;
    }

    /**
     * Get shops summary in geo region
     *
     * Returns shops summary information of Yandex.Market service in geo region.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/regions-id-shops-summary-docpage/
     *
     * @param int   $regionId
     * @param array $params
     *
     * @return Models\ResponseGeoRegionShopsSummaryGet
     */
    public function getShopsSummary($regionId, $params = array())
    {
        $resource = 'regions/' . $regionId . '/shops/summary.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $regionShopsSummary = new Models\ResponseGeoRegionShopsSummaryGet($response);

        return $regionShopsSummary;
    }
}
