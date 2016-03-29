<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:33 PM
 */
class Input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public static function getIp(){
        $ipaddress='0.0.0.0';

        if(isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress=$_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress=$_SERVER['HTTP_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress=$_SERVER['HTTP_FORWARDED'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress=$_SERVER['HTTP_X_FORWARDED'];
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress=$_SERVER['REMOTE_ADDR'];
        }
        return $ipaddress;
    }
    public static function get($data)
    {
        if (isset($_POST[$data])) {
            return $_POST[$data];
        } elseif (isset($_GET[$data])) {
            return $_GET[$data];
        }
        return '';

    }
}