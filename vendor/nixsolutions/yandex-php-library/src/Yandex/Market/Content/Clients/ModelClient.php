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
 * Class ModelClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 05.01.16 01:06
 */
class ModelClient extends ContentClient
{
    /**
     * Get model information
     *
     * Returns model of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-docpage/
     *
     * @param int   $modelId
     * @param array $params
     *
     * @return Models\ResponseModelGet
     */
    public function get($modelId, $params = array())
    {
        $resource = 'model/' . $modelId . '.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getModelResponse = new Models\ResponseModelGet($response);

        return $getModelResponse->getModel();
    }

    /**
     * Get model short information
     *
     * Returns short model of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-info-docpage/
     *
     * @param int   $modelId
     * @param array $params
     *
     * @return Models\ResponseModelInfoGet
     */
    public function getInfo($modelId, $params = array())
    {
        $resource = 'model/' . $modelId . '/info.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getModelInfoResponse = new Models\ResponseModelInfoGet($response);

        return $getModelInfoResponse;
    }

    /**
     * Get offers in model
     *
     * Returns offers list represented in model of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-offers-docpage/
     *
     * @param int   $modelId
     * @param array $params
     *
     * @return Models\ResponseModelOffersGet
     */
    public function getOffers($modelId, $params = array())
    {
        $resource = 'model/' . $modelId . '/offers.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getOffersResponse = new Models\ResponseModelOffersGet($response);

        return $getOffersResponse;
    }

    /**
     * Get outlets of model
     *
     * Returns outlets list where model of Yandex.Market service represented according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-outlets-docpage/
     *
     * @param int   $modelId
     * @param array $params
     *
     * @return Models\ResponseModelOutletsGet
     */
    public function getOutlets($modelId, $params = array())
    {
        $resource = 'model/' . $modelId . '/outlets.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getOutletsResponse = new Models\ResponseModelOutletsGet($response);

        return $getOutletsResponse;
    }

    /**
     * Get reviews of model
     *
     * Returns reviews list where model of Yandex.Market service represented.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-reviews-docpage/
     *
     * @param int $modelId
     *
     * @return Models\ResponseModelReviewsGet
     */
    public function getReviews($modelId)
    {
        $resource = 'model/' . $modelId . '/reviews.json';
        $response = $this->getServiceResponse($resource);

        $getReviewsResponse = new Models\ResponseModelReviewsGet($response);

        return $getReviewsResponse;
    }

    /**
     * Get model(-s) by name and params
     *
     * Returns model(-s) of Yandex.Market service by name and params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-match-docpage/
     *
     * @param array $params
     *
     * @return Models\ResponseModelMatchGet
     */
    public function getMatch($params = array())
    {
        $resource = 'model/match.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getModelMatchResponse = new Models\ResponseModelMatchGet($response);

        return $getModelMatchResponse;
    }

    /**
     * Get opinions of model
     *
     * Returns opinions list of Yandex.Market service model.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/model-id-opinion-docpage/
     *
     * @param int   $modelId
     * @param array $params
     *
     * @return Models\ResponseModelOpinionsGet
     */
    public function getOpinions($modelId, $params = array())
    {
        $resource = 'model/' . $modelId . '/opinion.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $modelOpinions = new Models\ResponseModelOpinionsGet($response);

        return $modelOpinions;
    }
}
