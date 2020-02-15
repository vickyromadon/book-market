@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Donasi
        <small>Buku</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Donasi Buku</li>
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
                                    <th class="text-center">Judul</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Status</th>
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
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Judul</label>

                                <div class="col-sm-12">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan Judul">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Jumlah</label>

                                <div class="col-sm-12">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" min="0">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Gambar</label>

                                <div class="col-sm-12">
                                    <input type="file" id="image" name="image" class="form-control" placeholder="Masukkan Gambar">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Gambar 1</label>

                                <div class="col-sm-12">
                                    <input type="file" id="image_1" name="image_1" class="form-control" placeholder="Masukkan Gambar 1">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Gambar 2</label>

                                <div class="col-sm-12">
                                    <input type="file" id="image_2" name="image_2" class="form-control" placeholder="Masukkan Gambar 2">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Gambar 3</label>

                                <div class="col-sm-12">
                                    <input type="file" id="image_3" name="image_3" class="form-control" placeholder="Masukkan Gambar 3">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Tanggal Penjemputan</label>

                                <div class="col-sm-12">
                                    <input type="date" id="date" name="date" class="form-control" placeholder="Masukkan Tanggal Penjemputan">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Lokasi Penjemputan</label>

                                <div class="col-sm-12">
                                    <textarea name="location" id="location" class="form-control" placeholder="Masukkan Lokasi Penjemputan"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Pesan</label>

                                <div class="col-sm-12">
                                    <textarea name="message" id="message" class="form-control" placeholder="Masukkan Pesan"></textarea>
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
                <form action="{{ route('donation.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Donasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Donasi ?</p>
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

    <!-- view -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalView">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table style="border-spacing: 10px; border-collapse: separate;">
                        <tr>
                            <th>Judul</th>
                            <td>:</td>
                            <td id="title"></td>
                        </tr>
                        <tr>
                            <th>Gambar</th>
                            <td>:</td>
                            <td id="image"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                        <tr>
                            <th>Gambar 1</th>
                            <td>:</td>
                            <td id="image_1"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                        <tr>
                            <th>Gambar 2</th>
                            <td>:</td>
                            <td id="image_2"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                        <tr>
                            <th>Gambar 3</th>
                            <td>:</td>
                            <td id="image_3"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                        <tr>
                            <th>Lokasi Penjemputan</th>
                            <td>:</td>
                            <td id="location"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Penjemputan</th>
                            <td>:</td>
                            <td id="date"></td>
                        </tr>
                        <tr>
                            <th>Pesan</th>
                            <td>:</td>
                            <td id="message"></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>:</td>
                            <td id="quantity"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:</td>
                            <td id="status"></td>
                        </tr>
                        <tr>
                            <th>Alasan</th>
                            <td>:</td>
                            <td id="reason"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
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
                    "url": "{{ route('donation.index') }}",
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
                        "data": "title",
                        "orderable": true,
                    },
                    {
                        "data": "quantity",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        render : function(data, type, row){
                            if (data == "pending") {
                                return "Tertunda";
                            } else if(data == "approve") {
                                return "Diterima";
                            } else {
                                return "Ditolak"
                            }
                        },
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            if(row.status == 'pending'){
                                return	'<a href="#" class="view-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a> &nbsp' +
                                    '<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp' +
                                    '<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
                            } else {
                                return '<a href="#" class="view-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                            }

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

            var url;

            // add
            $('#btnAdd').click(function () {
                $('#formAdd')[0].reset();
                $('#formAdd .modal-title').text("Tambah Donasi");
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd input[name="_method"]').remove();
                url = '{{ route("donation.store") }}';

                $('#modalAdd').modal('show');
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Donasi");
                $('#formAdd')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("donation.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#title').val(aData.title);
                $('#description').val(aData.description);
                $('#quantity').val(aData.quantity);
                $('#message').val(aData.message);
                $('#location').val(aData.location);
                $('#date').val(aData.date);

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
    	                    }, 2000);
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
    	                    }, 2000);
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

            // View
            $('#data_table').on('click', '.view-btn', function(e){
                $('#modalView .modal-title').text("Lihat Slider");

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                $('#modalView #title').text(aData.title);
                if ( aData.image != null ) {
                    $('#modalView #image img').attr("src", "{{ asset('storage/')}}" + "/" + aData.image);
                } else {
                    $('#modalView #image img').attr("src", "{{ asset('images/book.jpg') }}");
                }
                if ( aData.image_1 != null ) {
                    $('#modalView #image_1 img').attr("src", "{{ asset('storage/')}}" + "/" + aData.image_1);
                } else {
                    $('#modalView #image_1 img').attr("src", "{{ asset('images/book.jpg') }}");
                }
                if ( aData.image_2 != null ) {
                    $('#modalView #image_2 img').attr("src", "{{ asset('storage/')}}" + "/" + aData.image_2);
                } else {
                    $('#modalView #image_2 img').attr("src", "{{ asset('images/book.jpg') }}");
                }
                if ( aData.image_3 != null ) {
                    $('#modalView #image_3 img').attr("src", "{{ asset('storage/')}}" + "/" + aData.image_3);
                } else {
                    $('#modalView #image_3 img').attr("src", "{{ asset('images/book.jpg') }}");
                }
                $('#modalView #message').text(aData.message);
                $('#modalView #quantity').text(aData.quantity);
                $('#modalView #location').text(aData.location);
                $('#modalView #date').text(aData.date);
                $('#modalView #reason').text(aData.reason);

                if (aData.status == 'pending') {
                    $('#modalView #status').text("Tertunda");
                } else if( aData.status == 'approve' ){
                    $('#modalView #status').text("Diterima");
                } else {
                    $('#modalView #status').text("Ditolak");
                }

                $('#modalView').modal('show');
            });
        });
    </script>
@endsection

