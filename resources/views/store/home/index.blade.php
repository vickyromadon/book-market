@extends('layouts.store')

@section('header')
    <h1 class="mt-4 mb-3">Dashboard
        <small>Penjual</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('store.index') }}">Dashboard</a>
        </li>
    </ol>
@endsection

@section('content')
    <h2>Selamat Datang di Dashboar Penjual</h2>

    <div class="row">
        <div class="col-lg-3">
            <a href="{{ route('store.product.index') }}" style="color:black;">
                <div class="card bg-danger">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{ $product }}</h3>

                            <p>Jumlah Produk</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-entry.index') }}" style="color:black;">
                <div class="card bg-warning">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_payment}}</h3>

                            <p>Pesanan Masuk</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-shipped.index') }}" style="color:black;">
                <div class="card bg-success">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_approve}}</h3>

                            <p>Pesanan Dikirim</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{ route('store.order-received.index') }}" style="color:black;">
                <div class="card bg-primary">
                    <div class="col-lg-12">
                        <div class="inner">
                            <h3>{{$invoice_done}}</h3>

                            <p>Pesanan Diterima</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <br>

    @if (Auth::user()->store != null)
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-dark bg-light">
                    <div class="card-header bg-default text-center text-dark">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <span class="form-group-addon"><b>&nbsp;</b></span>
                                    <div id="periode_date" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                        <span></span> <b class="caret"></b>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 align-bottom">
                                    <span class="form-group-addon"><b>&nbsp;</b></span>
                                    <button id="btnFilter" class="form-control btn btn-md btn-primary"><i class="fa fa-filter"></i> Menyaring</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-12 chart-responsive">
                                <div id="line-cart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
    @if (Auth::user()->store != null)
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <script>
            jQuery(document).ready(function($) {
                var line = new Morris.Line({
                    element: 'line-cart',
                    resize: true,
                    xkey: 'date',
                    ykeys: ['total'],
                    labels: ['Total'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto',
                    xLabelAngle: 45,
                });

                var getChartData = function () {
                    $.ajax({
                        url: '{{ route("store.index") }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "periode_date" : $('#periode_date span').text(),
                            "_token": "{{ csrf_token() }}",
                        },

                        success: function (response) {
                            line.setData(response);
                            console.log(response);
                            if (response.length > 0) {
                                line.draw();
                            } else {
                                console.log(response.length)
                            }
                        }
                    });
                };

                $('#btnFilter').click(function (e) {
                    e.preventDefault();
                    getChartData();
                });
            });
        </script>

        <script>
            $(function() {
                var start = moment().startOf('year');
                var end = moment().endOf('year');

                function cb(start, end) {
                    $('#periode_date span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                }

                $('#periode_date').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'This Week' : [moment().startOf('week'), moment().endOf('week')],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year' : [moment().startOf('year'), moment().endOf('year')]
                    }
                }, cb);
                cb(start, end);
            });
        </script>
    @endif
@endsection
