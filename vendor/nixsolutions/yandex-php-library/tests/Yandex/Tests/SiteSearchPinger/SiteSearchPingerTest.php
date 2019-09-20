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
namespace Yandex\Tests\SiteSearchPinger;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yandex\Common\Exception\InvalidArgumentException;
use Yandex\Common\Exception\InvalidSettingsException;
use Yandex\SiteSearchPinger\Exception\InvalidUrlException;
use Yandex\SiteSearchPinger\Exception\SiteSearchPingerException;
use Yandex\SiteSearchPinger\SiteSearchPinger;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  14.03.16 15:30
 */
class SiteSearchPingerTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    protected $fixtureUrls = [
        'http://anton.shevchuk.name/php/php-development-environment-under-macos/',
        'http://anton.shevchuk.name/php/php-framework-bluz-update/',
        'http://ya.ru',
        'http://yandex.ru',
        'http://yaru',
        'yarus',
        'https://naxel.me'
    ];

    public function testInvalidSettingsException()
    {
        $siteSearchPinger = new SiteSearchPinger();
        $this->expectException(InvalidSettingsException::class);
        $siteSearchPinger->ping($this->fixtureUrls);
    }

    function testPingResponse()
    {
        $key                         = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                       = 'login';
        $searchId                    = '111111';
        $countAdded                  = 1;
        $outOfSearchAreaMessage      = 'Invalid site URL. Site is not under your search area';
        $invalidMalformedUrlsMessage = 'Invalid URL format';
        $xml                         = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/ping-response.xml');
        $response                    = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);

        $added = $pingerMock->ping($this->fixtureUrls);
        $this->assertEquals($countAdded, $added);
        $invalidUrls = $pingerMock->getInvalidUrls();

        $this->assertEquals($outOfSearchAreaMessage, $invalidUrls[$this->fixtureUrls[0]]);
        $this->assertEquals($invalidMalformedUrlsMessage, $invalidUrls[$this->fixtureUrls[4]]);
    }

    function testPingResponseError()
    {
        $key                  = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                = 'login';
        $searchId             = '111111';
        $xml                  = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/ping-response-error.xml'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);

        $this->expectException(InvalidArgumentException::class);

        $pingerMock->ping($this->fixtureUrls, time());
    }

    function testPingResponseEmptyParam()
    {
        $key                  = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                = 'login';
        $searchId             = '111111';
        $xml                  = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/ping-response-empty-param.xml'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);

        $this->expectException(InvalidUrlException::class);

        $pingerMock->ping([]);
    }

    function testPingWrongResponse()
    {
        $key                  = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                = 'login';
        $searchId             = '111111';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(''));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);

        $this->expectException(SiteSearchPingerException::class);

        $pingerMock->ping($this->fixtureUrls);
    }

    function testPingEmptyResponse()
    {
        $key                  = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                = 'login';
        $searchId             = '111111';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(''));
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);
        $added = $pingerMock->ping($this->fixtureUrls);
        $this->assertEquals(0, $added);
    }

    function testPingResponseIncorrectSearchId()
    {
        $key                  = '2b8d1253b4c7f3797245dc1af6e17ad801426c89';
        $login                = 'login';
        $searchId             = 'incorrect_id';
        $xml                  = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/ping-response-error-incorrect-search-id.xml'
        );
        $request              = new Request('POST', '');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $pingerMock = $this->getMockBuilder(SiteSearchPinger::class)
            ->setMethods(['getClient'])
            ->getMock();
        $pingerMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $pingerMock->setKey($key);
        $pingerMock->setLogin($login);
        $pingerMock->setSearchId($searchId);

        $this->expectException(InvalidArgumentException::class);

        $pingerMock->ping($this->fixtureUrls);
    }
}
