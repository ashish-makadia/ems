@if(isset($designation->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('designation.update',$designation->id)}}" method="POST"> 
                <input type="hidden" value="PATCH" name="_method">    
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('designation.store')}}" method="POST"> 
                <input type="hidden" value="POST" name="_method">    
            @endif
            
		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					
					{{-- Name Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="name">{{ __('messages.name')}}<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="name" name="name" placeholder="{{ __('messages.entername')}}" data-msg-required="This field is required." value="{{ ((isset($designation)) ? $designation->name : old('designation_name')) }}" required />
							<span class="help-block removedata" id="error_name">
							</span>
						</div>
					</div>
					{{-- End Name Field --}}

					{{-- Department Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="department_id">Department<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub">
							{{Form::select('department_id', $department, isset($designation->department_id) ? $designation->department_id:old('department_id'), ['class' => 'form-control m-input m-input--square custom-select','placeholder'=>'--- select department --', 'required','id' => 'department_id'])}}
							<span class="help-block removedata" id="error_department_id">
							</span>
						</div>
					</div>
					{{-- End Department Field --}}

					
					


					{{-- Status --}}
					@if(isset($designation))
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status')}}</label><br/>
						<div class="col-lg-4 m-form__group-sub">
							<span class="m-switch m-switch--icon">
								<label for="status">
									<input type="checkbox" name="status" id="status" value='Active' {{ ((isset($designation)) ? (($designation->status=='Active') ? 'checked' : '') : 'checked')}} />
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

