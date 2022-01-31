<?php
namespace Bank\Models;
use Bank\Dao\DaoAccount;


class ModelAccount
{

    /**
     * @param string $destination
     * @param double $amount
     * @return array $payload
     */
    public function deposit($destination_id, $amount = 0)
    {
        //find account by id
        $daoAccount = new DaoAccount();
        $destination = $daoAccount->getAccount($destination_id);

        if(!$destination) {
            //create account if not exist
            if($daoAccount->insertAccount($destination_id, $amount)) {
                $payload = array(
                    "destination" => array(
                        "id"        => $destination_id,
                        "balance"   => $amount,
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
            if($daoAccount->updateAccount($destination)) {
                $payload = array(
                    "destination" => array(
                        "id"        => $destination->getId(),
                        "balance"   => $destination->getBalance(),
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


    /**
     * @param string $origin_id
     * @param double $amount
     * @return array|false $payload
     */
    public function withdraw($origin_id, $amount = 0)
    {
        //find account by id
        $daoAccount = new DaoAccount();
        $origin = $daoAccount->getAccount($origin_id);

        if($origin) {
            //create account if not exist
            $balance = $origin->getBalance() - $amount;
            if($balance >= 0) {
                $origin->setBalance($balance);
                if($daoAccount->updateAccount($origin)) {
                    $payload = array(
                        "origin" => array(
                            "id"        => $origin_id,
                            "balance"   => $balance,
                        )
                    );
                }
                else {
                    $payload = array(
                        "error" => array(
                            "message" => "Não foi possível realizar a transação"
                        )
                    );
                }

            }
            else {
                $payload = array(
                    "error" => array(
                        "message" => "Não há saldo suficiente para realizar esta transação, seu saldo: R$".$origin->getBalance()
                    )
                );
            }
        }
        else {
            $payload = false;
        }
        return $payload;
    }
}