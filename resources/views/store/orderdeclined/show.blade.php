@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Detail Pengelolaan
        <small>Pesanan Ditolak</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Pesanan Ditolak</li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endsection
