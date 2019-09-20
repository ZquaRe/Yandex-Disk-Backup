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
 * Class OfferClient
 *
 * @category Yandex
 * @package  MarketContent
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 08.01.16 02:10
 */
class OfferClient extends ContentClient
{
    /**
     * Get offer information
     *
     * Returns offer of Yandex.Market service according to params.
     *
     * @see https://tech.yandex.ru/market/content-data/doc/dg/reference/offer-id-docpage/
     *
     * @param string $offerId
     * @param array  $params
     *
     * @return Models\ResponseOfferGet
     */
    public function get($offerId, $params = array())
    {
        $resource = 'offer/' . $offerId . '.json';
        $resource .= '?' . $this->buildQueryString($params);
        $response = $this->getServiceResponse($resource);

        $getOfferResponse = new Models\ResponseOfferGet($response);

        return $getOfferResponse;
    }
}
