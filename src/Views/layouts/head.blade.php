<head>
	<meta charset=" utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>{{ config('app.name', 'DVPLEX') }}</title>

	<link rel="apple-touch-icon-precomposed" href="/favicon.png" color="white"/>
	<link rel="shortcut icon" href="/favicon.ico"/>

	<!-- Stylesheets -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/after.css') }}" rel="stylesheet">
	@include( config('phantom.modules.current') .'::layouts.head')

</head>
