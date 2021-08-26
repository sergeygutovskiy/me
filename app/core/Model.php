<?php

namespace App\Core;

class Model 
{

    public static string $table;

    public function update(array $fields) : bool 
    {
        return DB::update_query(static::$table, $fields, $this->id);
    }

    public function delete() : bool
    {
        return DB::delete_query(static::$table, $this->id);
    }

    public static function all() : array 
    {
        $models_result = DB::query('SELECT * FROM ' . static::$table);

        $models = [];
        while ($row = $models_result->fetch()) { $models[] = static::fetch($row); }

        return $models;
    }

    public static function id(string $id) : ?static 
    {
        return static::key('id', $id);
    }

    public static function slug(string $slug) : ?static 
    {
        return static::key('slug', $slug);
    }

    private static function key(string $key, string $value) : ?static 
    {
        $model_result = DB::query('SELECT * FROM ' . static::$table . ' WHERE ' . $key . ' = ' . "'$value'");

        $row = $model_result->fetch();
        return static::fetch($row);
    }

    public static function create(array $fields) : static
    {
        $fields['created_at'] = date('Y-m-d H:i:s', time());

        $id = DB::insert_query(static::$table, $fields);
        $model = new static();

        $model->id = $id;            
        foreach ($fields as $key => $value) $model->{$key} = $value;

        return $model;
    }

    protected static function fetch($row) : ?static 
    {
        if ($row === false) return null;
        
        $model = new static();
        foreach ($row as $key => $value) { $model->{$key} = $value; }

        return $model;
    }

    protected static function foreign_children(string $primary_column, string $primary_column_value) : array 
    {    
        $models_result = DB::query(
            'SELECT * FROM ' . static::$table 
            . ' WHERE ' . $primary_column . '=' . $primary_column_value
        );

        $models = [];
        while ($row = $models_result->fetch()) { $models[] = static::fetch($row); }

        return $models;
    }

    public static function sort_by_created_at_date(Model $a, Model $b)
    {
        return date($a->created_at) > date($b->created_at) ? -1 : 1;
    }
}
