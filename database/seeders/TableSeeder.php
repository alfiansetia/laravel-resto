<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['free', 'booked', 'nonactive'];
        // for ($i = 1; $i < 100; $i++) {
        //     Table::create([
        //         'number'    => $i,
        //         'name'      => $i,
        //         'status'    => $status[array_rand($status)],
        //         'desc'      => '',
        //     ]);
        // }
        for ($i = 1; $i <= 100; $i++) {
            Table::create([
                'number'    => $i,
                'name'      => $i,
                'status'    => 'free',
                'desc'      => '',
            ]);
        }
    }
}
