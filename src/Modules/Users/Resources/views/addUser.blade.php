<form method="post" :action="formPath('/{{ app()->getLocale() }}/users')" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
	@csrf
	<div class="card">
		<div class="col-sm-10 image-editor">
			<div class="cropit-preview"></div>
			<div class="slider-wrapper" :data-user-avatar="form.formData.user_avatar">
				<i class="fa fa-picture-o pull-left"></i>
				<input id="crop-range" type="range" class="cropit-image-zoom-input pull-left" min="0" max="1" step="0.01">
				<i class="fa fa-picture-o fa-1d5x pull-right"></i>
			</div>
			<br>
			<label for="crop-input" class="btn btn-default">{{ __('users::messages.Choose file') }}</label>
			<input id="crop-input" type="file" class="d-none cropit-image-input" @change="onFileChange">
		</div>

		<div class="card-body">
			<div class="form-group">
				<label>{{ __('users::messages.Username') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="username" v-model="form.formData.username" autofocus>
				<span class="text-danger" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></span>
			</div>
			<div class="form-group">
				<label>{{ __('modules::messages.Name') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="name" v-model="form.formData.name">
				<span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
			</div>
			<div class="form-group">
				<label>{{ __('users::messages.Email') }}</label>
				<input :class="{focus: valData}" type="text" class="form-control" name="email" v-model="form.formData.email">
				<span class="text-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
			</div>
			<div class="form-group">
				<label>{{ __('users::messages.Password') }}</label>
				<input :class="{focus: valData}" type="password" class="form-control" name="password" v-model="form.formData.password">
				<span class="text-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
			</div>
			<div class="form-group">
				<label>{{ __('users::messages.Confirm password') }}</label>
				<input :class="{focus: valData}" type="password" class="form-control" name="password_confirmation" v-model="form.formData.password_confirmation">
				<span class="text-danger" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></span>
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
