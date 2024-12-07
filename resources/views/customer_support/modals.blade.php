<div class="modal fade {{$breadcrumb[0]['name']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
		</div>

	</div>

</div>
<div class="modal fade attachment-model1" id="assign-member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header" id="modalHeader">
				<h5 class="modal-title" id="exampleModalLabel">Assign Employee</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			 <div class="modal-body" id="modalBody">

                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label" for="name">{{ __('messages.employee')}}</label>
                            <div class="col-lg-9 m-form__group-sub ">
                                <select name="employee_id" required id="employee_id" multiple class="form-control select2">


                                </select>
                                <input type="hidden" name="customer_id" id="customer_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="m-form__actions">
                    <button type="button" id="assignMemberBtn" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{ __('messages.submit')}}</button>
                    <a href="#" data-dismiss="modal" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{ __('messages.cancel')}}</a>
                </div>
            </div>
		</div>
	</div>
</div>

<div class="modal fade request-model" id="request-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header" id="modalHeader">
				<h5 class="modal-title" id="exampleModalLabel">Reopen Ticket Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			 <div class="modal-body" id="modalBody">

                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label" for="name">Description</label>
                            <div class="col-lg-9 m-form__group-sub ">
                                <textarea class="form-control"></textarea>
                                <input type="hidden" name="customer_id" id="customer_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="m-form__actions">
                    <button type="button" id="assignMemberBtn" class="btn btn-accent m-btn m-btn--air m-btn--custom">{{ __('messages.submit')}}</button>
                    <a href="#" data-dismiss="modal" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{ __('messages.cancel')}}</a>
                </div>
            </div>
		</div>
	</div>
</div>
