@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Voucher
        <small>Belanja</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Voucher</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        @foreach ($voucher as $item)
            <div class="col-sm-4">
                <div class="card text-dark bg-light">
                    <div class="card-header bg-default text-center text-dark">
                        <h4>{{ $item->name }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Potongan Harga</h5>
                        <h1>{{ $item->discount }}%</h1>
                        <h6>Dapat ditukar dengan {{ $item->point_exchange }} poin</h6>
                        <h6>Tersedia {{ $item->count }} voucher</h6>
                    </div>
                    <div class="card-footer bg-default text-center">
                        <a href="#" data-voucherid="{{ $item->id }}" class="btnChange btn btn-danger btn-sm">
                            <i class="fa fa-refresh"></i> Tukar
                        </a>
                    </div>
                </div>
                <br>
            </div>
        @endforeach
    </div>

    <!-- change point -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalChange">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formChange">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Tukar Poin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menukar poin ?</p>
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
            var url;
            var idVoucher;
            // add
            $('.row').on('click', '.btnChange', function(e){
                $('#formChange')[0].reset();
                $('#formChange .modal-title').text("Tukar Poin");
                $('#formChange div.form-group').removeClass('has-error');
                $('#formChange .help-block').empty();
                $('#formChange button[type=submit]').button('reset');

                $('#formChange input[name="_method"]').remove();
                url = '{{ route("voucher.store") }}';
                idVoucher = $(this).data('voucherid');

                $('#modalChange').modal('show');
            });

            $('#formChange').submit(function (event) {
                event.preventDefault();
                $('#formChange div.form-group').removeClass('has-error');
                $('#formChange .help-block').empty();
                $('#formChange button[type=submit]').button('loading');

                var formData = new FormData($("#formChange")[0]);
                formData.append('voucher_id', idVoucher);

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

                        $('#formChange button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formChange').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formChange input[name='" + data[key].name + "']").length )
                                        elem = $("#formChange input[name='" + data[key].name + "']");
                                    else if( $("#formChange select[name='" + data[key].name + "']").length )
                                        elem = $("#formChange select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formChange textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formChange input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formChange input[name='image']").parent().find('.help-block').show();
                                $("#formChange input[name='image']").parent().find('.help-block').css("color", "red");
                                $("#formChange input[name='image']").parent().parent().addClass('has-error');
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
                        $('#formChange button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
