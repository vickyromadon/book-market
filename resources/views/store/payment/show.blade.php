@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Detail Histori
        <small>Pembayaran</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Histori Pembayaran</li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Informasi Pembeli</h5>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $data->invoice->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>{{ $data->invoice->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Nomor HP</th>
                            <td>:</td>
                            <td>{{ $data->invoice->user->phone == null ? "-" : $data->invoice->user->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Produk Yang Dibeli</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->invoice->invoice_carts as $item)
                                    <tr>
                                        <td>{{ $item->cart->product->title }}</td>
                                        <td>{{ $item->cart->quantity }}</td>
                                        <td>Rp. {{ number_format($item->cart->product->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Sub Total</th>
                                    <th>Rp. {{ number_format($data->invoice->subtotal) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Ongkos Kirim</th>
                                    <th>Rp. {{ number_format($data->invoice->shipping) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Potongan Harga</th>
                                    <th>Rp. {{ number_format($data->invoice->discount) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th>Rp. {{ number_format($data->invoice->total) }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
