@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Voucher
        <small>Saya</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Voucher Saya</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        @foreach ($user_voucher as $item)
            <div class="col-sm-4">
                <div class="card text-dark bg-light">
                    <div class="card-header bg-default text-center text-dark">
                        <h4>{{ $item->voucher->name }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Potongan Harga</h5>
                        <h1>{{ $item->voucher->discount }}%</h1>
                    </div>
                </div>
                <br>
            </div>
        @endforeach
    </div>
@endsection
