<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:32 PM
 */
class Config
{
    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $loc = explode('/', $path);
            foreach ($loc as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }


}
