<form method="post" :action="formPath('/{{ app()->getLocale() }}/admin/modules')" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card">
		<div class="card-body">
			<div v-show="!valData" class="form-group">
				<label>{{ __('modules::messages.Name') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="module_name" v-model="form.formData.module_name" autofocus>
				<span class="text-danger" v-if="form.errors.has('module_name')" v-text="form.errors.get('module_name')"></span>
			</div>
			<div v-show="!valData" class="form-group">
				<label>{{ __('modules::messages.Path') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="module_path" v-model="form.formData.module_path">
				<span class="text-danger" v-if="form.errors.has('module_path')" v-text="form.errors.get('module_path')"></span>
			</div>
			<div class="form-group form-material floating" data-plugin="formMaterial">
				<label>{{ __('modules::messages.Description') }}</label>
				<textarea :class="{focus: valData}" class="form-control" rows="3" name="module_description" v-model="form.formData.module_description"></textarea>
				<span class="text-danger" v-if="form.errors.has('module_description')" v-text="form.errors.get('module_description')"></span>
			</div>
			<button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
				<span v-if="valData">{{ __('modules::messages.edit') }}</span>
				<span v-else>{{ __('modules::messages.add') }}</span>
			</button>
		</div>
	</div>
</form>
