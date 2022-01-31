<?php
namespace Bank\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Bank\Models\ModelAccount;

class ControllerAccount
{
    /**
     * @param Request $request Search type
     * @return Response $response
     */
    public static function event(Request $request)
    {
        $modelAccount = new ModelAccount();
        $bodyData = $request->getParsedBody();

        switch($bodyData['type'])
        {
            case 'deposit':
                $response = $modelAccount->deposit($bodyData['destination'], $bodyData['amount']);
                return $response;
            break;
            case 'withdraw':
            break;
            case 'transfer':
            break;
        }

    }
}