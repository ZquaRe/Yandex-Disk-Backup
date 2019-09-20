<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Metrica\Management;

use Yandex\Metrica\MetricaClient;

/**
 * Class ManagementClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Tanya Kalashnik
 * @created  18.07.14 12:58
 */
class ManagementClient extends MetricaClient
{

    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api-metrika.yandex.ru/management/v1';


    /**
     * @return CountersClient
     */
    public function counters()
    {
        return new CountersClient($this->getAccessToken());
    }

    /**
     * @return GoalsClient
     */
    public function goals()
    {
        return new GoalsClient($this->getAccessToken());
    }

    /**
     * @return FiltersClient
     */
    public function filters()
    {
        return new FiltersClient($this->getAccessToken());
    }


    /**
     * @return OperationsClient
     */
    public function operations()
    {
        return new OperationsClient($this->getAccessToken());
    }


    /**
     * @return GrantsClient
     */
    public function grants()
    {
        return new GrantsClient($this->getAccessToken());
    }


    /**
     * @return DelegatesClient
     */
    public function delegates()
    {
        return new DelegatesClient($this->getAccessToken());
    }


    /**
     * @return AccountsClient
     */
    public function accounts()
    {
        return new AccountsClient($this->getAccessToken());
    }
}
