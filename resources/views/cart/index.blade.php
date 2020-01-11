@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Keranjang
        <small>Buku</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Keranjang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card">
		        <div class="card-body table-responsive">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead class="thead-light">
                                <tr >
                                    <th class="center">No</th>
                                    <th class="text-center">Judul</th>
                                    <th class="text-center">Gambar</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Harga</th>
                                    <th class="center text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($cart); $i++)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $cart[$i]->product->title }}</td>
                                        <td>
                                            @if ($cart[$i]->product->image != null)
                                                <img class="img-fluid rounded" src="{{ asset('storage/'. $cart[$i]->product->image)}}" style="width:150px; height:150px;">
                                            @else
                                                <img class="img-fluid rounded" src="{{ asset('images/book.jpg') }}" style="width:150px; height:150px;">
                                            @endif
                                        </td>
                                        <td>{{ $cart[$i]->quantity }}</td>
                                        <td>Rp. {{ number_format($cart[$i]->price) }}</td>
                                        <td>
                                            <a href="#" data-cartid="{{ $cart[$i]->id }}" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp;
                                            <a href="#" data-cartid="{{ $cart[$i]->id }}" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
		        </div>
		    </div>
		</div>
    </div>

    <!-- edit cart -->
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
                            <input type="hidden" id="cart_id" name="cart_id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jumlah</label>

                                <div class="col-sm-9">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" min="1">
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
                <form action="{{ route('cart.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Produk ?</p>
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
            $(document).ready( function () {
                $('#data_table').DataTable();
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Produk");
                $('#formAdd')[0].reset();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("cart.index") }}' + '/' + $(this).data('cartid');

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
                url =  $('#formDelete').attr('action').replace('#', $(this).data('cartid'));
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
        });
    </script>
@endsection
