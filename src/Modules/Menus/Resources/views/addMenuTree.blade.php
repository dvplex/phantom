<form method="post" :action="formPath('/{{ app()->getLocale() }}/menuNodes')" @submit.prevent="passHidden($event,{'menuId':'{{ $menu->id }}'})" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				<label>{{ __('modules::messages.Name') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="name" v-model="form.formData.name" autofocus>
				<span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
			</div>
			<div class="form-group">
				<label for="select">{{ __('modules::messages.Route') }}</label>
				<v-select id="select" class="form-control" v-model="form.formData.route" :options="{{ $routes }}"></v-select>
				<span class="text-danger" v-if="form.errors.has('route')" v-text="form.errors.get('route')"></span>
			</div>

			<div class="form-group">
				<label for="select1">{{ __('menus::messages.Parent node') }}</label>
				<v-select id="select1" class="form-control" v-model="form.formData.parent_name" :options="{{ $parentNodes }}"></v-select>
				<span class="text-danger" v-if="form.errors.has('parent')" v-text="form.errors.get('parent')"></span>
			</div>

			<div class="form-group">
				<label for="select2">{{ __('menus::messages.Menu icon') }}</label>
				<v-select id="select2" class="form-control" v-model="form.formData.menu_icon" :options="{{ $fa_icons}}" label="title">
				</v-select>
				<span class="text-danger" v-if="form.errors.has('menu_icon')" v-text="form.errors.get('menu_icon')"></span>
			</div>

			<div class="form-group">
				<label for="select3">{{ __('roles::messages.Roles') }}</label>
				<v-select multiple="multiple" class="form-control" id="select3" v-model="form.formData.role" :options="{{ $roles }}"></v-select>
			</div>
			<div class="form-group">
				<label for="select4">{{ __('roles::messages.Permissions') }}</label>
				<v-select multiple="multiple" class="form-control" id="select4" v-model="form.formData.permission" :options="{{ $permissions}}"></v-select>
			</div>
			<button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
				<span v-if="valData">{{ __('modules::messages.edit') }}</span>
				<span v-else>{{ __('modules::messages.add') }}</span>
			</button>
		</div>
	</div>
</form>

