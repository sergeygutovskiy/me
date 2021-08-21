<?php

namespace App\Core;
use App\Core\DB;

class Settings 
{
    private static array $settings = [];

    public static function init() : void 
    {
        $query_string = 'SELECT * FROM settings';
        $raw_results = DB::query($query_string);

        while ($result = $raw_results->fetch())
        {
            static::$settings[ $result['param'] ] = [
                'id' => $result['id'],
                'value' => $result['value'],
            ];
        }
    }

    public static function get($index) : string
    {
        return static::$settings[$index]['value'];
    }
}