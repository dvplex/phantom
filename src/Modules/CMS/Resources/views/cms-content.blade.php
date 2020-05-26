@if ($layouts->count() )
    <table class="table table-hover">
        <thead>
        <th class="phantom-th" @click="orderBy('file_name')">{{ __('modules::messages.Name')}}
            <i class="fas" :class="orderClass('file_name')"></i></th>
        <th class="phantom-th">{{ __('modules::messages.Description')}}</th>
        <th class="phantom-th">{{ __('messages.Action')}}</th>
        </thead>
        <tbody>
        @foreach($layouts as $layout)
            <tr>
                <td>{{ $layout['file_name']}}</td>
                <td>{{ $layout['description']}}</td>
                <td>
                    <a class="btn btn-sm btn-edit"
                       data-target="#addLayout"
                       data-backdrop="static"
                       data-keyboard="false"
                       data-toggle="modal"
                       ref="javascript:void(0)"
                       role="menuitem"
                       @click="editItems({{ $layout->toJson() }})"
                       title="{{ __('modules::messages.edit') }}">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $layouts->links() }}
@endif
