@extends('layouts.master')

@section('content')
	<div class="card">
		<div class="card-body">
			<form autocomplete="off" method="post" id="submit-prefs">
				<div class="form-group">
					@if(session('phantom.preferences.menu_type')=='side')
						@php $is_side = 'checked="checked"';$is_top='' @endphp
					@else
						@php $is_top = 'checked="checked"';$is_side='' @endphp
					@endif
					<label class="form-control-label">Menu type</label>
					<div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="menu_type" value="side" {{ $is_side }}>
							<label for="">Side</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="menu_type" value="top" {{ $is_top }}>
							<label for="">Top</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-primary btn-submit-prefs">Save</button>
				</div>
				<hr>
			</form>
		</div>
	</div>
@stop
