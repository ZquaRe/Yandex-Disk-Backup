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
use Yandex\DataSync\Models\Database;
use Yandex\DataSync\Models\Database\Delta\Record;
use Yandex\DataSync\Models\Database\Delta\RecordField;
use Yandex\DataSync\Models\Database\Delta\RecordFields;
use Yandex\DataSync\Models\Database\Delta\RecordFieldValue;
use Yandex\DataSync\Models\Databases;
use Yandex\DataSync\Responses\DatabasesResponse;
use Yandex\DataSync\DataSyncClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  04.03.16 11:09
 */
class DatabaseTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testDatabasesResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-databases.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context = DataSyncClient::CONTEXT_USER;
        /** @var DatabasesResponse $snapshotResponse */
        $databasesResponse = $dataSyncClientMock->getDatabases($context);

        //Response
        $this->assertEquals($jsonObj->total, $databasesResponse->getTotal());
        $this->assertEquals($jsonObj->limit, $databasesResponse->getLimit());
        $this->assertEquals($jsonObj->offset, $databasesResponse->getOffset());

        //Items
        $this->assertEquals(
            $jsonObj->items[0]->records_count,
            $databasesResponse->getItems()->getAll()[0]->getRecordsCount()
        );
        $this->assertEquals(
            $jsonObj->items[0]->created,
            $databasesResponse->getItems()->getAll()[0]->getCreated()
        );
        $this->assertEquals(
            $jsonObj->items[0]->modified,
            $databasesResponse->getItems()->getAll()[0]->getModified()
        );
        $this->assertEquals(
            $jsonObj->items[0]->database_id,
            $databasesResponse->getItems()->getAll()[0]->getDatabaseId()
        );
        $this->assertEquals(
            $jsonObj->items[0]->title,
            $databasesResponse->getItems()->getAll()[0]->getTitle()
        );
        $this->assertEquals(
            $jsonObj->items[0]->revision,
            $databasesResponse->getItems()->getAll()[0]->getRevision()
        );
        $this->assertEquals(
            $jsonObj->items[0]->size,
            $databasesResponse->getItems()->getAll()[0]->getSize()
        );
        $this->assertEquals(
            $context,
            $databasesResponse->getItems()->getAll()[0]->getContext()
        );
    }

    function testDatabasesFilteredResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-databases-filtered.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context = DataSyncClient::CONTEXT_USER;
        $limit   = 10;
        $offset  = 1;
        $fields  = ['total', 'limit', 'offset'];
        /** @var DatabasesResponse $snapshotResponse */
        $databasesResponse = $dataSyncClientMock->getDatabases($context, $fields, $limit, $offset);
        //Response
        $this->assertEquals($jsonObj->total, $databasesResponse->getTotal());
        $this->assertEquals($limit, $databasesResponse->getLimit());
        $this->assertEquals($offset, $databasesResponse->getOffset());
        $this->assertNull($databasesResponse->getItems());
    }

    function testUpdateDatabaseTitleResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/update-database-title.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context    = DataSyncClient::CONTEXT_USER;
        $title      = 'test title';
        $databaseId = 'test';
        /** @var Database $snapshotResponse */
        $databaseResponse = $dataSyncClientMock->updateDatabaseTitle($title, $databaseId, $context);

        //Response
        $this->assertEquals(
            $jsonObj->records_count,
            $databaseResponse->getRecordsCount()
        );
        $this->assertEquals(
            $jsonObj->created,
            $databaseResponse->getCreated()
        );
        $this->assertEquals(
            $jsonObj->modified,
            $databaseResponse->getModified()
        );
        $this->assertEquals(
            $jsonObj->database_id,
            $databaseResponse->getDatabaseId()
        );
        $this->assertEquals(
            $databaseId,
            $databaseResponse->getDatabaseId()
        );
        $this->assertEquals(
            $title,
            $databaseResponse->getTitle()
        );
        $this->assertEquals(
            $jsonObj->title,
            $databaseResponse->getTitle()
        );
        $this->assertEquals(
            $jsonObj->revision,
            $databaseResponse->getRevision()
        );
        $this->assertEquals(
            $jsonObj->size,
            $databaseResponse->getSize()
        );
        $this->assertEquals(
            $context,
            $databaseResponse->getContext()
        );
    }

    function testGetDatabaseResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        /** @var Database $snapshotResponse */
        $databaseResponse = $dataSyncClientMock->getDatabase($databaseId, $context);

        //Response
        $this->assertEquals($jsonObj->records_count, $databaseResponse->getRecordsCount());
        $this->assertEquals($jsonObj->created, $databaseResponse->getCreated());
        $this->assertEquals($jsonObj->modified, $databaseResponse->getModified());
        $this->assertEquals($jsonObj->database_id, $databaseResponse->getDatabaseId());
        $this->assertEquals($databaseId, $databaseResponse->getDatabaseId());
        $this->assertEquals($jsonObj->title, $databaseResponse->getTitle());
        $this->assertEquals($jsonObj->revision, $databaseResponse->getRevision());
        $this->assertEquals($jsonObj->size, $databaseResponse->getSize());
        $this->assertEquals($context, $databaseResponse->getContext());
    }

    function testGetDatabaseFilteredResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database-filtered.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        $fields     = ['size'];
        /** @var Database $snapshotResponse */
        $databaseResponse = $dataSyncClientMock->getDatabase($databaseId, $context, $fields);

        //Response
        $this->assertNull($databaseResponse->getRecordsCount());
        $this->assertNull($databaseResponse->getRevision());
        $this->assertEquals($jsonObj->size, $databaseResponse->getSize());
    }

    function testDeleteDatabasesResponse()
    {
        $response = new Response(204);
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        $this->assertTrue($dataSyncClientMock->deleteDatabase($databaseId, $context));
    }

    function testCreateDatabasesResponse()
    {
        $json     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/create-database.json');
        $jsonObj  = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        /** @var Database $snapshotResponse */
        $databaseResponse = $dataSyncClientMock->createDatabase($databaseId, $context);

        //Response
        $this->assertEquals($jsonObj->records_count, $databaseResponse->getRecordsCount());
        $this->assertEquals($jsonObj->created, $databaseResponse->getCreated());
        $this->assertEquals($jsonObj->modified, $databaseResponse->getModified());
        $this->assertEquals($jsonObj->database_id, $databaseResponse->getDatabaseId());
        $this->assertEquals($databaseId, $databaseResponse->getDatabaseId());
        $this->assertEmpty($databaseResponse->getTitle());
        $this->assertEquals($jsonObj->revision, $databaseResponse->getRevision());
        $this->assertEquals($jsonObj->size, $databaseResponse->getSize());
        $this->assertEquals($context, $databaseResponse->getContext());
    }

    function testFillDatabase()
    {
        $json    = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database.json');
        $jsonObj = json_decode($json);

        $database = new Database();

        $database->setDatabaseId($jsonObj->database_id)
            ->setTitle($jsonObj->title)
            ->setSize($jsonObj->size)
            ->setRevision($jsonObj->revision)
            ->setRecordsCount($jsonObj->records_count)
            ->setModified($jsonObj->modified)
            ->setCreated($jsonObj->modified);

        $arrayDiff = array_diff(
            $database->toArray(),
            json_decode($json, true)
        );
        $this->assertTrue(empty($arrayDiff), 'Is Equals arrays');
    }

    function testFillDatabases()
    {
        $json    = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-database.json');
        $jsonObj = json_decode($json);

        $database = new Database();
        $database->setTitle($jsonObj->title);
        $database->setSize($jsonObj->size);
        $database->setRevision($jsonObj->revision);
        $database->setRecordsCount($jsonObj->records_count);
        $database->setModified($jsonObj->modified);
        $database->setCreated($jsonObj->modified);

        $databases = new Databases();
        $databases->add($database);
        $arrayDiff = array_diff(
            $databases->current()->toArray(),
            json_decode($json, true)
        );
        $this->assertTrue(empty($arrayDiff), 'Is Equals arrays');
    }

    function testFillDatabaseRecord()
    {
        $fixture = array(
            'change_type'   => 'insert',
            'collection_id' => 'my_schedule',
            'record_id'     => 'monday',
            'changes'       =>
                array(
                    array(
                        'change_type' => 'set',
                        'field_id'    => 'work',
                        'value'       =>
                            array(
                                'string' => 'from 11am to 7pm',
                                'type'   => 'string',
                            )

                    )

                )
        );
        $record  = new Record($fixture);
        $this->assertEquals($fixture['change_type'], $record->getChangeType());
        $this->assertEquals($fixture['collection_id'], $record->getCollectionId());
        $this->assertEquals($fixture['record_id'], $record->getRecordId());
        $this->assertEquals(
            $fixture['changes'][0]['change_type'],
            $record->getChanges()->getAll()[0]->getChangeType()
        );
        $this->assertEquals(
            $fixture['changes'][0]['field_id'],
            $record->getChanges()->getAll()[0]->getFieldId()
        );
        $this->assertEquals(
            $fixture['changes'][0]['value']['type'],
            $record->getChanges()->getAll()[0]->getValue()->getType()
        );
        $this->assertEquals(
            $fixture['changes'][0]['value'][$fixture['changes'][0]['value']['type']],
            $record->getChanges()->getAll()[0]->getValue()->getValue()
        );

        $changedFiled = new RecordField();
        $changedFiled->setChangeType($fixture['changes'][0]['change_type'])
            ->setFieldId($fixture['changes'][0]['field_id'])
            ->setValue(new RecordFieldValue($fixture['changes'][0]['value']));
        $record2 = new Record();
        $record2->setChangeType($fixture['change_type'])
            ->setCollectionId($fixture['collection_id'])
            ->setChanges([$changedFiled])
            ->setRecordId($fixture['record_id']);

        $this->assertTrue($record->toArray() === $record2->toArray(), 'Is Equals records');

        $record2->setFields($fixture['changes']);
        $this->assertTrue($record2->getFields() instanceof RecordFields, 'Is RecordFields');
        $this->assertTrue($record2->getChanges() instanceof RecordFields, 'Is RecordFields');

        $field = new RecordFields();
        $field->add($fixture['changes'][0]);

        $record3 = new Record();
        $record3->setChangeType($fixture['change_type'])
            ->setCollectionId($fixture['collection_id'])
            ->setChanges($field)
            ->setRecordId($fixture['record_id'])
            ->setFields($field);

        $this->assertTrue($record2->toArray() === $record3->toArray(), 'Is Equals records');
    }
}
