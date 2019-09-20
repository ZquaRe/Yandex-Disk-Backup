<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\SafeBrowsing\Adapter;

use Predis\Client;

/**
 * Class RedisAdapter
 *
 * @category Yandex
 * @package SafeBrowsing
 */
class RedisAdapter
{
    const KEY_SHA_VARS = 'sha_vars';
    const KEY_SHA_VAR = 'sha_var';

    const KEY_HASH_PREFIXES = 'hash_prefixes';
    const KEY_HASH_PREFIX = 'hash_prefix';

    const KEY_CHUNK_NUMS = 'chunk_nums';
    const KEY_CHUNK_NUM = 'chunk_num';

    /**
     * @var Client
     */
    private $client;

    public function __construct($dsn = '', $options = [])
    {
        $this->client = $this->initClient($dsn, $options);
    }

    /**
     * @param string $dsn
     * @param array $options
     * @param bool $reset
     * @return Client
     */
    public function initClient($dsn = '', $options = [], $reset = false)
    {
        if (!$this->client || $reset) {
            $this->client = new Client($dsn, $options);
            $this->client->ping();
        }

        return $this->client;
    }

    /**
     * @param string $shaVar
     */
    public function addShaVar($shaVar)
    {
        $this->client->sadd(self::KEY_SHA_VARS, [$shaVar]);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     */
    public function addChunkNum($shaVar, $chunkNum)
    {
        $key = $this->getChunkNumsKey($shaVar);
        $this->client->sadd($key, [$chunkNum]);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     * @param string $hashPrefix
     */
    public function addHashPrefix($shaVar, $chunkNum, $hashPrefix)
    {
        $chunkNumKey = $this->getChunkNumKey($shaVar, $chunkNum);
        $hashPrefixKey = $this->getHashPrefixKey($hashPrefix);

        $this->client->sadd($chunkNumKey, [$hashPrefix]);
        $this->client->sadd($hashPrefixKey, [$chunkNumKey]);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     * @param string $hashPrefix
     */
    public function saveHashPrefix($shaVar, $chunkNum, $hashPrefix)
    {
        $this->addShaVar($shaVar);
        $this->addChunkNum($shaVar, $chunkNum);
        $this->addHashPrefix($shaVar, $chunkNum, $hashPrefix);
    }

    public function getShaVars()
    {
        return $this->client->smembers(self::KEY_SHA_VARS);
    }

    /**
     * @param string $shaVar
     * @return array
     */
    public function getChunkNums($shaVar)
    {
        $key = $key = $this->getChunkNumsKey($shaVar);

        return $this->client->smembers($key);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     * @return array
     */
    public function getHashPrefixes($shaVar, $chunkNum)
    {
        $key = $this->getChunkNumKey($shaVar, $chunkNum);

        return $this->client->smembers($key);
    }

    /**
     * @param string $hashPrefix
     * @return array
     */
    public function getHashPrefix($hashPrefix)
    {
        $key = $this->getHashPrefixKey($hashPrefix);

        return $this->client->smembers($key);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     */
    public function removeChunkNum($shaVar, $chunkNum)
    {
        $chunkNumsKey = $this->getChunkNumsKey($shaVar);
        $chunkNumKey = $this->getChunkNumKey($shaVar, $chunkNum);

        $hashPrefixes = $this->client->smembers($chunkNumKey);

        foreach ($hashPrefixes as $hashPrefix) {
            $this->removeHashPrefix($shaVar, $chunkNum, $hashPrefix);
        }

        $this->client->srem($chunkNumsKey, $chunkNum);
        $this->client->del([$chunkNumKey]);

        if (0 === $this->client->scard($chunkNumsKey)) {
            $this->client->srem(self::KEY_SHA_VARS, $shaVar);
        }
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     * @param string $hashPrefix
     */
    public function removeHashPrefix($shaVar, $chunkNum, $hashPrefix)
    {
        $chunkNumKey = $this->getChunkNumKey($shaVar, $chunkNum);
        $hashPrefixKey = $this->getHashPrefixKey($hashPrefix);

        $this->client->srem($chunkNumKey, $hashPrefix);
        $this->client->srem($hashPrefixKey, $chunkNumKey);

        if (0 === $this->client->scard($chunkNumKey)) {
            $this->removeChunkNum($shaVar, $chunkNum);
        }
    }

    /**
     * @param array $hashes
     * @return bool
     */
    public function hasHashes($hashes)
    {
        if (!is_array($hashes)) {
            return false;
        }

        foreach ($hashes as $hash) {
            $key = $this->getHashPrefixKey($hash['prefix']);

            if (!empty($hash['prefix']) && $this->client->exists($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $hashes
     * @return array
     */
    public function getShaVarsByHashes($hashes)
    {
        if (!is_array($hashes)) {
            return [];
        }

        $shaVars = [];

        foreach ($hashes as $hash) {
            if (!empty($hash['prefix']) && $hashPrefixShaVars = $this->getHashPrefix($hash['prefix'])) {
                foreach ($hashPrefixShaVars as $hashPrefixShaVar) {
                    $shaVars[] = explode(':', $hashPrefixShaVar)[1];
                }
            }
        }

        return array_unique($shaVars);
    }

    /**
     * @param string $shaVar
     * @return string
     */
    private function getChunkNumsKey($shaVar)
    {
        return sprintf('%s:%s:%s', self::KEY_SHA_VAR, $shaVar, self::KEY_CHUNK_NUMS);
    }

    /**
     * @param string $shaVar
     * @param string $chunkNum
     * @return string
     */
    private function getChunkNumKey($shaVar, $chunkNum)
    {
        return sprintf('%s:%s:%s', self::KEY_SHA_VAR, $shaVar, $chunkNum);
    }

    /**
     * @param string $hashPrefix
     * @return string
     */
    private function getHashPrefixKey($hashPrefix)
    {
        return sprintf('%s:%s', self::KEY_HASH_PREFIX, $hashPrefix);
    }
}
