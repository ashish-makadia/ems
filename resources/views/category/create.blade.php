@if(isset($category->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('categories.update',$category->id)}}" method="POST"> 
                <input type="hidden" value="PATCH" name="_method">    
                <input type="hidden" value="{{ @$category->id }}" name="id">    
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('categories.store')}}" method="POST"> 
                <input type="hidden" value="POST" name="_method">    
            @endif
            
		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					
					{{-- Season Name Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="name">{{ __('messages.name')}}</label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="name" name="name" placeholder="{{ __('messages.entername')}}" data-msg-required="This field is required." value="{{ ((isset($category)) ? $category->name : old('name')) }}" pattern="[a-z{1}[A-Z]{1}[0-9]{1}]" data-msg-pattern="" required />
							<span class="help-block removedata" id="error_name">
							</span>
						</div>
					</div>
					{{-- End Season Name Field --}}
					
					{{-- Status --}}
					@if(isset($category))
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status')}}</label><br/>
						<div class="col-lg-4 m-form__group-sub">
							<span class="m-switch m-switch--icon">
								<label for="status">
									<input type="checkbox" name="status" id="status" value='Active' {{ ((isset($category)) ? (($category->status=='Active') ? 'checked' : '') : 'checked')}} />
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
