<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(1, 2);
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 20; $i++) {
            $typeValue = array_rand($types, 1);
            if ($typeValue === 1) {
                $typesOfDocument = array("01", "04", "07");
                $typeDocument = array_rand($typesOfDocument, 1);
                $names = $faker->firstname;
                $firstLastname = $faker->lastname;
                $secondLastname = $faker->lastname;
                DB::table('clients')->insert([
                    'type' => $typeValue,
                    'type_document' => $typesOfDocument[$typeDocument],
                    'document_number' => rand(11111111, 99999999),
                    'name' => $names . ' ' . $firstLastname . ' ' . $secondLastname,
                    'names' => $names,
                    'first_lastname' =>  $firstLastname,
                    'second_lastname' =>  $secondLastname,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $rzSocial = strtoupper(Str::random(5)) . ' ' . $faker->state;
                DB::table('clients')->insert([
                    'type' => 2,
                    'type_document' => "06",
                    'document_number' => rand(11111111111, 99999999999),
                    'name' => $rzSocial,
                    'rz_social' =>  $rzSocial,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
