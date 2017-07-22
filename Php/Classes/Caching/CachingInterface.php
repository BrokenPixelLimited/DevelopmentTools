<?php
namespace DevelopmentTools\Php\Classes\Caching;

/**
 * Interface CachingInterface
 * @package DevelopmentTools\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 * @copyright Broken Pixel Limited
 * @license GPLv3
 */
interface CachingInterface
{
    /**
     * @param $type
     * @param $limited
     * @return mixed
     */
    public static function info(string $type, bool $limited);

    /**
     * @param $key
     * @return mixed
     */
    public static function exists(string $key);

    /**
     * @param $key
     * @param $data
     * @param $ttl
     * @param $overwrite
     * @return mixed
     */
    public static function store(
        string $key,
        $data,
        int $ttl,
        bool $overwrite
    );

    /**
     * @param $key
     * @return mixed
     */
    public static function fetch(string $key);

    /**
     * @param $key
     * @return mixed
     */
    public static function delete(string $key);

    /**
     * @param $type
     * @return mixed
     */
    public static function clear(string $type);
}