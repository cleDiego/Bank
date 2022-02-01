<?php
namespace Bank\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Bank\Models\ModelAccount;

class ControllerAccount
{
    /**
     * @param string $account
     * @return array|false $response
     */
    public static function balance($account_id)
    {
        $modelAccount = new ModelAccount();
        return $modelAccount->balance($account_id);
    }

    /**
     * @param Request $request Search type
     * @return array|false $response
     */
    public static function event(Request $request)
    {
        $modelAccount = new ModelAccount();
        $bodyData = $request->getParsedBody();

        switch($bodyData['type'])
        {
            case 'deposit':
                return $modelAccount->deposit($bodyData['destination'], $bodyData['amount']);
            break;
            case 'withdraw':
                return $modelAccount->withdraw($bodyData['origin'], $bodyData['amount']);
            break;
            case 'transfer':
                return $modelAccount->transfer($bodyData['origin'], $bodyData['destination'], $bodyData['amount']);
            break;
        }

    }
}