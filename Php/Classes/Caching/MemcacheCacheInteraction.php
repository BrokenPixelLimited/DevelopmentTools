<?php
namespace CodeLibrary\Php\Classes\Caching;

use CodeLibrary\Php\Config\Settings;


/**
 * Class MemcacheCacheInteraction
 * @package CodeLibrary\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 */
class MemcacheCacheInteraction implements CachingInterface
{
    private static $memcache;

    public function __construct() {


        self::$memcache = new Memcache;

        // This sets up a non-persistent connection that will be closed when the memcacheCacheInteraction is disposed.
        // Changing the last parameter to false turns it 
        self::$memcache->addServer (Settings::$memcacheServerAddress, Settings::$memcacheServerPort, false);
    }

    public function __destruct() {
        self::$memcache->close();
    }

    public static function info($type = '', $limited = false)
    {
        return self::$memcache->getExtendedStats();
    }

    /**
     * Checks if a key exists.
     *
     * @param mixed $key - A string key
     *
     * @return mixed - Returns true if the key exists, otherwise false or if an
     *                 array was passed to keys, then an array is returned that
     *                 contains all existing keys, or an empty array if none exist.
     */
    public static function exists($key = '')
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

            // Return type will be a string/array if the key exists or 
            // FALSE otherwise.
            return !is_bool($fetch);
        }
    }

    /**
     * Cache a variable in the data store.
     *
     * @param string $key - Store the variable using this name.
     * @param string $data - The variable to store.
     * @param string $ttl - Time To Live; store var in the cache for ttl seconds.
     * @param bool $overwrite - Overwrite the value if it exists.
     *
     * @return boolean - Returns true on success or false on failure.
     */
    public static function store($key, $data, $ttl, $overwrite)
    {
        try {
            $result = false;

            if ($overwrite) {
                $result = self::$memcache->set($key, $data, Settings::$memcacheUseCompression, $ttl);
            } else {
                $result = self::$memcache->add($key, $data, Settings::$memcacheUseCompression, $ttl);
            }

            return $result;
        } catch (\Exception $exceptionResponse) {
            throw new \Exception($exceptionResponse->getMessage(), $exceptionResponse->getCode());
        }
    }

    /**
     * Fetch stored value in memcache.
     *
     * @param string $key - The key used to store the value.
     * @return boolean - The stored variable or array of variables on success; false on failure.
     */
    public static function fetch($key = '')
    {
        try {
            return self::$memcache->get($key);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception($exceptionResponse->getMessage(), $exceptionResponse->getCode());
        }
    }

    /**
     * Removes a stored variable from the cache.
     * @param string $key - The key used to store the value.
     * @return boolean - Returns true on success or false on failure.
     */
    public static function delete($key)
    {
         try {
            return self::$memcache->delete($key);
        } catch (\Exception $exceptionResponse) {
            throw new \Exception($exceptionResponse->getMessage(), $exceptionResponse->getCode());
        }        
    }

    /**
     * Invalidates all items in the cache. This does not cause their immediate deletion but allows them to be overwritten.
     *
     * @param string $type - 
     * @return boolean - Returns true on success or false on failure.
     */
    public static function clear($type = '')
    {
        try {
            // Note: flush has a 1s granularity, so it may cause items added after the flush to be
            // removed.
            self::$memcache->flush();
        } catch (\Exception $exceptionResponse) {
             throw new \Exception($exceptionResponse->getMessage(), $exceptionResponse->getCode());
        }
    }

}