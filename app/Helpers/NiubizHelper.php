<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class NiubizHelper
{
    public static function getCurrentCredentials()
    {
        $environment = Config::get('visa.development') ? 'development' : 'production';
        return Config::get("visa.credentials.{$environment}");
    }

    public static function getScriptUrl()
    {
        return self::getCurrentCredentials()['url_js'];
    }
}