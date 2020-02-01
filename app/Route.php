<?php

namespace App;

class Route
{
    public static function rules()
    {
        return [
            '/' => 'MainController@index'
        ];
    }
}