@if(isset($holiday->id))
<form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);" action="{{route('holiday.update',$holiday->id)}}" method="POST" autocomplete="off">
	<input type="hidden" value="PATCH" name="_method">
	@else
	<form id="addform" method="POST" onsubmit="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('holiday.store')}}" method="POST" autocomplete="off">
		<input type="hidden" value="POST" name="_method">
		@endif

		@csrf
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">
				{{-- Season Name Field --}}
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" for="name">{{ __('messages.name')}}</label>
					<div class="col-lg-9 m-form__group-sub ">
						<input type="text" class="form-control m-input m-input--square" id="name" name="name" placeholder="{{ __('messages.entername')}}" data-msg-required="This field is required." value="{{ ((isset($holiday)) ? $holiday->name : old('name')) }}" pattern="[a-z{1}[A-Z]{1}[0-9]{1}]" data-msg-pattern="Please enter valid Name" required />
						<span class="help-block removedata" id="error_name">
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" for="from_date">From Date</label>
					<div class="col-lg-9 m-form__group-sub ">
						<input type="text" class="form-control m-input m-input--square datepicker" id="from_date" name="from_date" placeholder="Enter From Date" data-msg-required="This field is required." value="{{ ((isset($holiday)) ? $holiday->from_date : old('from_date')) }}" />
						<span class="help-block removedata" id="error_from_date">
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" for="to_date">To Date</label>
					<div class="col-lg-9 m-form__group-sub ">
						<input type="text" class="form-control m-input m-input--square datepicker" id="to_date" name="to_date" placeholder="Enter To Date" data-msg-required="This field is required." value="{{ ((isset($holiday)) ? $holiday->to_date : old('to_date')) }}" />
						<span class="help-block removedata" id="error_to_date">
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" for="name">Description</label>
					<div class="col-lg-9 m-form__group-sub ">
					<textarea class="form-control m-input m-input--square" name="description" id="description" rows="3">{{ ((isset($holiday)) ? $holiday->description : old('description')) }}</textarea>
						<span class="help-block removedata" id="error_from_date">
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" for="name">Type</label>
					<div class="col-lg-9 m-form__group-sub ">
					<select name="type" id="type" class="form-control">
                    <option value="">Select Type</option>
             
                        <option value="Optional" {{ isset($holiday->type)?($holiday->type == "Optional"?"Selected":''):'' }}>Optional Holiday</option>
                        <option value="Compulsory" {{ isset($holiday->type)?($holiday->type == "Compulsory"?"Selected":''):'' }}>National Holiday</option>
                   
                </select>
						<span class="help-block removedata" id="error_from_date">
						</span>
					</div>
				</div>
				
		{{-- End Season Name Field --}}

		{{-- Status --}}
		@if(isset($holiday))
		<div class="form-group m-form__group row">
			<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status')}}</label><br />
			<div class="col-lg-4 m-form__group-sub">
				<span class="m-switch m-switch--icon">
					<label for="status">
						<input type="checkbox" name="status" id="status" value='active' {{ ((isset($holiday)) ? (($holiday->status=='active') ? 'checked' : '') : 'checked')}} />
						<span class="help-block removedata" id="error_status">
						</span>
					</label>
				</span>
			</div>
		</div>
		@endif
		{{-- End Status --}}



		</div>
		</div>
		<div class="modal-footer">
			<div class="m-form__actions">
				<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{ __('messages.submit')}}</button>
				<a href="#" data-dismiss="modal" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{ __('messages.cancel')}}</a>
			</div>
		</div>
	</form>
	<script>
		$(".datepicker").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayBtn: true,
			todayHighlight: true
		});
	</script>