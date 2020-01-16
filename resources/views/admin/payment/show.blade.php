@extends('layouts.admin')

@section('header')
    <h1>
        Detail History Transaksi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>History Transaksi</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Transaksi
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Tipe Transaksi</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                @if ($data->status == "out")
                                    Keluar
                                @elseif($data->status == "in")
                                    Masuk
                                @else
                                    Kembali
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nominal</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                Rp. {{ number_format($data->nominal) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Saldo Awal</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                Rp. {{ number_format($data->beginning_balance) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Saldo Akhir</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                Rp. {{ number_format($data->ending_balance) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Potongan Harga</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                Rp. {{ number_format($data->discount) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail User
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nomor HP</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->phone == null ? "-" : $data->user->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Invoice
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Nomor</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->number }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Ongkos Kirim</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                Rp. {{ number_format($data->invoice->shipping) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Sub Total</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                Rp. {{ number_format($data->invoice->subtotal) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Total</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                Rp. {{ number_format($data->invoice->total) }}
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
                        Detail Keranjang Produk
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan </th>
                                    <th>Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->invoice->invoice_carts as $item)
                                    <tr>
                                        <td>{{ $item->cart->product->title }}</td>
                                        <td>{{ $item->cart->quantity }}</td>
                                        <td>Rp. {{ number_format($item->cart->product->price) }}</td>
                                        <td>Rp. {{ number_format($item->cart->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <div class="col-md-3">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Nomor Hp</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->user->phone }}
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
                        <div class="col-md-3">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->store->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->store->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>
                                <b>Nomor Hp</b>
                            </h5>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                {{ $data->invoice->store->user->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
