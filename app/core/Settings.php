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
                'param' => $result['param'],
                'value' => $result['value'],
                'name' => $result['name']
            ];
        }
    }

    public static function get($index) : string
    {
        return static::$settings[$index]['value'];
    }

    public static function all() : array
    {
        return static::$settings;
    }
}