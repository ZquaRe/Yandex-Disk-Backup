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
 * Class PopularClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 08.01.16 01:19
 */
class PopularClient extends ContentClient
{
    /**
     * Get popular models
     *
     * Returns popular models of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/popular-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponsePopularModelsGet
     */
    public function getModels($params = array())
    {
        $resource = 'popular.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getPopularModelsResponse = new Models\ResponsePopularModelsGet($response);

        return $getPopularModelsResponse;
    }

    /**
     * Get popular category models
     *
     * Returns popular category models of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/popular-category-id-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\ResponsePopularCategoryModelsGet
     */
    public function getCategoryModels($categoryId, $params = array())
    {
        $resource = 'popular/' . $categoryId . '.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getPopularCategoryModelsResponse = new Models\ResponsePopularCategoryModelsGet($response);

        return $getPopularCategoryModelsResponse;
    }
}
