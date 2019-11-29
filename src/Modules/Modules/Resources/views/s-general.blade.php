@extends('layouts.master')

@section('content')
    @component('layouts.settings-menu')
        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="post" id="submit-prefs">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
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
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="collapse_sidebar" id="collapse-sideBar" {{ @$gsettings['collapse_sidebar'] }}>
                            <label class="custom-control-label" for="collapse-sideBar">{{ __('modules::messages.Collapse side bar') }}</label>
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
