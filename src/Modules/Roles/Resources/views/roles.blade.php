<div class="row">
	<div class="col-sm-6">
		<button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addMenu" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
			<span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('roles::messages.add role') }}</span>
		</button>
	</div>
	<div class="col-sm-6">

		{!! phantom_search('roleSearch', phantom_link('roles@search')) !!}

	</div>
</div>
	<div class="card m-t-1">
		<div class="card-header border-bottom-0">
				<h3 class="card-title">
					{{ __('roles::messages.Roles') }}
				</h3>
			</div>
		<div class="card-body table-responsive p-0">
			<list-content v-if="hasContent.roleSearch==false">
				<template>
					{{ __('modules::messages.no records found') }}
				</template>
			</list-content>
			<div class="phantom-content roleSearch">
				@include('roles::role-content')
			</div>
		</div>
	</div>
	<side-modal :form-reset="formReset" id="addMenu">
		<template v-if="valData" slot="modal-title">{{ __('roles::messages.edit role') }}</template>
		<template v-else slot="modal-title">{{ __('roles::messages.add role') }}</template>
		<template slot="modal-body">
			@include('roles::addRole')
		</template>
	</side-modal>
