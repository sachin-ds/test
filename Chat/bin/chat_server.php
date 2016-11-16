<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';

 	$app = new Ratchet\App('192.168.1.44', 8080);
    $app->route('/chat', new HttpServer(
            new WsServer(
                new Chat()
            )
        ));
    $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
    $app->run();

    /*$server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        8080
    );

    

    $server->run();*/