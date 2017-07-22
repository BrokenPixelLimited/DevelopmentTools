<?php
namespace DevelopmentTools\Php\Classes\Caching;

use DevelopmentTools\Php\Config\Settings;


/**
 * Class MemcacheCacheInteraction
 * @package DevelopmentTools\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 * @copyright Broken Pixel Limited
 * @license GPLv3
 */
class MemcacheCacheInteraction extends CachingInteractionAbstract implements CachingInterface
{
    protected static $memCacheConnection;

    public function __construct(
        Settings $settings,
        \Memcache $memcache
    ) {
        parent::__construct($settings);

        self::$memCacheConnection = $memcache;

        self::$memCacheConnection->addServer(
            self::$settings->memcacheServerAddress,
            self::$settings->memcacheServerPort
        );
    }

    public function __destruct() {
        self::$memCacheConnection->close();
    }

    public static function info(string $type = '', bool $limited = false)
    {
        return self::$memCacheConnection->getExtendedStats();
    }

    /**
     * Checks if a key exists.
     *
     * @param mixed $key
     *      A string key
     *
     * @return mixed
     *      Returns true if the key exists, otherwise false or if an
     *      array was passed to keys, then an array is returned that
     *      contains all existing keys, or an empty array if none exist.
     */
    public static function exists(string $key = '')
    {
        $result = false;

        if (is_array($key)) {

            $result = array();

            foreach ($key as $value) {
                $result[$value] = self::exists($value);
            }

            return $result;
        } else {
            $fetch = self::fetch($key);

            return !is_bool($fetch);
        }
    }

    /**
     * Cache a variable in the data store.
     *
     * @param string $key
     *      Store the variable using this name.
     * @param string $data
     *      The variable to store.
     * @param int $ttl
     *      Time To Live; store var in the cache for ttl seconds.
     * @param bool $overwrite
     *      Overwrite the value if it exists.
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function store(
        string $key,
        $data,
        int $ttl,
        bool $overwrite
    ) {
        try {
            $result = false;

            if ($overwrite) {
                $result = self::$memCacheConnection->set(
                    $key,
                    $data,
                    self::$settings->memcacheUseCompression,
                    $ttl
                );
            } else {
                $result = self::$memCacheConnection->add(
                    $key,
                    $data,
                    self::$settings->memcacheUseCompression,
                    $ttl
                );
            }

            return $result;
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }
    }

    /**
     * Fetch stored value in memcache.
     *
     * @param string $key
     *      The key used to store the value.
     * @return bool
     *      The stored variable or array of variables on success; false
     *      on failure.
     * @throws \Exception
     */
    public static function fetch(string $key = '')
    {
        try {
            return self::$memCacheConnection->get($key);
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
     *      The key used to store the value.
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function delete(string $key)
    {
         try {
            return self::$memCacheConnection->delete($key);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception(
                $exceptionResponse->getMessage(),
                $exceptionResponse->getCode()
            );
        }        
    }

    /**
     * Invalidates all items in the cache. This does not cause their
     * immediate deletion but allows them to be overwritten.
     *
     * @param string $type
     *
     * @return bool
     *      Returns true on success or false on failure.
     * @throws \Exception
     */
    public static function clear(string $type = '')
    {
        try {
            self::$memCacheConnection->flush();
        } catch (\Exception $exceptionResponse) {
             throw new \Exception(
                 $exceptionResponse->getMessage(),
                 $exceptionResponse->getCode()
             );
        }
    }
}