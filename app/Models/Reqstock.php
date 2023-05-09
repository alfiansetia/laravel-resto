<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reqstock extends Model
{
    use HasFactory;
    protected $table = 'reqstock';

    protected $fillable = [
        'number',
        'user_id',
        'stateby_id',
        'type',
        'status',
        'date',
        'date_state',
        'desc',
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
