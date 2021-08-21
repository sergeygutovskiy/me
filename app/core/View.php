<?php

namespace App\Core;

class View 
{
    private static $renderer;

    public static function init($renderer) : void 
    {
        static::$renderer = $renderer;
    }

    public static function render(string $name, array $variables = []) : void 
    {
        echo static::$renderer->render($name, $variables);
    }
}