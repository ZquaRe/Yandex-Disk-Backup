<?php

namespace Yandex\Metrica\Analytics;

/**
 * Class GaClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Tanya Kalashnik
 * @created  28.07.14 11:37
 */
class GaClient extends AnalyticsClient
{

    /**
     * Get google analytics data
     *
     * @see http://api.yandex.ru/metrika/doc/beta/ga/queries/requestjson.xml
     *
     * @param Models\Params $params
     * @return Models\Ga
     */
    public function getGaData(Models\Params $params)
    {
        $resource = 'ga';

        $response = $this->sendGetRequest($resource, $params->toArray());
        $responseObj = new Models\Ga($response);
        return $responseObj;
    }
}
