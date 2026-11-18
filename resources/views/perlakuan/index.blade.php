@extends('layouts.app')

@section('title', 'Perlakuan Penyimpanan')

@section('content')
    <x-page-header title="Perlakuan Penyimpanan" subtitle="Pilihan perlakuan yang dapat dipasang pada aksesi.">
        <a href="{{ route('perlakuan.create') }}" class="btn btn-primary">+ Tambah Perlakuan</a>
    </x-page-header>

    <x-card>
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari perlakuan...">
            <button class="btn btn-primary" type="submit">Cari</button>
            <a href="{{ route('perlakuan.index') }}" class="btn">Reset</a>
        </form>
    </x-card>

    <x-card>
        <table class="table">
            <thead><tr><th>Nama</th><th>Deskripsi</th><th class="num">Dipakai</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($perlakuans as $p)
                    <tr>
                        <td>{{ $p->nama }}</td>
                        <td class="muted">{{ $p->deskripsi }}</td>
                        <td class="num">{{ $p->aksesis_count }}</td>
                        <td class="actions">
                            <a href="{{ route('perlakuan.edit', $p) }}" class="btn btn-sm">Edit</a>
                            <form action="{{ route('perlakuan.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus perlakuan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state /></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-footer">{{ $perlakuans->links() }}</div>
    </x-card>
@endsection
