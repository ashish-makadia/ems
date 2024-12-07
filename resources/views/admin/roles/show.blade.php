@extends('layouts.app')
@section('subheader',__('messages.viewrole'))
@section('content')
<div class="col-md-12">
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">@yield('subheader')</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<a href="{{ route('roles.index')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
					<span>
						<i class="la la-arrow-left"></i>
						<span>{{__('messages.back')}}</span>
					</span>
				</a>
			</div>
		</div>
		<div class="m-portlet__body">
			<dl class="dl-horizontal">
				<dt>{{__('messages.name')}}:</dt>
				<dd>{{ $role->name }}</dd>
				<dt>{{__('messages.permission')}}:</dt>
				<dd>@if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="m-badge m-badge--success m-badge--wide">{{ $v->name }}</label>
                @endforeach @endif</dd>
			</dl>
		</div>
	</div>
</div>
@stop