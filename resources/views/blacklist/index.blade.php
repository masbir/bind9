@extends('layouts.app')
@section('title')
	List Manager
@stop
<style type="text/css">
	.content-full-height{
		min-height:calc(100% - 150px);
	}
</style>
<div class="container">
	<h3>Blocked Domains</h3>
	<form method="POST">
		{{ csrf_field() }}
		<div class="form-group">
			<textarea class="form-control content-full-height" name="content">{{ $content }}</textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-default">Save</button>
		</div>
	</form>
</div>