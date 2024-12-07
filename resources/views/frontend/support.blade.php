@extends('frontend_layout.app')
@section('subheader',"Customer")
@section('content')


  <!-- Contact Start -->
  <div class="container-fluid bg-secondary px-0">
    <div class="row g-0">
        <div class="col-lg-12 py-6 px-5">
            <h1 class="display-5 mb-4">Customer Support Request Form </h1>
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
              {{ implode('', $errors->all()) }}
            </div>

            @endif
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <form id="customersupportForm" action="{{ route('customer.supportstore')}}" method="POST" class="userForm" enctype="multipart/form-data">
              @csrf
              <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <input type="text" id="subject" name= "subject" class="form-control" />
                      <label class="form-label" for="form6Example1">Subject</label>
                    </div>
                  </div>
                  <!-- Message input -->
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    <label class="form-label" for="form6Example7">Description</label>
                  </div>

                  <div class="col">
                    <div class="form-outline">
                      <input type="file" id="file_upload" name="file_upload" class="form-control" />
                      <label class="form-label" for="form6Example2">File upload</label>
                    </div>
                  </div>
                </div>

                <!-- Text input -->
                <div class="form-outline mb-4">
                  <input type="text" id="website" name="website" class="form-control" />
                  <label class="form-label" for="form6Example3">Website</label>
                </div>

                <!-- Text input -->
                <div class="form-outline mb-4">
                  <input type="text" id="firstname" name="firstname" class="form-control" />
                  <label class="form-label" for="form6Example4">First Name</label>
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" id="lastname" name="lastname" class="form-control" />
                  <label class="form-label" for="form6Example5">Last Name</label>
                </div>

                <!-- Number input -->
                <div class="form-outline mb-4">
                  <input type="text" id="company" name="company" class="form-control" />
                  <label class="form-label" for="form6Example6">Company</label>
                </div>

                <!-- Message input -->
                <div class="form-outline mb-4">
                  <input type="email" id="mail" name="mail" class="form-control" />
                  <label class="form-label" for="form6Example7">Mail</label>
                </div>

                   <!-- Message input -->
                   <div class="form-outline mb-4">
                    <input type="text" id="mobile" name="mobile" class="form-control" />
                    <label class="form-label" for="form6Example7">Mobile</label>
                  </div>

                  <div class="form-outline mb-4">
                    <select class="form-control" name="priority" id="priority">
                      <option value="">Select priority</option>

                      <option value="high" >High</option>
                      <option value="low" >Low</option>

                  </select>
                    <label class="form-label" for="form6Example7">Priority</label>
                  </div>


                  {{-- <div class="form-outline mb-4">
                    <select class="form-control" name="status" id="status">


                      <option value="1" >Active</option>
                      <option value="0" >InActive</option>

                  </select>
                    <label class="form-label" for="form6Example7">Status</label>
                  </div> --}}



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
</div>
<!-- Contact End -->
<script>
    $('#customersupportForm').on('submit', function(e) {
        e.preventDefault();
        $('.error_label').text('');
       alert('hello');
       die();
        var frm = $('#customersupportForm');
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
                if (response.status) {
                    window.location.href = '{{ route("frontend.customer") }}';
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
</script>
@endsection
