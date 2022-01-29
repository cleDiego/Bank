<?php
namespace Bank;

require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/Bank/api/v1');

//Enabled CORS
$cors = require __DIR__ . '/App/CORS.php';
$cors($app);

//Error Slim Middleware
$errorMiddleware = $app->addErrorMiddleware(false, false, false);

//Define routes
$routes = require __DIR__ . '/App/Routes.php';
$routes($app);

//App Start
$app->run();