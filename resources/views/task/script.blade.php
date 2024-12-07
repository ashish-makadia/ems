<script>
        $("#team_member").select2();
        $('#mtaskForm').on('submit', function(e) {
        e.preventDefault();
         $('.error_label').text('');
        var frm = $('#mtaskForm');
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
                    window.location.href = '{{ route("task.index") }}';
                } else {
                    toastr.error(response.message);
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

    // $('#project_id').on('change', function(e) {
    //     var prj_id = $(this).val();
    //     $.ajax({
    //         url: "{{route('getEmployeeProject')}}",
    //         type: "POST",
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: {'id':prj_id},
    //         success: function(response) {
    //             var html = '<option value="">...............</option>';
    //             $.each(response.employee, function(key, value) {
    //                 html += `<option value="${value['id']}">${value['name']}</option>`;
    //             });
    //             $("#team_member").html(html);
    //         }
    //     });
    // });

    $("#employee_id").select2();
    $("#project_id").select2();

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




    </script>

