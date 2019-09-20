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
namespace Yandex\DataSync;

use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\IncorrectDataFormatException;
use Yandex\DataSync\Exception\IncorrectRevisionNumberException;
use Yandex\Common\Exception\InvalidArgumentException;
use Yandex\DataSync\Exception\MaxDatabasesCountException;
use Yandex\Common\Exception\NotFoundException;
use Yandex\DataSync\Exception\RevisionOnServerOverCurrentException;
use Yandex\DataSync\Exception\RevisionTooOldException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\Exception\UnavailableResourceException;
use Yandex\DataSync\Exception\DataSyncException;
use Yandex\DataSync\Models\Database;
use Yandex\DataSync\Responses\DatabaseDeltasResponse;
use Yandex\DataSync\Responses\DatabaseSnapshotResponse;
use Yandex\DataSync\Responses\DatabasesResponse;

/**
 * Class DataSyncClient
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  01.03.15 12:07
 */
class DataSyncClient extends AbstractServiceClient
{
    /**
     * DB app context.
     */
    const CONTEXT_APP = 'app';

    /**
     * DB user context.
     */
    const CONTEXT_USER = 'user';

    /**
     * Requested version of API
     *
     * @var string
     */
    private $version = 'v1';

    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'cloud-api.yandex.net';

    /**
     * @var string
     */
    private $context;

    /**
     * @var string
     */
    private $databaseId;

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getDatabaseId()
    {
        if (!$this->databaseId) {
            throw new InvalidArgumentException('Empty database id');
        }

        return $this->databaseId;
    }

    /**
     * @param string $databaseId
     */
    public function setDatabaseId($databaseId)
    {
        $this->databaseId = $databaseId;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getContext()
    {
        if (!$this->context) {
            throw new InvalidArgumentException('Empty context');
        }
        return $this->context;
    }

    /**
     * @param string $context
     *
     * @throws InvalidArgumentException
     */
    public function setContext($context)
    {
        if ($context === self::CONTEXT_APP || $context === self::CONTEXT_USER) {
            $this->context = $context;
        } else {
            throw new InvalidArgumentException('Incorrect context');
        }
    }

    /**
     * @param string $token access token
     * @param null   $context
     * @param null   $databaseId
     */
    public function __construct($token = '', $context = null, $databaseId = null)
    {
        $this->setAccessToken($token);

        if ($context) {
            $this->setContext($context);
        }

        if ($databaseId) {
            $this->setDatabaseId($databaseId);
        }
    }

    /**
     * @param null|string $context
     * @param array       $fields
     * @param null        $limit
     * @param null        $offset
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDatabasesUrl($context = null, $fields = [], $limit = null, $offset = null)
    {
        if ($context) {
            $this->setContext($context);
        }

        $params = [];
        if ($limit) {
            $params['limit'] = $limit;
        }
        if ($offset) {
            $params['offset'] = $offset;
        }
        if ($fields) {
            $params['fields'] = implode(',', $fields);
        }

        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . $this->version . '/data/'
        . $this->getContext() . '/databases/?' . http_build_query($params);
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDatabaseUrl($databaseId = null, $context = null, $fields = [])
    {
        if ($context) {
            $this->setContext($context);
        }
        if ($databaseId) {
            $this->setDatabaseId($databaseId);
        }

        $params = [];
        if ($fields) {
            $params['fields'] = implode(',', $fields);
        }

        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . $this->version . '/data/'
        . $this->getContext() . '/databases/' . $this->getDatabaseId() . '/?' . http_build_query($params);
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param null        $collectionId
     * @param array       $fields
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDatabaseSnapshotUrl($databaseId = null, $context = null, $collectionId = null, $fields = [])
    {
        if ($context) {
            $this->setContext($context);
        }
        if ($databaseId) {
            $this->setDatabaseId($databaseId);
        }

        $params = [];
        if ($collectionId) {
            $params['collection_id'] = $collectionId;
        }
        if ($fields) {
            $params['fields'] = implode(',', $fields);
        }

        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . $this->version . '/data/'
        . $this->getContext() . '/databases/' . $this->getDatabaseId() . '/snapshot/?' . http_build_query($params);
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     * @param int         $baseRevision
     * @param int         $limit
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDatabaseDeltasUrl(
        $databaseId = null,
        $context = null,
        $fields = [],
        $baseRevision = null,
        $limit = null
    ) {
        if ($context) {
            $this->setContext($context);
        }
        if ($databaseId) {
            $this->setDatabaseId($databaseId);
        }
        $params = [];
        if ($baseRevision !== null) {
            $params['base_revision'] = $baseRevision;
        }
        if ($limit) {
            $params['limit'] = $limit;
        }
        if ($fields) {
            $params['fields'] = implode(',', $fields);
        }

        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . $this->version . '/data/'
        . $this->getContext() . '/databases/' . $this->getDatabaseId() . '/deltas?' . http_build_query($params);
    }

    /**
     * Sends a request
     *
     * @param string              $method  HTTP method
     * @param string $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @return Response|\Psr\Http\Message\ResponseInterface
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws IncorrectRevisionNumberException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws RevisionOnServerOverCurrentException
     * @throws RevisionTooOldException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result  = $ex->getResponse();
            $code    = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            switch ($code) {
                case 400:
                    throw new InvalidArgumentException($message);
                case 401:
                    throw new UnauthorizedException($message);
                case 403:
                    throw new ForbiddenException($message);
                case 404:
                    throw new NotFoundException($message);
                case 406:
                    throw new IncorrectDataFormatException($message);
                case 409:
                    throw new RevisionOnServerOverCurrentException($message);
                case 410:
                    throw new RevisionTooOldException($message);
                case 412:
                    throw new IncorrectRevisionNumberException($message);
                case 415:
                    throw new IncorrectDataFormatException($message);
                case 423:
                    throw new UnavailableResourceException($message);
                case 429:
                    throw new TooManyRequestsException($message);
                case 507:
                    throw new MaxDatabasesCountException($message);
            }

            throw new DataSyncException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }

    /**
     * @param null|string $context
     * @param array       $fields
     * @param null        $limit
     * @param null        $offset
     *
     * @return DatabasesResponse
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function getDatabases($context = null, $fields = [], $limit = null, $offset = null)
    {
        $response            = $this->sendRequest('GET', $this->getDatabasesUrl($context, $fields, $limit, $offset));
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $databasesResponse   = new DatabasesResponse($decodedResponseBody);
        if ($databasesResponse->getItems()) {
            $databases = $databasesResponse->getItems()->getAll();
            foreach ($databases as $database) {
                $database->setContext($this->getContext());
            }
        }

        return $databasesResponse;
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     *
     * @return Database
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function createDatabase($databaseId = null, $context = null, $fields = [])
    {
        $response            = $this->sendRequest('PUT', $this->getDatabaseUrl($databaseId, $context, $fields));
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $database            = new Database($decodedResponseBody);
        $database->setContext($this->getContext());
        return $database;
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     *
     * @return Database
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function getDatabase($databaseId = null, $context = null, $fields = [])
    {
        $response            = $this->sendRequest('GET', $this->getDatabaseUrl($databaseId, $context, $fields));
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $database            = new Database($decodedResponseBody);
        $database->setContext($this->getContext());
        return $database;
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     *
     * @return bool
     *
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function deleteDatabase($databaseId = null, $context = null)
    {
        $response = $this->sendRequest('DELETE', $this->getDatabaseUrl($databaseId, $context));
        return $response->getStatusCode() === 204;
    }

    /**
     * @param string $title
     * @param null   $databaseId
     * @param null   $context
     * @param array  $fields
     *
     * @return Database
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function updateDatabaseTitle($title, $databaseId = null, $context = null, $fields = [])
    {
        $response            = $this->sendRequest(
            'PATCH',
            $this->getDatabaseUrl($databaseId, $context, $fields),
            [
                'json' => ['title' => $title]
            ]
        );
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $database            = new Database($decodedResponseBody);
        $database->setContext($this->getContext());
        return $database;
    }

    /**
     * @param null|string $databaseId
     * @param null|string $context
     * @param null        $collectionId
     * @param array       $fields
     *
     * @return DatabaseSnapshotResponse
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function getDatabaseSnapshot($databaseId = null, $context = null, $collectionId = null, $fields = [])
    {
        $response            = $this->sendRequest(
            'GET',
            $this->getDatabaseSnapshotUrl($databaseId, $context, $collectionId, $fields)
        );
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $result              = new DatabaseSnapshotResponse($decodedResponseBody);
        return $result;
    }

    /**
     * @param array       $data
     * @param int         $revision
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     *
     * @return array
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws IncorrectRevisionNumberException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws RevisionOnServerOverCurrentException
     * @throws RevisionTooOldException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     *
     * @see https://tech.yandex.ru/datasync/http/doc/tasks/add-changes-docpage/
     */
    public function saveDelta($data, $revision = 0, $databaseId = null, $context = null, $fields = [])
    {
        $options             = [
            'headers' => [
                'If-Match' => $revision,
            ],
            'json'    => $data
        ];
        $response            = $this->sendRequest(
            'POST',
            $this->getDatabaseDeltasUrl($databaseId, $context, $fields),
            $options
        );
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        if ($response->getHeader('ETag')
            && is_array($response->getHeader('ETag'))
            && count($response->getHeader('ETag')) > 0
        ) {
            $decodedResponseBody['revision'] = $response->getHeader('ETag')[0];
        }

        return $decodedResponseBody;
    }

    /**
     * @param int         $baseRevision
     * @param null|string $databaseId
     * @param null|string $context
     * @param array       $fields
     * @param null|int    $limit
     *
     * @return DatabaseDeltasResponse
     * @throws DataSyncException
     * @throws ForbiddenException
     * @throws IncorrectDataFormatException
     * @throws IncorrectRevisionNumberException
     * @throws InvalidArgumentException
     * @throws MaxDatabasesCountException
     * @throws NotFoundException
     * @throws RevisionOnServerOverCurrentException
     * @throws RevisionTooOldException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnavailableResourceException
     */
    public function getDelta($baseRevision = 0, $databaseId = null, $context = null, $fields = [], $limit = null)
    {
        $response            = $this->sendRequest(
            'GET',
            $this->getDatabaseDeltasUrl($databaseId, $context, $fields, $baseRevision, $limit)
        );
        $decodedResponseBody = $this->getDecodedBody($response->getBody());
        $result              = new DatabaseDeltasResponse($decodedResponseBody);
        return $result;
    }
}
