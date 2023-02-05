<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtorder extends Model
{
    protected $table = 'dtorder';

    protected $fillable = [
        'order_id',
        'menu_id',
        'price',
        'total',
    ];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
