@extends('layouts.app')
@section('subheader','Customer')
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
                Customer Suupport
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
        <form id="customerForm" action="{{ route('customer-support.update',['customer_support' => 1])}}" method="POST" class="userForm" enctype="multipart/form-data">
            @csrf
            @method('post')
            <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <input type="text" id="subject" name= "subject" class="form-control" value="{{ $custmerSup->subject??'' }}" />
                    <label class="form-label" for="form6Example1">Subject</label>
                  </div>
                </div>
            </div>
            <div class="row mb-4">
                <!-- Message input -->
                <div class="col">
                    <div class="row form-outline mb-4">
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $custmerSup->description??'' }}</textarea>
                    <label class="form-label" for="form6Example7">Description</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <input type="file" id="file_upload" name="file_upload" class="form-control" />
                    <label class="form-label" for="form6Example2">File upload</label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div class="form-outline mb-4">
                <input type="text" id="website" name="website" class="form-control" value="{{ $custmerSup->website??'' }}" />
                <label class="form-label" for="form6Example3">Website</label>
              </div>

              <!-- Text input -->
              <div class="form-outline mb-4">
                <input type="text" id="firstname" name="firstname" class="form-control" value="{{ $custmerSup->first_name??'' }}"/>
                <label class="form-label" for="form6Example4">First Name</label>
              </div>

              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" id="lastname" name="lastname" class="form-control" value="{{ $custmerSup->last_name??'' }}" />
                <label class="form-label" for="form6Example5">Last Name</label>
              </div>

              <!-- Number input -->
              <div class="form-outline mb-4">
                <input type="text" id="company" name="company" class="form-control" value="{{ $custmerSup->company??'' }}"/>
                <label class="form-label" for="form6Example6">Company</label>
              </div>

              <!-- Message input -->
              <div class="form-outline mb-4">
                <input type="email" id="mail" name="mail" class="form-control" value="{{ $custmerSup->mail??'' }}" />
                <label class="form-label" for="form6Example7">Mail</label>
              </div>

                 <!-- Message input -->
                 <div class="form-outline mb-4">
                  <input type="text" id="mobile" name="mobile" class="form-control" value="{{ $custmerSup->mobile??'' }}" />
                  <label class="form-label" for="form6Example7">Mobile</label>
                </div>

                <div class="form-outline mb-4">
                  <select class="form-control" name="priority" id="priority" >
                    <option value="">Select priority</option>

                    <option value="high" @if(isset($custmerSup->priority) && $custmerSup->priority == 'high') {{ "selected" }} @endif>High</option>
                    <option value="low" @if(isset($custmerSup->priority) && $custmerSup->priority == 'low') {{ "selected" }} @endif>Low</option>

                </select>
                  <label class="form-label" for="form6Example7">Priority</label>
                </div>


                <div class="form-outline mb-4">
                  <select class="form-control" name="status" id="status">


                    <option value="1" >Active</option>
                    <option value="0" >InActive</option>

                </select>
                  <label class="form-label" for="form6Example7">Status</label>
                </div>



              <!-- Submit button -->
              <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                        <button type="submit" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                    </div>
                </div>
            </div>
            </form>
	</div>
</div>


@endsection

@section('footer_scripts')
@push('scripts')
    <script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor2',
    {
        on:
       {
           'instanceReady': function(evt) {
               evt.editor.document.on('keyup', function() {
                   document.getElementById('editor2').value = evt.editor.getData();
               });

              evt.editor.document.on('paste', function() {
                  document.getElementById('editor2').value = evt.editor.getData();
               });
           }
       }
    });
    });
        $('#customerForm').on('submit', function(e) {
        
        e.preventDefault();

         $('.error_label').text('');
        var frm = $('#customerForm');
        var fd = new FormData(frm[0]);
        url = $(this).attr('action');
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: fd,
            success: function(response) {
                if(response.status){
                    window.location.href = '{{ route("customer.index") }}';
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
    </script>
@endpush
