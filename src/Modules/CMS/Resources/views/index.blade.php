@extends('phantom::layouts.master')

@section('content')
    @component('phantom::layouts.settings-menu')
        <div class="row">
            <div class="col-6">
                <a class="btn btn-add btn-animate btn-animate-side btn-outline-primary"  href="add" type="button">
                    <span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('cms::messages.add layout') }}</span>
                </a>
            </div>
            <div class="col-6">
                {!! phantom_search('layoutsSearch', phantom_link('cms@search')) !!}

            </div>
        </div>
        <div class="card m-t-1 card-primary card-outline card-tabs">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">
                    {{ __('menus::messages.menus') }}
                </h3>
            </div>
            <div class="card-body table-responsive">
                <list-content v-if="hasContent.layoutsSearch==false">
                    <template>
                        {{ __('modules::messages.no records found') }}
                    </template>
                </list-content>
                <div class="phantom-content layoutsSearch">
                </div>
            </div>
        </div>
        <side-modal :form-reset="formReset" id="addLayout">
            <template v-if="valData" slot="modal-title">{{ __('menus::messages.edit menu') }}</template>
            <template v-else slot="modal-title">{{ __('menus::messages.add menu') }}</template>
            <template slot="modal-body">
                @include('cms::addLayout')
            </template>
        </side-modal>
    @endcomponent
@stop
