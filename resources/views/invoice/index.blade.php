@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Saya</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#pending">Belum Bayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#payment">Menunggu Tanggapan Toko</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#cancel">Dibatalkan</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="pending" class="container tab-pane active"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="table-responsive">
                                        <table id="data_table_invoice_pending" class="table table-striped table-bordered nowrap" style="width:100%">
                                            <thead class="thead-light">
                                                <tr >
                                                    <th class="center">No</th>
                                                    <th class="text-center">Nomor Invoice</th>
                                                    <th class="center text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($invoice_pending); $i++)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $invoice_pending[$i]->number }}</td>
                                                        <td>
                                                            <a href="{{ route('invoice.pending', ['id' => $invoice_pending[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
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
                </div>
                <div id="payment" class="container tab-pane fade"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="table-responsive">
                                        <table id="data_table_invoice_payment" class="table table-striped table-bordered nowrap" style="width:100%">
                                            <thead class="thead-light">
                                                <tr >
                                                    <th class="center">No</th>
                                                    <th class="text-center">Nomor Invoice</th>
                                                    <th class="center text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($invoice_payment); $i++)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $invoice_payment[$i]->number }}</td>
                                                        <td>
                                                            <a href="{{ route('invoice.waiting-store', ['id' => $invoice_payment[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
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
                </div>
                <div id="cancel" class="container tab-pane fade"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="table-responsive">
                                        <table id="data_table_invoice_cancel" class="table table-striped table-bordered nowrap" style="width:100%">
                                            <thead class="thead-light">
                                                <tr >
                                                    <th class="center">No</th>
                                                    <th class="text-center">Nomor Invoice</th>
                                                    <th class="center text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($invoice_cancel); $i++)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $invoice_cancel[$i]->number }}</td>
                                                        <td>
                                                            <a href="{{ route('invoice.canceled', ['id' => $invoice_cancel[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table_invoice_pending').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });
            $('#data_table_invoice_payment').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });
            $('#data_table_invoice_cancel').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });
        });
    </script>
@endsection


