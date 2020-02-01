<?php

namespace App;

class Route
{
    public static function rules()
    {
        return [
            '/' => 'ExcelController@index',
            '/upload' => 'ExcelController@upload',
        ];
    }
}