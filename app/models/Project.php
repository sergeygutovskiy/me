<?php

namespace App\Models;
use App\Core\Model;

class Project extends Model 
{
    public static string $table = 'portfolio';

    public static function sort_by_published_at_date(Project $a, Project $b)
    {
        return date($a->published_at) > date($b->published_at) ? -1 : 1;
    }
}