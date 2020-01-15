@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Dibatalkan</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Dibatalkan</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <table>
                <tr>
                    <th colspan="3">Keberangkatan Pengiriman</th>
                </tr>
                <tr>
                    <th>Jalan</th>
                    <td> : </td>
                    <td>{{ $invoice->depature_location->street }}</td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td> : </td>
                    <td>{{ $invoice->depature_location->sub_district }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td> : </td>
                    <td>{{ $invoice->depature_location->district }}</td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td> : </td>
                    <td>{{ $invoice->depature_location->province }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-3">
            <table>
                <tr>
                    <th colspan="3">Tujuan Pengiriman</th>
                </tr>
                <tr>
                    <th>Jalan</th>
                    <td> : </td>
                    <td>{{ $invoice->destination_location->street }}</td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td> : </td>
                    <td>{{ $invoice->destination_location->sub_district }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td> : </td>
                    <td>{{ $invoice->destination_location->district }}</td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td> : </td>
                    <td>{{ $invoice->destination_location->province }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table>
                <tr>
                    <th colspan="3">{{ $invoice->number }}</th>
                </tr>
                <tr>
                    <th>Tanggal di buat</th>
                    <td> : </td>
                    <td>{{ $invoice->created_at }}</td>
                </tr>
                <tr>
                    <th>Penjual</th>
                    <td> : </td>
                    <td>{{ $invoice->store->name }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td> : </td>
                    <td>{{ $invoice->user->name }}</td>
                </tr>
            </table>
        </div>
    </div>

    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jumlah</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->invoice_carts as $item)
                            <tr>
                                <td>{{ $item->cart->quantity }}</td>
                                <td>{{ $item->cart->product->title }}</td>
                                <td>Rp. {{ number_format($item->cart->product->price) }}</td>
                                <td>Rp. {{ number_format($item->cart->price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr style="font-size:20px;">
                        <td colspan="3">
                            Sub Total
                        </td>
                        <td>Rp. {{ number_format($invoice->subtotal) }}</td>
                    </tr>
                    <tr style="font-size:20px;">
                        <td colspan="3">
                            Ongkos Kirim
                        </td>
                        <td>Rp. {{ number_format($invoice->shipping) }}</td>
                    </tr>
                    <tr style="font-size:20px;">
                        <td colspan="3">
                            Potongan Harga
                        </td>
                        <td>
                            Rp. {{ number_format($invoice->discount) }}
                        </td>
                    </tr>
                    <tr style="font-size:25px;">
                        <td colspan="3">
                            Total
                        </td>
                        <td>Rp. {{ number_format($invoice->total) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
