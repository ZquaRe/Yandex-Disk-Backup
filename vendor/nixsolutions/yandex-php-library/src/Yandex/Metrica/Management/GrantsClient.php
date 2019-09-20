<?php
namespace Yandex\Metrica\Management;

/**
 * Class GrantsClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:43
 */
class GrantsClient extends ManagementClient
{

    /**
     * Get counter grants
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/grants/grants.xml
     *
     * @param int $counterId
     * @param array $params
     * @return array
     */
    public function getGrants($counterId, $params = [])
    {
        $resource = 'counter/' . $counterId . '/grants';
        $response = $this->sendGetRequest($resource, $params);
        $grantResponse = new Models\GetGrantsResponse($response);
        return $grantResponse->getGrants();
    }


    /**
     * Add grant to counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/grants/addgrant.xml
     *
     * @param int $counterId
     * @param Models\Grant $grant
     * @return Models\Grant
     */
    public function addGrant($counterId, Models\Grant $grant)
    {
        $resource = 'counter/' . $counterId . '/grants';
        $response = $this->sendPostRequest($resource, ["grant" => $grant->toArray()]);
        $grantResponse = new Models\AddGrantResponse($response);
        return $grantResponse->getGrant();
    }


    /**
     * Get counter grant
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/grants/grantold.xml
     *
     * @param int $counterId
     * @param string $userLogin
     * @param array $params
     * @return Models\Grant
     */
    public function getGrant($counterId, $userLogin, $params = [])
    {
        $resource = 'counter/' . $counterId . '/grant/' . $userLogin;
        $response = $this->sendGetRequest($resource, $params);
        $grantResponse = new Models\GetGrantResponse($response);
        return $grantResponse->getGrant();
    }


    /**
     * Update counter grant
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/grants/editgrantold.xml
     *
     * @param int $counterId
     * @param string $userLogin
     * @param Models\Grant $grant
     * @return Models\Grant
     */
    public function updateGrant($counterId, $userLogin, Models\Grant $grant)
    {
        $resource = 'counter/' . $counterId . '/grant/' . $userLogin;
        $response = $this->sendPutRequest($resource, ["grant" => $grant->toArray()]);
        $grantResponse = new Models\UpdateGrantResponse($response);
        return $grantResponse->getGrant();
    }


    /**
     * Delete counter grant
     *
     * @see http://api.yandex.ru/metrika/doc/ref/reference/del-counter-grant.xml
     *
     * @param int $counterId
     * @param string $userLogin
     * @return array
     */
    public function deleteGrant($counterId, $userLogin)
    {
        $resource = 'counter/' . $counterId . '/grant/' . $userLogin;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
