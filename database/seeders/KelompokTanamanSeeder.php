<?php

namespace Database\Seeders;

use App\Models\KelompokTanaman;
use Illuminate\Database\Seeder;

class KelompokTanamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'PDI', 'nama' => 'Padi', 'deskripsi' => 'Varietas lokal padi sawah dan padi gogo.'],
            ['kode' => 'JGG', 'nama' => 'Jagung', 'deskripsi' => 'Jagung pulut, jagung putih, dan jagung manis lokal.'],
            ['kode' => 'KCG', 'nama' => 'Kacang-kacangan', 'deskripsi' => 'Kedelai, kacang tunggak, dan kacang lokal lainnya.'],
            ['kode' => 'SYR', 'nama' => 'Sayuran', 'deskripsi' => 'Cabai, terong, dan sayuran buah lokal.'],
            ['kode' => 'UMB', 'nama' => 'Umbi-umbian', 'deskripsi' => 'Ubi jalar, talas, dan umbi lokal.'],
        ];

        foreach ($data as $row) {
            KelompokTanaman::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
