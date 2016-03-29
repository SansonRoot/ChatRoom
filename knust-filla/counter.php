<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 3/28/2016
 * Time: 12:16 AM
 */
require_once 'core/init.php';

$users=DB::getInstance()->get('users',array())->count();

echo json_encode(array('total'=>$users));