            @if(isset($work_log->id))
                <form id="addform" method="post" enctype="multipart/form-data" onsubmit="return saveModalFrm(this);"  action="{{route('work_log.update',$work_log->id)}}" method="POST">
                <input type="hidden" value="PATCH" name="_method">
            @else
                <form id="addform" method="POST" onsubmit ="return saveModalFrm(this);" enctype="multipart/form-data" action="{{route('work_log.store')}}" method="POST">
                <input type="hidden" value="POST" name="_method">
            @endif
            @csrf
            <div class="m-portlet__body">
                @include('work_log.form')
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                            <button type="submit" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <script type="text/javascript">
        $( "#log_date" ).datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
        $("input[name=remaining_estimate_type]").on("click",function(){
            if($(this).val() == "set_to"){
                $("input[name=reduced_by_time]").val('');
                $("input[name=reduced_by_time]").prop("disabled",true);
                $("input[name=set_to_time]").prop("disabled",false);
            }
            if($(this).val() == "reduced_by"){
                $("input[name=set_to_time]").val('');
                $("input[name=set_to_time]").prop("disabled",true);
                $("input[name=reduced_by_time]").prop("disabled",false);
            }
            console.log("value: ",$(this).val());
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


    //     $('#mworklogForm').on('submit', function(e) {
    //     e.preventDefault();
    //      $('.error_label').text('');
    //     var frm = $('#mworklogForm');
    //     var fd = new FormData(frm[0]);
    //     url = $(this).attr('action');
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         cache: false,
    //         processData: false,
    //         contentType: false,
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: fd,
    //         success: function(response) {
    //             if(response.status){
    //                 window.location.href = '{{ route("work_log.index") }}';

    //             } else {
    //                 toastr.error(response.message);
    //             }
    //         }
    //     });
    // });

$('#time_spent').on('keyup', function(e) {
        var task_id = $("#task_id").val();

        $.ajax({
            url: "{{route('work_log.checktimespent')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'time_spent':$(this).val(),'task_id':task_id},
            success: function(response) {

                if(response == 1 ){
                    $("#time_spent_err").addClass('d-none');
                } else {
                    $("#time_spent_err").removeClass('d-none');
                }

            }
        });
    });

    </script>

{{-- @endpush --}}
