<nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
	<!-- Left navbar links -->
	@if(session('phantom.preferences.disable_sidemenu')!='on'||!session('phantom.preferences.disable_sidemenu'))
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
	@else
		<div class="order-0 navbar-nav">
			<a href="/admin/">
				<img src="/images/th-logo-login.png" alt="Dvplex" class="brand-image">
				<span class="brand-text font-weight-light">&nbsp;</span>
			</a>
		</div>
	@endif
	@if(session('phantom.preferences.disable_topmenu')!='on'||!session('phantom.preferences.disable_topmenu'))
		<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse order-3" id="navbarCollapse">
			{{ phantom()->menu('top') }}
		</div>
	@endif

<!-- Right navbar links -->
	@if(Session::get('locale')=='en')
		@php($flag='us')
	@else
		@php($flag=app()->getLocale())
	@endif
	<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
		<!-- Messages Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
			   aria-expanded="false" role="button">
				<span class="flag-icon flag-icon-{{ $flag }}"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" role="menu">
				<a class="dropdown-item" href="/locale/en" role="menuitem">
					<span class="flag-icon flag-icon-us"></span> English</a>
				<a class="dropdown-item" href="/locale/bg" role="menuitem">
					<span class="flag-icon flag-icon-bg"></span> Български</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			@if(Auth::check())
				<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false"
				   data-animation="scale-up" role="button">{{ Auth::user()->name }}
					<span class="">
						<img class="img-circle navbar-avatar" src="/images/avatar/{{ Auth::user()->user_avatar }}" alt="...">
					</span>
				</a>
			@endif
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right elevation-3" role="menu">
				<a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i>
					{{ __('menu.Profile') }}</a>
				<a class="dropdown-item" href="/{{ app()->getLocale() }}/{{ config('phantom.modules.main') }}/settings/general/" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i>
					{{ __('menu.Settings') }}</a>
				<div class="dropdown-divider" role="presentation"></div>
				<a class="dropdown-item" href="{{ route('logout') }}" role="menuitem"
				   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
				><i class="icon wb-power" aria-hidden="true"></i>
					{{ __('messages.Logout') }}
				</a>
			</div>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</li>
	</ul>
</nav>
