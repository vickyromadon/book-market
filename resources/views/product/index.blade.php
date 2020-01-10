@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Produk
        <small>Semua Buku</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Produk</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        @for ($i = 0; $i < count($product); $i++)
            <div class="col-lg-3 portfolio-item">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['id' => $product[$i]->id]) }}">
                        @if ($product[$i]->image != null)
                            <img class="card-img-top" src="{{ asset('storage/'. $product[$i]->image)}}" style="width:100%; height:150px;">
                        @else
                            <img class="card-img-top" src="{{ asset('images/book.jpg') }}" style="width:100%; height:150px;">
                        @endif
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            @if ( strlen($product[$i]->title > 20) )
                                <a href="{{ route('product.detail', ['id' => $product[$i]->id]) }}">{{ substr($product[$i]->title, 0, 20) }} ...</a>
                            @else
                                <a href="{{ route('product.detail', ['id' => $product[$i]->id]) }}">{{ $product[$i]->title }}</a>
                            @endif
                        </h4>
                        <h5>
                            <i class="fa fa-user"></i>
                            @if ( strlen($product[$i]->publisher) > 20 )
                                {{ substr($product[$i]->publisher, 0, 20) }} ...
                            @else
                                {{ $product[$i]->publisher }}
                            @endif
                        </h5>
                        <p class="card-text" align="justify">
                            @if ( strlen($product[$i]->description) > 100 )
                                {{ substr($product[$i]->description, 0, 100) }} . . .
                            @else
                                {{ $product[$i]->description }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $product->links() }}
            </div>
        </div>
    </div>
@endsection
