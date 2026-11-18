<?php

namespace Database\Seeders;

use App\Models\PerlakuanPenyimpanan;
use Illuminate\Database\Seeder;

class PerlakuanPenyimpananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pengeringan (kadar air 5-8%)', 'deskripsi' => 'Benih dikeringkan hingga kadar air aman untuk disimpan.'],
            ['nama' => 'Penyimpanan Suhu Dingin 4°C', 'deskripsi' => 'Disimpan pada ruang pendingin untuk jangka menengah.'],
            ['nama' => 'Penyimpanan Beku -18°C', 'deskripsi' => 'Disimpan pada freezer untuk jangka panjang (koleksi dasar).'],
            ['nama' => 'Silika Gel', 'deskripsi' => 'Penyerap kelembapan dalam wadah tertutup.'],
            ['nama' => 'Kemasan Vakum Aluminium Foil', 'deskripsi' => 'Kemasan kedap udara dan cahaya.'],
            ['nama' => 'Pelindung Hayati (abu/daun nimba)', 'deskripsi' => 'Perlindungan alami terhadap hama gudang.'],
        ];

        foreach ($data as $row) {
            PerlakuanPenyimpanan::updateOrCreate(['nama' => $row['nama']], $row);
        }
    }
}
