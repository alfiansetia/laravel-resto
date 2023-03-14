<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Menulog;
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
        $a = Menu::create([
            'name'          => 'Ayam Goreng Iga Mekkah',
            'catmenu_id'    => 1,
            'price'         => 16000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $a->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);

        $b = Menu::create([
            'name'          => 'Ayam Bakar Syafaat Ummat',
            'catmenu_id'    => 1,
            'price'         => 16000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $b->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);

        $c = Menu::create([
            'name'          => 'Es Teh Jannah',
            'catmenu_id'    => 2,
            'price'         => 10000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $c->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);
        $d = Menu::create([
            'name'          => 'Es Jeruk Kebajikan',
            'catmenu_id'    => 2,
            'price'         => 10000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $d->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);
        $e = Menu::create([
            'name'          => 'Tempe Geprek',
            'catmenu_id'    => 3,
            'price'         => 2000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $e->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);
        $f = Menu::create([
            'name'          => 'Tahu Krispi Gurun',
            'catmenu_id'    => 3,
            'price'         => 2000,
            'stock'         => 10,
            'desc'          => '',
        ]);
        Menulog::create([
            'menu_id'   => $f->id,
            'user_id'   => 1,
            'date'      => date("Y-m-d H:i:s"),
            'message'   => 'Product created',
        ]);

        for ($i = 0; $i < 100; $i++) {
            $g = Menu::create([
                'name'          => 'Sample Menu ke ' . $i,
                'catmenu_id'    => 3,
                'price'         => 2000,
                'stock'         => 10,
                'desc'          => '',
            ]);
            Menulog::create([
                'menu_id'   => $g->id,
                'user_id'   => 1,
                'date'      => date("Y-m-d H:i:s"),
                'message'   => 'Product created',
            ]);
        }
    }
}
