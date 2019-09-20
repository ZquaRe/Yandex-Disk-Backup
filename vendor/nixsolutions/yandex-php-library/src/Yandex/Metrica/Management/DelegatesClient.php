<?php
namespace Yandex\Metrica\Management;

/**
 * Class DelegatesClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:43
 */
class DelegatesClient extends ManagementClient
{
    /**
     * Get delegates
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/delegates.xml
     *
     * @return Models\Delegates
     */
    public function getDelegates()
    {
        $resource = 'delegates';
        $response = $this->sendGetRequest($resource);
        $delegateResponse = new Models\GetDelegatesResponse($response);
        return $delegateResponse->getDelegates();
    }


    /**
     * Update delegates
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/updatedelegates.xml
     *
     * @param Models\Delegates $delegates
     * @return Models\Delegates
     */
    public function updateDelegates(Models\Delegates $delegates)
    {
        $resource = 'delegates';
        $response = $this->sendPutRequest($resource, $delegates->toArray());
        $delegateResponse = new Models\UpdateDelegateResponse($response);
        return $delegateResponse->getDelegates();
    }


    /**
     * Add delegate
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/adddelegate.xml
     *
     * @param string $login
     * @param string $comment
     * @return Models\Delegates
     */
    public function addDelegates($login, $comment = '')
    {
        $resource = 'delegates';
        $params = [
            'delegate' => [
                'user_login' => $login,
                'created_at' => date('c'),
                'comment' => $comment
            ]
        ];
        $response = $this->sendPostRequest($resource, $params);
        $delegateResponse = new Models\AddDelegateResponse($response);
        return $delegateResponse->getDelegates();
    }


    /**
     * Delete delegate
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/deletedelegateold.xml
     *
     * @param string $userLogin
     * @return array
     */
    public function deleteDelegate($userLogin)
    {
        $resource = 'delegate/' . $userLogin;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
