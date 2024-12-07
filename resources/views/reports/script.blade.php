<script>

    // $('#employee_id').on('change', function(e) {
    //     var emp_id = $(this).val();
    //     $("#employee_id_export").val(emp_id);
    //     $.ajax({
    //         url: "{{route('getEmployeeProject')}}",
    //         type: "POST",
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: {'employee_id':emp_id},
    //         success: function(response) {
    //             var html = '<option value="">Select Project</option>';
    //             $.each(response.project, function(key, value) {
    //                 html += `<option value="${value['id']}">${value['project_name']}</option>`;
    //             });
    //             $("#project_id").html(html);
    //         }
    //     });
    // });
    $('#project_id').on('change', function(e) {
        var prj_id = $(this).val();
        $("#project_id_export").val(prj_id)
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
                    html += `<option value="${value['id']}">${value['summry']}</option>`;
                });
                $("#task_id").html(html);
            }
        });
    });
    // $("#task_id").on('change', function(e) {
    //     var task_id = $(this).val();
    //     $("#task_id_export").val(task_id)
    // });
</script>
