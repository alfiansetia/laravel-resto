<?php

namespace Database\Seeders;

use App\Models\Catmenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Catmenu::create([
            'name'      => 'Makanan',
            'desc'      => '',
        ]);
        Catmenu::create([
            'name'      => 'Minuman',
            'desc'      => '',
        ]);
        Catmenu::create([
            'name'      => 'Other',
            'desc'      => '',
        ]);
    }
}
