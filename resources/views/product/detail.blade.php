@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Buku
        <small>{{ $product->title }}</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Detail Buku</li>
        <li class="breadcrumb-item active">{{ $product->title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    @if ($product->image != null)
                        <img class="img-fluid rounded" src="{{ asset('storage/'. $product->image)}}" style="width:100%;">
                    @else
                        <img class="img-fluid rounded" src="{{ asset('images/book.jpg') }}" style="width:100%;">
                    @endif
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-left">
                        <i class="fa fa-calendar"></i>
                        Posting Pada {{ $product->created_at }}
                    </div>
                    <div class="pull-right">
                        <i class="fa fa-user"></i>
                        Posting Oleh {{ $product->store->name }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-4">
                <h5 class="card-header">Keterangan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">Penerbit</a>
                                </li>
                                <li>
                                    <a href="#">Kategori</a>
                                </li>
                                <li>
                                    <a href="#">Jenjang</a>
                                </li>
                                <li>
                                    <a href="#">Tersedia</a>
                                </li>
                                <li>
                                    <a href="#">Harga</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    : {{ $product->publisher }}
                                </li>
                                <li>
                                    : {{ $product->category->name }}
                                </li>
                                <li>
                                    : {{ $product->level->name }}
                                </li>
                                <li>
                                    : {{ $product->quantity }}
                                </li>
                                <li>
                                    : Rp. {{ number_format($product->price) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <button class="btn btn-warning col-lg-12">
                <i class="fa fa-cart-plus"></i>
                Tambah Keranjang
            </button>
        </div>
    </div>
@endsection

