<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catmenu extends Model
{
    use HasFactory;
    protected $table = 'catmenu';

    protected $fillable = [
        'name',
        'desc',
    ];

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
