@extends('layouts.app')

@section('title', 'Aksesi Benih')

@section('content')
    <x-page-header title="Aksesi Benih" subtitle="Daftar koleksi benih varietas lokal.">
        <a href="{{ route('aksesi.create') }}" class="btn btn-primary">+ Tambah Aksesi</a>
    </x-page-header>

    {{-- Pencarian + Filter + Sorting (method GET agar bisa di-bookmark & dipertahankan saat paginasi) --}}
    <x-card>
        <form method="GET" action="{{ route('aksesi.index') }}" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari kode, nama, nama ilmiah, kabupaten, provinsi...">

            <select name="kelompok_id">
                <option value="">Semua kelompok</option>
                @foreach ($kelompoks as $k)
                    <option value="{{ $k->id }}" @selected(request('kelompok_id') == $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>

            <select name="perlakuan_id">
                <option value="">Semua perlakuan</option>
                @foreach ($perlakuans as $p)
                    <option value="{{ $p->id }}" @selected(request('perlakuan_id') == $p->id)>{{ $p->nama }}</option>
                @endforeach
            </select>

            <select name="status">
                <option value="">Semua status</option>
                @foreach (\App\Models\AksesiBenih::STATUS as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="sort">
                @foreach ($sorts as $key => $label)
                    <option value="{{ $key }}" @selected(request('sort', 'created_at') === $key)>Urut: {{ $label }}</option>
                @endforeach
            </select>

            <select name="direction">
                <option value="desc" @selected(request('direction', 'desc') === 'desc')>Menurun</option>
                <option value="asc" @selected(request('direction') === 'asc')>Menaik</option>
            </select>

            <button type="submit" class="btn btn-primary">Terapkan</button>
            <a href="{{ route('aksesi.index') }}" class="btn">Reset</a>
        </form>
    </x-card>

    <x-card>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Aksesi</th>
                        <th>Kelompok</th>
                        <th>Asal Pengumpulan</th>
                        <th>Perlakuan</th>
                        <th class="num">Stok (g)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aksesis as $a)
                        <tr>
                            <td><code>{{ $a->kode_aksesi }}</code></td>
                            <td>
                                <a href="{{ route('aksesi.show', $a) }}"><strong>{{ $a->nama_aksesi }}</strong></a><br>
                                <small class="muted"><em>{{ $a->nama_ilmiah }}</em></small>
                            </td>
                            <td>{{ $a->kelompokTanaman->nama }}</td>
                            <td>
                                {{ $a->asalPengumpulan?->kabupaten }}<br>
                                <small class="muted">{{ $a->asalPengumpulan?->provinsi }}</small>
                            </td>
                            <td>
                                @forelse ($a->perlakuans as $p)
                                    <x-badge>{{ $p->nama }}</x-badge>
                                @empty
                                    <span class="muted">-</span>
                                @endforelse
                            </td>
                            <td class="num">{{ number_format($a->stok_gram, 2, ',', '.') }}</td>
                            <td><x-badge :tone="$a->status_tone">{{ $a->status_label }}</x-badge></td>
                            <td class="actions">
                                <a href="{{ route('aksesi.show', $a) }}" class="btn btn-sm">Detail</a>
                                <a href="{{ route('aksesi.edit', $a) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('aksesi.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus aksesi {{ $a->kode_aksesi }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <x-empty-state message="Tidak ada aksesi yang cocok dengan pencarian/filter." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <small class="muted">Menampilkan {{ $aksesis->firstItem() ?? 0 }}–{{ $aksesis->lastItem() ?? 0 }} dari {{ $aksesis->total() }} aksesi</small>
            {{ $aksesis->links() }}
        </div>
    </x-card>
@endsection
