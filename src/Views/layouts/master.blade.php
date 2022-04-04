<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ app()->getLocale() }}">
@include('phantom::layouts.head')

@if(session('phantom.preferences.collapse_sidebar')!='on'||!session('phantom.preferences.collapse_sidebar'))
	@php $csb = '' @endphp
@else
	@php $csb = 'sidebar-collapse' @endphp
@endif

@if(session('phantom.preferences.disable_sidemenu')!='on'||!session('phantom.preferences.disable_sidemenu'))
	@php $dsm= 'layout-fixed' @endphp
@else
	@php $csb = '' @endphp
	@php $dsm= 'layout-top-nav' @endphp
@endif
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-footer-fixed {{ $dsm }} {{ $csb }} text-sm">
<div id="app" class="wrapper">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
		<a href="http://browsehappy.com/">upgrade
			your browser</a> to improve your experience.</p>
	<![endif]-->
@include('phantom::layouts.top-navbar')
@include('phantom::layouts.side-navbar')
<!-- Page -->

	<div class="content-wrapper">
		<div class="content-header">
			@include('phantom::layouts.page-header')
		</div>
		<div class="content">
			<vue-progress-bar></vue-progress-bar>
			@yield('content')
		</div>
	</div>
	<!-- End Page -->

	@include('phantom::layouts.footer')
</div>
<script src="{{ asset('js/app.js') }}"></script>
@include(config('phantom.modules.current') .'::layouts.scripts')
</body>
</html>
