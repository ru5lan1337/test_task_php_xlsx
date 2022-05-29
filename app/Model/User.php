<?php

namespace App\Model;


class User
{
    private $id;
    private $fullName;
    private $startBalance;
    private $balance;
    private $transactions;
    private static $excelNaming = ['id', 'fullName', 'startBalance'];
    private static $excelNumSheet = 0;

<<<<<<< HEAD
    public function __construct($id, $fullName, $startBalance)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->startBalance = $startBalance;
=======
    public function __construct()
    {
>>>>>>> refactor-by-24yo
    }

    public function calculateBalance()
    {
        $this->balance = $this->startBalance;
        foreach ($this->transactions as $transaction) {
            $this->balance += $transaction->getSum();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function addTransaction($transaction)
    {
        $this->transactions[] = $transaction;
    }

    public static function getExcelNaming()
    {
        return self::$excelNaming;
    }

    public static function getExcelNumSheet()
    {
        return self::$excelNumSheet;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> refactor-by-24yo
