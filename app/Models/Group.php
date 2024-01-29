<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Group extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'short_name' => 1,
            'name' => 1,
        ]
    ];

    protected $connection = 'mysql_info';
}
