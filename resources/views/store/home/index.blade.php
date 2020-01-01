@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Dashboard
        <small>Penjual</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
    </ol>
@endsection

@section('content')
    <h2>Selamat Datang di Dashboar Penjual</h2>
@endsection
