<?php


namespace App\Model;


class Transaction
{
    private $userId;
    private $sum;
<<<<<<< HEAD
    private static $excelNaming = ['id', 'sum'];
    private static $excelNumSheet = 1;

    public function __construct($id, $sum)
    {
        $this->userId = $id;
        $this->sum = $sum;
=======
    private static $excelNaming = ['userId', 'sum'];
    private static $excelNumSheet = 1;

    public function __construct()
    {
>>>>>>> refactor-by-24yo
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
<<<<<<< HEAD
}
=======
}
>>>>>>> refactor-by-24yo
