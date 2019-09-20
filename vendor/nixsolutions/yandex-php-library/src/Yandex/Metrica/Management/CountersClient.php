<?php

namespace Yandex\Metrica\Management;

/**
 * Class CountersClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:30
 */
class CountersClient extends ManagementClient
{

    /**
     * Get counters
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/counters/counters.xml
     *
     * @param Models\CountersParams $params
     * @return Models\GetCountersResponse
     */
    public function getCounters(Models\CountersParams $params)
    {
        $resource = 'counters';
        $response = $this->sendGetRequest($resource, $params->toArray());
        $counters = new Models\GetCountersResponse($response);

        return $counters;
    }


    /**
     * Add counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/counters/addcounter.xml
     *
     * @param Models\Counter $counter
     * @return Models\Counter
     */
    public function addCounter(Models\Counter $counter)
    {
        $resource = 'counters';
        $response = $this->sendPostRequest($resource, ["counter" => $counter->toArray()]);
        $counter = new Models\AddCounterResponse($response);
        return $counter->getCounter();
    }


    /**
     * Get counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/counters/counter.xml
     *
     * @param int $id
     * @param Models\CounterParams $params
     * @return Models\Counter
     */
    public function getCounter($id, Models\CounterParams $params)
    {
        $resource = 'counter/' . $id;
        $response = $this->sendGetRequest($resource, $params->toArray());
        $counter = new Models\GetCounterResponse($response);
        return $counter->getCounter();
    }


    /**
     * Update counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/counters/editcounter.xml
     *
     * @param int $id
     * @param Models\ExtendCounter $counter
     * @return Models\Counter
     */
    public function updateCounter($id, Models\ExtendCounter $counter)
    {
        $resource = 'counter/' . $id;
        $response = $this->sendPutRequest($resource, ["counter" => $counter->toArray()]);
        $counter = new Models\UpdateCounterResponse($response);
        return $counter->getCounter();
    }

    /**
     * Undelete counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/counters/undeletecounter.xml
     *
     * @param int $id
     * @return array
     */
    public function undeleteCounter($id)
    {
        $resource = 'counter/' . $id . '/undelete';
        $response = $this->sendPostRequest($resource, []);
        return $response;
    }


    /**
     * Delete counter
     *
     * @see http://api.yandex.ru/metrika/doc/ref/reference/delete-counter.xml
     *
     * @param int $id
     * @return array
     */
    public function deleteCounter($id)
    {
        $resource = 'counter/' . $id;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
