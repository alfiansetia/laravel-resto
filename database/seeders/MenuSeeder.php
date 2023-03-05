<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Menu::create([
            'name'          => 'Ayam Goreng',
            'catmenu_id'    => 1,
            'price'         => 16000,
            'stock'         => 10,
            'desc'          => '',
        ]);

        Menu::create([
            'name'          => 'Es Teh',
            'catmenu_id'    => 2,
            'price'         => 10000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menu::create([
            'name'          => 'Tempe',
            'catmenu_id'    => 3,
            'price'         => 2000,
            'stock'         => 10,
            'desc'          => '',
        ]);
    }
}
