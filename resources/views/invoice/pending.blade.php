@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Belum Bayar</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Belum Bayar</li>
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
                @if ( $invoice->destination_location == null )
                    <tr>
                        <th colspan="3">
                            <a href="#" id="btnDestinationLocation" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                                Alamat Baru
                            </a>
                        </th>
                    </tr>
                    @if ( Auth::user()->location != null )
                        <tr>
                            <th colspan="3">
                                Atau
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">
                                <a href="#" id="btnDestinationNow" class="btn btn-primary">
                                    <i class="fa fa-map-o"></i>
                                    Alamat Sekarang
                                </a>
                            </th>
                        </tr>
                    @endif
                @else
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
                @endif
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
                            @if ($invoice->voucher_id == null && $invoice->status == "pending")
                                <a href="#" class="btn btn-outline-warning" id="btnVoucher"><i class="fa fa-plus"></i> Voucher</a>
                            @endif
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
            @if ( $invoice->subtotal > 0 AND $invoice->shipping > 0 AND $invoice->total > 0 AND $invoice->status == "pending" )
                <button id="btnPayment" class="btn btn-primary pull-right">
                    <i class="fa fa-dollar"></i>
                    Bayar
                </button>
            @endif

            @if ( $invoice->status == "pending" )
                <button id="btnCancel" class="btn btn-danger pull-left">
                    <i class="fa fa-close"></i>
                    Batal
                </button>
            @endif
        </div>
    </div>

    <!-- add destination location -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDestinationLocation">
        <div class="modal-dialog" role="document" style="width: 100%;">
            <div class="modal-content">
                <form action="#" method="#" id="formDestinationLocation" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Jalan</label>

                                <div class="col-sm-12">
                                    <textarea name="street" id="street" class="form-control" placeholder="Silahkan Masukkan Jalan"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Provinsi</label>
                                <div class="col-sm-12">
                                    <select name="province" id="province" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($province as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">Kabupaten / Kota</label>
                                <div class="col-sm-12">
                                    <select name="district" id="district" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">Kecamatan</label>
                                <div class="col-sm-12">
                                    <select name="sub_district" id="sub_district" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add destination now -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDestinationNow">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formDestinationNow">
                    {{ csrf_field() }}
                    <input type="hidden" id="id_invoice" name="id_invoice" value="{{ $invoice->id }}">

                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Tujuan Pengiriman</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menggunakan alamat sekarang ?</p>
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

    <!-- payment -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalPayment">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formPayment">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    {{ csrf_field() }}

                    <div class="modal-header">
                        <h4 class="modal-title">Bayar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin melakukan pembayaran ?</p>
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

    <!-- cancel -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formCancel">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    {{ csrf_field() }}

                    <div class="modal-header">
                        <h4 class="modal-title">Batalkan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan pembayaran ?</p>
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

    <!-- add voucher -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalVoucher">
        <div class="modal-dialog" role="document" style="width: 100%;">
            <div class="modal-content">
                <form action="#" method="#" id="formVoucher" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Silahkan gunakan voucher yang anda miliki. Untuk mendapatkan potongan harga.</label>
                                <div class="col-sm-12">
                                    <select name="voucher_id" id="voucher_id" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($invoice->user->user_vouchers as $item)
                                            <option value="{{ $item->id }}">{{ $item->voucher->name }} potongan harga {{ $item->voucher->discount }}%</option>
                                        @endforeach
                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#district').prop('disabled', true);
            $('#sub_district').prop('disabled', true);
            $('#province').on('change', function() {
                if (this.value != "") {
                    $('#district').prop('disabled', false);

                    $('#district')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">-- Pilih Salah Satu --</option>')
                    ;

                    @foreach ($district as $item)
                        if( {{ $item->province_id }} == this.value){
                            $("#district").append('<option value={{ $item->id }}>{{ $item->name }}</option>');
                        }
                    @endforeach
                } else {
                    $('#district').prop('disabled', true);

                    $('#district')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">-- Pilih Salah Satu --</option>')
                    ;
                }
            });
            $('#district').on('change', function() {
                if (this.value != "") {
                    $('#sub_district').prop('disabled', false);

                    $('#sub_district')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">-- Pilih Salah Satu --</option>')
                    ;

                    @foreach ($sub_district as $item)
                        if( {{ $item->district_id }} == this.value){
                            $("#sub_district").append('<option value={{ $item->id }}>{{ $item->name }}</option>');
                        }
                    @endforeach
                } else {
                    $('#sub_district').prop('disabled', true);

                    $('#sub_district')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">-- Pilih Salah Satu --</option>')
                    ;
                }
            });

            // Destination New
            $('#btnDestinationLocation').click(function () {
                $('#formDestinationLocation')[0].reset();
                $('#formDestinationLocation .modal-title').text("Tambah Tujuan Pengiriman");
                $('#formDestinationLocation div.form-group').removeClass('has-error');
                $('#formDestinationLocation .help-block').empty();
                $('#formDestinationLocation button[type=submit]').button('reset');

                $('#formDestinationLocation input[name="_method"]').remove();
                url = '{{ route("invoice.destination-location-new") }}';

                $('#modalDestinationLocation').modal('show');
            });

            $('#formDestinationLocation').submit(function (event) {
                event.preventDefault();
    		 	$('#formDestinationLocation button[type=submit]').button('loading');
    		 	$('#formDestinationLocation div.form-group').removeClass('has-error');
    	        $('#formDestinationLocation .help-block').empty();

    		 	var _data = $("#formDestinationLocation").serialize();

    		 	$.ajax({
                    url: url,
                    method: 'POST',
                    data: _data,
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

                        $('#formDestinationLocation')[0].reset();
                        $('#formDestinationLocation button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formDestinationLocation').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formDestinationLocation input[name='" + data[key].name + "']").length )
                                        elem = $("#formDestinationLocation input[name='" + data[key].name + "']");
                                    else if( $("#formDestinationLocation textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formDestinationLocation textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formDestinationLocation select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
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
                        $('#formDestinationLocation button[type=submit]').button('reset');
                    }
                });
            });

            // Destination Now
            $('#btnDestinationNow').click(function () {
                url = '{{ route("invoice.destination-location-now") }}';
                $('#modalDestinationNow').modal('show');
            });

            $('#formDestinationNow').submit(function (event) {
                event.preventDefault();

                $('#modalDestinationNow button[type=submit]').button('loading');
                var _data = $("#formDestinationNow").serialize();

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
                        $('#modalDestinationNow button[type=submit]').button('reset');
                        $('#formDestinationNow')[0].reset();
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

                        $('#formDestinationNow button[type=submit]').button('reset');
                    }
                });
            });

            // Payment
            $('#btnPayment').click(function () {
                url = '{{ route("invoice.payment") }}';
                $('#modalPayment').modal('show');
            });

            $('#formPayment').submit(function (event) {
                event.preventDefault();

                $('#modalPayment button[type=submit]').button('loading');
                var _data = $("#formPayment").serialize();

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
                        $('#modalPayment button[type=submit]').button('reset');
                        $('#formPayment')[0].reset();
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

                        $('#formPayment button[type=submit]').button('reset');
                    }
                });
            });

            // Cancel
            $('#btnCancel').click(function () {
                url = '{{ route("invoice.cancel") }}';
                $('#modalCancel').modal('show');
            });

            $('#formCancel').submit(function (event) {
                event.preventDefault();

                $('#modalCancel button[type=submit]').button('loading');
                var _data = $("#formCancel").serialize();

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
                        $('#modalCancel button[type=submit]').button('reset');
                        $('#formCancel')[0].reset();
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

                        $('#formCancel button[type=submit]').button('reset');
                    }
                });
            });

            // voucher
            $('#btnVoucher').click(function () {
                $('#formVoucher')[0].reset();
                $('#formVoucher .modal-title').text("Tambah Voucher");
                $('#formVoucher div.form-group').removeClass('has-error');
                $('#formVoucher .help-block').empty();
                $('#formVoucher button[type=submit]').button('reset');

                $('#formVoucher input[name="_method"]').remove();
                url = '{{ route("invoice.use-voucher") }}';

                $('#modalVoucher').modal('show');
            });

            $('#formVoucher').submit(function (event) {
                event.preventDefault();
    		 	$('#formVoucher button[type=submit]').button('loading');
    		 	$('#formVoucher div.form-group').removeClass('has-error');
    	        $('#formVoucher .help-block').empty();

    		 	var _data = $("#formVoucher").serialize();

    		 	$.ajax({
                    url: url,
                    method: 'POST',
                    data: _data,
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

                        $('#formVoucher')[0].reset();
                        $('#formVoucher button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formVoucher').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formVoucher input[name='" + data[key].name + "']").length )
                                        elem = $("#formVoucher input[name='" + data[key].name + "']");
                                    else if( $("#formVoucher textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formVoucher textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formVoucher select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
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
                        $('#formVoucher button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
