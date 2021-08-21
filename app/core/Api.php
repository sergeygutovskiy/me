<?php

namespace App\Core;

class Api 
{
    static public function response(?array $data, int $status) : string
    {
        header('Content-Type: application/json');
        
        return json_encode([
            'status' => $status,
            'data' => $data,
        ]); 
    }

    static function good_response(array $data = []) : string 
    {
        return static::response($data, 1);
    } 

    static function bad_response() : string 
    {
        return static::response(null, 0);
    } 
}