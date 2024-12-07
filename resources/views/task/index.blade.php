@extends('layouts.app')
@section('subheader',__('messages.tasklisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.task')}}
				</h3>
			</div>
		</div>

			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href='{{route('task.create')}}' class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>{{ __('messages.addrecord')}}</span>
							</span>
						</a>
					</li>

				</ul>
			</div>

	</div>
	<div class="m-portlet__body">
       <div class="row mb-5">
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="category_id"><b>Project</b></label>
                    <select name="project_id" id="project_id" class="form-control select2">
                        <option value="">..........</option>
                          @foreach ($projects as $prj )
                         <option value="{{ $prj->id}}">{{$prj->project_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <div class="text-center" >
                    <button type="button" id="searchBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px"><i class="fa fa-search fa-fw "></i> Search</button>
                </div>
            </div>
        </div>
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">
                    <th>{{ __('messages.id')}}</th>
                    <!-- <th>{{ __('messages.task_title')}}</th> -->
                    @if(Auth::user()->role == 'Super Admin')
                    <th>{{ __('messages.team_member')}}</th>
                    @endif
					<th>{{ __('messages.project')}}</th>
                    <th>{{ __('messages.estimate_hour')}}</th>
                    <th>{{ __('messages.remaining_hour')}}</th>

					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="modal fade {{$breadcrumb[0]['worklog_name']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" id="modalHeader">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modalBody">

			</div>
		</div>
	</div>
</div>

@endsection
@section('footer_scripts')

<script type="text/javascript">
        $("#searchBtn").on("click",function(){
            $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
        })
	// Create datatable
	var taskDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable( {
		language: {
	        emptyTable:  "{{__('messages.no_data')}}",
	        info:        "{{__('messages.showing')}} _START_ {{__('messages.to')}} _END_ {{__('messages.of')}} _TOTAL_ {{__('messages.entries')}}",
	        infoEmpty:   "{{__('messages.showing')}} 0 {{__('messages.to')}} 0 {{__('messages.of')}} 0 {{__('messages.entries')}}",
	        infoFiltered:"({{__('messages.filtered')}} _MAX_ {{__('messages.total')}} {{__('messages.entries')}})",
	        lengthMenu:  "{{__('messages.show')}} _MENU_ {{__('messages.entries')}}",
	        search:      "{{__('messages.search')}}",
      	},
		"processing": true,
		"serverSide": true,
        "ajax": {
            url: '{{route("task.index")}}',
            "dataType": "json",
            "type": "get",
            data: function(data) {
                // data._token = $('meta[name="csrf-token"]').attr('content');
                // data.start_date = $('#start_date').val();
                // data.end_date = $('#end_date').val();
                data.team_member = $('#team_member').val();
                data.project_id = $('#project_id').val();
            },
        },
		"columns": [
            { "data": "id", "name":"id"},
            // { "data": "task_title", "name":"task_title"},
            @if(Auth::user()->role == 'Super Admin')
            { "data": "team_members_name", "name":"team_members_name"},
            @endif
			{ "data": "project_id", "name":"project_id",
            "render": function(action, type, row){
                return row['project']?row['project']['project_name']:'';
            }
        },
        { "data": "estimate_hour", "name":"estimate_hour",
        "render": function(row){
                return row+"h";
            }},
            { "data": "remaining_estimate_time", "name":"remaining_estimate_time",
                "render": function(row){
                    return row+"h";
            }},
                { "data": 'status', "name": 'status',
					"render": function(status,type, row){
						var checkedd = '';
						if(status=='Active')
						{
							var checkedd = 'checked';
						}
						return '<span class="m-switch m-switch--icon"><label for="status_'+row['id']+'"><input onchange="changestatus('+row['id']+')" type="checkbox" class="changestatus" name="status" id="status_'+row['id']+'" value="Active" '+checkedd+'><span class="help-block removedata" id="error_status"></span></label></span>';
					},
				},
			{ "data": 'action', "name": 'action',
					"render": function(action, type, row){
						var btns = '';
                        btns += '<a href="'+row['task_edit_url']+'" data-original-title="Edit" data-toggle="tooltip" data-placement="top" class="edit editclick" title="Edit"><i class="la la-edit"></i></a>';
                        btns += `<a href="javascript:void(0)" data-toggle="modal" onclick="openWorkLogModal('Add worklog','{{route('work_log.create')}}',${row['id']})" title="Work Log"><i class="la la-history"></i></a>`;
                        btns += `<a href="javascript:void(0)" data-original-title="Delete" id="${row['id']}" data-toggle="tooltip" data-placement="top" title="Delete" class="delete" onClick="deleteAjaxRecord(${row['id']})"><i class="la la-trash"></i></a>`;
                        return btns;
                            },
                        }
		],
		"order": [ 0, 'desc' ],
		// "columnDefs": [
		// 	{
		// 		"targets": [ 5 ],
		// 		"orderable": false,
		// 		"searchable": true
		// 	}
		// ],
	});

    function deleteAjaxRecord(id){
        deleteData(id,taskDatatble);
    }
	function formatedate(date)
	{
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

    var modal = $('.{{$breadcrumb[0]['worklog_name']}}');
    var modal_body = $('#modalBody');
    var modal_title = modal.find('#modalHeader');
    function openWorkLogModal(title,link,task_id)
    {
        modal_body.html('');
        $(".modal-title").html(title+" - "+task_id);
        $.ajax({
            'url':link,
            'dataType':'json',
            success:function(result)
            {
                $("#modalBody").html(result.view);
                $(".worklog").modal();
                $("#task_id").val(task_id);

            }
        })
    }


</script>
@include('layouts.customdatatable');
@include('task.script')
@endsection
