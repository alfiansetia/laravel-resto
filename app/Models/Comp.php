<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp extends Model
{
    use HasFactory;

    protected $table = 'comp';

    protected $fillable = [
        'name',
        'slogan',
        'address',
        'logo',
        'fav',
        'telp',
        'wa',
        'fb',
        'ig',
        'logo',
    ];
}
