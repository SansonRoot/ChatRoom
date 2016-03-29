<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 3/27/2016
 * Time: 10:43 PM
 */
require_once 'core/init.php';

$users=DB::getInstance()->get('users',array())->results();

echo '<div class="list-group scrolling" style="max-height: 500px">';
foreach($users as $user) {
    echo '<li class="list-group-item">' . $user->Username . '</li>';
}
echo '</div>';