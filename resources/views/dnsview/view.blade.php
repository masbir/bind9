@extends('layouts.app')
@section('title')
	{{ $dnsview->name }}
@stop
@section('content') 
	<div class="container">
		<h3>{{ $dnsview->name }}</h3>

		@if(isset($message))
			<div class="alert alert-{{ $message->type }}" role="alert">{{ $message->content }}</div>
		@endif
		@if ($errors->count() > 0)
			<div class="alert alert-danger" role="alert">
				@foreach ($errors->all() as $error)
	                {{ $error }}<br>        
	            @endforeach
			</div>
		@endif


		<div class="panel panel-default">
			<div class="panel-heading">Ip Ranges</div>
			<ul class="list-group"> 
				@foreach($dnsview->ips as $ip)
					<li class="list-group-item clearfix">
						<form class="pull-right" method="POST" action="/views/{{ $dnsview->id }}/ips/{{ $ip->id }}">
							{{ csrf_field() }}
							<button class="btn btn-danger"><i class="fa fa-times"></i></button>
						</form>
						{{ $ip->ipstart }} / {{ $ip->range }}
					</li>
				@endforeach
			</ul> 
	  		<div class="panel-body">
				<form class="form-inline" method="POST" action="/views/{{ $dnsview->id }}/ips">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('ipstart') ? ' has-error' : '' }}"> 
						<input type="text" class="form-control" id="ipstart" placeholder="127.0.0.1" name="ipstart" value="{{ old('ipstart') }}">
					</div>
					<div class="form-group"> 
						<select class="form-control" name="range">
							@for($i = 32; $i >= 16; $i--)
								<option value="{{ $i }}" {{ $i == old('range') ? 'selected' : '' }}>{{ $i }} ( {{ number_format(pow(2, (32 - $i))) }} Ip Addresses)</option>
							@endfor
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Add IP</button>
				</form>
			</div> 
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Domains</div>
			<ul class="list-group">
				@foreach($dnsview->domains as $domain)
					<li class="list-group-item clearfix"> 
						<form class="pull-right" method="POST" action="/views/{{ $dnsview->id }}/domains/{{ $domain->id }}">
							{{ csrf_field() }}
							<button class="btn btn-danger"><i class="fa fa-times"></i></button>
						</form>
						<a href='http://{{ $domain->domain }}' target="_blank">{{ $domain->domain }} <i class="fa fa-external-link"></i></a>
						<div>
							Visits : {{ $domain->view_count }}
						</div>
					</li>
				@endforeach
			</ul> 
	  		<div class="panel-body">
				<form class="form-inline" method="POST" action="/views/{{ $dnsview->id }}/domains">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}"> 
						<input type="text" class="form-control" id="domain" placeholder="google.com" name="domain" value="{{ old('domain') }}">
					</div>
					<button type="submit" class="btn btn-primary">Add Domain</button>
				</form>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Block Page</div>
	  		<div class="panel-body">
	  			<form method="POST" action="/views/{{ $dnsview->id }}/message">
	  				{{ csrf_field() }}
	  			  	<div class="form-group{{ $errors->has('warning') ? ' has-error' : '' }}">
	  			  		<label for="msg-warning">Message</label>
						<textarea class="form-control" id="msg-warning" name="warning">{{ $dnsview->warning }}</textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Save</button>
						<a href="/warning/{{ $dnsview->id }}" class="btn btn-default" target="_blank"><i class="fa fa-eye"></i> Preview</a>
					</div>
				</form>
	  		</div>
	</div>
@stop