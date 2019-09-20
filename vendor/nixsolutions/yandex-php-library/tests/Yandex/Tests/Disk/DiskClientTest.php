<?php

namespace Yandex\Tests\OAuth;

use GuzzleHttp\Client as GuzzleHttpClient;
use Yandex\Disk\DiskClient;
use Yandex\Tests\TestCase;
use Yandex\Disk\Exception\DiskRequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class DiskClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    public function testGetClient()
    {
        $diskClient   = new DiskClient('test');
        $getClient    = self::getNotAccessibleMethod($diskClient, 'getClient');
        $guzzleClient = $getClient->invokeArgs($diskClient, []);
        $this->assertInstanceOf('\GuzzleHttp\ClientInterface', $guzzleClient);
    }

    public function testSetVersion()
    {
        $diskClient = new DiskClient('test');
        $this->assertEquals('v1', $diskClient->getVersion());
        $diskClient->setVersion('v2');
        $this->assertEquals('v2', $diskClient->getVersion());
    }

    public function testGetRequestUrl()
    {
        $diskClient = new DiskClient('test');
        $diskClient->getRequestUrl('');
        $this->assertEquals(
            $diskClient->getServiceUrl(),
            $diskClient->getRequestUrl('') . '/' . $diskClient->getVersion()
        );
    }

    public function testDiskRequestExceptionWithCode()
    {
        $response             = new Response(401, [], \GuzzleHttp\Psr7\stream_for(''));
        $request              = new Request('MKCOL', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        try {
            $diskClientMock->createDirectory('/test');
            $this->fail('DiskRequestException has not been thrown');
        } catch (DiskRequestException $e) {
            $this->assertEquals(401, $e->getCode());
        }
    }

    public function testDirectoryContentsResponseNotFound()
    {
        $response             = new Response(404, [], \GuzzleHttp\Psr7\stream_for(''));
        $request              = new Request('PROPFIND', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(DiskRequestException::class);
        $diskClientMock->directoryContents('');
    }

    public function testDirectoryContentsResponse()
    {
        $href                 = '/test/';
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/directory-contents.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->directoryContents($href);

        $this->assertEquals($href, $result[0]['href']);
    }

    public function testDiskSpaceInfoResponse()
    {
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/disk-space-info.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->diskSpaceInfo();
        $this->assertArrayHasKey('usedBytes', $result);
        $this->assertArrayHasKey('availableBytes', $result);
    }

    public function testSetPropertyResponse()
    {
        $path                 = '/test/';
        $prop                 = 'myprop';
        $value                = 'myvalue';
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/set-property.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->setProperty($path, $prop, $value);
        $this->assertTrue($result);
    }

    public function testSetPropertyIncorrectStatusResponse()
    {
        $path                 = '/test/';
        $prop                 = 'myprop';
        $value                = 'myvalue';
        $xml                  = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/set-property-incorrect-status.xml'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->setProperty($path, $prop, $value);
        $this->assertFalse($result);
    }

    public function testSetEmptyProperty()
    {
        $path       = '/test/';
        $prop       = '';
        $value      = '';
        $diskClient = new DiskClient();
        $result     = $diskClient->setProperty($path, $prop, $value);
        $this->assertFalse($result);
    }

    public function testGetEmptyProperty()
    {
        $path       = '/test/';
        $prop       = '';
        $diskClient = new DiskClient();
        $result     = $diskClient->getProperty($path, $prop);
        $this->assertFalse($result);
    }

    public function testGetPropertyResponse()
    {
        $path                 = '/test/';
        $prop                 = 'myprop';
        $value                = 'myvalue';
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-property.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->getProperty($path, $prop);
        $this->assertEquals($value, $result);
    }

    public function testGetPropertyIncorrectStatusResponse()
    {
        $path                 = '/test/';
        $prop                 = 'myprop';
        $value                = 'myvalue';
        $xml                  = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/get-property-incorrect-status.xml'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->getProperty($path, $prop);
        $this->assertFalse($result);
    }

    public function testGetLoginResponse()
    {
        $login                = 'test.user';
        $txt                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-login.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($txt));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->getLogin();
        $this->assertEquals($login, $result);
    }

    public function testGetFileResponse()
    {
        $path                 = '/test/test.txt';
        $content              = 'test';
        $txt                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-file.txt');
        $response             = new Response(200, ['Server' => 'CLI'], \GuzzleHttp\Psr7\stream_for($txt));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->getFile($path);
        $this->assertArrayHasKey('body', $result);
        $this->assertEquals($content, $result['body']->getContents());
    }

    public function testDownloadFileResponse()
    {
        $path                 = '/test/test.txt';
        $destination          = '';
        $name                 = 'test.txt';
        $txt                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/test.txt');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($txt));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->downloadFile($path, $destination, $name);
        $this->assertEquals($name, $result);
        $this->assertTrue(file_exists($result));
        unlink($result);
        $this->assertFalse(file_exists($result));
    }

    public function testDownloadFileWithEmptyNameResponse()
    {
        $path                 = '/test/test.txt';
        $destination          = '';
        $name                 = 'test.txt';
        $txt                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/test.txt');
        $response             = new Response(
            200,
            ['Content-Disposition' => 'attachment; filename="test.txt"'],
            \GuzzleHttp\Psr7\stream_for($txt)
        );
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->downloadFile($path, $destination);
        $this->assertEquals($name, $result);
    }

    public function testUploadFile()
    {
        $destinationPath      = '/test/test.txt';
        $sourcePath           = __DIR__ . '/' . $this->fixturesFolder . '/test.txt';
        $fixtureFileData      = [
            'size' => filesize($sourcePath),
            'path' => $sourcePath,
            'name' => ''
        ];
        $headers              = [
            'Yandex-Cloud-Request-ID'   => 'dav-bJ2C_4H2_B68-1-webdav5g',
            'Server'                    => 'MochiWeb/1.0',
            'Keep-Alive'                => '300',
            'Date'                      => 'Wed, 01 Nov 2017 15:42:25 GMT',
            'Content-Length'            => '11',
        ];
        $response = new Response(201, $headers, null, 1.1, 'Created');
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->assertEquals(201, $diskClientMock->uploadFile($destinationPath, $fixtureFileData)->getStatusCode());
    }

    public function testGetImagePreview()
    {
        $path                 = '/test/elephant.png';
        $size                 = 'M';
        $response             = new Response(200, ['content-type' => 'mage/png'], \GuzzleHttp\Psr7\stream_for(''));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->getImagePreview($path, $size);

        $this->assertArrayHasKey('headers', $result);
        $this->assertArrayHasKey('body', $result);
    }

    public function testCopy()
    {
        $sourcePath           = '/test/test.txt';
        $destinationPath      = '/test/test2.txt';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(''));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->copy($sourcePath, $destinationPath);

        $this->assertTrue($result);
    }

    public function testMove()
    {
        $sourcePath           = '/test/test.txt';
        $destinationPath      = '/test/test2.txt';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(''));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->move($sourcePath, $destinationPath);

        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $path                 = '/test/test.txt';
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for(''));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->delete($path);

        $this->assertTrue($result);
    }

    public function testStartPublishing()
    {
        $path                 = '/test/test.txt';
        $link                 = 'https://yadi.sk/i/6dZVYPKCqCcYR';
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/start-publishing.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->startPublishing($path);

        $this->assertEquals($link, $result);
    }

    public function testStopPublishing()
    {
        $path                 = '/test/test.txt';
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue(true));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->assertNull($diskClientMock->stopPublishing($path));
    }

    public function testCheckPublishing()
    {
        $path                 = '/test/test.txt';
        $link                 = 'https://yadi.sk/i/6dZVYPKCqCcYR';
        $xml                  = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/check-publishing.xml');
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($xml));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $diskClientMock = $this->getMockBuilder(DiskClient::class)
            ->setMethods(['getClient'])
            ->getMock();
        $diskClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $diskClientMock->checkPublishing($path);

        $this->assertEquals($link, $result);
    }
}
