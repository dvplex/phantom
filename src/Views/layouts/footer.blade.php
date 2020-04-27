<!-- Footer -->
@if(session('phantom.preferences.menu_type')=='side')
	@php $menu_top='' @endphp
@elseif(session('phantom.preferences.menu_type')=='top')
	@php $menu_top='menu-top' @endphp
@endif

<footer class="main-footer">
	<!-- To the right -->
	<div class="float-right d-none d-sm-inline text-xxs">
		web template by <strong><a href="https://adminlte.io">AdminLTE.io</a>.</strong>
	</div>
	<!-- Default to the left -->
	{{ date('Y') }} © <strong><a href="#">DVPLEX</a></strong>
</footer>
