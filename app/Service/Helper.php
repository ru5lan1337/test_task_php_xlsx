<?php


namespace App\Service;


class Helper
{
    public static function getStrArray($arr){
        $str = '';
        foreach ($arr as $value) {
            $str .= $value . ' ';
        }
        return $str;
    }
}