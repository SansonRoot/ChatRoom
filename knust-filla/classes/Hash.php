<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:34 PM
 */
class Hash{

    public static function make($string,$salt=''){
        return hash('sha256', $string . $salt);
    }
    public static function salt($length){
        return mcrypt_create_iv($length);
    }
    public static function unique(){
       return  self::make(uniqid());
    }
}