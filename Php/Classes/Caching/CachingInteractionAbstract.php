<?php
namespace DevelopmentTools\Php\Classes\Caching;

use DevelopmentTools\Php\Config\Settings;

abstract class CachingInteractionAbstract implements CachingInterface
{
    protected static $settings;

    public function __construct(
        Settings $settings
    ) {
        self::$settings = $settings;
    }
}