@extends('phantom::layouts.master')

@section('content')
    @component('phantom::layouts.settings-menu')
        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="post" id="submit-prefs">
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-on-danger">
                            <input type="checkbox" class="custom-control-input" name="disable_topmenu" id="disableTopmenu" {{ @$gsettings['disable_topmenu'] }}>
                            <label class="custom-control-label" for="disableTopmenu">{{ __('modules::messages.Disable top menu') }}</label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="disable_sidemenu" id="disableSidemenu" {{ @$gsettings['disable_sidemenu'] }}>
                            <label class="custom-control-label" for="disableSidemenu">{{ __('modules::messages.Disable side menu') }}</label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-on-orange">
                            <input type="checkbox" class="custom-control-input" name="collapse_sidebar" id="collapseSideBar" {{ @$gsettings['collapse_sidebar'] }}>
                            <label class="custom-control-label" for="collapseSideBar">{{ __('modules::messages.Collapse side bar') }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-on-green">
                            <input type="checkbox" class="custom-control-input" name="modules_sidemenu" id="modulesSidemenu" {{ @$gsettings['modules_sidemenu'] }}>
                            <label class="custom-control-label" for="modulesSidemenu">{{ __('modules::messages.Side menu per module') }}</label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-submit-prefs">Save</button>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    @endcomponent
@stop
