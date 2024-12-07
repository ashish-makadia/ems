@if(isset($accessip->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('accessips.update',$accessip->id)}}" method="POST"> 
                <input type="hidden" value="PATCH" name="_method">    
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('accessips.store')}}" method="POST"> 
                <input type="hidden" value="POST" name="_method">    
            @endif
            
		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					{{-- Ip Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="title">{{ __('messages.ip') }}</label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="ip" name="ip" placeholder="{{ __('messages.enterip') }}" data-msg-required="This field is required." value="{{ ((isset($accessip)) ? $accessip->ip : old('ip')) }}" required />
							<span class="help-block removedata" id="error_ip">
							</span>
						</div>
					</div>
					{{-- End Ip Field --}}


					{{-- Ip type Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="type">{{ __('messages.iptype') }}</label>
						<div class="col-lg-9 m-form__group-sub ">
							<select name="type" class="form-control">
								<option value=''> -- {{ __('messages.iptypeoption') }} -- </option>;
								<option value='White' @isset($accessip) <?= $accessip->type =='White' ? 'selected' : ""  ?> @endisset>White</option>
								<option value='Black' @isset($accessip) <?= $accessip->type =='Black' ? 'selected' : ""  ?>  @endisset>Black</option>
							</select>
							<span class="help-block removedata" id="error_type">
							</span>
						</div>
					</div>
					{{-- Ip type Field --}}



					{{-- Status --}}
					@if(isset($accessip))
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status') }}</label><br/>
						<div class="col-lg-4 m-form__group-sub">
							<span class="m-switch m-switch--icon">
								<label for="status">
									<input type="checkbox" name="status" id="status" value='Active' {{ ((isset($accessip)) ? (($accessip->status=='Active') ? 'checked' : '') : 'checked')}} />
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
					<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{ __('messages.submit') }}</button>
					<a href="#" data-dismiss="modal" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{ __('messages.cancel') }}</a>
				</div>
			</div>
</form>
