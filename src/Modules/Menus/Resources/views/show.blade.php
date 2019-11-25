@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-6">
			<button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addRoute" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
				<span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('menus::messages.add menu node') }}</span>
			</button>
		</div>
		<div class="col-sm-6">

			{!! phantom_search('menuNodeSearch', phantom_link('menuNodes@search',['menuId'=>$menu->id])) !!}

		</div>
	</div>
	<div class="card card-primary m-t-1 card-outline card-tabs">
		<div class="card-header border-bottom-0">
			<h3 class="card-title">{{ mb_ucfirst(__('messages.details')) }} <b>{{ $menu->name}}</b>
			</h3>
			<br>
			<ul class="nav nav-tabs nav-tabs-animate nav-tabs-line mt-3" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" data-toggle="tab" href="#menuDetails" aria-controls="menuDetails" role="tab" aria-selected="true">{{ __('menus::messages.Menu nodes') }}</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" data-toggle="tab" href="#menuOrder" aria-controls="menuOrder" role="tab" aria-selected="false">{{ __('menus::messages.Menu order') }}</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content pt-20">
				<div class="tab-pane active" id="menuDetails" role="tabpanel">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-body">
								<list-content v-if="hasContent.menuNodeSearch==false">
									{{ __('modules::messages.no records found') }}
								</list-content>
								<div class="phantom-content menuNodeSearch">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="menuOrder" role="tabpanel">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-body">
								<phantom-menu>
									<template slot="content">
										<div class="dd">
											{{ phantom()->menu('reorder',$menu->name) }}
										</div>
									</template>
									<template slot="save">{{ __('messages.Save') }}</template>
								</phantom-menu>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<side-modal :form-reset="formReset" id="addRoute">
		<template slot="modal-title" v-if="valData">{{ __('menus::messages.edit menu node') }}</template>
		<template slot="modal-title" v-else>{{ __('menus::messages.add menu node') }}</template>
		<template slot="modal-body">
			@include('menus::addMenuTree')
		</template>
	</side-modal>
	</div>
@stop
