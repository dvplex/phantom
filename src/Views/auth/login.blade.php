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
<div class="login-box">
	<div class="card card-primary card-outline card-tabs">
		<div class="card-body login-card-body" id="app">
			<div class="brand">
				<img class="brand-img" src="/images/th-logo-login.png" alt="Telehouse">
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
<script src="/js/app.js"></script>
</body>
</html>
