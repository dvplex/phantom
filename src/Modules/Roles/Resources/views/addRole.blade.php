<form method="post" :action="formPath('/{{ app()->getLocale() }}/admin/roles')" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card card-primary">
		<div class="card-body">
			<div class="form-group">
				<label>{{ __('modules::messages.Name') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="name" v-model="form.formData.name" autofocus>
				<span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
			</div>
			<div class="form-group form-material" data-plugin="formMaterial">
				<label for="select">{{ __('roles::messages.Permissions') }}</label>
				<v-select multiple="multiple" class="form-control" id="select" v-model="form.formData.permission" :options="{{ $permissions}}"></v-select>
			</div>
			<button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
				<span v-if="valData">{{ __('modules::messages.edit') }}</span>
				<span v-else>{{ __('modules::messages.add') }}</span>
			</button>
		</div>
	</div>
</form>
