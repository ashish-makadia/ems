@extends('layouts.app')
@section('subheader',__('messages.editrole'))
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
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<form id="role-form" method="post"  action="{{route('roles.update',$role->id)}}" enctype="multipart/form-data">
		@csrf
		{{ method_field('PATCH') }}
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					<div class="form-group m-form__group row">
						<label class="col-lg-2 col-form-label" for="name">{{__('messages.name')}}</label>
						<div class="col-lg-4 m-form__group-sub @if($errors->has('name')){{ 'has-danger' }}@endif">
							<input class="form-control m-input m-input--square" type="text" id="name" name="name"  placeholder="{{__('messages.entername')}}"  value="{{ ((isset($role)) ? $role->name : old('name')) }}" data-msg-required="Please Enter Name" required >
						</div>
						<div class="m-checkbox-inline">
							<div class="col-md-12">
							<label class="m-checkbox m-checkbox--solid">
								<input type="checkbox" class="selectunselect" value=""/> {{__('messages.selectunselect')}}
								<span></span>
							</label>
							</div>
						</div>
					</div>
				</div>
				<div class="m-form__section m-form__section--first">
					<div class="form-group m-form__group row">
						<label class="col-lg-2 col-form-label" for="permission">{{__('messages.permission')}}:</label>
						<div class="col-lg-10 m-form__group-sub @if($errors->has('permission')){{ 'has-danger' }}@endif">
							<div class="m-checkbox-inline">
								<div class="col-md-12 row">
								@foreach($permission as $value)
								<div class="col-md-3">
								<label class="m-checkbox m-checkbox--solid">
									<input type="checkbox" class="checkbox" name="permission[]" value="{{ $value->id }}" @if(in_array($value->id, $rolePermissions)) checked @endif/> {{ $value->name }}
									<span></span>
								</label>
								</div>
								@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{__('messages.submit')}}</button>
					<a href="{{ route('roles.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{__('messages.cancel')}}</a>
				</div>
			</div>
		</form>
	</div>
</div>
@section('footer_scripts')
<script>
	$(document).on('change','.selectunselect',function()
	{  //"select all" change 
    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
	});
</script>
@endsection
@stop