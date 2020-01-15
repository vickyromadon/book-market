@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Buku
        <small>{{ $product->title }}</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Detail Buku</li>
        <li class="breadcrumb-item active">{{ $product->title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    @if ($product->image != null)
                        <img class="img-fluid rounded" src="{{ asset('storage/'. $product->image)}}" style="width:100%; height:500px;">
                    @else
                        <img class="img-fluid rounded" src="{{ asset('images/book.jpg') }}" style="width:100%; height:500px;">
                    @endif
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-left">
                        <i class="fa fa-calendar"></i>
                        Posting Pada {{ $product->created_at }}
                    </div>
                    <div class="pull-right">
                        <i class="fa fa-user"></i>
                        Posting Oleh {{ $product->store->name }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <h5 class="card-header">Keterangan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">Penerbit</a>
                                </li>
                                <li>
                                    <a href="#">Kategori</a>
                                </li>
                                <li>
                                    <a href="#">Jenjang</a>
                                </li>
                                <li>
                                    <a href="#">Tersedia</a>
                                </li>
                                <li>
                                    <a href="#">Harga</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    : {{ $product->publisher }}
                                </li>
                                <li>
                                    : {{ $product->category->name }}
                                </li>
                                <li>
                                    : {{ $product->level->name }}
                                </li>
                                <li>
                                    : {{ $product->quantity }}
                                </li>
                                <li>
                                    : Rp. {{ number_format($product->price) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if( Auth::user() )
            <hr>
            <button id="btnCart" class="btn btn-warning col-lg-12">
                <i class="fa fa-cart-plus"></i>
                Tambah Keranjang
            </button>
            @endif
        </div>
    </div>

    <!-- add cart -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCart">
        <div class="modal-dialog" role="document" style="width: 100%;">
            <div class="modal-content">
                <form action="#" method="post" id="formCart" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jumlah</label>

                                <div class="col-sm-9">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" min="1" max="{{ $product->quantity }}">
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
            // add cart
            $('#btnCart').click(function () {
                $('#formCart')[0].reset();
                $('#formCart .modal-title').text("Tambah Keranjang");
                $('#formCart div.form-group').removeClass('has-error');
                $('#formCart .help-block').empty();
                $('#formCart button[type=submit]').button('reset');

                $('#formCart input[name="_method"]').remove();

                $('#modalCart').modal('show');
            });

            $('#formCart').submit(function (event) {
                event.preventDefault();
                $('#formCart button[type=submit]').button('loading');
                $('#formCart div.form-group').removeClass('has-error');
                $('#formCart .help-block').empty();

                var formData = new FormData($("#formCart")[0]);

                $.ajax({
                    url: "{{ route('cart.store') }}",
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
                        }
                        else{
                            swal({
                                title: "Gagal",
                                text: response.message,
                                icon: "error",
                            });
                        }
                        $('#formCart button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up

                            var error = response.responseJSON.errors;
                            var data = $('#formCart').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formCart input[name='" + data[key].name + "']").length )
                                        elem = $("#formCart input[name='" + data[key].name + "']");
                                    else if( $("#formCart textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formCart textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formCart select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });

                            if(error['proof'] != undefined){
                                $("#formCart input[name='proof']").parent().find('.help-block').text(error['proof']);
                                $("#formCart input[name='proof']").parent().find('.help-block').show();
                                $("#formCart input[name='proof']").parent().find('.help-block').css("color", "red");
                                $("#formCart input[name='proof']").parent().parent().addClass('has-error');
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
                        $('#formCart button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
