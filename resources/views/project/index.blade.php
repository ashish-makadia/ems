@extends('layouts.app')
@section('subheader',__('messages.projectlisting'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" type="text/css" />
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.project')}}
				</h3>
			</div>
		</div>
		@if(Auth::user()->role == 'Super Admin')
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href='{{route('project.create')}}' class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>{{ __('messages.addrecord')}}</span>
						</span>
					</a>
				</li>

			</ul>
		</div>
		@endif
	</div>
	<div class="m-portlet__body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><b>Start Date</b></label>
					<input type="text" class="form-control datepicker" name="start_date" id="start_date">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><b>End Date</b></label>
					<input type="text" class="form-control datepicker" name="end_date" id="end_date">
				</div>
			</div>
            @if(Auth::user()->role == 'Super Admin')
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id"><b>Employee</b></label>
                        <select name="team_members" id="team_member" class="form-control select2">
                            <option value="">..........</option>
                            @foreach ($employees as $employee )
                            <option value="{{ $employee->id}}" @if(isset($team_members) && in_array($employee->id,$team_members)) {{"Selected"}} @endif>{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
			<div class="col-md-2">
				<div class="text-center" style="margin-bottom:10px">
					<button type="button" id="searchBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px"><i class="fa fa-search fa-fw "></i> Search</button>
				</div>
			</div>
		</div>

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">
					<th>{{ __('messages.name')}}</th>
                    @if(Auth::user()->role == 'Super Admin')
					<th>{{ __('messages.team_member')}}</th>
                    @endif
					<th>{{ __('messages.start_date')}}</th>
					<th>{{ __('messages.end_date')}}</th>
					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div class="modal fade attachment-model" id="attachment-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" id="modalHeader">
				<h5 class="modal-title" id="exampleModalLabel">Project Attachment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modalBody">
                <label for="exampleInputFile"><b>Attachment</b></label>
                <form id="project-form" class="dropzone" action="{{ route('projectattachment.store')}}" method="POST" class="userForm" enctype="multipart/form-data">
                    <input type="hidden" id="project_id" name="project_id" />
                    @csrf
                </form>
                <button class="btn btn-primary mt-2" id="uploadFile">Upload Files</button>
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
                                <input type="hidden" name="project_id" id="project_id" value="">
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
@endsection
@section('footer_scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript">

// Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", {
         autoProcessQueue: false,
         paramName: "file", // The name that will be used to transfer the file
        // maxFilesize: 100, // MB
        parallelUploads: 100,
        autoProcessQueue: false,
        dictDefaultMessage: "<strong>Drop Your files here or click to upload. </strong>"
    });
    // Dropzone.options.projectForm = {
    //     init: function() {
            myDropzone.on("complete", function (file, response) {
                this.removeFile(file);
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    if(file.status){
                        toastr.success("Attachment uploaded Successfully");
                        $("#attachment-model").modal("hide");

                    } else {
                        toastr.error("Something went wrong!!");
                    }
                }
        });
        // },

    // };

    $('#uploadFile').click(function(){
        myDropzone.processQueue();
    });

	$(".datepicker").datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});
	$("#start_date").on("changeDate", function(event) {
		if (event.date) {
			$("#end_date").datepicker("setStartDate", event.date);
		} else {
			$("#end_date").datepicker("setStartDate", null);
		}
	});

	$("#end_date").on("changeDate", function(event) {
		if (event.date) {
			$("#start_date").datepicker("setEndDate", event.date);
		} else {
			$("#end_date").datepicker("setEndDate", null);
		}
	});
	$("#searchBtn").on("click", function() {
		$("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();

	})
	// Create datatable
	var taskDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable({
		language: {
			emptyTable: "{{__('messages.no_data')}}",
			info: "{{__('messages.showing')}} _START_ {{__('messages.to')}} _END_ {{__('messages.of')}} _TOTAL_ {{__('messages.entries')}}",
			infoEmpty: "{{__('messages.showing')}} 0 {{__('messages.to')}} 0 {{__('messages.of')}} 0 {{__('messages.entries')}}",
			infoFiltered: "({{__('messages.filtered')}} _MAX_ {{__('messages.total')}} {{__('messages.entries')}})",
			lengthMenu: "{{__('messages.show')}} _MENU_ {{__('messages.entries')}}",
			search: "{{__('messages.search')}}",
		},
		"processing": true,
		"serverSide": true,

        "ajax": {
            url: '{{route("project.index")}}',
            "dataType": "json",
            "type": "get",
            data: function(data) {
                // data._token = $('meta[name="csrf-token"]').attr('content');
                data.start_date = $('#start_date').val();
                data.end_date = $('#end_date').val();
                data.team_member = $('#team_member').val();
            },
        },
		"columns": [
			{ "data": "project_name", "name":"project_name"},
            @if(Auth::user()->role == 'Super Admin')
			{ "data": "team_members_name", "name":"team_members_name"},
            @endif
			{ "data": "start_date", "name":"start_date",
                "render": function(start_date){
					if(start_date){
						return formatedate(start_date);
					}else{
						return "N/A";
					}

				},
			},
			{
				"data": "end_date",
				"name": "end_date",
				"render": function(end_date) {
					if(end_date){
						return formatedate(end_date);
					}else{
						return "N/A";
					}
				},
			},
			{
				"data": 'status',
				"name": 'status',
				"render": function(status, type, row) {
					var checkedd = '';
					if (status == 'Active') {
						var checkedd = 'checked';
					}
					return '<span class="m-switch m-switch--icon"><label for="status_' + row['id'] + '"><input onchange="changestatus(' + row['id'] + ')" type="checkbox" class="changestatus" name="status" id="status_' + row['id'] + '" value="Active" ' + checkedd + '><span class="help-block removedata" id="error_status"></span></label></span>';
				},
			},
			{
				"data": 'action',
				"name": 'action',
				"render": function(action, type, row) {
					var btns = '';

                    @if(Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Employee')
					btns += '<a href="' + row['project_edit_url'] + '" data-original-title="Edit" data-toggle="tooltip" data-placement="top" class="edit editclick" title="Edit"><i class="la la-edit"></i></a>';

					btns += '<a href="' + row['project_show_url'] + '" data-original-title="Edit" data-toggle="tooltip" data-placement="top" class="edit " title="project Detail"><i class="la la-info-circle"></i></a>';
                    btns += `&nbsp;<a href="javascript:void(0)" onclick="openModel(${row['id']})" class="attachment-btn" id="${row['id']}"><i class="fas fa-file-upload"></i></a>`;
                    @endif
                    @if(Auth::user()->role == 'Super Admin')
                    btns += `<a href="javascript:void(0)" data-original-title="Delete" id="${row['id']}" data-toggle="tooltip" data-placement="top" title="Delete" class="delete" onClick="deleteAjaxRecord(${row['id']})"><i class="la la-trash"></i></a>`;
                     btns += `&nbsp;<a href="javascript:void(0)" onclick='openModel1(${row['id']})' class="attachment-btn" id="${row['id']}"><i class="fa fa-user"></i></a>`;
                    @endif
					return btns;
				},
			}
		],
		"order": [0, 'desc'],
		// "columnDefs": [
		// 	{
		// 		"targets": [ 5 ],
		// 		"orderable": false,
		// 		"searchable": true
		// 	}
		// ],
	});
   function openModel(id){
        // var id = $(this).attr("id");
        $("#project_id").val(id);
        $("#attachment-model").modal();
        console.log("Fgdfgdfgdf"+id);
    }
     function openModel1(id){
        // var id = $(this).attr("id");
        $("#project_id").val(id);

        $("#employee_id").select2();
        $.ajax({
            url: "{{route('getEmployee')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'id':id},
            success: function(response) {
                $("#employee_id").html(response.employee);
            }
        });

        $("#assign-member").modal();
        console.log("klds"+id);
    }

    $("#assignMemberBtn").on("click",function() {
       var prj_id = $("#project_id").val();
        var employee_id = $("#employee_id").val();
        $.ajax({
            url: "{{route('project.assignmember')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'prj_id':prj_id,'employee_id':employee_id},
            success: function(response) {
                if(response.status){
                    toastr.success("Assgin employee for project "+response.project+" Successfully");
                    $("#assign-member").modal("hide");
                    $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
                }
            }
        });
    });
    // );
	function deleteAjaxRecord(id) {
		deleteData(id, taskDatatble);
	}

	function formatedate(date) {
        if(date != null && date != "0000-00-00" && date != ""){
            date1 = date.split('T');
            date = date1[0]
            console.log(date," ",date1);
            date = new Date(date);
            console.log(date);
            if(date && date != "Invalid Date"){
                getDate = date.getDate() > 10?date.getDate():'0'+date.getDate();
                return getDate+'-'+(date.getMonth() + 1)+'-'+ date.getFullYear();
            } else {
                return "";
            }
        }
        return "";
	}
</script>
@include('layouts.customdatatable');
@endsection
