<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';

    protected $fillable = [
        'name',
        'catmenu_id',
        'img',
        'price',
        'disc',
        'stock',
        'status',
        'desc',
    ];

    public function catmenu()
    {
        return $this->belongsTo(Catmenu::class);
    }

    public function menu()
    {
        return $this->hasOne(Cart::class);
    }

    public function dtorder()
    {
        return $this->hasOne(Dtorder::class);
    }
}
