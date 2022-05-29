<?php


namespace App\Model;


class Transaction
{
    private $userId;
    private $sum;
    private static $excelNaming = ['userId', 'sum'];
    private static $excelNumSheet = 1;

    public function __construct()
    {
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getSum()
    {
        return $this->sum;
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
