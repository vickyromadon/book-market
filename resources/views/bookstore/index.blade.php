@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Toko
        <small>Buku</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Toko</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        @foreach ($store as $item)
            <div class="col-sm-4">
                <div class="card text-dark bg-light">
                    <div class="card-header bg-default text-center text-dark">
                        <h4>{{ $item->name }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-12">
                                @if ( $item->image != null )
                                    <img src="{{ asset('storage/'. $item->image)}}" class="img-thumbnail" style="width:100%; height:200px;">
                                @else
                                    <img src="{{ asset('images/book_store.jpg') }}" class="img-thumbnail" style="width:100%; height:200px;">
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="pull-left">
                                    <b>Produk Terjual</b>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="pull-right">
                                    @php
                                        $totalSold = 0;
                                    @endphp
                                    @foreach ($item->products as $productSold)
                                        @php
                                            $totalSold += $productSold->sold;
                                        @endphp
                                    @endforeach

                                    {{ $totalSold }}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="pull-left">
                                    <b>Pembeli Melihat</b>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="pull-right">
                                    @php
                                        $totalView = 0;
                                    @endphp
                                    @foreach ($item->products as $productView)
                                        @php
                                            $totalView += $productView->view;
                                        @endphp
                                    @endforeach

                                    {{ $totalView }}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="pull-left">
                                    <b>Ulasan Masuk</b>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="pull-right">
                                    @php
                                        $totalRating = 0;
                                    @endphp
                                    @foreach ($item->ratings as $ratingTotal)
                                        @php
                                            $totalRating += 1;
                                        @endphp
                                    @endforeach

                                    {{ $totalRating }}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="pull-left">
                                    <b>Rating</b>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="pull-right">
                                    @php
                                        $rerataRating = 0;
                                    @endphp
                                    @foreach ($item->ratings as $ratingRerata)
                                        @php
                                            $rerataRating += $ratingRerata->rate;
                                        @endphp
                                    @endforeach

                                    @if ( $rerataRating == 0 )
                                        0
                                    @else
                                        {{ $rerataRating / $totalRating }}
                                    @endif
                                    <i class="fa fa-lg fa-star" style="color:goldenrod"></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-default text-center">
                        <a href="{{ route('book-store.detail', ['id' => $item->id]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-eye"></i>
                            Lihat Toko
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
                {{ $store->links() }}
            </div>
        </div>
    </div>
@endsection
