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
		<h3>Manage Networks</h3>
		<div class="panel panel-default">
			<div class="panel-heading">Your Networks</div> 
			<ul class="list-group">
				@foreach($dnsviews as $dnsview)
					<li class="list-group-item">
						<a href="/views/{{ $dnsview->id }}">
							{{ $dnsview->name }}
						</a>
					</li>
				@endforeach
			</ul> 
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Create Network</div>
	  		<div class="panel-body">
				<form class="form-inline" method="POST" action="/views">
					{{ csrf_field() }}
					<div class="form-group"> 
						<input type="text" class="form-control" id="ipstart" placeholder="Home Network" name="name">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div> 
		</div>
	</div>
@stop