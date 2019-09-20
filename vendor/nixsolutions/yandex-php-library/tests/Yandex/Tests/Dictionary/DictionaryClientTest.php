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
use Yandex\Dictionary\DictionaryClient;
use Yandex\Dictionary\DictionaryDefinition;
use Yandex\Dictionary\DictionaryTranslation;
use Yandex\Dictionary\Exception\DictionaryException;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  17.03.16 12:18
 */
class DictionaryClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    public function testConstruct()
    {
        $apiKey           = 'test';
        $dictionaryClient = new DictionaryClient('');
        $this->assertEmpty($dictionaryClient->getApiKey());
        $dictionaryClient->setApiKey($apiKey);
        $this->assertEquals($apiKey, $dictionaryClient->getApiKey());
    }

    public function testGetLanguages()
    {
        $json                 = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/get-languages-response.json'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $dictionaryClientMock->getLanguages();
        $this->assertNotEmpty($result[0][0]);
        $this->assertNotEmpty($result[0][1]);
    }

    public function testGetLanguagesError()
    {
        $response             = new Response(500);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $result = $dictionaryClientMock->getLanguages();
        $this->assertFalse($result);
    }

    function testSendRequestForbiddenException()
    {
        $response             = new Response(403);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)->setMethods(['request'])->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(ForbiddenException::class);
        $dictionaryClientMock->getLanguages();
    }

    function testSendRequestDictionaryException()
    {
        $response             = new Response(500);
        $request              = new Request('POST', '');
        $exception            = new \GuzzleHttp\Exception\ClientException('error', $request, $response);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->throwException($exception));
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $this->expectException(DictionaryException::class);
        $dictionaryClientMock->getLanguages();
    }

    public function testLookupText()
    {
        $text                 = 'hi';
        $translation          = 'привет';
        $json                 = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/lookup-response.json'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));

        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $dictionaryClientMock
            ->setTranslateFrom('en')
            ->setTranslateTo('ru');

        $result = $dictionaryClientMock->lookup($text);

        /** @var DictionaryDefinition $dictionaryDefinition */
        $dictionaryDefinition = $result[0];
        $this->assertEquals($text, $dictionaryDefinition->getText());
        $this->assertEquals($text, $dictionaryDefinition);
        $this->assertNotEmpty($dictionaryDefinition->getPartOfSpeech());
        /** @var DictionaryTranslation $dictionaryTranslation */
        $dictionaryTranslation = $dictionaryDefinition->getTranslations()[0];

        $this->assertEquals($translation, $dictionaryTranslation->getText());
    }

    public function testLookupOtherText()
    {
        $text                 = 'lookup';
        $translation          = 'поиск';
        $json                 = file_get_contents(
            __DIR__ . '/' . $this->fixturesFolder . '/lookup-response2.json'
        );
        $response             = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $dictionaryClientMock
            ->setTranslateFrom('en')
            ->setTranslateTo('ru');

        $result = $dictionaryClientMock->lookup($text);

        /** @var DictionaryDefinition $dictionaryDefinition */
        $dictionaryDefinition = $result[0];
        $this->assertEquals($text, $dictionaryDefinition->getText());
        $this->assertEquals($text, $dictionaryDefinition);
        $this->assertNotEmpty($dictionaryDefinition->getPartOfSpeech());
        $this->assertNotEmpty($dictionaryDefinition->getTranscription());
        /** @var DictionaryTranslation $dictionaryTranslation */
        $dictionaryTranslation = $dictionaryDefinition->getTranslations()[0];
        $this->assertEquals($translation, $dictionaryTranslation->getText());
        $this->assertNotEmpty($dictionaryTranslation->getSynonyms());
        $this->assertNotEmpty($dictionaryTranslation->getMeanings());
        $this->assertNotEmpty($dictionaryTranslation->getExamples());
        $this->assertNotEmpty($dictionaryTranslation->getExamples()[0]->getTranslations());
    }

    public function testLookupError()
    {
        $text                 = 'hi';
        $response             = new Response(500);
        $guzzleHttpClientMock = $this->getMockBuilder(GuzzleHttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $guzzleHttpClientMock->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response));
        /** @var DictionaryClient $dictionaryClientMock */
        $dictionaryClientMock = $this->getMockBuilder(DictionaryClient::class)
            ->setMethods(['getClient'])
            ->disableOriginalConstructor()
            ->getMock();
        $dictionaryClientMock->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($guzzleHttpClientMock));

        $dictionaryClientMock
            ->setTranslateFrom('en')
            ->setTranslateTo('ru');

        $result = $dictionaryClientMock->lookup($text);
        $this->assertFalse($result);
    }

    /**
     * @param $flag
     * @param $expectedFlag
     *
     * @dataProvider dataSetGetFlag
     */
    public function testSetGetFamilyFlag($flag, $expectedFlag)
    {
        $dictionaryClient = new DictionaryClient('');
        $this->assertEmpty($dictionaryClient->getFlags());
        $dictionaryClient->setFamilyFlag($flag);
        $this->assertEquals($expectedFlag, $dictionaryClient->getFlags());
    }

    /**
     * @param $flag
     * @param $expectedFlag
     *
     * @dataProvider dataSetGetFlag
     */
    public function testSetGetMorphoFlag($flag, $expectedFlag)
    {
        $dictionaryClient = new DictionaryClient('');
        $this->assertEmpty($dictionaryClient->getFlags());
        $dictionaryClient->setMorphoFlag($flag);
        $this->assertEquals($expectedFlag, $dictionaryClient->getFlags());
    }

    /**
     * @param $flag
     * @param $expectedFlag
     *
     * @dataProvider dataSetGetFlag
     */
    public function testSetGetPositionFilterFlag($flag, $expectedFlag)
    {
        $dictionaryClient = new DictionaryClient('');
        $this->assertEmpty($dictionaryClient->getFlags());
        $dictionaryClient->setPositionFilterFlag($flag);
        $this->assertEquals($expectedFlag, $dictionaryClient->getFlags());
    }

    /**
     * @return array
     */
    public function dataSetGetFlag()
    {
        return [
            'empty access Flag' => [
                'flag'         => true,
                'expectedFlag' => true
            ],
            'not empty Flag'    => [
                'flag'         => false,
                'expectedFlag' => false
            ],
        ];
    }

    /**
     * @param $language
     * @param $expectedLanguage
     *
     * @dataProvider dataSetGetLanguage
     */
    public function testSetGetUiLanguage($language, $expectedLanguage)
    {
        $dictionaryClient = new DictionaryClient('');
        $dictionaryClient->setUiLanguage($language);
        $this->assertEquals($expectedLanguage, $dictionaryClient->getUiLanguage());
    }

    /**
     * @return array
     */
    public function dataSetGetLanguage()
    {
        return [
            'empty access Language' => [
                'language'         => 'en',
                'expectedLanguage' => 'en'
            ],
            'not empty Flag'        => [
                'language'         => 'ru',
                'expectedLanguage' => 'ru'
            ],
        ];
    }

    /**
     * @param $language
     * @param $expectedLanguage
     *
     * @dataProvider dataSetGetLanguage
     */
    public function testSetGetTranslateFrom($language, $expectedLanguage)
    {
        $dictionaryClient = new DictionaryClient('');
        $dictionaryClient->setTranslateFrom($language);
        $this->assertEquals($expectedLanguage, $dictionaryClient->getTranslateFrom());
    }

    /**
     * @param $language
     * @param $expectedLanguage
     *
     * @dataProvider dataSetGetLanguage
     */
    public function testSetGetTranslateTo($language, $expectedLanguage)
    {
        $dictionaryClient = new DictionaryClient('');
        $dictionaryClient->setTranslateTo($language);
        $this->assertEquals($expectedLanguage, $dictionaryClient->getTranslateTo());
    }
}
