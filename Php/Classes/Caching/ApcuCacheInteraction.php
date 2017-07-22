<?php
namespace DevelopmentTools\Php\Classes\Caching;

/**
 * Class ApcuCacheInteraction
 * @package DevelopmentTools\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 * @copyright Broken Pixel Limited
 * @license GPLv3
 */
class ApcuCacheInteraction extends CachingInteractionAbstract implements CachingInterface
{
    /**
     * Retrieves cached information from APC's data store.
     *
     * @param string $type
     *      If $type is "user", information about the user
     *      cache will be returned.
     * @param boolean $limited
     *      If $limited is true, the return value will
     *      exclude the individual list of cache entries. This is useful when
     *      trying to optimize calls for statistics gathering.
     * @return array
     *      array of cached data (and meta-data) or false on failure.
     * @throws \Exception
     */
    public static function info(string $type = '', bool $limited = false)
    {
        try {
            return apcu_cache_info($limited);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Checks if APC key exists.
     *
     * @param mixed $key
     *      A string, or an array of strings, that contain keys.
     * @return mixed
     *      Returns true if the key exists, otherwise false or if an
     *      array was passed to keys, then an array is returned that
     *      contains all existing keys, or an empty array if none exist.
     * @throws \Exception
     */
    public static function exists(string $key = '')
    {
        try {
            return apcu_exists($key);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Cache a variable in the data store.
     *
     * @param string $key
     *      Store the variable using this name.
     * @param string $data
     *      The variable to store.
     * @param int|string $ttl
     *      Time To Live; store var in the cache for ttl seconds.
     * @param bool $overwrite
     *      Flag to set whether the current stored value
     *      is overwritten if it exists
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function store(
        string $key,
        $data,
        int $ttl = 0,
        bool $overwrite = false
    ) {
        try {
            if ($overwrite) {
                return apcu_store($key, $data, $ttl);
            } else {
                return apcu_add($key, $data, $ttl);
            }
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Fetch stored value in APC from key.
     *
     * @param string $key
     *      The key used to store the value.
     * @return bool
     *      The stored variable or array of variables on success;
     *      false on failure.
     * @throws \Exception
     */
    public static function fetch(string $key = '')
    {
        try {
            if (self::exists($key)) {
                return apcu_fetch($key);
            } else {
                return false;
            }
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Removes a stored variable from the cache.
     *
     * @param string $key
     *      The key used to store the value (with apcu_store()).
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function delete(string $key = '')
    {
        try {
            return apcu_delete($key);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Clears the APC cache.
     *
     * @param string $type
     *      If $type is "user", the user cache will be cleared; otherwise,
     *      the system cache (cached files) will be cleared.
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function clear(string $type = '') {
        try {
            return apcu_clear_cache($type);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }
}