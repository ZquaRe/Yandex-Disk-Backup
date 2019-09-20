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
namespace Yandex\Tests\DataSync;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\IncorrectDataFormatException;
use Yandex\Common\Exception\InvalidArgumentException as YandexInvalidArgumentException;
use Yandex\Common\Exception\NotFoundException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\Exception\UnavailableResourceException;
use Yandex\DataSync\DataSyncClient;
use Yandex\DataSync\Exception\DataSyncException;
use Yandex\DataSync\Exception\IncorrectRevisionNumberException;
use Yandex\DataSync\Exception\MaxDatabasesCountException;
use Yandex\DataSync\Exception\RevisionOnServerOverCurrentException;
use Yandex\DataSync\Exception\RevisionTooOldException;
use Yandex\DataSync\Models\Database;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  04.03.16 11:51
 */
class DataSyncClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testConstruct()
    {
        $token          = 'TOKEN';
        $databaseId     = 'DATABASE_ID';
        $dataSyncClient = new DataSyncClient();
        $this->assertEmpty($dataSyncClient->getAccessToken());

        $dataSyncClient2 = new DataSyncClient($token, DataSyncClient::CONTEXT_USER, $databaseId);
        $this->assertEquals(DataSyncClient::CONTEXT_USER, $dataSyncClient2->getContext());
        $this->assertEquals($databaseId, $dataSyncClient2->getDatabaseId());
        $this->assertEquals($token, $dataSyncClient2->getAccessToken());
    }

    function testSetIncorrectContext()
    {
        $token   = 'TOKEN';
        $context = 'INCORRECT_CONTEXT';
        $this->expectException(YandexInvalidArgumentException::class);
        new DataSyncClient($token, $context);
    }

    function testGetEmptyDatabasesIdException()
    {
        $token          = 'TOKEN';
        $dataSyncClient = new DataSyncClient($token);
        $this->expectException(YandexInvalidArgumentException::class);
        $dataSyncClient->getDatabaseId();
    }

    function testGetEmptyContextException()
    {
        $token          = 'TOKEN';
        $dataSyncClient = new DataSyncClient($token);
        $this->expectException(YandexInvalidArgumentException::class);
        $dataSyncClient->getContext();
    }

    function testSendRequestInvalidArgumentException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(400);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(YandexInvalidArgumentException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestUnauthorizedException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(401);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(UnauthorizedException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestForbiddenException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(403);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(ForbiddenException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestNotFoundException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(404);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(NotFoundException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestIncorrectDataFormatException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(406);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(IncorrectDataFormatException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestRevisionOnServerOverCurrentException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(409);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(RevisionOnServerOverCurrentException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestRevisionTooOldException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(410);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(RevisionTooOldException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestIncorrectRevisionNumberException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(412);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(IncorrectRevisionNumberException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestIncorrectDataFormatException2()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(415);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(IncorrectDataFormatException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestUnavailableResourceException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(423);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(UnavailableResourceException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestTooManyRequestsException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(429);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(TooManyRequestsException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestMaxDatabasesCountException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(507);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(MaxDatabasesCountException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequestDataSyncException()
    {
        $databaseId           = 'DATABASE_ID';
        $response             = new Response(599);
        $request              = new Request('GET', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(DataSyncException::class);
        $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
    }

    function testSendRequest()
    {
        $json                 = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database.json');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $databaseId           = 'DATABASE_ID';
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $database = $dataSyncClientMock->getDatabase($databaseId, DataSyncClient::CONTEXT_USER);
        $this->assertTrue($database instanceof Database);
    }
}
