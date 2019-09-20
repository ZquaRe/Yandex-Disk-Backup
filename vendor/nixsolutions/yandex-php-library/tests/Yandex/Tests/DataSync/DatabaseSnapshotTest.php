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

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Yandex\DataSync\Models\DatabaseSnapshotRecords;
use Yandex\DataSync\Responses\DatabaseSnapshotResponse;
use Yandex\DataSync\DataSyncClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  03.03.16 15:12
 */
class DatabaseSnapshotTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/database-snapshot.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $databaseId = 'test';
        $context    = DataSyncClient::CONTEXT_USER;

        /** @var DatabaseSnapshotResponse $snapshotResponse */
        $snapshotResponse = $dataSyncClientMock->getDatabaseSnapshot($databaseId, $context);

        //Response
        $this->assertEquals($jsonObj->records_count, $snapshotResponse->getRecordsCount());
        $this->assertEquals($databaseId, $snapshotResponse->getDatabaseId());
        $this->assertEquals($jsonObj->database_id, $snapshotResponse->getDatabaseId());
        $this->assertEquals($jsonObj->revision, $snapshotResponse->getRevision());
        $this->assertEquals($jsonObj->size, $snapshotResponse->getSize());
        $this->assertEquals($jsonObj->created, $snapshotResponse->getCreated());
        $this->assertEquals($jsonObj->modified, $snapshotResponse->getModified());
        //Record #1
        $this->assertEquals(
            $jsonObj->records->items[0]->record_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getRecordId()
        );
        $this->assertEquals(
            $jsonObj->records->items[0]->collection_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getCollectionId()
        );
        $this->assertEquals(
            $jsonObj->records->items[0]->revision,
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getRevision()
        );
        //Record field
        $this->assertEquals(
            $jsonObj->records->items[0]->fields[0]->field_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getFields()->getAll()[0]->getFieldId()
        );
        //Record field value
        $stdClass = $jsonObj->records->items[0]->fields[0]->value;
        $this->assertEquals(
            $stdClass->type,
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getFields()->getAll()[0]->getValue()->getType()
        );
        $this->assertEquals(
            $stdClass->{$stdClass->type},
            $snapshotResponse->getRecords()->getItems()->getAll()[0]->getFields()->getAll()[0]->getValue()->getValue()
        );
        //Record #2
        $this->assertEquals(
            $jsonObj->records->items[1]->record_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getRecordId()
        );
        $this->assertEquals(
            $jsonObj->records->items[1]->collection_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getCollectionId()
        );
        $this->assertEquals(
            $jsonObj->records->items[1]->revision,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getRevision()
        );
        //Record field
        $this->assertEquals(
            $jsonObj->records->items[1]->fields[0]->field_id,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getFields()->getAll()[0]->getFieldId()
        );
        //Record field value
        $stdClass = $jsonObj->records->items[1]->fields[0]->value;
        $this->assertEquals(
            $stdClass->type,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getFields()->getAll()[0]->getValue()->getType()
        );
        $this->assertEquals(
            $stdClass->{$stdClass->type},
            $snapshotResponse->getRecords()->getItems()->getAll()[1]->getFields()->getAll()[0]->getValue()->getValue()
        );
        $arrayDiff = array_diff(
            (array)$stdClass,
            $snapshotResponse->getRecords()->getItems()->getAll()[1]
                ->getFields()->getAll()[0]->getValue()->toArray()
        );
        $this->assertTrue(empty($arrayDiff), 'Is Equals arrays');
    }

    function testGetFilteredResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database-snapshot-filtered.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $databaseId   = 'test';
        $context      = DataSyncClient::CONTEXT_USER;
        $collectionId = 'my_schedule';
        $fields       = ['revision', 'size'];

        /** @var DatabaseSnapshotResponse $snapshotResponse */
        $snapshotResponse = $dataSyncClientMock->getDatabaseSnapshot($databaseId, $context, $collectionId, $fields);

        //Response
        $this->assertEquals($jsonObj->revision, $snapshotResponse->getRevision());
        $this->assertEquals($jsonObj->size, $snapshotResponse->getSize());
        $this->assertEmpty($snapshotResponse->getDatabaseId());
    }

    function testSetProperties()
    {
        $fixture = [
            'size'         => 0,
            'revision'     => 0,
            'recordsCount' => 0,
            'modified'     => 0,
            'created'      => 0,
            'databaseId'   => 'test'
        ];

        $response1 = new DatabaseSnapshotResponse($fixture);

        $response2 = new DatabaseSnapshotResponse();
        $response2->setSize($fixture['size']);
        $response2->setRevision($fixture['revision']);
        $response2->setRecordsCount($fixture['recordsCount']);
        $response2->setModified($fixture['modified']);
        $response2->setCreated($fixture['created']);
        $response2->setDatabaseId($fixture['databaseId']);

        $arrayDiff = array_diff(
            $response1->toArray(),
            $response2->toArray()
        );

        $this->assertTrue(empty($arrayDiff), 'Is Equals arrays');
    }

    function testGetProperties()
    {
        $fixture = [
            'title'        => 'test',
            'size'         => 0,
            'revision'     => 0,
            'recordsCount' => 0,
            'records'      => [],
            'modified'     => 0,
            'created'      => 0,
            'databaseId'   => 'test'
        ];

        $response = new DatabaseSnapshotResponse($fixture);

        $this->assertEquals($response->getRevision(), $fixture['revision']);
        $this->assertEquals($response->getRecordsCount(), $fixture['recordsCount']);
        $this->assertEquals($response->getModified(), $fixture['modified']);
        $this->assertEquals($response->getCreated(), $fixture['created']);
        $this->assertEquals($response->getDatabaseId(), $fixture['databaseId']);

        $databaseSnapshotRecords = new DatabaseSnapshotRecords($fixture['records']);
        $response->setRecords($databaseSnapshotRecords);
        $this->assertEquals($response->getRecords()->toArray(), $fixture['records']);
    }
}
