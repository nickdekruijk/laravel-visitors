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

    public function scopeFiltered($query)
    {
        $query->where('javascript', 1)->orWhere('pixel', 1);
    }

    public function getHardwareAttribute()
    {
        return $this->desktop ? 'Desktop' : ($this->tablet ? 'Tablet' : 'Mobile');
    }
}
