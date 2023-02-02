<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = User::create([
            'name'              => 'Alfian',
            'email'             => 'admin@gmail.com',
            'password'          => Hash::make('admin12345'),
            'wa'                => '62823555445',
            'address'           => 'Bekasi',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $admin->assignRole('admin');
        
        $kasir = User::create([
            'name'              => 'Alfi',
            'email'             => 'kasir@gmail.com',
            'password'          => Hash::make('kasir12345'),
            'wa'                => '6522555888',
            'address'           => 'Wajo',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $kasir->assignRole('kasir');

    }
}
