<?php
namespace Bank\App;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Bank\Controllers\ControllerAccount;
use Slim\App;


return function (App $app)
{

    /**
     * Default route info
     * @param Request
     * @return Response
     */
    $app->get('/', function (Request $request, Response $response) {
        $data = array(
            'ApiName'  => 'Bank',
            'Version'   => '0.1'
        );
        $payload = json_encode($data);
        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    });

    /**
     * Event route
     * @param Request
     * @return Response
     */
    $app->post('/event', function (Request $request, Response $response) {
        $payload = ControllerAccount::event($request);
        $payload = json_encode($payload);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    });

    /**
     * Reset route
     * @param Request
     * @return Response
     */
    $app->post('/reset', function (Request $request, Response $response) {
        session_destroy();
        $response->getBody()->write('OK');
        return $response
            ->withStatus(200);
    });

};