@extends('layouts.app')
@section('title')
	{{ $dnsview->name }}
@stop
@section('content') 
	<div class="container">
		<h3>{{ $dnsview->name }}</h3>

		<div class="panel panel-default">
	  		<div class="panel-body">
				<h4>Ip Ranges</h4>


				<form class="form-inline" method="POST" action="/views/{{ $dnsview->id }}/ips">
					{{ csrf_field() }}
					<div class="form-group"> 
						<input type="text" class="form-control" id="ipstart" placeholder="127.0.0.1" name="ipstart">
					</div>
					<div class="form-group"> 
						<select class="form-control" name="range">
							@for($i = 32; $i >= 16; $i--)
								<option value="{{ $i }}">{{ $i }} ( {{ number_format(pow(2, (32 - $i))) }} Ip Addresses)</option>
							@endfor
							
						</select>
					</div>
					<button type="submit" class="btn btn-default">Add IP</button>
				</form>


				<ul class="list-group"> 
					@foreach($dnsview->ips as $ip)
						<li class="list-group-item clearfix">
							<form class="pull-right" method="POST" action="/views/{{ $dnsview->id }}/ips/{{ $ip->id }}">
								{{ csrf_field() }}
								<button class="btn btn-danger">&times;</button>
							</form>
							{{ $ip->ipstart }} / {{ $ip->range }}
						</li>
					@endforeach
				</ul> 
			</div>
		</div>

		<div class="panel panel-default">
	  		<div class="panel-body">
				<h4>Domains</h4>
				<form class="form-inline" method="POST" action="/views/{{ $dnsview->id }}/domains">
					{{ csrf_field() }}
					<div class="form-group"> 
						<input type="text" class="form-control" id="domain" placeholder="google.com" name="domain">
					</div>
					<button type="submit" class="btn btn-default">Add Domain</button>
				</form>
				<ul class="list-group">
					@foreach($dnsview->domains as $domain)
						<li class="list-group-item clearfix"> 
							<form class="pull-right" method="POST" action="/views/{{ $dnsview->id }}/domains/{{ $domain->id }}">
								{{ csrf_field() }}
								<button class="btn btn-danger">&times;</button>
							</form>
							{{ $domain->domain }}
						</li>
					@endforeach
				</ul> 
			</div>
		</div>
	</div>
@stop