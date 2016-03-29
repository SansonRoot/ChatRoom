<?php

session_start();

$GLOBALS['config']=array(
    'mysql'=>array(
        'host'=>'127.0.0.1',
        'username'=>'root',
        'password'=>'ro0t',
        'db'=>'fillaDB'
    ),
    'remember'=>array(
        'cookie_name'=>'hash',
        'cookie_expiry'=>604800
    ),
    'session'=>array(
        'session_name'=>'user_chat',
        'token_name'=>'token'
    )
);


spl_autoload_register(function($classes){
    require_once 'classes/' . $classes . '.php';
});
