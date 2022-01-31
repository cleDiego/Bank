<?php
namespace Bank;

session_name("Bank");
session_start();

require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/Bank/api/v1');

//Enabled CORS
$cors = require __DIR__ . '/src/Utils/CORS.php';
$cors($app);

//Error Slim Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

//Define routes
$routes = require __DIR__ . '/src/Routes/Routes.php';
$routes($app);

//App Start
$app->run();