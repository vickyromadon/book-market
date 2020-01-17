@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Toko
        <small>{{ $store->name }}</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Detail Buku</li>
        <li class="breadcrumb-item active">{{ $store->name }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        @foreach ($product as $item)
            <div class="col-sm-4">
                <div class="card text-dark bg-light">
                    <div class="card-header bg-default text-center text-dark">
                        <h5>{{ $item->title }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-12">
                                @if ( $item->image != null )
                                    <img src="{{ asset('storage/'. $item->image)}}" class="img-thumbnail" style="width:100%; height:200px;">
                                @else
                                    <img src="{{ asset('images/book.jpg') }}" class="img-thumbnail" style="width:100%; height:200px;">
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="pull-left">
                                    <b>Penerbit : </b>
                                    {{ $item->publisher == null ? "-" : $item->publisher }}
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="pull-left">
                                    <b>Terjual : </b>
                                    {{ $item->sold }}
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="pull-left">
                                    <b>Melihat : </b>
                                    {{ $item->view }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-default text-center">
                        <a href="{{ route('product.detail', ['id' => $item->id]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-eye"></i>
                            Lihat Buku
                        </a>
                    </div>
                </div>
                <br>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $product->links() }}
            </div>
        </div>
    </div>
@endsection
