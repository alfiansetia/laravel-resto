<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'table';
    use HasFactory;
    protected $fillable = [
        'number',
        'status',
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
