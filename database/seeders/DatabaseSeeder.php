<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //memanggil seeder siswa
        $this->call(SiswaSeeder::class);

        //memanggil sedder guru
        $this->call(GuruSeeder::class);
    }
}
