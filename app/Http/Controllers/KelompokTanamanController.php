<?php

namespace App\Http\Controllers;

use App\Models\KelompokTanaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KelompokTanamanController extends Controller
{
    public function index(Request $request): View
    {
        $kelompoks = KelompokTanaman::query()
            ->withCount('aksesis')
            ->when($request->input('q'), function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('kode', 'like', "%{$keyword}%")
                        ->orWhere('nama', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('kelompok-tanaman.index', compact('kelompoks'));
    }

    public function create(): View
    {
        return view('kelompok-tanaman.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode'      => ['required', 'string', 'max:10', 'unique:kelompok_tanamans,kode'],
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        KelompokTanaman::create($validated);

        return redirect()->route('kelompok-tanaman.index')
            ->with('success', 'Kelompok tanaman berhasil ditambahkan.');
    }

    public function edit(KelompokTanaman $kelompok): View
    {
        return view('kelompok-tanaman.edit', compact('kelompok'));
    }

    public function update(Request $request, KelompokTanaman $kelompok): RedirectResponse
    {
        $validated = $request->validate([
            'kode'      => ['required', 'string', 'max:10', Rule::unique('kelompok_tanamans', 'kode')->ignore($kelompok->id)],
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $kelompok->update($validated);

        return redirect()->route('kelompok-tanaman.index')
            ->with('success', 'Kelompok tanaman berhasil diperbarui.');
    }

    public function destroy(KelompokTanaman $kelompok): RedirectResponse
    {
        // Selaras dengan restrictOnDelete di migration: beri pesan ramah, bukan error SQL.
        if ($kelompok->aksesis()->exists()) {
            return back()->with('error', 'Kelompok masih dipakai aksesi benih, tidak dapat dihapus.');
        }

        $kelompok->delete();

        return redirect()->route('kelompok-tanaman.index')
            ->with('success', 'Kelompok tanaman berhasil dihapus.');
    }
}
