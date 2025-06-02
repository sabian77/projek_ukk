<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use Faker\Factory as Faker;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_IND');
        
        for ($i = 0; $i < 2 ; $i++){
            Guru::create([
                'nama' => $faker->name,
                'nip' => $faker->unique()->numberBetween(100000000000000000, 999999999999999999),
                'gender' => $i % 2 === 0 ? 'L' : 'P',
                'alamat' => $faker->address,
                'kontak' => '08' . rand(1000000000, 9999999999),
                'email' => $faker->unique()->userName . '@gmail.com',
            ]);
        }

    }
}
