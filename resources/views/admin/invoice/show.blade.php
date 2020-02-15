@extends('layouts.admin')

@section('header')
    <h1>
        Detail Histori Penjualan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Histori Penjualan</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Penjualan
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Nomor</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->number }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Sub Total</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->subtotal }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Ongkos Kirim</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->shipping }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Potongan Harga</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->discount }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Total</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->total }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Status</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                @if ($data->status == "pending")
                                    Tertunda
                                @elseif($data->status == "reject")
                                    Ditolak
                                @elseif($data->status == "cancel")
                                    Dibatalkan
                                @elseif($data->status == "approve")
                                    Dalam Pengiriman
                                @elseif($data->status == "payment")
                                    Menunggu Konfirmasi
                                @else
                                    Sudah Diterima
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Alasan</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->reason == null ? "-" : $data->reason }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Pembeli
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>No. HP</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->user->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Penjual
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Nama Toko</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->store->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->store->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->store->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>No. HP</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->store->user->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Alamat Pengiriman
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Alamat</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->depature_location == null ? '-' : $data->depature_location->street }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Kecamatan</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->depature_location == null ? '-' : $data->depature_location->sub_district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Kabupaten</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->depature_location == null ? '-' : $data->depature_location->district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Provinsi</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->depature_location == null ? '-' : $data->depature_location->province }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Alamat Tujuan
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Alamat</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->destination_location == null ? '-' : $data->destination_location->street }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Kecamatan</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->destination_location == null ? '-' : $data->destination_location->sub_district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Kabupaten</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->destination_location == null ? '-' : $data->destination_location->district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <b>Provinsi</b>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                {{ $data->destination_location == null ? '-' : $data->destination_location->province }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Produk
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->invoice_carts as $item)
                                <tr>
                                    <td>{{ $item->cart->product->title }}</td>
                                    <td>{{ $item->cart->quantity }}</td>
                                    <td>{{ $item->cart->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
