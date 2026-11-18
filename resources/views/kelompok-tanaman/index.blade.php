@extends('layouts.app')

@section('title', 'Kelompok Tanaman')

@section('content')
    <x-page-header title="Kelompok Tanaman" subtitle="Kategori untuk mengelompokkan aksesi.">
        <a href="{{ route('kelompok-tanaman.create') }}" class="btn btn-primary">+ Tambah Kelompok</a>
    </x-page-header>

    <x-card>
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari kode / nama kelompok...">
            <button class="btn btn-primary" type="submit">Cari</button>
            <a href="{{ route('kelompok-tanaman.index') }}" class="btn">Reset</a>
        </form>
    </x-card>

    <x-card>
        <table class="table">
            <thead><tr><th>Kode</th><th>Nama</th><th>Deskripsi</th><th class="num">Aksesi</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($kelompoks as $k)
                    <tr>
                        <td><code>{{ $k->kode }}</code></td>
                        <td>{{ $k->nama }}</td>
                        <td class="muted">{{ $k->deskripsi }}</td>
                        <td class="num">{{ $k->aksesis_count }}</td>
                        <td class="actions">
                            <a href="{{ route('kelompok-tanaman.edit', $k) }}" class="btn btn-sm">Edit</a>
                            <form action="{{ route('kelompok-tanaman.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kelompok ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-empty-state /></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-footer">{{ $kelompoks->links() }}</div>
    </x-card>
@endsection
