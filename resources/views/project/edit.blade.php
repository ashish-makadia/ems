@extends('layouts.app')
@section('subheader',__('messages.projectlisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.project')}}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
        <form id="projectForm" action="{{ route("project.update", ['project' => $project->id]) }}" method="POST" class="userForm" enctype="multipart/form-data">
            @include('project.form')
            @method('patch')
            @csrf
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
$("#team_member").select2();
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
    $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
        $( "#start_date" ).on("changeDate", function(event) {
            if (event.date) {
                $("#end_date").datepicker("setStartDate", event.date);
            } else {
                $("#end_date").datepicker("setStartDate", null);
            }
        });

        $( "#end_date" ).on("changeDate", function(event) {
            if (event.date) {
                $("#start_date").datepicker("setEndDate", event.date);
            } else {
                $("#end_date").datepicker("setEndDate", null);
            }
        });

        $('#projectForm').on('submit', function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
         $('.error_label').text('');
        var frm = $('#projectForm');
        var fd = new FormData(frm[0]);
        fd.decription = $("#editor2").val();
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
                    window.location.href = '{{ route("project.index") }}';
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
    </script>
@endpush
