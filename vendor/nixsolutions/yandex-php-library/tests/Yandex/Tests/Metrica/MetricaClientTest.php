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
namespace Yandex\Tests\Dictionary;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Metrica\Exception\BadRequestException;
use Yandex\Metrica\Exception\MetricaException;
use Yandex\Metrica\Management\AccountsClient;
use Yandex\Metrica\MetricaClient;
use Yandex\Tests\Metrica\Fixtures\Accounts;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  17.03.16 15:43
 */
class MetricaClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    public function testConstruct()
    {
        $token         = 'test';
        $metricaClient = new MetricaClient($token);
        $this->assertEquals($token, $metricaClient->getAccessToken());
    }

    public function testConstructWithCustomGuzzleClient()
    {
        $token = 'test';
        $mock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $metricaClient = new MetricaClient($token, $mock);
        $this->assertEquals($token, $metricaClient->getAccessToken());
    }

    function testSendRequestForbiddenException()
    {
        $response             = new Response(403);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(ForbiddenException::class);
        $accountsClientMock->getAccounts();
    }

    function testSendRequestUnauthorizedException()
    {
        $response             = new Response(401);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(UnauthorizedException::class);
        $accountsClientMock->getAccounts();
    }

    function testSendRequestBadRequestException()
    {
        $fixtures             = Accounts::$badRequestFixtures;
        $response             = new Response(400, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(BadRequestException::class);
        $accountsClientMock->getAccounts();
    }

    function testSendRequestTooManyRequestsException()
    {
        $response             = new Response(429);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(TooManyRequestsException::class);
        $accountsClientMock->getAccounts();
    }

    function testSendRequestMetricaException()
    {
        $response             = new Response(500);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(MetricaException::class);
        $accountsClientMock->getAccounts();
    }

    function testSendRequestResponse()
    {
        $fixtures             = Accounts::$accountsFixtures;
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(json_encode($fixtures)));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $accountsClientMock = $this->getMockBuilder(AccountsClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $accountsClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $table = $accountsClientMock->getAccounts();
        $this->assertEquals($fixtures["accounts"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["accounts"][0]["created_at"], $table->current()->getCreatedAt());
    }

    public function testGetServiceUrl()
    {
        $metricaClient = new MetricaClient();
        $this->assertNotEmpty($metricaClient->getServiceUrl('test', ['test' => 'test']));
    }
}
