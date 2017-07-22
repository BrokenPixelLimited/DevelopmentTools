<?php
namespace DevelopmentTools\Php\Classes\Caching;

use DevelopmentTools\Php\Classes\ExceptionHandling\CachingException,
    DevelopmentTools\Php\Config\Settings;

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
     * installed and enabled in the system also handles all the dependency
     * management for caching
     *
     * @param string $cacheType
     *      used to specify volatile or persistent
     * @param string $cachingSystem
     *      used for which caching system you want to us
     * @return ApcCacheInteraction|ApcuCacheInteraction|FileSystemCacheInteraction|MemcacheCacheInteraction
     * @throws \Exception
     */
    public static function useCache(
        string $cacheType = 'volatile',
        string $cachingSystem
    ) {
        $cachingObject = null;

        $settings = new Settings();

        // check which cacheType was specified
        if ($cacheType === 'volatile') {
            switch ($cachingSystem) {
                case 'apcu':
                    if (function_exists('apcu_add')) {
                        $cachingObject = new ApcuCacheInteraction(
                            $settings
                        );
                    } else {
                        throw new CachingException(
                            'You have tried to use APCU caching '
                            . 'but it is not configured properly for php'
                            . 'please install and configure APCU'
                        );
                    }
                    break;

                case 'apc':
                    if (function_exists('apc_add')) {
                        $cachingObject = new ApcCacheInteraction(
                            $settings
                        );
                    } else {
                        throw new CachingException(
                            'You have tried to use APC caching '
                            . 'but it is not configured properly for php'
                            . 'please install and configure APC'
                        );
                    }
                    break;

                case 'memcache':
                    if (function_exists('memcache_add')) {
                        $memCache = new \Memcache();
                        $cachingObject = new MemcacheCacheInteraction(
                            $settings,
                            $memCache
                        );
                    } else {
                        throw new CachingException(
                            'You have tried to use MemCache caching '
                            . 'but it is not configured properly for php'
                            . 'please install and configure MemCache');
                    }
                    break;
                default:
                    self::throwCachingSystemUndefinedError();
            }
        } elseif ($cacheType === 'persistent') {
            switch ($cachingSystem) {
                case 'fileSystem':
                    $cachingObject = new FileSystemCacheInteraction(
                        $settings
                    );
                    break;
                default:
                    self::throwCachingSystemUndefinedError();
            }

        } else {
            throw new \Exception(
                'You have tried to use a caching type that is neither '
                .'\'volatile\' or \'persistent\''
            );
        }

        return $cachingObject;
    }

    protected static function throwCachingSystemUndefinedError()
    {
        throw new CachingException(
            'You have not specified a caching system to use when calling '
            . __CLASS__ . __METHOD__
        );
    }
}