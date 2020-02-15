@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Detail Pengelolaan
        <small>Pesanan Masuk</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Pesanan Masuk</li>
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
                            <td>{{ $data->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>{{ $data->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Nomor HP</th>
                            <td>:</td>
                            <td>{{ $data->user->phone == null ? "-" : $data->user->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>Alamat</th>
                            <td>:</td>
                            <td>{{ $data->destination_location->street }}</td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td>:</td>
                            <td>{{ $data->destination_location->sub_district }}</td>
                        </tr>
                        <tr>
                            <th>Kabupaten</th>
                            <td>:</td>
                            <td>{{ $data->destination_location->district }}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>:</td>
                            <td>{{ $data->destination_location->province }}</td>
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
                                @foreach ($data->invoice_carts as $item)
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
                                    <th>Rp. {{ number_format($data->subtotal) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Ongkos Kirim</th>
                                    <th>Rp. {{ number_format($data->shipping) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Potongan Harga</th>
                                    <th>Rp. {{ number_format($data->discount) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th>Rp. {{ number_format($data->total) }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if ( $data->status == "payment" )
                    <div class="card-footer">
                        <button class="btn btn-danger pull-left" id="btnReject"><i class="fa fa-close"></i> Tolak</button>
                        <button class="btn btn-success pull-right" id="btnApprove"><i class="fa fa-check "></i> Setujui</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalApprove">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formApprove">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Setujui Pembelian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyetujui pembelian ini ?</p>

                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
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

    <!-- reject -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalReject">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReject">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Tolak Pembelian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menolak pembelian ini ?</p>
                        <textarea name="reason" id="reason" placeholder="Masukkan Alasan Penolakan" required class="form-control"></textarea>
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

@section('js')]
    <script>
        jQuery(document).ready(function($){
            var url;

            // approve
            $('#btnApprove').click(function () {
                url = '{{ route("store.order-entry.approve") }}';
                $('#modalApprove').modal('show');
            });

            $('#formApprove').submit(function (event) {
                event.preventDefault();
                $('#formApprove button[type=submit]').button('loading');

                var formData = new FormData($("#formApprove")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            swal({
                                title: "Sukses",
                                text: response.message,
                                icon: "success",
                            });

                            $('#modalApprove').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formApprove button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                icon: "error",
                            });
                        }
                        else {
                            swal({
                                title: "Gagal",
                                text: "Whoops, looks like something went wrong.",
                                icon: "error",
                            });
                        }
                        $('#formApprove button[type=submit]').button('reset');
                    }
                });
            });

            // reject
            $('#btnReject').click(function () {
                url = '{{ route("store.order-entry.reject") }}';
                $('#modalReject').modal('show');
            });

            $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');

                var formData = new FormData($("#formReject")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            swal({
                                title: "Sukses",
                                text: response.message,
                                icon: "success",
                            });

                            $('#modalReject').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formReject button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                icon: "error",
                            });
                        }
                        else {
                            swal({
                                title: "Gagal",
                                text: "Whoops, looks like something went wrong.",
                                icon: "error",
                            });
                        }
                        $('#formReject button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
