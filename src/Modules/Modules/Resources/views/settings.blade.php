@extends('layouts.master')

@section('content')
	<div class="panel">
		<div class="panel-body text-center">
			<a href="/{{ app()->getLocale() }}/admin/settings/general/">
				<div class="card card-block p-0">
					<div class="counter counter-lg counter-inverse bg-blue-600 vertical-align w-150 h-150">
						<div class="vertical-align-middle">
							<div class="counter-icon mb-5"><i class="icon wb-settings" aria-hidden="true"></i></div>
							<span class="counter-number">{{ mb_strtoupper(__('modules::settings.general')) }}</span>
						</div>
					</div>
				</div>
			</a>
			<a href="/{{ app()->getLocale() }}/admin/settings/modules/">
				<div class="card card-block p-0">
					<div class="counter counter-lg counter-inverse bg-red-600 vertical-align w-150 h-150">
						<div class="vertical-align-middle">
							<div class="counter-icon mb-5"><i class="icon wb-memory" aria-hidden="true"></i></div>
							<span class="counter-number">{{ mb_strtoupper(__('modules::settings.modules')) }}</span>
						</div>
					</div>
				</div>
			</a>
			<a href="/{{ app()->getLocale() }}/admin/settings/menus/">
				<div class="card card-block p-0">
					<div class="counter counter-lg counter-inverse bg-purple-600 vertical-align w-150 h-150">
						<div class="vertical-align-middle">
							<div class="counter-icon mb-5"><i class="icon wb-menu" aria-hidden="true"></i></div>
							<span class="counter-number">{{ mb_strtoupper(__('modules::settings.menus')) }}</span>
						</div>
					</div>
				</div>
			</a>
			<a href="/{{ app()->getLocale() }}/admin/settings/users/">
				<div class="card card-block p-0">
					<div class="counter counter-lg counter-inverse bg-green-600 vertical-align w-150 h-150">
						<div class="vertical-align-middle">
							<div class="counter-icon mb-5"><i class="icon wb-users" aria-hidden="true"></i></div>
							<span class="counter-number">{{ mb_strtoupper(__('modules::settings.users')) }}</span>
						</div>
					</div>
				</div>
			</a>
			<a href="/{{ app()->getLocale() }}/admin/settings/roles/">
				<div class="card card-block p-0">
					<div class="counter counter-lg counter-inverse bg-orange-500 vertical-align w-150 h-150">
						<div class="vertical-align-middle">
							<div class="counter-icon mb-5"><i class="icon wb-unlock" aria-hidden="true"></i></div>
							<span class="counter-number">{{ mb_strtoupper(__('modules::settings.roles and permissions')) }}</span>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
@stop

