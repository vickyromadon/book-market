@extends('layouts.app')

@section('slider')
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($slider); $i++)
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $i==0 ? 'active' : '' }}"></li>
            @endfor
        </ol>
        <div class="carousel-inner" role="listbox">
            @for ($i = 0; $i < count($slider); $i++)
            <div class="carousel-item {{ $i==0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$slider[$i]->image) }}')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>{{ $slider[$i]->title }}</h3>
                    <p>{{ $slider[$i]->description }}</p>
                </div>
            </div>
            @endfor
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endsection

@section('content')
    <h1 class="my-4">Produk Buku Baru</h1>

    <div class="row">
        @for ($i = 0; $i < (count($product) < 6 ? count($product) : 6); $i++)
            <div class="col-lg-4 portfolio-item">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['id' => $product[$i]->id]) }}">
                        @if ($product[$i]->image != null)
                            <img class="card-img-top" src="{{ asset('storage/'. $product[$i]->image)}}" style="width:100%; height:250px;">
                        @else
                            <img class="card-img-top" src="{{ asset('images/book.jpg') }}" style="width:100%; height:250px;">
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
                            @if ( strlen($product[$i]->description) > 200 )
                                {{ substr($product[$i]->description, 0, 200) }} . . .
                            @else
                                {{ $product[$i]->description }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <hr>

    <h1 class="my-4">Tentang</h1>

    <div class="row">
        <div class="col-lg-12">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, officiis! Sunt quibusdam accusantium tenetur saepe quasi voluptate harum? Odit labore laudantium debitis perferendis at accusamus quod nam quos incidunt nesciunt?
            </p>
        </div>
    </div>
@endsection
