@extends('layouts.app')
@section('subheader',__('messages.permissionslisting'))
@section('content')
<style type="text/css">.pagination{display: inline-flex;}</style>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{__('messages.permissionmanagement')}}
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="{{ route('permissions.create') }}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>{{__('messages.createnewpermission')}}</span>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">
		@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
		@endif
		<table class="table table-bordered">
			<tr>
				<th>{{__('messages.no')}}</th>
				<th>{{__('messages.name')}}</th>
				<th width="280px">{{__('messages.actions')}}</th>
			</tr>
			@foreach ($permissions as $key => $permission)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $permission->name }}</td>
				<td>
					<a class="btn btn-primary" href="{{ route('permissions.edit',$permission->id) }}">{{__('messages.edit')}}</a>
				</td>
			</tr>
			@endforeach
		</table>
		<center>{!! $permissions->render() !!}</center>
	</div>
</div>
@stop