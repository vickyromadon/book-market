@extends('layouts.admin')

@section('header')
    <h1>
        TopUp Saldo
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">TopUp Saldo</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nominal</th>
                            <th>Tanggal Transfer</th>
                            <th>Status</th>
                            <th>Member</th>
                            <th>Tanggal di Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            var table = $('#data_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.topup.index') }}",
                    "type": "POST",
                    "data" : {}
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
                        "data": "nominal",
                        "orderable": true,
                    },
                    {
                        "data": "transfer_date",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        "orderable": true,
                    },
                    {
                        "data": "user",
                        render : function(data, type, row){
                            return data.name;
                        },
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return '<a href="{{ route('admin.topup.index') }}/'+ row.id +'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 5, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
