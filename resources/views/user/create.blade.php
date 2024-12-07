@if(isset($user->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('user.update',$user->id)}}" method="POST">
                <input type="hidden" value="PATCH" name="_method">    
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('user.store')}}" method="POST"> 
                <input type="hidden" value="POST" name="_method">
            @endif
            
		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					
					{{-- Name Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="title">{{ __('messages.name')}}<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="name" name="name" placeholder="{{ __('messages.entername')}}" data-msg-required="This field is required." value="{{ old('name', (isset($user)) ? $user->name : '') }}"/>
							<span class="help-block removedata" id="error_name">
							</span>
						</div>
					</div>
					{{-- End Name Field --}}

					{{-- Email Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="email">{{ __('messages.email')}}<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="email" class="form-control m-input m-input--square" id="email" name="email" placeholder="{{ __('messages.enteremail')}}" data-msg-required="This field is required." value="{{ old('email', (isset($user)) ? $user->email : '') }}"/>
							<span class="help-block removedata" id="error_email">
							</span>
						</div>
					</div>
					{{-- End Email Field --}}

					{{-- Password Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="password">{{ __('messages.password')}}<strong class="text-danger">*</strong></label><br/>
						<div class="col-lg-9 m-form__group-sub">
							<input type="password" class="form-control m-input m-input--square" id="password" name="password" placeholder="enter password" data-msg-required="This field is required."/>
							<span class="help-block removedata" id="error_password">
							</span>
						</div>
					</div>
					{{-- End Password Field --}}

					{{-- Mobile Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="modile">{{ __('messages.mobileno')}}<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="mobile_no" name="mobile_no" placeholder="{{ __('messages.entermobileno')}}" data-msg-required="This field is required." value="{{ ((isset($user)) ? $user->mobile_no : old('mobile_no')) }}"/>
							<span class="help-block removedata" id="error_mobile_no">
							</span>
						</div>
					</div>
					{{-- End Mobile Field --}}
					
					{{-- Role --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="role">{{ __('messages.role')}}<strong class="text-danger">*</strong></label><br/>
						<div class="col-lg-9 m-form__group-sub">
							<select class="form-control hide-search" id="users-role" name="role" data-placeholder="Select country">
							<option value="">-- Select Role --</option>
								@foreach($roles as $role)
									<option value="{{$role->id}}" {{ (!empty(old('role')) && old('role')==$role->id) ? 'selected' : '' }} @if(isset($user->role) and $user->role==$role->name){{ 'selected' }} @endif>{{$role->name}}</option>
								@endforeach
							</select>
							<span class="help-block removedata" id="error_role"></span>
						</div>
					</div>
					{{-- End Roles Field --}}

					{{-- Status --}}
					@if(isset($user))
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status')}}</label><br/>
						<div class="col-lg-4 m-form__group-sub">
							<span class="m-switch m-switch--icon">
								<label for="status">
									<input type="checkbox" name="status" id="status" value='Active' {{ ((isset($user)) ? (($user->status=='Active') ? 'checked' : '') : 'checked')}} />
									<span class="help-block removedata" id="error_status">
									</span>
								</label>
							</span>
						</div>
					</div>
					@endif
					{{--  End Status --}}
				</div>
			</div>
			<div class="modal-footer">
				<div class="m-form__actions">
					<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{ __('messages.submit')}}</button>
					<a href="#" data-dismiss="modal" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{ __('messages.cancel')}}</a>
				</div>
			</div>
</form>
