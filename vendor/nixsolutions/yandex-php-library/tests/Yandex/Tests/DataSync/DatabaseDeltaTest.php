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
use Yandex\DataSync\Models\Database;
use Yandex\DataSync\Models\Database\Delta\Record;
use Yandex\DataSync\Models\Database\Delta\RecordField;
use Yandex\DataSync\Models\Database\Delta\RecordFieldValue;
use Yandex\DataSync\DataSyncClient;
use Yandex\DataSync\Responses\DatabaseDeltasResponse;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Alex Khaylo
 * @created  09.03.16 12:42
 */
class DatabaseDeltaTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testSaveDeltaResponse()
    {
        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        $revision   = 2;
        $json       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/save-delta.json');
        $response   = new Response(200, ['ETag' => ($revision + 1)], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));
        $fixture = array(
            'delta_id' => 'add new object to collection',
            'changes'  =>
                array(
                    array(
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
                    )
                )
        );

        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue($fixture['changes'][0]['changes'][0]['value']['string']);
        //Field changes
        $recordField = new RecordField();
        $recordField->setValue($recordFieldValue)
            ->setFieldId($fixture['changes'][0]['changes'][0]['field_id'])
            ->setChangeType(RecordField::CHANGE_TYPE_SET);
        //Record changes
        $record = new Record();
        $record->setChangeType(Record::CHANGE_TYPE_INSERT)
            ->setCollectionId($fixture['changes'][0]['collection_id'])
            ->setRecordId($fixture['changes'][0]['record_id'])
            ->setChanges(array($recordField));

        $delta = new Database\Delta();
        $delta->setDeltaId($fixture['delta_id'])
            ->setChanges(array($record));

        $result = $dataSyncClientMock->saveDelta($delta->toArray(), $revision, $databaseId, $context);

        $this->assertEquals(
            $dataSyncClientMock->getServiceScheme() . '://' . $dataSyncClientMock->getServiceDomain() . '/v1/data/'
            . $dataSyncClientMock->getContext() . '/databases/' . $dataSyncClientMock->getDatabaseId()
            . '/deltas?' . 'base_revision=' . ($revision + 1),
            $result['href']
        );
        $this->assertArrayHasKey('method', $result);
        $this->assertArrayHasKey('templated', $result);
        $this->assertArrayHasKey('revision', $result);
        $this->assertEquals(($revision + 1), $result['revision']);
    }

    function testSaveDeltaFilteredResponse()
    {
        $context    = DataSyncClient::CONTEXT_USER;
        $databaseId = 'test';
        $revision   = 5;
        $fields     = ['href'];
        $json       = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/save-delta-filtered.json');
        $response   = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));
        $fixture = array(
            'delta_id' => 'add new object to collection',
            'changes'  =>
                array(
                    array(
                        'change_type'   => 'insert',
                        'collection_id' => 'schedule',
                        'record_id'     => 'friday',
                        'changes'       =>
                            array(
                                array(
                                    'change_type' => 'set',
                                    'field_id'    => 'work',
                                    'value'       =>
                                        array(
                                            'string' => 'from 11am to 8pm',
                                            'type'   => 'string',
                                        )

                                )

                            )
                    )
                )
        );

        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue($fixture['changes'][0]['changes'][0]['value']['string']);
        //Field changes
        $recordField = new RecordField();
        $recordField->setValue($recordFieldValue)
            ->setFieldId($fixture['changes'][0]['changes'][0]['field_id'])
            ->setChangeType(RecordField::CHANGE_TYPE_SET);
        //Record changes
        $record = new Record();
        $record->setChangeType(Record::CHANGE_TYPE_INSERT)
            ->setCollectionId($fixture['changes'][0]['collection_id'])
            ->setRecordId($fixture['changes'][0]['record_id'])
            ->setChanges(array($recordField));

        $delta = new Database\Delta();
        $delta->setDeltaId($fixture['delta_id'])
            ->setChanges(array($record));

        $result = $dataSyncClientMock->saveDelta($delta->toArray(), $revision, $databaseId, $context, $fields);

        $this->assertEquals(
            $dataSyncClientMock->getServiceScheme() . '://' . $dataSyncClientMock->getServiceDomain() . '/v1/data/'
            . $dataSyncClientMock->getContext() . '/databases/' . $dataSyncClientMock->getDatabaseId()
            . '/deltas?' . 'base_revision=' . ($revision + 1),
            $result['href']
        );
        $this->assertArrayNotHasKey('method', $result);
        $this->assertArrayNotHasKey('templated', $result);
    }

    function testFillDelta()
    {
        $fixture = array(
            'delta_id' => 'add new object to collection',
            'changes'  =>
                array(
                    array(
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
                    )
                )
        );

        $recordFieldValue = new RecordFieldValue();
        $recordFieldValue->setValue($fixture['changes'][0]['changes'][0]['value']['string']);
        //Field changes
        $recordField = new RecordField();
        $recordField->setValue($recordFieldValue)
            ->setFieldId($fixture['changes'][0]['changes'][0]['field_id'])
            ->setChangeType(RecordField::CHANGE_TYPE_SET);
        //Record changes
        $record = new Record();
        $record->setChangeType(Record::CHANGE_TYPE_INSERT)
            ->setCollectionId($fixture['changes'][0]['collection_id'])
            ->setRecordId($fixture['changes'][0]['record_id'])
            ->setChanges(array($recordField))
            ->setFields(array($recordField))
            ->setRevision(0);

        $delta = new Database\Delta();
        $delta->setDeltaId($fixture['delta_id'])
            ->setChanges(array($record));

        $delta2 = new Database\Delta();
        $delta2->setDeltaId($fixture['delta_id'])
            ->setChanges(
                new Database\Delta\Records(array($record))
            );
        $array1 = $delta->toArray();
        $array2 = $delta2->toArray();

        $this->assertEquals($fixture['delta_id'], $delta->getDeltaId());
        $this->assertEquals($delta2->getChanges(), $delta->getChanges());

        $this->assertTrue($array1 === $array2, 'Is Equals arrays');
    }

    function testGetDeltaResponse()
    {
        $context      = DataSyncClient::CONTEXT_USER;
        $databaseId   = 'test';
        $baseRevision = 0;
        $fields       = [];
        $limit        = 100;
        $json         = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-delta.json');
        $jsonObj      = json_decode($json);
        $response     = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $deltasResponse = $dataSyncClientMock->getDelta($baseRevision, $databaseId, $context, $fields, $limit);

        $this->assertEquals($jsonObj->base_revision, $deltasResponse->getBaseRevision());
        $this->assertEquals($jsonObj->total, $deltasResponse->getTotal());
        $this->assertEquals($jsonObj->limit, $deltasResponse->getLimit());
        $this->assertEquals($jsonObj->revision, $deltasResponse->getRevision());
        $this->assertTrue($deltasResponse->getItems() instanceof Database\Deltas, 'Items is Deltas');
    }

    function testGetDeltaFilteredResponse()
    {
        $context      = DataSyncClient::CONTEXT_USER;
        $databaseId   = 'test';
        $baseRevision = 0;
        $fields       = ['items'];
        $limit        = 100;
        $json         = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/get-delta-filtered.json');
        $response     = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));
        $dataSyncClientMock = $this->getMockBuilder(DataSyncClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $dataSyncClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $deltasResponse = $dataSyncClientMock->getDelta($baseRevision, $databaseId, $context, $fields, $limit);

        $this->assertNull($deltasResponse->getBaseRevision());
        $this->assertNull($deltasResponse->getTotal());
        $this->assertNull($deltasResponse->getLimit());
        $this->assertNull($deltasResponse->getRevision());
    }

    function testSetProperties()
    {
        $fixture = [
            'base_revision' => 5,
            'limit'         => 10,
            'revision'      => 5,
            'total'         => 10,
            'items'         => []
        ];

        $response1 = new DatabaseDeltasResponse($fixture);

        $response2 = new DatabaseDeltasResponse();
        $response2->setBaseRevision($fixture['base_revision']);
        $response2->setLimit($fixture['limit']);
        $response2->setRevision($fixture['revision']);
        $response2->setTotal($fixture['total']);
        $response2->setItems($fixture['items']);
        $this->assertTrue($response1->toArray() === $response2->toArray(), 'Is Equals arrays');
    }

    function testDeltas()
    {
        $deltaId      = 'test';
        $baseRevision = 5;
        $deltas       = new Database\Deltas();
        $deltas->add(['delta_id' => $deltaId, 'base_revision' => $baseRevision]);
        $deltas2 = new Database\Deltas();
        $delta   = new Database\Delta();
        $delta->setDeltaId($deltaId);
        $delta->setBaseRevision($baseRevision);
        $deltas2->add($delta);
        $this->assertEquals($baseRevision, $deltas2->getAll()[0]->getBaseRevision());
        $this->assertTrue($deltas->toArray() === $deltas2->toArray(), 'Is Equals arrays');
    }
}
