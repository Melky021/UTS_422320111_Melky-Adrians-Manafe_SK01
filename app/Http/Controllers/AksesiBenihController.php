<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAksesiBenihRequest;
use App\Http\Requests\UpdateAksesiBenihRequest;
use App\Models\AksesiBenih;
use App\Models\KelompokTanaman;
use App\Models\PerlakuanPenyimpanan;
use App\Services\AksesiBenihService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AksesiBenihController extends Controller
{
    public function __construct(private AksesiBenihService $service)
    {
    }

    public function index(Request $request): View
    {
        // Whitelist kolom sorting (jangan langsung percaya input user)
        $sorts = ['kode_aksesi', 'nama_aksesi', 'stok_gram', 'created_at'];
        $sort = in_array($request->input('sort'), $sorts, true) ? $request->input('sort') : 'created_at';
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        $aksesis = AksesiBenih::query()
            ->with(['kelompokTanaman:id,kode,nama', 'asalPengumpulan', 'perlakuans'])
            ->search($request->input('q'))
            ->kelompokId($request->integer('kelompok_id'))
            ->perlakuanId($request->integer('perlakuan_id'))
            ->status($request->input('status'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('aksesi.index', [
            'aksesis'    => $aksesis,
            'kelompoks'  => KelompokTanaman::orderBy('nama')->get(['id', 'nama']),
            'perlakuans' => PerlakuanPenyimpanan::orderBy('nama')->get(['id', 'nama']),
            'sorts'      => [
                'created_at'  => 'Terbaru dibuat',
                'kode_aksesi' => 'Kode aksesi',
                'nama_aksesi' => 'Nama aksesi',
                'stok_gram'   => 'Stok',
            ],
        ]);
    }

    public function create(): View
    {
        return view('aksesi.create', [
            'kelompoks'  => KelompokTanaman::orderBy('nama')->get(),
            'perlakuans' => PerlakuanPenyimpanan::orderBy('nama')->get(),
        ]);
    }

    public function store(StoreAksesiBenihRequest $request): RedirectResponse
    {
        $aksesi = $this->service->buat($request->validated());

        return redirect()
            ->route('aksesi.show', $aksesi)
            ->with('success', 'Aksesi benih berhasil ditambahkan.');
    }

    public function show(AksesiBenih $aksesi): View
    {
        $aksesi->load(['kelompokTanaman', 'asalPengumpulan', 'perlakuans']);

        return view('aksesi.show', compact('aksesi'));
    }

    public function edit(AksesiBenih $aksesi): View
    {
        $aksesi->load(['asalPengumpulan', 'perlakuans']);

        return view('aksesi.edit', [
            'aksesi'            => $aksesi,
            'kelompoks'         => KelompokTanaman::orderBy('nama')->get(),
            'perlakuans'        => PerlakuanPenyimpanan::orderBy('nama')->get(),
            'selectedPerlakuan' => $aksesi->perlakuans->pluck('id')->all(),
        ]);
    }

    public function update(UpdateAksesiBenihRequest $request, AksesiBenih $aksesi): RedirectResponse
    {
        $this->service->ubah($aksesi, $request->validated());

        return redirect()
            ->route('aksesi.show', $aksesi)
            ->with('success', 'Aksesi benih berhasil diperbarui.');
    }

    public function destroy(AksesiBenih $aksesi): RedirectResponse
    {
        $this->service->hapus($aksesi);

        return redirect()
            ->route('aksesi.index')
            ->with('success', 'Aksesi benih berhasil dihapus.');
    }
}
