<?php

namespace App\Core;

class Storage {
    private static string $root = '/images/storage/';

    public static function save($file, $path) : bool 
    {
        $name = $file['name'];
        
        return move_uploaded_file(
            $file['tmp_name'], 
            $_SERVER['DOCUMENT_ROOT'] 
                . static::$root 
                . $path 
                . '/' 
                . $name
        );
    } 

    public static function get($path) : array
    {
        return array_values( 
            array_diff(
                scandir($_SERVER['DOCUMENT_ROOT'] . static::$root . $path),
                ['.', '..']
            )
        );
    }

    public static function delete($path, $name) : bool
    {
        return unlink(
            $_SERVER['DOCUMENT_ROOT'] . static::$root . $path . '/' . $name
        );
    }
}