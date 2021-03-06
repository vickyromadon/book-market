@extends('layouts.admin')

@section('header')
    <h1>
        Pengelola Penjual
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Pengelola Penjual</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Saldo</th>
                                    <th>Nama Toko</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $item)
                                        @if ($item->roles[0]->name != "administrator" && $item->roles[0]->name != "member")
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->balance }}</td>
                                                <td>{{ $item->store == null ? "-" : $item->store->name }}</td>
                                                <td>
                                                    @if ($item->status == 'active')
                                                        Aktif
                                                    @else
                                                        Blok
                                                    @endif
                                                </td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    @if ($item->status == 'active')
                                                        <a href="#" data-userid="{{ $item->id }}" class="block-btn btn btn-xs btn-danger"><i class="fa fa-close"></i></a>
                                                    @else
                                                        <a href="#" data-userid="{{ $item->id }}" class="active-btn btn btn-xs btn-primary"><i class="fa fa-check"></i></a>
                                                    @endif
                                                    <a href="#" data-userid="{{ $item->id }}" class="reset-btn btn btn-xs btn-warning"><i class="fa fa-refresh"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- block -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalBlock">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.management-store.block', ['id' => '#']) }}" method="post" id="formBlock">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Blok Pengguna</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin blok pengguna ini ?</p>
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

    <!-- active -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalActive">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.management-store.active', ['id' => '#']) }}" method="post" id="formActive">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Aktifkan Pengguna</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin aktifkan pengguna ini ?</p>
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

    <!-- reset-password -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalResetPassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.management-store.reset-password', ['id' => '#']) }}" method="post" id="formResetPassword">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Reset Password Pengguna</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin Reset Password pengguna ini ?</p>
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
            $('#data_table').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            // Block
            $('#data_table').on('click', '.block-btn' , function(e){
                url = $('#formBlock').attr('action').replace('#', $(this).data('userid'));
                $('#modalBlock').modal('show');
            });

            $('#formBlock').submit(function (event) {
                event.preventDefault();

                $('#modalBlock button[type=submit]').button('loading');
                var _data = $("#formBlock").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 2000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#modalBlock button[type=submit]').button('reset');
                        $('#formBlock')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formBlock button[type=submit]').button('reset');
                    }
                });
            });

            // Active
            $('#data_table').on('click', '.active-btn' , function(e){
                url = $('#formActive').attr('action').replace('#', $(this).data('userid'));
                $('#modalActive').modal('show');
            });

            $('#formActive').submit(function (event) {
                event.preventDefault();

                $('#modalActive button[type=submit]').button('loading');
                var _data = $("#formActive").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 2000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#modalActive button[type=submit]').button('reset');
                        $('#formActive')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formActive button[type=submit]').button('reset');
                    }
                });
            });

            // Reset Password
            $('#data_table').on('click', '.reset-btn' , function(e){
                url = $('#formResetPassword').attr('action').replace('#', $(this).data('userid'));
                $('#modalResetPassword').modal('show');
            });

            $('#formResetPassword').submit(function (event) {
                event.preventDefault();

                $('#modalResetPassword button[type=submit]').button('loading');
                var _data = $("#formResetPassword").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 2000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#modalResetPassword button[type=submit]').button('reset');
                        $('#formResetPassword')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formResetPassword button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
