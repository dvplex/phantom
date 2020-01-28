<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mb-4">
		<aside class="settings-sidebar sidebar-light-smenu">
			<div class="sidebar sidebar-settings">
				<nav>
					<div class="d-flex" aria-expanded="false">
						<div class="info text-light text-xs user-ip">
							<h5 class="text-primary">{{ __('modules::settings.Settings') }}</h5>
						</div>
					</div>
					<hr>
					<ul data-widget="treeview" data-accordion="false" class="nav nav-pills nav-sidebar flex-column nav-flat">
						<li></li>
						<li class="nav-item">
							<a class="nav-link" href="/{{ app()->getLocale() }}/admin/settings/general/"><i class="nav-icon fas fa-cog text-blue" aria-hidden="true"></i>
								<span>{{ __('modules::settings.general') }}</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/{{ app()->getLocale() }}/admin/settings/modules/"><i class="nav-icon fas fa-memory text-danger" aria-hidden="true"></i>
								<span>{{ __('modules::settings.modules') }}</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/{{ app()->getLocale() }}/admin/settings/menus/"><i class="nav-icon fas fa-list text-green" aria-hidden="true"></i>
								<span>{{ __('modules::settings.menus') }}</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/{{ app()->getLocale() }}/admin/settings/users/"><i class="nav-icon fas fa-user-cog text-dark" aria-hidden="true"></i>
								<span>{{ __('modules::settings.users') }}</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/{{ app()->getLocale() }}/admin/settings/roles/"><i class="nav-icon fas fa-user-secret text-orange" aria-hidden="true"></i>
								<span>{{ __('modules::settings.roles and permissions') }}</span>
							</a>
						</li>
                        <li class="nav-item has-treeview">
                            <a class="nav-link" href="javascript:void(0)"><i class="nav-icon fas fa-sitemap text-cyan" aria-hidden="true"></i>
                                <span>{{ __('modules::settings.CMS') }}</span>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a class="nav-link" href="/{{ app()->getLocale() }}/admin/cms/"><i class="nav-icon fas fa-clipboard-list text-dark" aria-hidden="true"></i>
                                        <span>{{ __('modules::settings.Layouts') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/{{ app()->getLocale() }}/cms/pages/"><i class="nav-icon fas fa-scroll text-dark" aria-hidden="true"></i>
                                        <span>{{ __('modules::settings.Pages') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
					</ul>
				</nav>
			</div>
		</aside>
	</div>
	<div class="col-lg-10 col-sm-10 col-md-10 col-xs-10">
		{{ $slot }}
	</div>
</div>
