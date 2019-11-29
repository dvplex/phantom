@extends('phantom::layouts.master')

@section('content')
    @component('phantom::layouts.settings-menu')
        <div class="row">
            <div class="col-6">
                <button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addMenu" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
                    <span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('menus::messages.add menu') }}</span>
                </button>
            </div>
            <div class="col-6">

                {!! phantom_search('menuSearch', phantom_link('menus@search')) !!}

            </div>
        </div>
        <div class="card m-t-1 card-primary card-outline card-tabs">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">
                    {{ __('menus::messages.menus') }}
                </h3>
            </div>
            <div class="card-body table-responsive">
                <list-content v-if="hasContent.menuSearch==false">
                    <template>
                        {{ __('modules::messages.no records found') }}
                    </template>
                </list-content>
                <div class="phantom-content menuSearch">
                </div>
            </div>
        </div>
    @endcomponent
    <side-modal :form-reset="formReset" id="addMenu">
        <template v-if="valData" slot="modal-title">{{ __('menus::messages.edit menu') }}</template>
        <template v-else slot="modal-title">{{ __('menus::messages.add menu') }}</template>
        <template slot="modal-body">
            @include('menus::addMenu')
        </template>
    </side-modal>
@stop


