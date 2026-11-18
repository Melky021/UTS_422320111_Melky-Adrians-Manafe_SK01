@extends('layouts.app')

@section('title', 'Edit Aksesi')

@section('content')
    <x-page-header title="Edit Aksesi" :subtitle="$aksesi->identitas" />

    <form action="{{ route('aksesi.update', $aksesi) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('aksesi._form')

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('aksesi.show', $aksesi) }}" class="btn">Batal</a>
        </div>
    </form>
@endsection
