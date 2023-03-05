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
            'name'      => 'makanan',
            'status'    => 'active',
            'desc'      => '',
        ]);
        Catmenu::create([
            'name'      => 'minuman',
            'status'    => 'active',
            'desc'      => '',
        ]);
        Catmenu::create([
            'name'      => 'other',
            'status'    => 'active',
            'desc'      => '',
        ]);
    }
}
