@extends('layouts.app')
@section('subheader',__('messages.workloglisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.worklog')}}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">

        <form id="mworklogForm" action="{{ route("work_log.update", ['work_log' => $work_log->id]) }}" method="POST" class="userForm" enctype="multipart/form-data">
            @include('work_log.form')
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
@include('work_log.script')
    <script type="text/javascript">
     $("#employee_id").select2();
     $( "#log_date" ).datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
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

        $('#mworklogForm').on('submit', function(e) {
        e.preventDefault();
         $('.error_label').text('');
        var frm = $('#mworklogForm');
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
                    window.location.href = '{{ route("work_log.index") }}';
                } else {
                    toastr.error(response.message);
                }

            }

        });
    });
         $( "#start_date" ).datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
        $( "#end_date" ).datepicker({
            dateFormat: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
    </script>
@endpush
