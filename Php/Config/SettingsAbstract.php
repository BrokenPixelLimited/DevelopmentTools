<?php
namespace DevelopmentTools\Php\Config;

class SettingsAbstract
{
    public $memcacheServerAddress;

    public $memcacheServerPort;

    public $memcacheUseCompression = MEMCACHE_COMPRESSED;
}