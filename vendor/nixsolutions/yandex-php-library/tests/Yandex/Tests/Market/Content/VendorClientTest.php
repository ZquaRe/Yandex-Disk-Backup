<?php
/**
 * @namespace
 */
namespace Yandex\Tests\Market;

use GuzzleHttp\Psr7\Response;
use Yandex\Market\Content\Clients\VendorClient;
use Yandex\Tests\TestCase;

/**
 * PackageTest
 *
 * @category Yandex
 * @package  Tests
 *
 * @author   Oleg Scherbakov <holdmann@yandex.ru>
 * @created  08.01.2016 02:20
 */
class VendorClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    function testGetList()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/vendor-list.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $vendorClientMock = $this->getMockBuilder(VendorClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $vendorClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $vendorsResponse = $vendorClientMock->getList();

        $this->assertEquals(
            $jsonObj->vendorList->count,
            $vendorsResponse->getCount()
        );

        $this->assertEquals(
            $jsonObj->vendorList->total,
            $vendorsResponse->getTotal()
        );

        $this->assertEquals(
            $jsonObj->vendorList->page,
            $vendorsResponse->getPage()
        );

        /** @var Vendors $vendors */
        $vendors = $vendorsResponse->getItems();

        /** @var Vendor $vendor0 */
        $vendor0 = $vendors->current();
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->id,
            $vendor0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->name,
            $vendor0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->site,
            $vendor0->getSite()
        );

        /** @var Categories $categories */
        $categories = $vendor0->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->name,
            $category0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->nmodels,
            $category0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->popularity,
            $category0->getPopularity()
        );

        /** @var Categories $childrenCategories */
        $childrenCategories = $category0->getChildren();

        /** @var Category $childrenCategory0 */
        $childrenCategory0 = $childrenCategories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->id,
            $childrenCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->name,
            $childrenCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->nmodels,
            $childrenCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->popularity,
            $childrenCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->filterId,
            $childrenCategory0->getFilterId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->categories[0]->innerCategories[0]->filterValueId,
            $childrenCategory0->getFilterValueId()
        );

        /** @var Categories $topCategories */
        $topCategories = $vendor0->getTopCategories();

        /** @var Category $topCategory0 */
        $topCategory0 = $topCategories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->topCategories[0]->id,
            $topCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->topCategories[0]->name,
            $topCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->topCategories[0]->nmodels,
            $topCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->topCategories[0]->popularity,
            $topCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[0]->topCategories[0]->imageUrl,
            $topCategory0->getImageUrl()
        );

        ///
        /** @var Vendor $vendor1 */
        $vendor1 = $vendors->next();
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->id,
            $vendor1->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->name,
            $vendor1->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->site,
            $vendor1->getSite()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->site,
            $vendor1->getSite()
        );

        /** @var Categories $categories */
        $categories = $vendor1->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->name,
            $category0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->nmodels,
            $category0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->popularity,
            $category0->getPopularity()
        );

        /** @var Categories $childrenCategories */
        $childrenCategories = $category0->getChildren();

        /** @var Category $childrenCategory0 */
        $childrenCategory0 = $childrenCategories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->id,
            $childrenCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->name,
            $childrenCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->nmodels,
            $childrenCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->popularity,
            $childrenCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->filterId,
            $childrenCategory0->getFilterId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->categories[0]->innerCategories[0]->filterValueId,
            $childrenCategory0->getFilterValueId()
        );

        /** @var Categories $topCategories */
        $topCategories = $vendor1->getTopCategories();

        /** @var Category $topCategory0 */
        $topCategory0 = $topCategories->current();

        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->topCategories[0]->id,
            $topCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->topCategories[0]->name,
            $topCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->topCategories[0]->nmodels,
            $topCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->topCategories[0]->popularity,
            $topCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendorList->vendor[1]->topCategories[0]->imageUrl,
            $topCategory0->getImageUrl()
        );
    }

    function testGet()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/vendor.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $vendorClientMock = $this->getMockBuilder(VendorClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $vendorClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $vendorResponse = $vendorClientMock->get(153043);

        /** @var Vendor $vendor */
        $vendor = $vendorResponse->getVendor();
        $this->assertEquals(
            $jsonObj->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->site,
            $vendor->getSite()
        );
        $this->assertEquals(
            $jsonObj->vendor->picture,
            $vendor->getPictureUrl()
        );

        /** @var Categories $categories */
        $categories = $vendor->getCategories();

        /** @var Category $category0 */
        $category0 = $categories->current();

        $this->assertEquals(
            $jsonObj->vendor->categories[0]->id,
            $category0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->name,
            $category0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->nmodels,
            $category0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->popularity,
            $category0->getPopularity()
        );

        /** @var Categories $childrenCategories */
        $childrenCategories = $category0->getChildren();

        /** @var Category $childrenCategory0 */
        $childrenCategory0 = $childrenCategories->current();

        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->id,
            $childrenCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->name,
            $childrenCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->nmodels,
            $childrenCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->popularity,
            $childrenCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->filterId,
            $childrenCategory0->getFilterId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[0]->innerCategories[0]->filterValueId,
            $childrenCategory0->getFilterValueId()
        );

        /** @var Category $category1 */
        $category1 = $categories->next();

        $this->assertEquals(
            $jsonObj->vendor->categories[1]->id,
            $category1->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->name,
            $category1->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->nmodels,
            $category1->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->popularity,
            $category1->getPopularity()
        );

        /** @var Categories $childrenCategories */
        $childrenCategories = $category1->getChildren();

        /** @var Category $childrenCategory0 */
        $childrenCategory0 = $childrenCategories->current();

        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->id,
            $childrenCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->name,
            $childrenCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->nmodels,
            $childrenCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->popularity,
            $childrenCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->filterId,
            $childrenCategory0->getFilterId()
        );
        $this->assertEquals(
            $jsonObj->vendor->categories[1]->innerCategories[0]->filterValueId,
            $childrenCategory0->getFilterValueId()
        );

        /** @var Categories $topCategories */
        $topCategories = $vendor->getTopCategories();

        /** @var Category $topCategory0 */
        $topCategory0 = $topCategories->current();

        $this->assertEquals(
            $jsonObj->vendor->topCategories[0]->id,
            $topCategory0->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[0]->name,
            $topCategory0->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[0]->nmodels,
            $topCategory0->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[0]->popularity,
            $topCategory0->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[0]->imageUrl,
            $topCategory0->getImageUrl()
        );

        /** @var Category $topCategory1 */
        $topCategory1 = $topCategories->next();

        $this->assertEquals(
            $jsonObj->vendor->topCategories[1]->id,
            $topCategory1->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[1]->name,
            $topCategory1->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[1]->nmodels,
            $topCategory1->getModelsCount()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[1]->popularity,
            $topCategory1->getPopularity()
        );
        $this->assertEquals(
            $jsonObj->vendor->topCategories[1]->imageUrl,
            $topCategory1->getImageUrl()
        );
    }

    function testGetMatch()
    {
        $json = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/vendor-match.json');
        $jsonObj = json_decode($json);
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($json));

        $vendorClientMock = $this->getMockBuilder(VendorClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $vendorClientMock->expects($this->any())
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $vendorMatchResponse = $vendorClientMock->getMatch(['name' => 'nike']);

        $this->assertEquals(
            $jsonObj->time,
            $vendorMatchResponse->getTime()
        );

        /** @var Vendor $vendor */
        $vendor = $vendorMatchResponse->getVendor();
        $this->assertEquals(
            $jsonObj->vendor->id,
            $vendor->getId()
        );
        $this->assertEquals(
            $jsonObj->vendor->name,
            $vendor->getName()
        );
        $this->assertEquals(
            $jsonObj->vendor->site,
            $vendor->getSite()
        );
        $this->assertEquals(
            $jsonObj->vendor->picture,
            $vendor->getPictureUrl()
        );
    }
}
