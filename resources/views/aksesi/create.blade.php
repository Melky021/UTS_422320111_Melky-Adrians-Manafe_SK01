@extends('layouts.app')

@section('title', 'Tambah Aksesi')

@section('content')
    <x-page-header title="Tambah Aksesi Benih" subtitle="Isi identitas, asal pengumpulan, dan perlakuan penyimpanan." />

    <form action="{{ route('aksesi.store') }}" method="POST" novalidate>
        @csrf
        @include('aksesi._form', ['aksesi' => null])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('aksesi.index') }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
