<?php

namespace Database\Seeders;

use App\Models\Catmenu;
use App\Models\Menu;
use App\Models\Menulog;
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
        $menus = [
            ['name' => 'Nasi Goreng', 'category' => 'Makanan', 'price' => 20000],
            ['name' => 'Mie Goreng', 'category' => 'Makanan', 'price' => 18000],
            ['name' => 'Nasi Padang', 'category' => 'Makanan', 'price' => 25000],
            ['name' => 'Bakso', 'category' => 'Makanan', 'price' => 15000],
            ['name' => 'Mie Ayam', 'category' => 'Makanan', 'price' => 12000],
            ['name' => 'Sate Ayam', 'category' => 'Makanan', 'price' => 25000],
            ['name' => 'Es Teh', 'category' => 'Minuman', 'price' => 5000],
            ['name' => 'Es Jeruk', 'category' => 'Minuman', 'price' => 7000],
            ['name' => 'Kopi', 'category' => 'Minuman', 'price' => 8000],
            ['name' => 'Teh', 'category' => 'Minuman', 'price' => 5000],
            ['name' => 'Jus Alpukat', 'category' => 'Minuman', 'price' => 12000],
            ['name' => 'Jus Mangga', 'category' => 'Minuman', 'price' => 10000],
            ['name' => 'Brownies', 'category' => 'Other', 'price' => 15000],
            ['name' => 'Pudding', 'category' => 'Other', 'price' => 10000],
            ['name' => 'Salad Buah', 'category' => 'Other', 'price' => 18000],
            ['name' => 'Roti Bakar', 'category' => 'Other', 'price' => 12000],
            ['name' => 'Martabak', 'category' => 'Other', 'price' => 25000],
            ['name' => 'Pizza', 'category' => 'Other', 'price' => 30000],
            ['name' => 'Pancake', 'category' => 'Other', 'price' => 12000],
            ['name' => 'Susu Kedelai', 'category' => 'Minuman', 'price' => 9000],
            ['name' => 'Sate Kambing', 'category' => 'Makanan', 'price' => 35000],
            ['name' => 'Soto Ayam', 'category' => 'Makanan', 'price' => 18000],
            ['name' => 'Nasi Uduk', 'category' => 'Makanan', 'price' => 20000],
            ['name' => 'Gado-Gado', 'category' => 'Makanan', 'price' => 22000],
            ['name' => 'Pecel', 'category' => 'Makanan', 'price' => 18000],
            ['name' => 'Kerupuk Udang', 'category' => 'Other', 'price' => 8000],
            ['name' => 'Rendang', 'category' => 'Makanan', 'price' => 35000],
        ];

        foreach ($menus as $menu) {
            $m = Menu::create([
                'name'          => $menu['name'],
                'catmenu_id'    => Catmenu::firstOrCreate([
                    'name' => $menu['category']
                ])->id,
                'price'         => $menu['price'],
                'stock'         => 10,
                'desc'          => '',
            ]);
            Menulog::create([
                'menu_id'   => $m->id,
                'user_id'   => 1,
                'date'      => date("Y-m-d H:i:s"),
                'message'   => 'Menu created',
            ]);
        }
    }
}
