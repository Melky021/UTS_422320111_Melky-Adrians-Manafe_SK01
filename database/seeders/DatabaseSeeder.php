<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan: master/parent dulu, baru child yang butuh foreign key.
        $this->call([
            KelompokTanamanSeeder::class,
            PerlakuanPenyimpananSeeder::class,
            AksesiBenihSeeder::class,
        ]);
    }
}
