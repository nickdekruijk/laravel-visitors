<?php

namespace NickDeKruijk\LaravelVisitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public function __construct()
    {
        // Set database connection
        $this->connection = config('visitors.db_connection');

        // Set table name
        $this->table = config('visitors.table_prefix') . 'visitors';
    }

    protected $guarded = [
        'id',
    ];

    public function scopeValid($query)
    {
        return $query->whereNull('robot');
    }
}
