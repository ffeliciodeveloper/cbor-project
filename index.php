<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/cbor', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello CBOR!');
    return $response;
});

$app->get('/json', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello JSON!');

    return $response;
});

$app->run();
