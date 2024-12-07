@if(isset($team_lead->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('team-lead.update',$team_lead->id)}}" method="POST">
                <input type="hidden" value="PATCH" name="_method">
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('team-lead.store')}}" method="POST">
                <input type="hidden" value="POST" name="_method">
            @endif

		@csrf
			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">

					{{-- Name Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="name">{{ __('messages.name')}}<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub ">
                            <select name="employee_id" required id="employee_id" multiple class="form-control select2">
                                <option value="">...............</option>
                                @foreach ($employees as $emp )
                                <option value="{{ $emp->id}}"  {{ @@$employee->
                                    id && $employee->id == $emp->id? "Selected":''; }}>{{$emp->name}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
					{{-- End Name Field --}}

					{{-- Department Field --}}
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" for="department_id">Department<strong class="text-danger">*</strong></label>
						<div class="col-lg-9 m-form__group-sub">
                            <select name="designation_id" required id="designation_id" class="form-control select2">
                                <option value="">..........</option>
                                @foreach ($designations as $key => $desig)
                                @if($key ==7 || $key ==8 ||$key==9)
                                <option value="{{ $key }}" {{ @@$empDesig?(is_array($empDesig) && in_array($key,$empDesig)?"selected":""):""}}>{{$desig}}</option>
                                @endif
                                @endforeach
                            </select>
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

<script type="text/javascript">
 $("#employee_id").select2();
 $("#designation_id").select2();
    </script>
