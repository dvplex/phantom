@extends('phantom::layouts.master')

@section('content')
    @component('phantom::layouts.settings-menu')
        <div class="row">
            <div class="col-6">
                <button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addMenu" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
                    <span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('modules::messages.add module') }}</span>
                </button>
            </div>
            <div class="col-6">

                {!! phantom_search('moduleSearch', phantom_link('modules@search')) !!}

            </div>
        </div>
        <div class="card card-primary m-t-1 card-outline card-tabs">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">
                    {{ __('modules::messages.Modules') }}
                </h3>
            </div>
            <div class="card-body table-responsive">
                <list-content v-if="hasContent.moduleSearch==false">
                    <template>
                        {{ __('modules::messages.no records found') }}
                    </template>
                </list-content>
                <div class="phantom-content moduleSearch">
                </div>
            </div>
        </div>
    @endcomponent
    <side-modal :form-reset="formReset" id="addMenu">
        <template v-if="valData" slot="modal-title">{{ __('modules::messages.edit module') }}</template>
        <template v-else slot="modal-title">{{ __('modules::messages.add module') }}</template>
        <template slot="modal-body">
            @include('modules::addModule')
        </template>
    </side-modal>
@endsection


