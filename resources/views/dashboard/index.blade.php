@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header title="Dashboard Koleksi" subtitle="Ringkasan koleksi benih varietas lokal.">
        <a href="{{ route('aksesi.create') }}" class="btn btn-primary">+ Aksesi Baru</a>
    </x-page-header>

    <div class="grid grid-4">
        <x-stat-card title="Total Aksesi" :value="$stats['aksesi']" hint="Koleksi tercatat" />
        <x-stat-card title="Kelompok Tanaman" :value="$stats['kelompok']" />
        <x-stat-card title="Jenis Perlakuan" :value="$stats['perlakuan']" />
        <x-stat-card title="Perlu Regenerasi" :value="$stats['regenerasi']" tone="warn" hint="Segera tanam ulang" />
    </div>

    <div class="grid grid-2">
        <x-card title="Aksesi per Kelompok Tanaman">
            <table class="table">
                <thead><tr><th>Kelompok</th><th class="num">Jumlah</th></tr></thead>
                <tbody>
                    @forelse ($perKelompok as $k)
                        <tr>
                            <td>{{ $k->nama }}</td>
                            <td class="num">{{ $k->aksesis_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>

        <x-card title="Asal Pengumpulan Teratas (Provinsi)">
            <table class="table">
                <thead><tr><th>Provinsi</th><th class="num">Aksesi</th></tr></thead>
                <tbody>
                    @forelse ($perProvinsi as $row)
                        <tr>
                            <td>{{ $row->provinsi }}</td>
                            <td class="num">{{ $row->total }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </div>

    <x-card title="Aksesi Terbaru">
        <table class="table">
            <thead>
                <tr><th>Aksesi</th><th>Kelompok</th><th>Asal</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse ($terbaru as $a)
                    <tr>
                        <td><a href="{{ route('aksesi.show', $a) }}">{{ $a->identitas }}</a></td>
                        <td>{{ $a->kelompokTanaman->nama }}</td>
                        <td>{{ $a->asalPengumpulan?->kabupaten }}, {{ $a->asalPengumpulan?->provinsi }}</td>
                        <td><x-badge :tone="$a->status_tone">{{ $a->status_label }}</x-badge></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
@endsection
