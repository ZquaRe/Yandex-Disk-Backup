<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\PopularClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  08.01.2016 01:40
 */
class PopularClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetModels()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/popular-models.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $popularClientMock = $this->getMockBuilder(PopularClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $popularClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $popularModels = $popularClientMock->getModels(['geo_id' => 44]);

        $categories = $popularModels->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->name,
            $category0->getName()
        );

        $categoryVendor = $category0->getVendors();

        /** @var Vendor $vendor0 */
        $vendor0 = $categoryVendor->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->id,
            $vendor0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->name,
            $vendor0->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->topModelId,
            $vendor0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->topModelImage,
            $vendor0->getModelPhotoUrl()
        );

        /** @var Vendor $vendor1 */
        $vendor1 = $categoryVendor->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->id,
            $vendor1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->name,
            $vendor1->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->topModelId,
            $vendor1->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->topModelImage,
            $vendor1->getModelPhotoUrl()
        );

        /** @var Category $category1 */
        $category1 = $categories->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->id,
            $category1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->name,
            $category1->getName()
        );

        $categoryVendor = $category1->getVendors();

        /** @var Vendor $vendor0 */
        $vendor0 = $categoryVendor->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->id,
            $vendor0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->name,
            $vendor0->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->topModelId,
            $vendor0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->topModelImage,
            $vendor0->getModelPhotoUrl()
        );

        /** @var Vendor $vendor1 */
        $vendor1 = $categoryVendor->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->id,
            $vendor1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->name,
            $vendor1->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->topModelId,
            $vendor1->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->topModelImage,
            $vendor1->getModelPhotoUrl()
        );
    }

    function testGetCategoryModels()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/popular-category-models.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $popularClientMock = $this->getMockBuilder(PopularClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $popularClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $popularModels = $popularClientMock->getCategoryModels(90402, ['geo_id' => 44]);

        $categories = $popularModels->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->name,
            $category0->getName()
        );

        $categoryVendor = $category0->getVendors();

        /** @var Vendor $vendor0 */
        $vendor0 = $categoryVendor->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->id,
            $vendor0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->name,
            $vendor0->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->topModelId,
            $vendor0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[0]->topModelImage,
            $vendor0->getModelPhotoUrl()
        );

        /** @var Vendor $vendor1 */
        $vendor1 = $categoryVendor->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->id,
            $vendor1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->name,
            $vendor1->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->topModelId,
            $vendor1->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[0]->topVendors[1]->topModelImage,
            $vendor1->getModelPhotoUrl()
        );

        /** @var Category $category1 */
        $category1 = $categories->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->id,
            $category1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->name,
            $category1->getName()
        );

        $categoryVendor = $category1->getVendors();

        /** @var Vendor $vendor0 */
        $vendor0 = $categoryVendor->current();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->id,
            $vendor0->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->name,
            $vendor0->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->topModelId,
            $vendor0->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[0]->topModelImage,
            $vendor0->getModelPhotoUrl()
        );

        /** @var Vendor $vendor1 */
        $vendor1 = $categoryVendor->next();

        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->id,
            $vendor1->getId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->name,
            $vendor1->getName()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->topModelId,
            $vendor1->getModelId()
        );
        $this->assertEquals(
            $jsonObj->popular->topCategoryList[1]->topVendors[1]->topModelImage,
            $vendor1->getModelPhotoUrl()
        );
    }
}
