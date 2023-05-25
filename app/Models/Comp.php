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
        'address',
        'logo',
        'fav',
        'telp',
        'wa',
        'fb',
        'ig',
        'logo',
        'footer_struk',
        'tax',
    ];

    public function getLogoAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/logo.png');
        }
    }

    public function getFavAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/favicon.ico');
        }
    }
}
