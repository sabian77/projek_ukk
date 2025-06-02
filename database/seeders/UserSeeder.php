<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name'     => Str::random(10),
                'email'    => rand(20000, 20560) . '@sija.com',
                'password' => bcrypt('12345678'),
            ]);

            $user->assignRole('siswa');
        }
    }
}
