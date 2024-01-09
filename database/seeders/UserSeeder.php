<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create(
            [
                'firstname'=>'sadmin',
                'lastname'=>'sadmin',
                'email'=>'sadmin@gmail.com',
                'number'=>1234567890,
                'role'=>2,
                'status'=>1,
                'password'=>\Hash::make('sadmin')
            ]);
    }
}
