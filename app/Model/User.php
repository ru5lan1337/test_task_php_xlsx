<?php

namespace App\Model;


class User
{
    public $id;
    public $fullName;
    public $startBalance;
    public $balance;
    public $transactions;
    private static $excelNaming = ['id', 'fullName', 'startBalance'];
    private static $excelNumSheet = 0;

    public function __construct()
    {
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
}
