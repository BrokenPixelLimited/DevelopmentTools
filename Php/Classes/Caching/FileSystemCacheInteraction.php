<?php
namespace CodeLibrary\Php\Classes\Caching;


/**
 * Class FileSystemCacheInteraction
 * @package CodeLibrary\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 */
class FileSystemCacheInteraction implements CachingInterface
{
    /**
     * @param $type
     * @param $limited
     */
    public static function info($type, $limited)
    {
        // TODO: Implement info() method.
    }

    /**
     * @param $key
     */
    public static function exists($key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * @param $key
     * @param $data
     * @param $ttl
     * @param $overwrite
     */
    public static function store($key, $data, $ttl, $overwrite)
    {
        // TODO: Implement store() method.
    }

    /**
     * @param $key
     */
    public static function fetch($key)
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $type
     */
    public static function clear($type)
    {
        // TODO: Implement clear() method.
    }

}