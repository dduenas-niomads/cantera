<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cars')->insert([
            'brand' => 'AUDI',
            'model' => 'A6',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2015',
            'model_year' => '2015',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'AUDI',
            'model' => 'Q5',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'PLATEADO',
            'fab_year' => '2017',
            'model_year' => '2017',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'BMW',
            'model' => '114 I',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2012',
            'model_year' => '2012',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'BMW',
            'model' => 'X5 40I',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'AZUL',
            'fab_year' => '2019',
            'model_year' => '2019',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'HONDA',
            'model' => 'ODYSSEY',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'DORADO',
            'fab_year' => '2015',
            'model_year' => '2015',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'HYUNDAI',
            'model' => 'GRAND SANTA FE',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'PLATEADO',
            'fab_year' => '2015',
            'model_year' => '2015',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'KIA',
            'model' => 'RIO LX MT',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'NEGRO',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'LEXUS',
            'model' => 'IS200T',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2017',
            'model_year' => '2017',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'MAZDA',
            'model' => '3 HIGH AT',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'ROJO',
            'fab_year' => '2020',
            'model_year' => '2020',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'MAZDA',
            'model' => 'CX-5 HICH',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'ROJO',
            'fab_year' => '2020',
            'model_year' => '2020',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'AUDI',
            'model' => 'A6',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2015',
            'model_year' => '2015',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'MITSUBISHI',
            'model' => 'ASX GLS',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'GRIS',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'NISSAN',
            'model' => 'NP300 FRONTIER',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'AZUL',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'TOYOTA',
            'model' => 'FORTUNER',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'VOLKSWAGEN',
            'model' => 'TIGUAN',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'VERDE OLIVO',
            'fab_year' => '2020',
            'model_year' => '2020',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'VW',
            'model' => 'TRANSPORTER',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'GRIS',
            'fab_year' => '2017',
            'model_year' => '2017',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'JEEP',
            'model' => 'G-C LIMITED 4X4',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'GRIS',
            'fab_year' => '2012',
            'model_year' => '2012',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'KIA',
            'model' => 'CARNIVAL EX FULL',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2019',
            'model_year' => '2019',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'AUDI',
            'model' => 'Q5 ATTRACTION',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('cars')->insert([
            'brand' => 'BMW',
            'model' => '520I BERLINA',
            'number' => strtoupper(Str::random(6)),
            'ref_number' => strtoupper(Str::random(6)),
            'color' => 'BLANCO',
            'fab_year' => '2018',
            'model_year' => '2018',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
