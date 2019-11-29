<form method="post" :action="formPath('/{{ app()->getLocale() }}/menus')" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				<label>{{ __('modules::messages.Name') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="name" v-model="form.formData.name" autofocus>
				<span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
			</div>
			<div class="form-group form-material floating" data-plugin="formMaterial">
				<label>{{ __('modules::messages.Description') }}</label>
				<textarea :class="{focus: valData}" class="form-control empty" rows="3" name="description" v-model="form.formData.description"></textarea>
				<span class="text-danger" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></span>
			</div>
            <div class="form-group">
                <label>{{ __('menus::messages.Type') }}</label>
                <v-select class="form-control" id="select" v-model="form.formData.type" :options="{{ $types }}"></v-select>
                <span class="text-danger" v-if="form.errors.has('type')" v-text="form.errors.get('type')"></span>
            </div>
			<div class="form-group">
				<label for="select">{{ __('roles::messages.Roles') }}</label>
				<v-select multiple="multiple" class="form-control" id="select" v-model="form.formData.role" :options="{{ $roles }}"></v-select>
			</div>
			<div class="form-group form-material" data-plugin="formMaterial">
				<label for="select1">{{ __('roles::messages.Permissions') }}</label>
				<v-select multiple="multiple" class="form-control" id="select1" v-model="form.formData.permission" :options="{{ $permissions}}"></v-select>
			</div>
			<button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
				<span v-if="valData">{{ __('modules::messages.edit') }}</span>
				<span v-else>{{ __('modules::messages.add') }}</span>
			</button>
		</div>
	</div>
</form>
