<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'table_id',
        'user_id',
        'date',
        'category',
        'status',
        'desc',
    ];

    use HasFactory;

    public function dtorder()
    {
        return $this->hasMany(Dtorder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
