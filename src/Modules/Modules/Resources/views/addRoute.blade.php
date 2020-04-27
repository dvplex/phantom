<form method="post" :action="formPath('/{{ app()->getLocale() }}/admin/routes')" @submit.prevent="passHidden($event,{'moduleId':'{{ $module->id }}'})" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				<label>{{ __('modules::messages.Route') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="route" v-model="form.formData.route" autofocus>
				<span class="text-danger" v-if="form.errors.has('route')" v-text="form.errors.get('route')"></span>
			</div>
			<div class="form-group">
				<label>{{ __('modules::messages.Controller method') }}</label>
				<input type="text" :class="{focus: valData}" class="form-control" name="controllerMethod" v-model="form.formData.controllerMethod">
				<span class="text-danger" v-if="form.errors.has('controllerMethod')" v-text="form.errors.get('controllerMethod')"></span>
			</div>

			<div class="form-group">
				<label>{{ __('modules::messages.Middleware') }}</label>
				<v-select multiple="multiple" class="form-control" id="select" v-model="form.formData.middleware" :options="{{ $middlewares }}"></v-select>
				<span class="text-danger" v-if="form.errors.has('middleware')" v-text="form.errors.get('middleware')"></span>
			</div>

			<div class="form-group">
				<label for="select1">{{ __('modules::messages.Request method') }}</label>
				<v-select id="select1" multiple="multiple" class="form-control" v-model="form.formData.httpMethod" :options="{{ $method }}"></v-select>
				<span class="text-danger" v-if="form.errors.has('httpMethod')" v-text="form.errors.get('httpMethod')"></span>
			</div>

			<div class="form-group form-material" data-plugin="formMaterial">
				<label for="select2">{{ __('roles::messages.Roles') }}</label>
				<v-select multiple="multiple" class="form-control" id="select2" v-model="form.formData.role" :options="{{ $roles }}"></v-select>
			</div>
			<div class="form-group form-material" data-plugin="formMaterial">
				<label for="select3">{{ __('roles::messages.Permissions') }}</label>
				<v-select multiple="multiple" class="form-control" id="select3" v-model="form.formData.permission" :options="{{ $permissions}}"></v-select>
			</div>
			<button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
				<span v-if="valData">{{ __('modules::messages.edit') }}</span>
				<span v-else>{{ __('modules::messages.add') }}</span>
			</button>
		</div>
	</div>
</form>

