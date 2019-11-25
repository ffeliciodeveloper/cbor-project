<?php

require __DIR__.'/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use CBOR\CBOREncoder;

$app = AppFactory::create();

$app->get('/cbor', function (Request $request, Response $response, $args) {
    $target = [
        [2 => ['c' => true]],
        [3 => ['p' => 10]],
        1,
        'string',
        [1, 2, 3, 4],
    ];

    //encoded string
    $encoded_data = CBOREncoder::encode($target);

    $byte_arr = unpack('C*', $encoded_data);
    $dechex = implode(' ', array_map(function ($byte) {
        $dechex = dechex($byte);

        if (strlen($dechex) == 1 || (is_numeric($dechex) && $dechex < 10)) {
            $dechex = '0'.$dechex;
        }

        return '0x'.$dechex;
    }, $byte_arr));

    $response->getBody()->write($dechex);

    return $response;
});

$app->run();
