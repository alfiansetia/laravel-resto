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
        'desc',
    ];

    public function getImgAttribute($value)
    {
        if ($value) {
            return url('/images/menu/' . $value);
        } else {
            return url('/images/menu/default/default.png');
        }
    }

    public function catmenu()
    {
        return $this->belongsTo(Catmenu::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function dtorder()
    {
        return $this->hasOne(Dtorder::class);
    }

    public function menulog()
    {
        return $this->hasMany(Menulog::class)->orderBy('date', 'DESC');
    }
}
