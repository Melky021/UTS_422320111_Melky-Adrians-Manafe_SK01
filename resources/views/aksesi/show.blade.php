@extends('layouts.app')

@section('title', $aksesi->nama_aksesi)

@section('content')
    <x-page-header :title="$aksesi->nama_aksesi" :subtitle="$aksesi->kode_aksesi . ' · ' . $aksesi->kelompokTanaman->nama">
        <a href="{{ route('aksesi.edit', $aksesi) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('aksesi.index') }}" class="btn">Kembali</a>
    </x-page-header>

    <div class="grid grid-2">
        <x-card title="Identitas">
            <dl class="dl">
                <dt>Kode Aksesi</dt><dd><code>{{ $aksesi->kode_aksesi }}</code></dd>
                <dt>Nama Ilmiah</dt><dd><em>{{ $aksesi->nama_ilmiah ?? '-' }}</em></dd>
                <dt>Kelompok</dt><dd>{{ $aksesi->kelompokTanaman->nama }}</dd>
                <dt>Stok</dt><dd>{{ number_format($aksesi->stok_gram, 2, ',', '.') }} gram</dd>
                <dt>Status</dt><dd><x-badge :tone="$aksesi->status_tone">{{ $aksesi->status_label }}</x-badge></dd>
            </dl>
        </x-card>

        <x-card title="Asal Pengumpulan">
            @if ($aksesi->asalPengumpulan)
                @php $asal = $aksesi->asalPengumpulan; @endphp
                <dl class="dl">
                    <dt>Lokasi</dt><dd>{{ $asal->lokasi_lengkap }}</dd>
                    <dt>Tanggal Koleksi</dt><dd>{{ $asal->tanggal_koleksi->format('d-m-Y') }}</dd>
                    <dt>Kolektor</dt><dd>{{ $asal->kolektor }}</dd>
                    <dt>Ketinggian</dt><dd>{{ $asal->ketinggian_mdpl ? $asal->ketinggian_mdpl.' mdpl' : '-' }}</dd>
                    <dt>Catatan</dt><dd>{{ $asal->catatan ?? '-' }}</dd>
                </dl>
            @else
                <x-empty-state message="Detail asal belum diisi." />
            @endif
        </x-card>
    </div>

    <x-card title="Perlakuan Penyimpanan">
        @forelse ($aksesi->perlakuans as $p)
            <div class="list-row">
                <strong>{{ $p->nama }}</strong>
                <small class="muted">{{ $p->deskripsi }}</small>
            </div>
        @empty
            <x-empty-state message="Belum ada perlakuan." />
        @endforelse
    </x-card>
@endsection
