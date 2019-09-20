<?php
namespace Yandex\Metrica\Management;

/**
 * Class OperationsClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:42
 */
class OperationsClient extends ManagementClient
{

    /**
     * Get counter operations
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/operations/operations.xml
     *
     * @param int $counterId
     * @param array $params
     * @return array
     */
    public function getOperations($counterId, $params = [])
    {
        $resource = 'counter/' . $counterId . '/operations';
        $response = $this->sendGetRequest($resource, $params);
        $operationResponse = new Models\GetOperationsResponse($response);
        return $operationResponse->getOperations();
    }


    /**
     * Add operation to counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/operations/addoperation.xml
     *
     * @param int $counterId
     * @param Models\Operation $operation
     * @return Models\Operation
     */
    public function addOperation($counterId, Models\Operation $operation)
    {
        $resource = 'counter/' . $counterId . '/operations';
        $response = $this->sendPostRequest($resource, ["operation" => $operation->toArray()]);
        $operationResponse = new Models\AddOperationResponse($response);
        return $operationResponse->getOperation();
    }


    /**
     * Get counter operation
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/operations/operation.xml
     *
     * @param int $id
     * @param int $counterId
     * @param array $params
     * @return Models\Operation
     */
    public function getOperation($id, $counterId, $params = [])
    {
        $resource = 'counter/' . $counterId . '/operation/' . $id;
        $response = $this->sendGetRequest($resource, $params);
        $operationResponse = new Models\GetOperationResponse($response);
        return $operationResponse->getOperation();
    }


    /**
     * Update counter operation
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/operations/editoperation.xml
     *
     * @param int $id
     * @param int $counterId
     * @param Models\Operation $operation
     * @return Models\Operation
     */
    public function updateOperation($id, $counterId, Models\Operation $operation)
    {
        $resource = 'counter/' . $counterId . '/operation/' . $id;
        $response = $this->sendPutRequest($resource, ["operation" => $operation->toArray()]);
        $operationsResponse = new Models\UpdateOperationResponse($response);
        return $operationsResponse->getOperation();
    }


    /**
     * Delete counter operation
     *
     * @see http://api.yandex.ru/metrika/doc/ref/reference/del-counter-operation.xml
     *
     * @param int $id
     * @param int $counterId
     * @return array
     */
    public function deleteCounterOperation($id, $counterId)
    {
        $resource = 'counter/' . $counterId . '/operation/' . $id;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
