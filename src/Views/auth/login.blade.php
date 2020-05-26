<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'DVPLEX') }} Login</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/after.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body class="login-page">
@if (!$creds)
    <div class="login-box">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-body login-card-body" id="app">
                <div class="brand">
                    <img class="brand-img" src="/images/th-logo-login.png" alt="{{ config('app.name', 'DVPLEX') }}">
                    <h2 class="brand-text font-size-18"></h2>
                </div>
                <form method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="floating-label">{{ __('auth.username/email') }}</label>
                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"/>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ __('auth.password') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"/>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group clearfix">
                        <label for="inputCheckbox" {{ old('remember') ? 'checked' : '' }}> {{ __('auth.remember me') }}</label>
                        <input type="checkbox" id="inputCheckbox" name="remember">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">{{ __('auth.login') }}</button>

                </form>
            </div>
        </div>
    </div>
@else
    <div class="login-box" id="app">

        <div class="card card-primary card-outline card-tabs">

            <div class="lockscreen-logo">
                <div class="brand">
                    <img class="brand-img" src="/images/th-logo-login.png" alt="{{ config('app.name', 'DVPLEX') }}">
                    <h2 class="brand-text font-size-18"></h2>
                </div>
            </div>
            <div class="card-body login-card-body">

                <div class="lockscreen-name">{{ $creds->name }}</div>

                <div class="lockscreen-item">
                    <!-- lockscreen image -->
                    <div class="lockscreen-image">
                        <img src="/images/avatar/{{ $creds->avatar }}" alt="User Image">
                    </div>
                    <!-- /.lockscreen-image -->

                    <!-- lockscreen credentials (contains the form) -->
                    <form method="post" action="{{ route('login') }}" class="lockscreen-credentials">
                        {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $creds->username ?? $creds->email }}">
                        <div class="input-group">
                            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="password">

                            <div class="input-group-append">
                                <button type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- /.lockscreen credentials -->

                </div>
                @if ($errors->has('password'))
                    <div class="login-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
                @if ($errors->has('email'))
                    <div class="login-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
                <div class="lock-additional">
                    <div class="help-block text-center">
                        {{ __('auth.Enter credentials') }}
                    </div>
                    <div class="text-center">
                        <a href="javascript: void(0);" onclick="event.preventDefault();document.getElementById('logout-form1').submit();">{{ __('auth.Sign different') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endif
<script src="/js/app.js"></script>
</body>
</html>
