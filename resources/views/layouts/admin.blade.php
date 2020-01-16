<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | {{ env('APP_NAME') }}</title>

    <!-- Google Font -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>

<body class="hold-transition skin-black-light sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ route('admin.index') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>ADM</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b> Marketplace</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications Menu -->
                        {{-- <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-danger">{{ $countUnreadNotif }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Memiliki {{ $countUnreadNotif }} Notifikasi yang Belum di Baca</li>
                                <li>
                                    <ul class="menu">
                                        @foreach ($dataNotif as $data)
                                            <li>
                                                <a href="{{ $data->link }}?id={{$data->id}}" title="{{ $data->status == \App\Models\Notification::STATUS_UNREAD ? 'Belum di buka' : '' }}" class="{{ $data->status == \App\Models\Notification::STATUS_UNREAD ? 'bg-gray' : '' }}">
                                                    <h4>
                                                        {{ $data->type }}
                                                    </h4>
                                                    <p>{{ $data->message }}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                @if ( Auth::user()->image != null )
                                    <img class="user-image" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                                @else
                                    <img class="user-image" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if ( Auth::user()->image != null )
                                        <img class="img-circle" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                                    @else
                                        <img class="img-circle" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                                    @endif

                                    <p>
                                        {{ Auth::user()->name }}
                                        <small>{{ Auth::user()->roles[0]->display_name }} Sejak {{ date_format(Auth::user()->created_at, 'M. Y') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Keluar
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        @if ( Auth::user()->image != null )
                            <img class="img-circle" style="height:5vh; width:100%;" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                        @else
                            <img class="img-circle" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                        @endif
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="{{(Request::segment(2) == '') ? "active" : ""}}">
                        <a href="{{ route('admin.index') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="treeview {{ (Request::segment(2) == 'province') ? "active" : "" }} {{ (Request::segment(2) == 'district') ? "active" : "" }} {{ (Request::segment(2) == 'sub-district') ? "active" : ""}}">
                        <a href="#">
                            <i class="fa fa-map"></i> <span>Pengelola Lokasi</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ (Request::segment(2) == 'province') ? "active" : "" }}">
                                <a href="{{ route('admin.province.index') }}"><i class="fa fa-circle-o"></i> Provinsi</a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'district') ? "active" : "" }}">
                                <a href="{{ route('admin.district.index') }}"><i class="fa fa-circle-o"></i> Kabupaten</a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'sub-district') ? "active" : "" }}">
                                <a href="{{ route('admin.sub-district.index') }}"><i class="fa fa-circle-o"></i> Kecamatan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{(Request::segment(2) == 'shipping') ? "active" : ""}}">
                        <a href="{{ route('admin.shipping.index') }}">
                            <i class="fa fa-money"></i> <span>Onkos Kirim</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'bank') ? "active" : ""}}">
                        <a href="{{ route('admin.bank.index') }}">
                            <i class="fa fa-bank"></i> <span>Bank</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'category') ? "active" : ""}}">
                        <a href="{{ route('admin.category.index') }}">
                            <i class="fa fa-list"></i> <span>Kategori</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'level') ? "active" : ""}}">
                        <a href="{{ route('admin.level.index') }}">
                            <i class="fa fa-signal"></i> <span>Jenjang</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'slider') ? "active" : ""}}">
                        <a href="{{ route('admin.slider.index') }}">
                            <i class="fa fa-picture-o"></i> <span>Slider</span>
                        </a>
                    </li>

                    <li class="treeview {{ (Request::segment(2) == 'topup') ? "active" : "" }} {{ (Request::segment(2) == 'withdraw') ? "active" : ""}}">
                        <a href="#">
                            <i class="fa fa-dollar"></i> <span>Saldo</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ (Request::segment(2) == 'topup') ? "active" : "" }}">
                                <a href="{{ route('admin.topup.index') }}"><i class="fa fa-circle-o"></i> Penambahan</a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'withdraw') ? "active" : "" }}">
                                <a href="{{ route('admin.withdraw.index') }}"><i class="fa fa-circle-o"></i> Penarikan</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{(Request::segment(2) == 'product') ? "active" : ""}}">
                        <a href="{{ route('admin.product.index') }}">
                            <i class="fa fa-cubes"></i> <span>Produk</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'message') ? "active" : ""}}">
                        <a href="{{ route('admin.message.index') }}">
                            <i class="fa fa-envelope"></i> <span>Pesan</span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'donation') ? "active" : ""}}">
                        <a href="{{ route('admin.donation.index') }}">
                            <i class="fa fa-book"></i>
                            <span>
                                Donasi
                                <span class="pull-right-container">
                                    <span class="label label-primary pull-right">
                                        {{ \App\Models\Donation::where('status', '=', 'pending')->count() }}
                                    </span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="{{(Request::segment(2) == 'voucher') ? "active" : ""}}">
                        <a href="{{ route('admin.voucher.index') }}">
                            <i class="fa fa-credit-card"></i> <span>Voucher</span>
                        </a>
                    </li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('header')
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
        </footer>
        <!-- /.control-sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
    @yield('js')
</body>

</html>
