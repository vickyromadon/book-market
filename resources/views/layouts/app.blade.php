<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME') }}</title>

    <link href="{{ asset('/templates/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/templates/css/modern-business.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('index') }}" class="nav-link"><i class="fa fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link">Produk</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Kategori</a>
                        <div class="dropdown-menu">
                            @foreach (\App\Models\Category::all() as $item)
                                <a href="{{ route('product.category', ['id' => $item->id]) }}" class="dropdown-item">{{ $item->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Jenjang</a>
                        <div class="dropdown-menu">
                            @foreach (\App\Models\Level::all() as $item)
                                <a href="{{ route('product.level', ['id' => $item->id]) }}" class="dropdown-item">{{ $item->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('message.index') }}" class="nav-link">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if( !Auth::user() )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <b style="color:red;"><i class="fa fa-money"></i> Rp. {{ number_format(Auth::user()->balance) }}</b>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile.index') }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('donation.index') }}" class="dropdown-item">Donasi Buku</a>

                            <div class="dropdown-divider"></div>

                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header>
        @yield('slider')
    </header>

    <div class="container" style="min-height:100vh;">
        @yield('header')

        @yield('content')
    </div>

    <footer class="py-3 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{ env('APP_NAME') }} 2020</p>
        </div>
    </footer>

    <script src="{{ asset('/templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    @yield('js')
</body>
</html>
