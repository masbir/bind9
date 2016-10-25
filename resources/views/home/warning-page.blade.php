@extends('layouts.warning')
@section('title')
	Opppps!
@stop
@section('content')
	<div class="warning-page valign-center">
		<div class="logo">
			<img src="/images/logo-sq.jpg">
		</div>
		@if($view->warning == null || trim($view->warning) == '')
			<h1>Hey there! This page is blocked by your network administrator</h1>
		@else
			<h1>{!! nl2br(e($view->warning)) !!}</h1>
		@endif
		
	</div>
@stop