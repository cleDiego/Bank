<?php
namespace Bank\Models;

class Account
{

    private $id;
    private $amount;
    private $balance;

    public function __construct($id = null, $amount = 0)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function geAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount = 0)
    {
        $this->amount = $amount;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance = 0)
    {
        $this->balance = $balance;
    }

}