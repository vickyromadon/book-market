@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Kontak
        <small>Kirim Pesan</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Kontak</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="POST" id="formMessage">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-12 control-label">Nama</label>

                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama">

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">Email</label>

                    <div class="col-sm-12">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">Kategori</label>

                    <div class="col-sm-12">
                        <select name="category" id="category" class="form-control">
                            <option value="">-- Pilih Salah Satu --</option>
                            <option value="keluhan">Keluhan</option>
                            <option value="laporan">Laporan</option>
                            <option value="reset password">Permintaan Reset Password</option>
                        </select>

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">Pesan</label>

                    <div class="col-sm-12">
                        <textarea name="description" id="description" class="form-control" rows="10" cols="100" placeholder="Masukkan Pesan"></textarea>

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-send"></i> Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#formMessage').submit(function (event) {
                event.preventDefault();
    		 	$('#formMessage button[type=submit]').button('loading');
    		 	$('#formMessage div.form-group').removeClass('has-error');
    	        $('#formMessage .help-block').empty();

    		 	var _data = $("#formMessage").serialize();

    		 	$.ajax({
                    url: "{{ route('message.index') }}",
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
                        }
                        else{
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formMessage')[0].reset();
                        $('#formMessage button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formMessage').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formMessage input[name='" + data[key].name + "']").length )
                                        elem = $("#formMessage input[name='" + data[key].name + "']");
                                    else if( $("#formMessage textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formMessage textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formMessage select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");

                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
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
                        $('#formMessage button[type=submit]').button('reset');
                    }
                });
    		});
        });
    </script>
@endsection
