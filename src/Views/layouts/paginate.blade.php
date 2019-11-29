@if ($paginator->hasPages())

	<ul class="pagination pagination-no-border">
		{{-- Previous Page Link --}}
		@if ($paginator->onFirstPage())
			<li class="page-item disabled"><span class="page-link">&lsaquo;&lsaquo;</span></li>
			<li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
		@else
			<li class="page-item">
				<a class="page-link" @click.prevent="$parent.search[searchId].gotoPage('{{$paginator->url(1)}}')" href="{{ $paginator->url(1) }}" rel="first">&lsaquo;&lsaquo;</a>
			</li>
			<li class="page-item">
				<a class="page-link" @click.prevent="$parent.search[searchId].gotoPage('{{$paginator->previousPageUrl()}}')" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
			</li>
		@endif

		{{-- Pagination Elements --}}
		@foreach ($elements as $element)
			{{-- "Three Dots" Separator --}}
			@if (is_string($element))
				<li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
			@endif

			{{-- Array Of Links --}}
			@if (is_array($element))
				@foreach ($element as $page => $url)
					@if ($page == $paginator->currentPage())
						<li class="page-item active"><span class="page-link">{{ $page }}</span></li>
					@else

						<li class="page-item">
							<a class="page-link" @click.prevent="$parent.search[searchId].gotoPage('{{ $url }}')" href="{{ $url }}">{{ $page }}</a>
						</li>
					@endif
				@endforeach
			@endif
		@endforeach


		{{-- Next Page Link --}}
		@if ($paginator->hasMorePages())
			<li class="page-item">
				<a class="page-link" @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->nextPageUrl() }}')" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
			</li>
			<li class="page-item">
				<a class="page-link" @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->url($paginator->lastPage()) }}')" href="{{ $paginator->url($paginator->nextPageUrl()) }}" rel="last">&rsaquo;&rsaquo;</a>
			</li>
		@else
			<li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
			<li class="page-item disabled"><span class="page-link">&rsaquo;&rsaquo;</span></li>
		@endif
	</ul>
@endif
<div class="pagination-legend" style="margin:15px;font-size:0.6rem">
	{{ __('messages.showing') }}
	<b>{{ $paginator->firstItem()}}</b> -
	<b>{{ $paginator->lastItem() }}</b> {{__('messages.of')}}
	<b>{{ $paginator->total() }}</b> {{ __('messages.records') }} <br>{{ __('messages.show' ) }}
	<a v-if="$parent.search[searchId].perPage==5" class="active">5</a>
	<a v-else @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->url(1) }}',5)" href="{{ $paginator->url(1) }}">5</a>
	|
	<a v-if="$parent.search[searchId].perPage==10" class="active">10</a>
	<a v-else @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->url(1) }}',10)" href="{{ $paginator->url(1) }}">10</a>
	|
	<a v-if="$parent.search[searchId].perPage==20" class="active">20</a>
	<a v-else @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->url(1) }}',20)" href="{{ $paginator->url(1) }}">20</a>
	|
	<a v-if="$parent.search[searchId].perPage== {{ $paginator->total() }}" class="active">{{ __('messages.all') }}</a>
	<a v-else @click.prevent="$parent.search[searchId].gotoPage('{{ $paginator->url(1) }}',{{ $paginator->total() }})" href="{{ $paginator->url(1) }}">{{ __('messages.all') }}</a>
</div>

