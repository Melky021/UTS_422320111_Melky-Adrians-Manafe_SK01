@extends('layouts.app')

@section('title', 'Edit Perlakuan')

@section('content')
    <x-page-header title="Edit Perlakuan Penyimpanan" :subtitle="$perlakuan->nama" />

    <form action="{{ route('perlakuan.update', $perlakuan) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('perlakuan._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('perlakuan.index') }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
