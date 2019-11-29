<div class="row">
	<div class="col-6">
		<button class="btn btn-add btn-animate btn-animate-side btn-outline-primary" data-target="#addMenu1" data-backdrop="static" data-keyboard="false" data-toggle="modal" type="button">
			<span><i class="icon wb-plus" aria-hidden="true"></i>{{ __('permissions::messages.add permission') }}</span>
		</button>
	</div>
	<div class="col-6">

		{!! phantom_search('permissionSearch', phantom_link('permissions@search')) !!}

	</div>
</div>
<div class="card m-t-1">
	<div class="card-header border-bottom-0">
		<h3 class="card-title">
			{{ __('permissions::messages.Permissions') }}
		</h3>
	</div>
	<div class="card-body p-0 table-responsive">
		<list-content v-if="hasContent.permissionSearch==false">
			<template>
				{{ __('modules::messages.no records found') }}
			</template>
		</list-content>
		<div class="phantom-content permissionSearch">
			@include('permissions::permission-content')
		</div>
	</div>
</div>
<side-modal :form-reset="formReset" id="addMenu1">
	<template v-if="valData" slot="modal-title">{{ __('permissions::messages.edit permission') }}</template>
	<template v-else slot="modal-title">{{ __('permissions::messages.add permission') }}</template>
	<template slot="modal-body">
		@include('permissions::addPermission')
	</template>
</side-modal>
