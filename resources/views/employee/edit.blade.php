@extends('layouts.app')
@section('subheader',__('messages.employeelisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.employee')}}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
        <form id="memployeeForm" action="{{ route("employee.update", ['employee' => $employee->id]) }}" method="POST" class="userForm" enctype="multipart/form-data">
            @include('employee.form')
            @method('patch')
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
        $("#employeeImage").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
        $("#designation_id").select2();
        $('#memployeeForm').on('submit', function(e) {
        e.preventDefault();
         $('.error_label').text('');
        var frm = $('#memployeeForm');
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
                    window.location.href = '{{ route("employee.index") }}';
                } else {
                    toastr.error(response.message);
                }

            }

        });
    });
    </script>
@endpush
