<?php

require __DIR__ . '/vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/Bank/api/v1');
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Test");
    return $response;
});

$app->run();