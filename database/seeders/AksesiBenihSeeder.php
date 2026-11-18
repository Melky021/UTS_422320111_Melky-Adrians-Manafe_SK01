<?php

namespace Database\Seeders;

use App\Models\KelompokTanaman;
use App\Models\PerlakuanPenyimpanan;
use App\Services\AksesiBenihService;
use Illuminate\Database\Seeder;

class AksesiBenihSeeder extends Seeder
{
    public function run(AksesiBenihService $service): void
    {
        $kelompok  = KelompokTanaman::pluck('id', 'kode');
        $perlakuan = PerlakuanPenyimpanan::pluck('id', 'nama');

        $p = fn (array $namaList) => collect($namaList)->map(fn ($n) => $perlakuan[$n])->all();

        $rows = [
            ['PDI', 'PDI-001', 'Pandanwangi', 'Oryza sativa', 850, 'tersimpan',
                ['Warungkondang', 'Warungkondang', 'Cianjur', 'Jawa Barat', '2024-03-12', 'Ahmad Fauzi', 450],
                ['Pengeringan (kadar air 5-8%)', 'Penyimpanan Suhu Dingin 4°C']],
            ['PDI', 'PDI-002', 'Rojolele Srinuk', 'Oryza sativa', 620, 'tersimpan',
                ['Srinuk', 'Delanggu', 'Klaten', 'Jawa Tengah', '2024-05-20', 'Siti Rahayu', 160],
                ['Pengeringan (kadar air 5-8%)', 'Silika Gel']],
            ['PDI', 'PDI-003', 'Padi Gogo Kerinci', 'Oryza sativa', 90, 'perlu_regenerasi',
                ['Siulak Mukai', 'Gunung Kerinci', 'Kerinci', 'Jambi', '2023-08-02', 'Budi Hartono', 1200],
                ['Penyimpanan Beku -18°C']],
            ['JGG', 'JGG-001', 'Jagung Pulut Madura', 'Zea mays', 400, 'tersimpan',
                ['Batuan', 'Batuan', 'Sumenep', 'Jawa Timur', '2024-09-15', 'Hasan Basri', 35],
                ['Pengeringan (kadar air 5-8%)', 'Kemasan Vakum Aluminium Foil']],
            ['JGG', 'JGG-002', 'Jagung Putih Gorontalo', 'Zea mays', 0, 'habis',
                ['Tilango', 'Tilango', 'Gorontalo', 'Gorontalo', '2022-11-10', 'Rina Pakaya', 20],
                []],
            ['KCG', 'KCG-001', 'Kacang Tunggak Gunungkidul', 'Vigna unguiculata', 310, 'tersimpan',
                ['Semanu', 'Semanu', 'Gunungkidul', 'DI Yogyakarta', '2025-02-08', 'Wahyu Nugroho', 180],
                ['Silika Gel', 'Pelindung Hayati (abu/daun nimba)']],
            ['KCG', 'KCG-002', 'Kedelai Hitam Ponorogo', 'Glycine max', 275.5, 'tersimpan',
                ['Sambit', 'Sambit', 'Ponorogo', 'Jawa Timur', '2025-04-21', 'Lestari Wulan', 120],
                ['Penyimpanan Suhu Dingin 4°C', 'Kemasan Vakum Aluminium Foil']],
            ['SYR', 'SYR-001', 'Cabai Rawit Hiyung', 'Capsicum frutescens', 45.25, 'perlu_regenerasi',
                ['Hiyung', 'Tapin Tengah', 'Tapin', 'Kalimantan Selatan', '2023-12-01', 'Norhasanah', 15],
                ['Penyimpanan Beku -18°C', 'Silika Gel']],
            ['SYR', 'SYR-002', 'Terong Ungu Lembang', 'Solanum melongena', 60, 'tersimpan',
                ['Cikole', 'Lembang', 'Bandung Barat', 'Jawa Barat', '2025-06-30', 'Dedi Mulyadi', 1250],
                ['Pengeringan (kadar air 5-8%)']],
            ['UMB', 'UMB-001', 'Ubi Jalar Cilembu', 'Ipomoea batatas', 150, 'tersimpan',
                ['Cilembu', 'Pamulihan', 'Sumedang', 'Jawa Barat', '2025-01-18', 'Yayat Sudrajat', 700],
                ['Penyimpanan Suhu Dingin 4°C']],
        ];

        foreach ($rows as [$kode, $kodeAksesi, $nama, $ilmiah, $stok, $status, $asal, $perlakuanList]) {
            $service->buat([
                'kelompok_tanaman_id' => $kelompok[$kode],
                'kode_aksesi'         => $kodeAksesi,
                'nama_aksesi'         => $nama,
                'nama_ilmiah'         => $ilmiah,
                'stok_gram'           => $stok,
                'status'              => $status,
                'asal' => [
                    'desa'            => $asal[0],
                    'kecamatan'       => $asal[1],
                    'kabupaten'       => $asal[2],
                    'provinsi'        => $asal[3],
                    'tanggal_koleksi' => $asal[4],
                    'kolektor'        => $asal[5],
                    'ketinggian_mdpl' => $asal[6],
                    'catatan'         => null,
                ],
                'perlakuan_ids' => $p($perlakuanList),
            ]);
        }
    }
}
