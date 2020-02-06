@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Sedang Dikirim</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Sedang Dikirim</li>
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

    <div class="row">
        <div class="col-md-12">
            @if ( $invoice->status == "approve" )
                <button id="btnConfirmShipped" class="btn btn-primary pull-right">
                    <i class="fa fa-truck"></i>
                    Konfirmasi Produk Sudah Diterima
                </button>
            @endif

            @if ($invoice->rating == null && $invoice->status == "done")
                <button id="btnRating" class="btn btn-warning pull-right">
                    <i class="fa fa-star"></i>
                    Berikan Rating
                </button>
            @endif
        </div>
    </div>

    <!-- confirm shipped -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmShipped">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formConfirmShipped">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Barang Sudah Diterima</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin sudah menerima barang ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- rating -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRating">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formRating">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Berikan Rating</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select id="rate" name="rate" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/fontawesome-stars.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/js/jquery.barrating.min.js') }}"></script>
	<script>
        jQuery(document).ready(function($){
            // ConfirmShipped
            $('#btnConfirmShipped').click(function () {
                url = '{{ route("invoice.confirm-shipped") }}';
                $('#modalConfirmShipped').modal('show');
            });

            $('#formConfirmShipped').submit(function (event) {
                event.preventDefault();

                $('#modalConfirmShipped button[type=submit]').button('loading');
                var _data = $("#formConfirmShipped").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            swal({
                                title: "Sukses",
                                text: response.message,
                                icon: "success",
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 1000);
                        } else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }
                        $('#modalConfirmShipped button[type=submit]').button('reset');
                        $('#formConfirmShipped')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                icon: "error",
                            });
                        } else {
                            swal({
                                title: "Gagal",
                                text: "Whoops, looks like something went wrong.",
                                icon: "error",
                            });
                        }

                        $('#formConfirmShipped button[type=submit]').button('reset');
                    }
                });
            });

            $('#rate').barrating({
                theme: 'fontawesome-stars'
            });

            // Rating
            $('#btnRating').click(function () {
                url = '{{ route("invoice.rating") }}';
                $('#modalRating').modal('show');
            });

            $('#formRating').submit(function (event) {
                event.preventDefault();

                $('#modalRating button[type=submit]').button('loading');
                var _data = $("#formRating").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            swal({
                                title: "Sukses",
                                text: response.message,
                                icon: "success",
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 1000);
                        } else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }
                        $('#modalRating button[type=submit]').button('reset');
                        $('#formRating')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                icon: "error",
                            });
                        } else {
                            swal({
                                title: "Gagal",
                                text: "Whoops, looks like something went wrong.",
                                icon: "error",
                            });
                        }

                        $('#formRating button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
