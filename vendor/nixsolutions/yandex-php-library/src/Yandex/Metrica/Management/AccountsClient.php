<?php
namespace Yandex\Metrica\Management;

/**
 * Class AccountsClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:44
 */
class AccountsClient extends ManagementClient
{

    /**
     * Get accounts
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/accounts/accounts.xml
     *
     * @return null|Models\Accounts
     */
    public function getAccounts()
    {
        $resource = 'accounts';

        $response = $this->sendGetRequest($resource);
        $accountsResponse = new Models\GetAccountsResponse($response);
        return $accountsResponse->getAccounts();
    }


    /**
     * Update accounts
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/accounts/updateaccounts.xml
     *
     * @param Models\Accounts $accounts
     * @return null|Models\Account
     */
    public function updateAccounts(Models\Accounts $accounts)
    {
        $resource = 'accounts';
        $response = $this->sendPutRequest($resource, $accounts->toArray());
        $accountsResponse = new Models\UpdateAccountResponse($response);
        return $accountsResponse->getAccounts();
    }


    /**
     * Delete account
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/accounts/deleteaccountold.xml
     *
     * @param string $userLogin
     * @return array
     */
    public function deleteAccount($userLogin)
    {
        $resource = 'account/' . $userLogin;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
