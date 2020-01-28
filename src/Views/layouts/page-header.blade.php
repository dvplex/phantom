<ul class="breadcrumbs">
    <?php $segments = ''; ?>
        <li class="first"><a href="/{{ config('phantom.modules.main') }}"><i class="fas fa-home"></i></a></li>
        @foreach(Request::segments() as $segment)
        <?php $segments .= '/' . $segment; ?>
        @if(! $loop->last && !$loop->first)
            <li class="">
                <a href="{{ $segments }}">{{ucfirst($segment)}}</a>
            </li>
        @endif
    @endforeach
        <li class="last active"><a>{{ ucfirst(last(request()->segments())) }}</a></li>
</ul>
<hr>
