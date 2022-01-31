<?php
namespace Bank\Dao;
use Bank\Beans\Account;

class DaoAccount
{
    public function getAccount($id) {
        if(isset($_SESSION['accounts'][$id])) {
            $account = new Account($id);
            $account->setBalance($_SESSION['accounts'][$id]['balance']);
            return $account;
        }
        else {
            return false;
        }
    }

    public function insertAccount($id, $amount = 0) {
        $account = new Account($id, $amount);
        if($account) {
            $_SESSION['accounts'][$id]['balance'] = $amount;
            return true;
        }
        else {
            return false;
        }
    }

    public function updateAccount(Account $account) {
        $id = $account->getId();
        $balance = $account->getBalance();

        if(isset($_SESSION['accounts'][$id])) {
            $_SESSION['accounts'][$id]['balance'] = $balance;
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteAccount(Account $account) {
        $id = $account->getId();
        if(isset($_SESSION['accounts'][$id])) {
            unset($_SESSION['accounts'][$id]);
            return true;
        }
        else {
            return false;
        }
    }
}