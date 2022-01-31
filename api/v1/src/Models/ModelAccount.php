<?php
namespace Bank\Models;
use Psr\Http\Message\ResponseInterface as Response;
use Bank\Beans\Account;
use Bank\Dao\DaoAccount;
$daoAccount = new DaoAccount();

class ModelAccount
{

    /**
     * @param string $destination
     * @param double $amount
     * @return array $payload
     */
    public function deposit($destination_id, $amount = 0)
    {
        $daoAccount = new DaoAccount();
        //find account by id
        $destination = $daoAccount->getAccount($destination_id);

        if(!$destination) {
            //create account if not exist
            $account = $daoAccount->insertAccount($destination_id, $amount);
            if($account) {
                $payload = array(
                    "destination" => array(
                        "id"        => $account->getId(),
                        "balance"   => $account->getBalance(),
                    )
                );
            }
            else {
                $payload = array(
                    "error" => array(
                        "message" => "Não foi possível criar a conta"
                    )
                );
            }
        }
        else {
            //update account if exist
            //sum amount with balance
            $destination->setBalance($destination->getBalance() + $amount);
            $account = $daoAccount->updateAccount($destination);

            if($account) {
                $payload = array(
                    "destination" => array(
                        "id"        => $account->getId(),
                        "balance"   => $account->getBalance(),
                    )
                );
            }
            else {
                $payload = array(
                    "error" => array(
                        "message" => "Não foi possível atualizar a conta"
                    )
                );
            }
        }
        return $payload;
    }
}