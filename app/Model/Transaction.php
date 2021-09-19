<?php


namespace App\Model;


class Transaction
{
    private $id;
    private $sum;
    private static $excelNaming = ['id', 'sum'];
    private static $excelNumSheet = 1;

    public function __construct($id, $sum)
    {
        $this->userId = $id;
        $this->sum = $sum;
    }

    public function getUserId()
    {
        return $this->id;
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