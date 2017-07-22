<?php
namespace DevelopmentTools\Php\Classes\Caching;

/**
 * Class CachingMediator
 * @package Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 * @copyright Broken Pixel Limited
 * @license GPLv3
 */
class CachingMediator
{
    /**
     * used to work out what caching types are available on the installed system
     * and returns a cache object in order of preference based on what is
     * installed and enabled in the system
     *
     * @todo possibly change to define what cache software type you want to use
     * @todo if multiple are setup
     *
     * @param string $cacheType
     * @return ApcCacheInteraction|ApcuCacheInteraction|FileSystemCacheInteraction|MemcacheCacheInteraction
     * @throws \Exception
     */
    public static function useCache($cacheType = 'volatile')
    {
        if ($cacheType === 'volatile') {
            if (function_exists('apcu_add')) {
                $cachingObject = new ApcuCacheInteraction();
            } elseif (
                function_exists('apc_add')
                && empty($cachingObject)
            ) {
                $cachingObject = new ApcCacheInteraction();
            } elseif (
                function_exists('memcache_add')
                && empty($cachingObject)
            ) {
                $cachingObject = new MemcacheCacheInteraction();
            }
        } elseif ($cacheType === 'persistent') {
            $cachingObject = new FileSystemCacheInteraction();
        } else {
            throw new \Exception(
                'You have tried to use a caching type that is neither '
                .'\'volatile\' or \'persistent\''
            );
        }

        if (empty($cachingObject)) {
            throw new \Exception(
                'You don\'t have a cache to work with please '
                .'install apcu or memcached'
            );
        }
        return $cachingObject;
    }
}