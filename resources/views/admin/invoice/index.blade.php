@extends('layouts.admin')

@section('header')
    <h1>
        Penjualan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Penjualan</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-header with-border">
            <form>
                <div class="row">
                    <div class="form-group col-md-6">
                        <span class="form-group-addon"><b>&nbsp;</b></span>
                        <select class="form-control" id="status" name="status">
                            <option value="">Pilih Status</option>
                            <option value="pending">Tertunda</option>
                            <option value="reject">Ditolak</option>
                            <option value="cancel">Dibatalkan</option>
                            <option value="approve">Dalam Pengiriman</option>
                            <option value="payment">Menunggu Konfirmasi</option>
                            <option value="done">Sudah Diterima</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 align-bottom">
                        <span class="form-group-addon"><b>&nbsp;</b></span>
                        <button id="btnFilter" class="form-control btn btn-md btn-primary"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Invoice</th>
                            <th>Status</th>
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
                    "url": "{{ route('admin.invoice.index') }}",
                    "type": "POST",
                    "data" : function(d){
                        return $.extend({},d,{
                            'status' : $('#status').val(),
                        });
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
                        "data": "number",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        render : function(data, type, row){
                            if (data == "pending") {
                                return "Tertunda";
                            } else if( data == "reject" ) {
                                return "Ditolak";
                            } else if( data == "cancel" ) {
                                return "Dibatalkan";
                            } else if( data == "approve" ) {
                                return "Dalam Pengiriman";
                            } else if( data == "payment" ) {
                                return "Menunggu Konfirmasi";
                            } else {
                                return "Sudah Diterima"
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
                            return '<a href="{{ route('admin.invoice.index') }}/'+ row.id +'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 3, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            $('#btnFilter').click(function (e) {
               e.preventDefault();
               table.draw();
            });
        });
    </script>
@endsection
