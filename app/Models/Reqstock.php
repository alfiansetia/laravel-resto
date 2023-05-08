<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reqstock extends Model
{
    use HasFactory;
    protected $table = 'reqstock';

    protected $fillable = [
        'reqstock_id',
        'menu_id',
        'qty',
    ];

    public function dtreqstock()
    {
        return $this->hasMany(Dtreqstock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stateby()
    {
        return $this->belongsTo(User::class, 'stateby_id');
    }
}
