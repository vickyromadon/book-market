@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Pengelolaan
        <small>Bank</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Bank</li>
    </ol>
@endsection

@section('content')
    <div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
                    <a href="#" class="btn btn-primary btn-sm pull-right" id="btnAdd"><i class="fa fa-plus"></i> Tambah</a>
				</div>
		        <div class="card-body table-responsive">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead class="thead-light">
                                <tr >
                                    <th class="center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Nomor Rekening</th>
                                    <th class="text-center">Nama Pemilik</th>
                                    <th class="text-center">Tanggal di Buat</th>
                                    <th class="center text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
		        </div>
		    </div>
		</div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAdd">
        <div class="modal-dialog" role="document" style="width: 100%;">
            <div class="modal-content">
                <form action="#" method="post" id="formAdd" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Nama Bank</label>

                                <div class="col-sm-12">
                                    <select name="name" id="name" class="form-control">
                                    	<option value="">-- Pilih Salah Satu --</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="Mandiri">Mandiri</option>
                                        <option value="BCA">BCA</option>
                                        <option value="Maybank">Maybank</option>
                                        <option value="Syariah Mandiri">Syariah Mandiri</option>
                                        <option value="SUMUT">SUMUT</option>
                                        <option value="BTPN">BTPN</option>
                                        <option value="CIMB Niaga">CIMB Niaga</option>
                                        <option value="Sinarmas">Sinarmas</option>
                                        <option value="Mega">Mega</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">Nomor Rekening</label>

                                <div class="col-sm-12">
                                    <input type="text" id="number" name="number" class="form-control" placeholder="Masukkan No. Rekening">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">Nama Pemilik</label>

                                <div class="col-sm-12">
                                    <input type="text" id="owner" name="owner" class="form-control" placeholder="Masukkan Nama Pemilik Rekening">
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('store.bank.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Bank</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Bank ?</p>
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

@section('js')
	<script>
        jQuery(document).ready(function($){
            var table = $('#data_table').DataTable({
                "responsive": true,
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('store.bank.index') }}",
                    "type": "POST",
                    "data" : {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
                "columns": [
                    {
                       data: null,
                       render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                       },
                       "width": "20px",
                       "orderable": false,
                    },
                    {
                        "data": "name",
                        "orderable": true,
                    },
                    {
                        "data": "number",
                        "orderable": true,
                    },
                    {
                        "data": "owner",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 4, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            // add
            $('#btnAdd').click(function () {
                $('#formAdd')[0].reset();
                $('#formAdd .modal-title').text("Tambah Bank");
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd input[name="_method"]').remove();
                url = '{{ route("store.bank.store") }}';

                $('#modalAdd').modal('show');
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Bank");
                $('#formAdd')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("store.bank.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#name').val(aData.name);
                $('#number').val(aData.number);
                $('#owner').val(aData.owner);


                $('#modalAdd').modal('show');
            });

            $('#formAdd').submit(function (event) {
                event.preventDefault();
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('loading');

                var formData = new FormData($("#formAdd")[0]);

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

                        $('#formAdd button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formAdd').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formAdd input[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd input[name='" + data[key].name + "']");
                                    else if( $("#formAdd select[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formAdd textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formAdd input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAdd input[name='image']").parent().find('.help-block').show();
                                $("#formAdd input[name='image']").parent().find('.help-block').css("color", "red");
                                $("#formAdd input[name='image']").parent().parent().addClass('has-error');
                            }
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
                        $('#formAdd button[type=submit]').button('reset');
                    }
                });
            });

            // Delete
            $('#data_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDelete').attr('action').replace('#', aData.id);
                $('#modalDelete').modal('show');
            });

            $('#formDelete').submit(function (event) {
                event.preventDefault();

                $('#modalDelete button[type=submit]').button('loading');
                var _data = $("#formDelete").serialize();

                $.ajax({
                    url: url,
                    type: 'DELETE',
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
                        $('#modalDelete button[type=submit]').button('reset');
                        $('#formDelete')[0].reset();
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

                        $('#formDelete button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
