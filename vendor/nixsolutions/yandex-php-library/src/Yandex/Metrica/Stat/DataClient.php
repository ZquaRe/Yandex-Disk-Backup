<?php
namespace Yandex\Metrica\Stat;

use Yandex\Metrica\Stat\StatClient;

/**
 * Class DataClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Tanya Kalashnik
 * @created  18.07.14 15:37
 */
class DataClient extends StatClient
{

    /**
     * Get table
     *
     * @see http://api.yandex.ru/metrika/doc/beta/api_v1/data.xml
     *
     * @param Models\TableParams $params
     * @return Models\Table
     */
    public function getTable(Models\TableParams $params)
    {
        $resource = '';

        $response = $this->sendGetRequest($resource, $params->toArray());
        $dataResponse = new Models\Table($response);
        return $dataResponse;
    }

    /**
     * Get drill down
     *
     * @see http://api.yandex.ru/metrika/doc/beta/api_v1/drilldown.xml
     *
     * @param Models\TableParams $params
     * @param array $parentId
     * @return Models\DrillDown
     */
    public function getDrillDown(Models\TableParams $params, array $parentId = [])
    {
        $resource = 'drilldown';
        $params = $params->toArray();

        if (!empty($parentId)) {
            $params['parent_id'] = json_encode($parentId);
        }

        $response = $this->sendGetRequest($resource, $params);
        $dataResponse = new Models\DrillDown($response);
        return $dataResponse;
    }

    /**
     * Get data by time
     *
     * @see http://api.yandex.ru/metrika/doc/beta/api_v1/bytime.xml
     *
     * @param Models\ByTimeParams $params
     * @return Models\ByTimeData
     */
    public function getByTime(Models\ByTimeParams $params)
    {
        $resource = 'bytime';
        $response = $this->sendGetRequest($resource, $params->toArray());
        $dataResponse = new Models\ByTimeData($response);
        return $dataResponse;
    }

    /**
     * Comparison segments
     *
     * @see http://api.yandex.ru/metrika/doc/beta/api_v1/requestcompareab.xml
     *
     * @param Models\ComparisonParams $params
     * @return Models\Comparison
     */
    public function getComparisonSegments(Models\ComparisonParams $params)
    {
        $resource = 'comparison';
        $response = $this->sendGetRequest($resource, $params->toArray());
        $dataResponse = new Models\Comparison($response);
        return $dataResponse;
    }

    /**
     * Comparison drill down
     *
     * @see http://api.yandex.ru/metrika/doc/beta/api_v1/comparison_drilldown.xml
     *
     * @param Models\DrillDownComparisonParams $params
     * @return Models\DrillDownComparison
     */
    public function getComparisonDrillDown(Models\DrillDownComparisonParams $params)
    {
        $resource = 'comparison/drilldown';
        $response = $this->sendGetRequest($resource, $params->toArray());
        $dataResponse = new Models\DrillDownComparison($response);
        return $dataResponse;
    }
}
