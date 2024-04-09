<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@hi.nepal',
            'password' => bcrypt('admin123'),
             'phone' => 1234567890,
             'role' => "admin"
        ]);
    }
}
