<?php
namespace CodeLibrary\Php\Classes\Caching;

/**
 * Class Cache
 * @package Php\Classes\Caching
 * @author John James contact@brokenpixel.uk
 */
class Cache
{
    /**
     * @param string $cacheType
     * @return ApcCacheInteraction|ApcuCacheInteraction|FileSystemCacheInteraction|MemcacheCacheInteraction
     * @throws \Exception
     */
    public static function useCache($cacheType = 'volatile')
    {
        if ($cacheType === 'volatile') {
            if (function_exists('apcu_add')) {
                $cachingObject = new ApcuCacheInteraction();
            } elseif (function_exists('apc_add') && empty($cachingObject)) {
                $cachingObject = new ApcCacheInteraction();
            } elseif (function_exists('memcache_add') && empty($cachingObject)) {
                $cachingObject = new MemcacheCacheInteraction();
            }
        } elseif ($cacheType === 'persistent') {
            $cachingObject = new FileSystemCacheInteraction();
        } else {
            throw new \Exception(
                'You have tried to use a caching type is neither '
                .'\'volatile\' or \'persistent\''
            );
        }

        if (empty($cachingObject)) {
            throw new \Exception(
                'You don\'t cache to work with please install apcu or memcached'
            );
        }
        return $cachingObject;
    }
}