@extends('layouts.app')

@section('title', 'Tambah Perlakuan')

@section('content')
    <x-page-header title="Tambah Perlakuan Penyimpanan" />

    <form action="{{ route('perlakuan.store') }}" method="POST" novalidate>
        @csrf
        @include('perlakuan._form', ['perlakuan' => null])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('perlakuan.index') }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
