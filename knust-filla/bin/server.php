<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 3/26/2016
 * Time: 11:32 AM
 */
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

$server=IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),2000);

$server->run();
