<?php

namespace App\Http\Controllers;

use App\Models\AksesiBenih;
use App\Models\KelompokTanaman;
use App\Models\PerlakuanPenyimpanan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'aksesi'    => AksesiBenih::count(),
            'kelompok'  => KelompokTanaman::count(),
            'perlakuan' => PerlakuanPenyimpanan::count(),
            'regenerasi'=> AksesiBenih::where('status', 'perlu_regenerasi')->count(),
        ];

        $perKelompok = KelompokTanaman::withCount('aksesis')
            ->orderByDesc('aksesis_count')
            ->get();

        // Query Builder untuk laporan agregat lintas tabel
        $perProvinsi = DB::table('asal_pengumpulans')
            ->select('provinsi', DB::raw('COUNT(*) as total'))
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $terbaru = AksesiBenih::with(['kelompokTanaman:id,kode,nama', 'asalPengumpulan'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'perKelompok', 'perProvinsi', 'terbaru'));
    }
}
