<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Key;

class API_KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $faker = \Faker\Factory::create();

        $key = md5(time() . rand());
        $api_key = Key::create([
            'key' => $key,
            'expiration_date' => $faker->date('2099-12-31'),
            'owner_id' => 1
        ]);
    }
}
