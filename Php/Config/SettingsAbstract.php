<?php
namespace DevelopmentTools\Php\Config;

use DevelopmentTools\Php\Classes\ExceptionHandling\SettingsException;

class SettingsAbstract
{
    public $memcacheServerAddress;

    public $memcacheServerPort;

    public $memcacheUseCompression = MEMCACHE_COMPRESSED;

    public function checkSettingsAreSet(array $arrayOfSettingsToCheck)
    {
        foreach ($arrayOfSettingsToCheck as $settingName) {
            if (empty($this->{$settingName})) {
                throw new SettingsException(
                    'The setting '.$settingName.' is not set, please add it '
                    .' in the settings file.'
                );
            }
        }
    }
}