<?php

namespace App\Http\Controllers;

use App\Models\PerlakuanPenyimpanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerlakuanPenyimpananController extends Controller
{
    public function index(Request $request): View
    {
        $perlakuans = PerlakuanPenyimpanan::query()
            ->withCount('aksesis')
            ->when($request->input('q'), fn ($q, $kw) => $q->where('nama', 'like', "%{$kw}%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('perlakuan.index', compact('perlakuans'));
    }

    public function create(): View
    {
        return view('perlakuan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:100', 'unique:perlakuan_penyimpanans,nama'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        PerlakuanPenyimpanan::create($validated);

        return redirect()->route('perlakuan.index')
            ->with('success', 'Perlakuan penyimpanan berhasil ditambahkan.');
    }

    public function edit(PerlakuanPenyimpanan $perlakuan): View
    {
        return view('perlakuan.edit', compact('perlakuan'));
    }

    public function update(Request $request, PerlakuanPenyimpanan $perlakuan): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:100', Rule::unique('perlakuan_penyimpanans', 'nama')->ignore($perlakuan->id)],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $perlakuan->update($validated);

        return redirect()->route('perlakuan.index')
            ->with('success', 'Perlakuan penyimpanan berhasil diperbarui.');
    }

    public function destroy(PerlakuanPenyimpanan $perlakuan): RedirectResponse
    {
        if ($perlakuan->aksesis()->exists()) {
            return back()->with('error', 'Perlakuan masih dipakai aksesi benih, tidak dapat dihapus.');
        }

        $perlakuan->delete();

        return redirect()->route('perlakuan.index')
            ->with('success', 'Perlakuan penyimpanan berhasil dihapus.');
    }
}
