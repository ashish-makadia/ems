@if(isset($templatetype->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('templatetype.update',$templatetype->id)}}" method="POST">
                <input type="hidden" value="PATCH" name="_method">
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('templatetype.store')}}" method="POST">
                <input type="hidden" value="POST" name="_method">
            @endif

		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">

					{{-- Season Name Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="template_name">{{ __('messages.name')}}</label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="template_name" name="name" placeholder="{{ __('messages.entername')}}" data-msg-required="This field is required." value="{{ ((isset($templatetype)) ? $templatetype->name : old('name')) }}" required />
							<span class="help-block removedata" id="error_name">
							</span>
						</div>
					</div>

                    <div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="slug">Slug</label>
						<div class="col-lg-9 m-form__group-sub ">
							<input type="text" class="form-control m-input m-input--square" id="slug" name="slug" placeholder="Slug" data-msg-required="This field is required." value="{{ ((isset($templatetype)) ? $templatetype->slug : old('slug')) }}" required />
							<span class="help-block removedata" id="error_name">
							</span>
						</div>
					</div>
					{{-- End Season Name Field --}}

					{{-- Status --}}
					@if(isset($templatetype))
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="status">{{ __('messages.status')}}</label><br/>
						<div class="col-lg-4 m-form__group-sub">
							<span class="m-switch m-switch--icon">
								<label for="status">
									<input type="checkbox" name="status" id="status" value='Active' {{ ((isset($department)) ? (($department->status=='Active') ? 'checked' : '') : 'checked')}} />
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

@section('footer_scripts')
        <script type="text/javascript">
            $("#template_name").on("change",function(){
                console.log("FDgdfgdfg"+$(this).val());
                var name = $(this).val();
                name = (name.replace(" ","-")).toLowerCase();
                console.log(name);
                $("#slug").val(name);
            });
        </script>

@endsection
