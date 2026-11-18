@extends('layouts.app')

@section('title', 'Tambah Kelompok Tanaman')

@section('content')
    <x-page-header title="Tambah Kelompok Tanaman" />

    <form action="{{ route('kelompok-tanaman.store') }}" method="POST" novalidate>
        @csrf
        @include('kelompok-tanaman._form', ['kelompok' => null])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kelompok-tanaman.index') }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
