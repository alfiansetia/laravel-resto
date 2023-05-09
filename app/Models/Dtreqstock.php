<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtreqstock extends Model
{
    use HasFactory;
    protected $table = 'dtreqstock';
    protected $fillable = [
        'reqstock_id',
        'menu_id',
        'type',
        'qty',
    ];

    public function reqstock(){
        return $this->belongsTo(Reqstock::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
