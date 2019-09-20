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
namespace Yandex\Tests\Metrica;

use Yandex\Metrica\Management\AccountsClient;
use Yandex\Metrica\Management\CountersClient;
use Yandex\Metrica\Management\DelegatesClient;
use Yandex\Metrica\Management\FiltersClient;
use Yandex\Metrica\Management\GoalsClient;
use Yandex\Metrica\Management\GrantsClient;
use Yandex\Metrica\Management\ManagementClient;
use Yandex\Metrica\Management\OperationsClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  18.03.16 16:40
 */
class ManagementClientTest extends TestCase
{
    public function testGetCountersClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->counters();
        $this->assertTrue($client instanceof CountersClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetGoalsClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->goals();
        $this->assertTrue($client instanceof GoalsClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetFiltersClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->filters();
        $this->assertTrue($client instanceof FiltersClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetOperationsClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->operations();
        $this->assertTrue($client instanceof OperationsClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetGrantsClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->grants();
        $this->assertTrue($client instanceof GrantsClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetDelegatesClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->delegates();
        $this->assertTrue($client instanceof DelegatesClient);
        $this->assertEquals($token, $client->getAccessToken());
    }

    public function testGetAccountsClient()
    {
        $token         = 'test';
        $metricaClient = new ManagementClient($token);
        $client        = $metricaClient->accounts();
        $this->assertTrue($client instanceof AccountsClient);
        $this->assertEquals($token, $client->getAccessToken());
    }
}
