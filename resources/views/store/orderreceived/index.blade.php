@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Pengelolaan
        <small>Pesanan Diterima</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Pesanan Diterima</li>
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
                                    <th class="text-center">Nomor Invoice</th>
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
                    "url": "{{ route('store.order-received.index') }}",
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
                        "data": "number",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return '<a href="{{ route('store.order-received.index') }}/'+ row.id +'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 2, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
