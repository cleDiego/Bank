<?php
namespace Bank\App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

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
};