<aside class="main-sidebar sidebar-dark-primary">
	<!-- Brand Logo -->
	<a href="/admin/" class="brand-link navbar-white">
		<img src="/images/th-logo.png" alt="Dvplex" class="brand-image">
		<span class="brand-text font-weight-light">&nbsp;</span>
	</a>

	<div class="sidebar">
		<div class="user-panel mt-2  pb-3 mb-3 d-flex" data-toggle="dropdown" href="#" aria-expanded="false">
		</div>
		@if(session('phantom.preferences.disable_sidemenu')!='on'||!session('phantom.preferences.disable_sidemenu'))
			<nav class="mt-2">
				{{ phantom()->menu() }}
			</nav>
		@endif
	</div>
	@role('Administrator')
	<div class="site-menubar-footer">
		<a href="/{{ app()->getLocale() }}/{{ config('phantom.modules.main') }}/settings/" class="fold-show" data-placement="top" data-toggle="tooltip"
		   data-original-title="Settings">
			<i class="fas fa-cog text-warning"></i>
		</a>
		<a href="javascript: void(0);" onclick="event.preventDefault();document.getElementById('lock-form').submit();" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
			<i class="fas fa-lock text-info"></i>
		</a>
		<a href="javascript: void(0);" onclick="event.preventDefault();document.getElementById('logout-form1').submit();" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
			<i class="fas fa-sign-out-alt text-danger"></i>
		</a>
		<form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
        <form id="lock-form" action="{{ route('system-lock') }}" method="POST" style="display: none;">
            @csrf
        </form>
	</div>
	@endrole()
</aside>
