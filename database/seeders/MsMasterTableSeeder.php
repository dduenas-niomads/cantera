<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MsMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'ALFA ROMEO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'AUDI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'BMW',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'FORD',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'HONDA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'HYUNDAI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'JEEP',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'KIA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'LEXUS',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'MAZDA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'MITSUBISHI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'NISSAN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'TOYOTA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ms_masters')->insert([
            'tag' => 'brand',
            'name' => 'VOLKSWAGEN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
