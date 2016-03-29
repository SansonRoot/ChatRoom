<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:35 PM
 */
class Token{
    public static function generate(){
        return Session::put(Config::get('session/token_name'),Hash::unique());
    }


    public static function check($token){
        $tokenName=Config::get('session/token_name');
        if(Session::exist($tokenName) && $token===Session::get($tokenName)){
            Session::delete($tokenName);

            return true;

        }
        return false;
    }

}
