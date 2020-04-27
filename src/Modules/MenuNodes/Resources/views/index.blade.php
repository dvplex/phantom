@extends('phantom::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('menunodes.name') !!} -  Built with DVPLEX Phantom!
    </p>
@stop
