<?php

namespace App\Core;
use PDO;

class DB 
{
    private static $pdo = null;

    public static function connect(string $host, string $user, string $password, string $db) 
    {
        $dsn = "mysql:host=$host;dbname=$db";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try 
        {
            static::$pdo = new PDO($dsn, $user, $password, $opt);
        } 
        catch (PDOException $e) 
        {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public static function update_query(string $table, array $fields, int $id) : bool 
    {
        $query_string = 'UPDATE ' . $table . ' SET ';
        
        foreach ($fields as $index => $value)
        {
            $query_string .= $index . ' = ?';
            $query_string .= ($index === array_key_last($fields)) ? '' : ', '; 
        }
        
        $query_string .= ' WHERE id = ' . $id;

        $prepared_query = static::$pdo->prepare($query_string);
        return $prepared_query->execute(array_values( $fields)); 
    }

    public static function insert_query(string $table, array $fields) : int
    {
        $query_string = 'INSERT INTO ' . $table . ' ';
        $query_string .= '(' . implode(', ', array_keys($fields)) . ') ';
        
        $query_string .= 'VALUES(';
        for ($i = 0; $i < count($fields) - 1; $i++) { $query_string .= '?, '; }
        $query_string .= '?)';

        $prepared_query = static::$pdo->prepare($query_string);
        $prepared_query->execute(array_values($fields)); 
    
        return static::$pdo->lastInsertId();
    }

    public static function delete_query(string $table, int $id) : bool
    {
        $query_string = 'DELETE FROM ' . $table . ' WHERE id = ' . $id;
        return (bool) static::$pdo->query($query_string);
    }

    public static function query(string $query_string) 
    {
        $query = static::$pdo->query($query_string);
        return $query;
    }
}
