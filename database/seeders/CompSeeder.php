<?php

namespace Database\Seeders;

use App\Models\Comp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Comp::create([
            'name'      => 'Ani Resto',
            'slogan'    => 'Murah Enak Berkualitas',
            'address'   => 'Jl Mbah pojok No 36',
            'telp'      => '082324129752',
            'wa'        => '6282324129752',
            'ig'        => 'aniresto',
            'fb'        => 'aniresto',
        ]);
    }
}
