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
            @if ($product->image != null)
                <img class="img-fluid rounded" src="{{ asset('storage/'. $product->image)}}" style="width:100%;">
            @else
                <img class="img-fluid rounded" src="{{ asset('images/book.jpg') }}" style="width:100%;">
            @endif

            <hr>

            <p>Di Posting Pada {{ $product->created_at }}</p>

            <hr>

            <p>
                {{ $product->description }}
            </p>
        </div>
        <div class="col-lg-4">
            <div class="card my-4">
                <h5 class="card-header">Keterangan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">Web Design</a>
                                </li>
                                <li>
                                    <a href="#">HTML</a>
                                </li>
                                <li>
                                    <a href="#">Freebies</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">JavaScript</a>
                                </li>
                                <li>
                                    <a href="#">CSS</a>
                                </li>
                                <li>
                                    <a href="#">Tutorials</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

