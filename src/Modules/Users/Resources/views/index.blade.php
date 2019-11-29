@extends('layouts.master')

@section('content')
    @component('layouts.settings-menu')
        <div class="row">
            <div class="col-6">
                <button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addUser" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button" @click="doCrop">
                    <span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('users::messages.add user') }}</span>
                </button>
            </div>
            <div class="col-6">

                {!! phantom_search('usersSearch', phantom_link('users@search')) !!}

            </div>
        </div>
        <div class="card card-primary m-t-1 card-outline card-tabs">
            <div class="card-header border-bottom-0">
                <h4 class="card-title">
                    {{ __('users::messages.Users') }}
                </h4>
            </div>
            <div class="card-body table-responsive">
                <list-content v-if="hasContent.usersSearch==false">
                    <template>
                        {{ __('modules::messages.no records found') }}
                    </template>
                </list-content>
                <div class="phantom-content usersSearch">
                </div>
            </div>
        </div>
    @endcomponent
    <side-modal :form-reset="formReset" id="addUser">
        <template v-if="valData" slot="modal-title">{{ __('users::messages.edit user') }}</template>
        <template v-else slot="modal-title">{{ __('users::messages.add user') }}</template>
        <template slot="modal-body">
            @include('users::addUser')
        </template>
    </side-modal>
@stop


