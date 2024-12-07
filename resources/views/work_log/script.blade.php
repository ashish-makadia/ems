<script>

    $('#employee_id').on('change', function(e) {
        var emp_id = $(this).val();
        $.ajax({
            url: "{{route('getEmployeeProject')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'employee_id':emp_id},
            success: function(response) {
                var html = '<option value="">Select Prject</option>';
                $.each(response.project, function(key, value) {
                    html += `<option value="${value['id']}">${value['project_name']}</option>`;
                });
                $("#project_id").html(html);
            }
        });
    });
    $('#project_id').on('change', function(e) {
        var prj_id = $(this).val();
        $.ajax({
            url: "{{route('getProjectTask')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'project_id':prj_id},
            success: function(response) {
                var html = '<option value="">Select Task</option>';
                $.each(response.task, function(key, value) {
                    html += `<option value="${value['id']}">${value['task_title']}</option>`;
                });
                $("#task_id").html(html);
            }
        });
    });

    // $(".timepicker").on('change', function(e) {
    //     var employee = $("#employee_id").val();
    //     var log_date = $("#log_date").val();
    //     var start_time = $("#start_time").val();
    //     var end_time = $("#end_time").val();
    //     $.ajax({
    //         url: "{{route('reports.checkworklogTime')}}",
    //         type: "POST",
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: {'employee':employee,'log_date':log_date,'start_time':start_time,'end_time':start_time},
    //         success: function(response) {
    //             if(response.worklog > 0)
    //                 $("#time_err").removeClass('d-none');
    //             else
    //                 $("#time_err").addClass('d-none');
    //         }
    //     });
    // });
</script>
