<?php
namespace CodeLibrary\Php\Classes\Caching;

/**
 * Interface CachingInterface
 * @package CodeLibrary\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 */
interface CachingInterface
{
    /**
     * @param $type
     * @param $limited
     * @return mixed
     */
    public static function info($type, $limited);

    /**
     * @param $key
     * @return mixed
     */
    public static function exists($key);

    /**
     * @param $key
     * @param $data
     * @param $ttl
     * @param $overwrite
     * @return mixed
     */
    public static function store($key, $data, $ttl, $overwrite);

    /**
     * @param $key
     * @return mixed
     */
    public static function fetch($key);

    /**
     * @param $key
     * @return mixed
     */
    public static function delete($key);

    /**
     * @param $type
     * @return mixed
     */
    public static function clear($type);
}