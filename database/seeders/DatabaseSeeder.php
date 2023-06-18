<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('forms')->truncate();

    }
}

/*
        DB::table('orders')->truncate();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'info@ikatech.tech',
            'password' => Hash::make('7G9r4k#Y%u@2'), // Şifreyi hashleyerek kaydediyoruz
        ]);
*/
/*

*/