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
namespace Yandex\Tests\SafeBrowsing;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\NotFoundException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\SafeBrowsing\SafeBrowsingClient;
use Yandex\SafeBrowsing\SafeBrowsingException;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  16.03.16 11:51
 */
class SafeBrowsingClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    /**
     * @param $apiKey
     * @param $expectedApiKey
     *
     * @dataProvider dataSetGetApiKey
     */
    public function testSetGetAccessToken($apiKey, $expectedApiKey)
    {
        $safeBrowsing = new SafeBrowsingClient();

        $this->assertEmpty($safeBrowsing->getApiKey());

        $safeBrowsing->setApiKey($apiKey);

        $this->assertEquals($expectedApiKey, $safeBrowsing->getApiKey());
    }

    /**
     * @return array
     */
    public function dataSetGetApiKey()
    {
        return [
            'empty access api key' => [
                'apiKey'         => null,
                'expectedApiKey' => null
            ],
            'not empty api key'    => [
                'apiKey'         => 'test',
                'expectedApiKey' => 'test'
            ],
        ];
    }

    function testConstruct()
    {
        $apiKey       = 'test';
        $safeBrowsing = new SafeBrowsingClient($apiKey);
        $this->assertEquals($apiKey, $safeBrowsing->getApiKey());
    }

    function testSearchUrlNotFound()
    {
        $url                  = 'http://site.com/';
        $response             = new Response(204);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->searchUrl($url);
        $this->assertFalse($result);
    }

    function testSearchUrlIncorrectCode()
    {
        $url                  = 'http://site.com/';
        $response             = new Response(500);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(SafeBrowsingException::class);
        $safeBrowsingMock->searchUrl($url);
    }

    public function testSearchUrlFoundAndMatched()
    {
        $content              = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/search-url-found-response.txt'
        );
        $url                  = 'www.wmconvirus.narod.ru';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->searchUrl($url);
        $this->assertArrayHasKey('host', $result);
        $this->assertArrayHasKey('prefix', $result);
        $this->assertArrayHasKey('full', $result);
    }

    public function testSearchUrlFoundAndNotMatched()
    {
        $content              = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/search-url-found-response.txt'
        );
        $url                  = 'www.wmconvirus.narod.ru';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $safeBrowsingMock->setMalwareShavars(['ydx-no-shavar']);
        $result = $safeBrowsingMock->searchUrl($url);
        $this->assertFalse($result);
    }

    public function testGetHashesByUrlIp()
    {
        $apiKey       = 'test';
        $url          = '127.0.0.1';
        $safeBrowsing = new SafeBrowsingClient($apiKey);

        $result = $safeBrowsing->getHashesByUrl($url);
        $this->assertNotEmpty($result);
    }

    public function testGetHashesByUrlTooMuchSubDomains()
    {
        $apiKey       = 'test';
        $url          = 'test.test.test.test.test.test.com';
        $safeBrowsing = new SafeBrowsingClient($apiKey);

        $result = $safeBrowsing->getHashesByUrl($url);
        $this->assertNotEmpty($result);
    }

    public function testLookupFound()
    {
        $content              = 'malware';
        $url                  = 'www.wmconvirus.narod.ru';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->lookup($url);
        $this->assertNotEmpty($result);
    }

    public function testLookupNotFound()
    {
        $url                  = 'test.com';
        $response             = new Response(204);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->lookup($url);
        $this->assertFalse($result);
    }

    public function testCheckAdultFound()
    {
        $content              = 'adult';
        $url                  = 'www.wmconvirus.narod.ru';
        $response             = new Response(200, [], $content);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->checkAdult($url);
        $this->assertTrue($result);
    }

    public function testCheckAdultNotFound()
    {
        $url                  = 'test.com';
        $response             = new Response(200);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->checkAdult($url);
        $this->assertFalse($result);
    }

    public function testSendRequestForbiddenException()
    {
        $url                  = 'test.com';
        $response             = new Response(403);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(ForbiddenException::class);
        $safeBrowsingMock->checkAdult($url);
    }

    public function testSendRequestUnauthorizedException()
    {
        $url                  = 'test.com';
        $response             = new Response(401);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(UnauthorizedException::class);
        $safeBrowsingMock->checkAdult($url);
    }

    public function testSendRequestNotFoundException()
    {
        $url                  = 'test.com';
        $response             = new Response(404);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(NotFoundException::class);
        $safeBrowsingMock->checkAdult($url);
    }

    public function testSendRequestSafeBrowsingException()
    {
        $url                  = 'test.com';
        $response             = new Response(500);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(SafeBrowsingException::class);
        $safeBrowsingMock->checkAdult($url);
    }

    public function testGetSetMalwareShavars()
    {
        $fixture          = 'my-malware-shavar';
        $safeBrowsing     = new SafeBrowsingClient();
        $malwareShavars   = $safeBrowsing->getMalwareShavars();
        $malwareShavars[] = 'my-malware-shavar';
        $safeBrowsing->setMalwareShavars($malwareShavars);

        $this->assertEquals($fixture, $malwareShavars[count($malwareShavars) - 1]);
    }

    public function testGetChunkByUrl()
    {
        $url                  = 'http://test.com';
        $content              = 'test';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->getChunkByUrl($url);
        $this->assertNotEmpty($result);
    }

    public function testGetShavarsList()
    {
        $content              = '
        ydx-phish-shavar
        ydx-sms-fraud-shavar
        ydx-imgs-shavar
        goog-mobile-only-malware-shavar';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->getShavarsList();
        $this->assertTrue(is_array($result));
    }

    public function testGetMalwaresDataIncorrectDataException()
    {
        $content              = '';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(SafeBrowsingException::class);
        $safeBrowsingMock->getMalwaresData();
    }

    public function testPrepareDownloadsRequestException()
    {
        $safeBrowsing = new SafeBrowsingClient();
        $safeBrowsing->setMalwareShavars([]);
        $this->expectException(SafeBrowsingException::class);
        $safeBrowsing->getMalwaresData();
    }

    public function testGetMalwaresDataPleasereset()
    {
        $content              = 'r:pleasereset';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($content));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $safeBrowsingMock->getMalwaresData();
        $this->assertEquals('pleasereset', $result);
    }

    public function testPrepareDownloadsRequestSavedChunks()
    {
        $savedChunks = [
            'ydx-malware-shavar' => [
                'removed' => [
                    'min' => 1,
                    'max' => 1
                ],
                'added'   => [
                    'min' => 1,
                    'max' => 1
                ]
            ]
        ];

        $chunk                = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/get-chunk-by-url-response.txt'
        );
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $result = $safeBrowsingMock->getMalwaresData($savedChunks);
        $this->assertArrayHasKey(array_keys($savedChunks)[0], $result);
    }

    public function testParseChunkEmptyChunk()
    {
        $chunk                = '';
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $this->expectException(SafeBrowsingException::class);
        $safeBrowsingMock->getMalwaresData();
    }

    public function testParseChunkIncorrectChunkLength()
    {
        $chunk                = 's:13314:4:';
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $result = $safeBrowsingMock->getMalwaresData();

        $this->assertArrayHasKey('ydx-malware-shavar', $result);
        $this->assertArrayHasKey('removed', $result['ydx-malware-shavar']);
        $this->assertArrayHasKey('13314', $result['ydx-malware-shavar']['removed']);
    }

    public function testParseChunkIncorrectChunkType()
    {
        $chunk                = '0:13314:4:39
        000';
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $this->expectException(SafeBrowsingException::class);
        $safeBrowsingMock->getMalwaresData();
    }

    public function testParseChunkWithOneChunk()
    {
        $chunk                = 's:13314:4:39
000';
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $result = $safeBrowsingMock->getMalwaresData();
        $this->assertArrayHasKey('ydx-malware-shavar', $result);
    }

    public function testParseChunkAddedPrefixes()
    {
        $chunk                = 'a:13314:4:39
999999999999999999999999';
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->returnValue($chunk));

        $result = $safeBrowsingMock->getMalwaresData();
        $this->assertArrayHasKey('ydx-malware-shavar', $result);
    }

    public function testGetMalwaresDataGetChunkByUrlNotFound()
    {
        $chunksResponse       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-chunks-response.txt');
        $response             = new Response(404, [], \GuzzleHttp\Psr7\stream_for($chunksResponse));
        $exception            = new \Yandex\Common\Exception\NotFoundException('error');
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->throwException($exception));

        $result = $safeBrowsingMock->getMalwaresData();
        $this->assertArrayHasKey('ydx-malware-shavar', $result);
    }

    public function testGetMalwaresDataDeleteAddedRanges()
    {
        $content              = '
        i:ydx-malware-shavar
        ad:1-2,4-5
        sd:2-6,8-9
        ad:6-7
        sd:10-11';
        $response             = new Response(404, [], \GuzzleHttp\Psr7\stream_for($content));
        $exception            = new \Yandex\Common\Exception\NotFoundException('error');
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $safeBrowsingMock = $this->getMockBuilder(SafeBrowsingClient::class)
            ->setMethods(['getClient', 'getChunkByUrl'])
            ->getMock();
        $safeBrowsingMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));
        $safeBrowsingMock->expects($this->any())
            ->method('getChunkByUrl')
            ->will($this->throwException($exception));

        $result = $safeBrowsingMock->getMalwaresData();
        $this->assertArrayHasKey('ydx-malware-shavar', $result);
        $this->assertArrayHasKey('delete_added_ranges', $result['ydx-malware-shavar']);
        $this->assertArrayHasKey('delete_removed_ranges', $result['ydx-malware-shavar']);
    }
}
