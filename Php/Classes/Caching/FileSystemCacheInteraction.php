<?php
namespace DevelopmentTools\Php\Classes\Caching;


/**
 * Class FileSystemCacheInteraction
 * @package DevelopmentTools\Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 * @copyright Broken Pixel Limited
 * @license GPLv3
 */
class FileSystemCacheInteraction extends CachingInteractionAbstract implements CachingInterface
{
    /**
     * @param $type
     * @param $limited
     * @return mixed|void
     */
    public static function info(string $type, bool $limited)
    {
        // TODO: Implement info() method.
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public static function exists(string $key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * @param $key
     * @param $data
     * @param $ttl
     * @param $overwrite
     * @return mixed|void
     */
    public static function store(
        string $key,
        $data,
        int $ttl,
        bool $overwrite
    ) {
        // TODO: Implement store() method.
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public static function fetch(string $key)
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public static function delete(string $key)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $type
     * @return mixed|void
     */
    public static function clear(string $type)
    {
        // TODO: Implement clear() method.
    }

}