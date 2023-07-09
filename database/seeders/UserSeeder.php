<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => "mukan",
            'role' => "admin",
            'phone' => "+919982158760",
            'email' => 'mukan@gmail.com',
            'password' => Hash::make('Admin@007@'),
        ],
        [
            'name' => "sumer",
            'role' => "customer",
            'phone' => "+919636200102",
            'email' => 'sumer@gmail.com',
            'password' => Hash::make('Admin@007@'),
        ]]);
    }
}
