@extends('layouts.app')

@section('title', 'Edit Kelompok Tanaman')

@section('content')
    <x-page-header title="Edit Kelompok Tanaman" :subtitle="$kelompok->nama" />

    <form action="{{ route('kelompok-tanaman.update', $kelompok) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('kelompok-tanaman._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('kelompok-tanaman.index') }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
