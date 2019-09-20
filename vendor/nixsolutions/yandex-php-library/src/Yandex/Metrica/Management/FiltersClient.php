<?php
namespace Yandex\Metrica\Management;

/**
 * Class FiltersClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:41
 */
class FiltersClient extends ManagementClient
{

    /**
     * Get counter filters
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/filters/filters.xml
     *
     * @param int $counterId
     * @return array
     */
    public function getFilters($counterId)
    {
        $resource = 'counter/' . $counterId . '/filters';
        $response = $this->sendGetRequest($resource);
        $filterResponse = new Models\GetFiltersResponse($response);
        return $filterResponse->getFilters();
    }


    /**
     * Add filter to counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/filters/addfilter.xml
     *
     * @param int $counterId
     * @param Models\Filter $filter
     * @return array
     */
    public function addFilter($counterId, Models\Filter $filter)
    {
        $resource = 'counter/' . $counterId . '/filters';
        $response = $this->sendPostRequest($resource, ["filter" => $filter->toArray()]);
        $filterResponse = new Models\AddFilterResponse($response);
        return $filterResponse->getFilter();
    }


    /**
     * Get counter filter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/filters/filter.xml
     *
     * @param int $id
     * @param int $counterId
     * @param array $params
     * @return array
     */
    public function getFilter($id, $counterId, $params = [])
    {
        $resource = 'counter/' . $counterId . '/filter/' . $id;
        $response = $this->sendGetRequest($resource, $params);
        $filterResponse = new Models\GetFilterResponse($response);
        return $filterResponse->getFilter();
    }


    /**
     * Update counter filter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/filters/editfilter.xml
     *
     * @param int $id
     * @param int $counterId
     * @param  Models\Filter $filter
     * @return array
     */
    public function updateFilter($id, $counterId, Models\Filter $filter)
    {
        $resource = 'counter/' . $counterId . '/filter/' . $id;
        $response = $this->sendPutRequest($resource, ["filter" => $filter->toArray()]);
        $filterResponse = new Models\UpdateFilterResponse($response);
        return $filterResponse->getFilter();
    }


    /**
     * Delete counter filter
     *
     * @see http://api.yandex.ru/metrika/doc/ref/reference/del-counter-filter.xml
     *
     * @param int $id
     * @param int $counterId
     * @return array
     */
    public function deleteFilter($id, $counterId)
    {
        $resource = 'counter/' . $counterId . '/filter/' . $id;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
