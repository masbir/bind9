@extends('layouts.app')
@section('title')
	DNS Views
@stop
@section('content')
	<style type="text/css">
		.content-full-height{
			min-height:calc(100% - 150px);
		}
	</style>
	<div class="container">
		<h3>Manage DNS</h3>
		<ul class="list-group">
			@foreach($dnsviews as $dnsview)
				<li class="list-group-item"><a href="/views/{{ $dnsview->id }}">{{ $dnsview->name }}</a></li>
			@endforeach
		</ul> 
	</div>
@stop