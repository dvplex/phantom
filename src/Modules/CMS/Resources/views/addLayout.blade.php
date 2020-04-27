<form method="post" :action="formPath('/{{ app()->getLocale() }}/admin/cms')" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('modules::messages.Name') }}</label>
                <input :class="{focus: valData}" type="text" class="form-control" name="name" v-model="form.formData.file_name" autofocus>
                <span class="text-danger" v-if="form.errors.has('file_name')" v-text="form.errors.get('file_name')"></span>
            </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
                <label>{{ __('modules::messages.Description') }}</label>
                <textarea :class="{focus: valData}" class="form-control empty" rows="3" name="description" v-model="form.formData.description"></textarea>
                <span class="text-danger" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></span>
            </div>
            <label>{{ __('modules::messages.Contents') }}</label>
            <div class="form-group form-material floating" data-plugin="formMaterial">
                <div id="ace-content">
                    <span></span>
                </div>
            </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
                <textarea id="t_content" style="display:none" :class="{focus: valData}" class="form-control empty" rows="3" name="description" v-model="form.formData.contents"></textarea>
                <span class="text-danger" v-if="form.errors.has('contents')" v-text="form.errors.get('contents')"></span>
            </div>
            <button type="submit" class="btn btn-add btn-outline-primary" :disabled="form.errors.any()">
                <span v-if="valData">{{ __('modules::messages.edit') }}</span>
                <span v-else>{{ __('modules::messages.add') }}</span>
            </button>
        </div>
    </div>
</form>
