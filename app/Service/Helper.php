<?php


namespace App\Service;


class Helper
{
    public static function getStrByKeyArray($arr){
        $keysStr = '';
        foreach ($arr as $key => $value) {
            $keysStr .= $key . ' ';
        }
        return $keysStr;
    }
}