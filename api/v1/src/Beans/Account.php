<?php
namespace Bank\Beans;

class Account
{
    /**
     * The account id.
     *
     * @var string
     */
    private $id;

    /**
     * Account balance, this id the amount available in the account.
     *
     * @var string
     */
    private $balance;

    /**
     * @param string $id
     * @param double $balance
     */
    public function __construct($id = null, $balance = 0)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return double $balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param double $balance
     */
    public function setBalance($balance = 0)
    {
        $this->balance = $balance;
    }

}