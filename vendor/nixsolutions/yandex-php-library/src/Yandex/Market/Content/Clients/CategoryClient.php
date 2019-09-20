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
 * Class CategoryClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 04.01.16 23:54
 */
class CategoryClient extends ContentClient
{
    /**
     * Get Categories
     *
     * Returns categories list of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseCategoryGetList
     */
    public function getList($params = array())
    {
        $resource = 'category.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getCategoriesResponse = new Models\ResponseCategoryGetList($response);

        return $getCategoriesResponse;
    }

    /**
     * Get category information
     *
     * Returns category of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-id-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\Category
     */
    public function get($categoryId, $params = array())
    {
        $resource = 'category/' . $categoryId . '.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getCategoryResponse = new Models\ResponseCategoryGet($response);

        return $getCategoryResponse->getCategory();
    }

    /**
     * Get children categories
     *
     * Returns children categories list of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-id-children-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\ResponseCategoryGetList
     */
    public function getChildren($categoryId, $params = array())
    {
        $resource = 'category/' . $categoryId . '/children.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getCategoryResponse = new Models\ResponseCategoryGetList($response);

        return $getCategoryResponse;
    }

    /**
     * Get models in category
     *
     * Returns models list represented in category of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-id-model-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\ResponseCategoryGetModels
     */
    public function getModels($categoryId, $params = array())
    {
        $resource = 'category/' . $categoryId . '/models.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getCategoryModelsResponse = new Models\ResponseCategoryGetModels($response);

        return $getCategoryModelsResponse;
    }

    /**
     * Get filters in category
     *
     * Returns filters list of models represented in category of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/category-id-filters-docpage/
     *
     * @param int   $categoryId
     * @param array $params
     *
     * @return Models\ResponseCategoryGetFilters
     */
    public function getFilters($categoryId, $params = array())
    {
        $resource = 'category/' . $categoryId . '/filters.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getCategoryFiltersResponse = new Models\ResponseCategoryGetFilters($response);

        return $getCategoryFiltersResponse;
    }
}
