@extends('layouts.auth')

@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#">{{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Masukkan Email dan Password</p>
    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <!-- /.col -->
            <button type="submit" class="btn btn-default btn-block btn-flat">Masuk</button>
            <!-- /.col -->

            <div>
                <br>
                <p class="pull-left"><a href="{{ route('index') }}"><u>Beranda</u></a></p>
                <p class="pull-right">Member Baru ? <a href="{{ route('register') }}"><u>Daftar Sekarang</u></a></p>
            </div>
        </div>

    </form>
@endsection
