@extends('layouts.admin')

@section('header')
	<section class="content-header">
		<h1>
		Dashboard
		<small>Admin</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $member }}</h3>

                    <p>Member Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('admin.management-member.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $seller }}</h3>

                    <p>Penjual Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('admin.management-store.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $product }}</h3>

                    <p>Produk Terdafar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="{{ route('admin.product.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $donation }}</h3>

                    <p>Produk Donasi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="{{ route('admin.donation.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <div class="small-box bg-fuchsia">
                <div class="inner">
                    <h3>{{ $trx_pending }}</h3>

                    <p>Transaksi</p>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3>{{ $trx_payment }}</h3>

                    <p>Transaksi</p>
                    <p>Menunggu Konfirmasi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-gray">
                <div class="inner">
                    <h3>{{ $trx_reject }}</h3>

                    <p>Transaksi</p>
                    <p>Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $trx_cancel }}</h3>

                    <p>Transaksi</p>
                    <p>Dibatalkan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-lime">
                <div class="inner">
                    <h3>{{ $trx_approve }}</h3>

                    <p>Transaksi</p>
                    <p>Dalam Pengiriman</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-maroon">
                <div class="inner">
                    <h3>{{ $trx_done }}</h3>

                    <p>Transaksi</p>
                    <p>Sudah Diterima</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.invoice.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
