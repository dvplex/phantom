@extends('layouts.master')

@section('content')
    @component('layouts.settings-menu')
        <div class="card card-primary card-outline card-tabs" data-plugin="tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs nav-tabs-line mr-25" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#roles" aria-controls="roles" role="tab" aria-selected="true">{{ __('roles::messages.Roles') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#permissions" aria-controls="permissions" role="tab" aria-selected="false">{{ __('roles::messages.Permissions') }}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content py-15">
                    <div class="tab-pane active" id="roles" role="tabpanel">
                        @include('roles::roles')
                    </div>
                    <div class="tab-pane" id="permissions" role="tabpanel">
                        @include('permissions::permissions')
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
@stop
