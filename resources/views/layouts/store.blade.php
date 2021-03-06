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
            <a class="navbar-brand" href="{{ route('store.index') }}">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    @if( Auth::user() )
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <b style="color:red;"><i class="fa fa-money"></i> Rp. {{ number_format(Auth::user()->balance) }}</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('store.profile.index') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('header')

        <div class="row" style="min-height:100vh;">
            <div class="col-lg-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('store.index') }}" class="list-group-item {{(Request::segment(2) == '') ? "active" : ""}}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    @if ( $checkStore != null AND Auth::user()->store->location != null )
                        <a href="{{ route('store.bank.index') }}" class="list-group-item {{(Request::segment(2) == 'bank') ? "active" : ""}}"><i class="fa fa-bank"></i> Bank</a>
                        <a href="{{ route('store.withdraw.index') }}" class="list-group-item {{(Request::segment(2) == 'withdraw') ? "active" : ""}}"><i class="fa fa-dollar"></i> Penarikan Saldo</a>
                        <a href="{{ route('store.product.index') }}" class="list-group-item {{(Request::segment(2) == 'product') ? "active" : ""}}"><i class="fa fa-cubes"></i> Produk</a>
                        <a href="{{ route('store.order-entry.index') }}" class="list-group-item {{(Request::segment(2) == 'order-entry') ? "active" : ""}}"><i class="fa fa-cube"></i> Pesanan Masuk</a>
                        <a href="{{ route('store.order-shipped.index') }}" class="list-group-item {{(Request::segment(2) == 'order-shipped') ? "active" : ""}}"><i class="fa fa-car"></i> Pesanan Dikirim</a>
                        <a href="{{ route('store.order-declined.index') }}" class="list-group-item {{(Request::segment(2) == 'order-declined') ? "active" : ""}}"><i class="fa fa-times-circle"></i> Pesanan Ditolak</a>
                        <a href="{{ route('store.order-received.index') }}" class="list-group-item {{(Request::segment(2) == 'order-received') ? "active" : ""}}"><i class="fa fa-truck"></i> Pesanan Diterima</a>
                        <a href="{{ route('store.payment.index') }}" class="list-group-item {{(Request::segment(2) == 'payment') ? "active" : ""}}"><i class="fa fa-money"></i> Histori Pembayaran</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-9 mb-4">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="py-3 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{ env('APP_NAME') }} 2019</p>
        </div>
    </footer>

    <script src="{{ asset('/templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    @yield('js')
</body>

</html>
