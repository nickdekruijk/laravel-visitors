<?php

namespace NickDeKruijk\LaravelVisitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public function __construct()
    {
        $this->connection = config('visitors.db_connection');
    }

    protected $guarded = [
        'id',
    ];
}
