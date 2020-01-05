<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME') }}</title>
    <link href="{{ asset('/templates/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/templates/css/modern-business.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('store.index') }}">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    @if( Auth::user() )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('store.profile.index') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="min-height:100vh;">
        <h1 class="mt-4 mb-3">Profile
            <small>Penjual</small>
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('store.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#setting">Pengaturan Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#password">Kata Sandi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#avatar">Foto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#location">Lokasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#balance">Saldo</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="setting" class="container tab-pane active"><br>
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal" id="formSetting">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Nama Toko</label>

                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Toko">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">No Handphone</label>

                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Handphone">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Deskripsi Toko</label>

                                        <div class="col-sm-12">
                                            <textarea name="description" id="description" class="form-control" placeholder="Masukkan Deskripsi Toko"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Jam Buka</label>

                                        <div class="col-sm-12">
                                            <input type="time" id="open_time" name="open_time" class="form-control">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Jam Tutup</label>

                                        <div class="col-sm-12">
                                            <input type="time" id="close_time" name="close_time" class="form-control">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-12 col-sm-9">
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <th>Nama Toko</th>
                                        <td> : </td>
                                        <td>
                                            {{ $store != null ? $store->name : "" }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. Handphone</th>
                                        <td> : </td>
                                        <td>
                                            {{ $user->phone != null ? $user->phone : "-" }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi Toko</th>
                                        <td> : </td>
                                        <td>
                                            {{ $store != null ? $store->description : "" }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jam Buka</th>
                                        <td> : </td>
                                        <td>
                                            {{ $store != null ? $store->open_time : "" }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jam Tutup</th>
                                        <td> : </td>
                                        <td>
                                            {{ $store != null ? $store->close_time : "" }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="password" class="container tab-pane fade"><br>
                        <form class="form-horizontal" id="formPassword">
                            {{ csrf_field() }}
							<div class="form-group">
								<label class="col-sm-12 control-label">Kata Sandi Lama</label>
								<div class="col-sm-12">
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan Kata Sandi Lama">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label">Kata Sandi Baru</label>

								<div class="col-sm-12">
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan Kata Sandi Baru">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label">Konfirmasi Kata Sandi</label>

								<div class="col-sm-12">
									<input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Masukkan Konfirmasi Kata Sandi">

									<span class="help-block"></span>
								</div>
							</div>

							<div class="form-group">
			                    <div class="col-sm-offset-4 col-sm-8">
			                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
                    </div>
                    <div id="avatar" class="container tab-pane fade"><br>
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal" id="formAvatar">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Foto Toko</label>

                                        <div class="col-sm-12">
                                            <input type="file" class="form-control" id="image" name="image">

                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                @if ( $store != null && $store->image != null )
                                    <img src="{{ asset('storage/'. $store->image)}}" class="img-thumbnail" width="304" height="236">
                                @else
                                    <img src="{{ asset('images/book_store.jpg') }}" class="img-thumbnail" width="304" height="236">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="location" class="container tab-pane fade"><br>
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal" id="formLocation">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Alamat</label>

                                        <div class="col-sm-12">
                                            <textarea name="street" id="street" class="form-control" placeholder="Masukkan Alamat"></textarea>
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
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <th>Alamat</th>
                                        <td> : </td>
                                        <td>
                                            @if ($store != null && $store->location != null)
                                                {{ $store->location->street }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Provinsi</th>
                                        <td> : </td>
                                        <td>
                                            @if ($store != null && $store->location != null)
                                                {{ $store->location->province }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kabupaten / Kota</th>
                                        <td> : </td>
                                        <td>
                                            @if ($store != null && $store->location != null)
                                                {{ $store->location->district }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <td> : </td>
                                        <td>
                                            @if ($store != null && $store->location != null)
                                                {{ $store->location->sub_district }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="balance" class="container tab-pane fade"><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-3 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{ env('APP_NAME') }} 2019</p>
        </div>
    </footer>

    <script src="{{ asset('/templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($){
            // Setting
            $('#formSetting').submit(function (event) {
                event.preventDefault();
    		 	$('#formSetting button[type=submit]').button('loading');
    		 	$('#formSetting div.form-group').removeClass('has-error');
    	        $('#formSetting .help-block').empty();

    		 	var _data = $("#formSetting").serialize();

    		 	$.ajax({
                    url: "{{ route('store.profile.setting')}}",
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
    	                    }, 2000);
                        } else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formSetting')[0].reset();
                        $('#formSetting button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSetting').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formSetting input[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting input[name='" + data[key].name + "']");
                                    else if( $("#formSetting textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formSetting select[name='" + data[key].name + "']");
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
                        $('#formSetting button[type=submit]').button('reset');
                    }
                });
    		});

            // Password
            $('#formPassword').submit(function (event) {
                event.preventDefault();
    		 	$('#formPassword button[type=submit]').button('loading');
    		 	$('#formPassword div.form-group').removeClass('has-error');
    	        $('#formPassword .help-block').empty();

    		 	var _data = $("#formPassword").serialize();

    		 	$.ajax({
                    url: "{{ route('store.profile.password')}}",
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
    	                    }, 2000);
                        } else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formPassword')[0].reset();
                        $('#formPassword button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPassword').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formPassword input[name='" + data[key].name + "']").length )
                                        elem = $("#formPassword input[name='" + data[key].name + "']");
                                    else if( $("#formPassword textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formPassword textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formPassword select[name='" + data[key].name + "']");
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
                        }else {
                            swal({
                                title: "Gagal",
                                text: "Whoops, looks like something went wrong.",
                                icon: "error",
                            });
                        }
                        $('#formPassword button[type=submit]').button('reset');
                    }
                });
    		});

            // Avatar
            $('#formAvatar').submit(function (event) {
                event.preventDefault();
                $('#formAvatar button[type=submit]').button('loading');
                $('#formAvatar div.form-group').removeClass('has-error');
                $('#formAvatar .help-block').empty();

                var formData = new FormData($("#formAvatar")[0]);

                $.ajax({
                    url: "{{ route('store.profile.avatar') }}",
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

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else{
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }
                        $('#formAvatar button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            if(error['image'] != undefined){
                                $("#formAvatar input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAvatar input[name='image']").parent().find('.help-block').show();
                                $("#formAvatar input[name='image']").parent().find('.help-block').css("color", "red");
                                $("#formAvatar input[name='image']").parent().parent().addClass('has-error');
                            }
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
                        $('#formAvatar button[type=submit]').button('reset');
                    }
                });
            });

            // Location
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

            $('#formLocation').submit(function (event) {
                event.preventDefault();
    		 	$('#formLocation button[type=submit]').button('loading');
    		 	$('#formLocation div.form-group').removeClass('has-error');
    	        $('#formLocation .help-block').empty();

    		 	var _data = $("#formLocation").serialize();

    		 	$.ajax({
                    url: "{{ route('store.profile.location')}}",
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
    	                    }, 2000);
                        } else {
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }

                        $('#formLocation')[0].reset();
                        $('#formLocation button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formLocation').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formLocation input[name='" + data[key].name + "']").length )
                                        elem = $("#formLocation input[name='" + data[key].name + "']");
                                    else if( $("#formLocation textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formLocation textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formLocation select[name='" + data[key].name + "']");
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
                        $('#formLocation button[type=submit]').button('reset');
                    }
                });
    		});
        });
    </script>

</body>
</html>
