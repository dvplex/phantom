<ol class="breadcrumb">
	<?php $segments = ''; ?>
	@foreach(Request::segments() as $segment)
		<?php $segments .= '/' . $segment; ?>
		@if(! $loop->last && !$loop->first)
			<li class="breadcrumb-item">
				<a href="{{ $segments }}">{{ucfirst($segment)}}</a>
			</li>
		@endif
	@endforeach
	<li class="breadcrumb-item active">{{ ucfirst(last(request()->segments())) }}</li>
</ol>
<hr>
