@extends('layouts.app')
@section('subheader',__('messages.editpermission'))
@section('content')
<div class="col-md-12">
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">@yield('subheader')</h3>
				</div>
			</div>
		</div>
		
		<form id="permission-form" method="POST"  action="{{route('permissions.update',$permission->id)}}" enctype="multipart/form-data">
			@csrf
			{{ method_field('PATCH') }}
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					<div class="form-group m-form__group row">
						<label class="col-lg-2 col-form-label" for="name">{{__('messages.name')}}</label>
						<div class="col-lg-4 m-form__group-sub @if($errors->has('name')){{ 'has-danger' }}@endif">
							<input class="form-control m-input m-input--square" type="text" id="name" name="name"  placeholder="{{__('messages.entername')}}"  value="{{ ((isset($permission)) ? $permission->name : old('name')) }}" data-msg-required="Please Enter permission" required/>
							
						</div>
					</div>
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{__('messages.submit')}}</button>
					<a href="{{ route('permissions.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{__('messages.cancel')}}</a>
				</div>
			</div>
		</form>
	</div>
</div>
@stop