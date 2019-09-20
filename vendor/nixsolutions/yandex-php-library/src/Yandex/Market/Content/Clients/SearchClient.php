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
 * Class SearchClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 09.01.16 15:03
 */
class SearchClient extends ContentClient
{
    /**
     * Get models & offers search result
     *
     * Returns models and offers of Yandex.Market service search result according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/search-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseSearchGet
     */
    public function get($params = array())
    {
        $resource = 'search.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getSearchResponse = new Models\ResponseSearchGet($response);

        return $getSearchResponse;
    }

    /**
     * Get models & offers search by filters result
     *
     * Returns models and offers of Yandex.Market service search by filters result according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/filter-id-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\ResponseFilterCategoryGet
     */
    public function getFilterCategory($categoryId, $params = array())
    {
        $resource = 'filter/' . $categoryId. '.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getFilterCategoryResponse = new Models\ResponseFilterCategoryGet($response);

        return $getFilterCategoryResponse;
    }
}
