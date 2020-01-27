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

    <div class="row">
        <div class="col-lg-3">
            <a href="{{ route('store.product.index') }}" style="color:black;">
                <div class="card bg-danger">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{ $product }}</h3>

                            <p>Jumlah Produk</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-entry.index') }}" style="color:black;">
                <div class="card bg-warning">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_payment}}</h3>

                            <p>Pesanan Masuk</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-shipped.index') }}" style="color:black;">
                <div class="card bg-success">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_approve}}</h3>

                            <p>Pesanan Dikirim</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-received.index') }}" style="color:black;">
                <div class="card bg-primary">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_done}}</h3>

                            <p>Pesanan Diterima</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
