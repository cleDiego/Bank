<?php
namespace Bank\Models;
use Bank\Dao\DaoAccount;

class ModelAccount
{

    /**
     * @param string $origin_id
     * @param double $amount
     * @return array|false $payload
     */
    public function balance($account_id)
    {
        //find account by id
        $daoAccount = new DaoAccount();
        $account = $daoAccount->getAccount($account_id);
        if($account) {
            return $account->getBalance();
        }
        else {
            return false;
        }

    }

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
            //Withdraw
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

    /**
     * @param string $origin_id
     * @param string $destionation_id
     * @param double $amount
     * @return array|false $payload
     */
    public function transfer($origin_id, $destination_id, $amount = 0)
    {
        //find account by id
        $daoAccount = new DaoAccount();
        $origin = $daoAccount->getAccount($origin_id);
        if($origin) {
            //Transfer
            $withdraw_origin = $this->withdraw($origin_id, $amount);
            if(!$withdraw_origin['error']) {
              $deposit_destination = $this->deposit($destination_id, $amount);
              if(!$deposit_destination['error']) {
                $payload = array(
                    "origin" => array(
                        "id"        => $origin_id,
                        "balance"   => $this->balance($origin_id),
                    ),
                    "destination" => array(
                        "id"        => $destination_id,
                        "balance"   => $this->balance($destination_id),
                    )
                );
              }
              else {
                //deposit into destination error, give back amount to origin
                $give_back = $this->deposit($origin_id, $amount);
                $payload = $deposit_destination;
              }
            }
            else {
              $payload = $withdraw_origin;
            }
        }
        else {
            $payload = false;
        }
        return $payload;
    }
}