@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-6">
			<button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addRoute" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
				<span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('modules::messages.add route') }}</span>
			</button>
		</div>
		<div class="col-sm-6">

			{!! phantom_search('routeSearch', phantom_link('routes@search',['moduleId'=>$module->id])) !!}

		</div>
	</div>
	<div class="card card-primary m-t-1 card-outline card-tabs">
		<div class="card-header border-bottom-0">
			<h3 class="card-title">{{ mb_ucfirst(__('messages.details')) }} <b>{{ $module->module_name }}</b>
			</h3>
		</div>
		<div class="card-body table-responsive">
			<list-content v-if="hasContent.routeSearch==false">
				{{ __('modules::messages.no records found') }}
			</list-content>
			<div class="phantom-content routeSearch">
			</div>
		</div>
	</div>
	<side-modal :form-reset="formReset" id="addRoute">
		<template slot="modal-title" v-if="valData">{{ __('modules::messages.edit route') }}</template>
		<template slot="modal-title" v-else>{{ __('modules::messages.add route') }}</template>
		<template slot="modal-body">
			@include('modules::addRoute')
		</template>
	</side-modal>
@stop