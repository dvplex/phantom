<li class="nav-item dropdown dropdown-fw dropdown-mega">
	<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="fade"
	   role="button"><b>{{ mb_strtoupper(__('menu.menu')) }} </b><i class="icon wb-chevron-down-mini" aria-hidden="true"></i></a>
	<div class="dropdown-menu" role="menu">
		<div class="mega-content">
			<div class="row">
				<div class="col-md-4">
					<div class="site-menubar-body mega-menubar">
						<ul class="blocks-2">
							<li class="mega-menu m-0">
								{{ phantom()->menu('top') }}
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-8">
					<div class="panel">
						{{ __('menu.Settings') }}
						<hr>
						<div class="panel-body text-center panel-settings">
							<a href="/{{ app()->getLocale() }}/admin/settings/general/">
								<div class="card card-block p-0">
									<div class="counter counter-lg counter-inverse bg-blue-600 vertical-align w-100 h-100">
										<div class="vertical-align-middle">
											<div class="counter-icon mb-5"><i class="icon wb-settings" aria-hidden="true"></i></div>
											<span class="counter-number">{{ mb_strtoupper(__('modules::settings.general')) }}</span>
										</div>
									</div>
								</div>
							</a>
							<a href="/{{ app()->getLocale() }}/admin/settings/modules/">
								<div class="card card-block p-0">
									<div class="counter counter-lg counter-inverse bg-red-600 vertical-align w-100 h-100">
										<div class="vertical-align-middle">
											<div class="counter-icon mb-5"><i class="icon wb-memory" aria-hidden="true"></i></div>
											<span class="counter-number">{{ mb_strtoupper(__('modules::settings.modules')) }}</span>
										</div>
									</div>
								</div>
							</a>
							<a href="/{{ app()->getLocale() }}/admin/settings/menus/">
								<div class="card card-block p-0">
									<div class="counter counter-lg counter-inverse bg-purple-600 vertical-align w-100 h-100">
										<div class="vertical-align-middle">
											<div class="counter-icon mb-5"><i class="icon wb-menu" aria-hidden="true"></i></div>
											<span class="counter-number">{{ mb_strtoupper(__('modules::settings.menus')) }}</span>
										</div>
									</div>
								</div>
							</a>
							<a href="/{{ app()->getLocale() }}/admin/settings/users/">
								<div class="card card-block p-0">
									<div class="counter counter-lg counter-inverse bg-green-600 vertical-align w-100 h-100">
										<div class="vertical-align-middle">
											<div class="counter-icon mb-5"><i class="icon wb-users" aria-hidden="true"></i></div>
											<span class="counter-number">{{ mb_strtoupper(__('modules::settings.users')) }}</span>
										</div>
									</div>
								</div>
							</a>
							<a href="/{{ app()->getLocale() }}/admin/settings/roles/">
								<div class="card card-block p-0">
									<div class="counter counter-lg counter-inverse bg-orange-500 vertical-align w-100 h-100">
										<div class="vertical-align-middle">
											<div class="counter-icon mb-5"><i class="icon wb-unlock" aria-hidden="true"></i></div>
											<span class="counter-number">{{ mb_strtoupper(__('modules::settings.roles and permissions')) }}</span>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>

