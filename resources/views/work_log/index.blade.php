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
		{{-- @if(Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Employee')
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">

					<li class="m-portlet__nav-item">
						<a href='{{route('work_log.create')}}' class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>{{ __('messages.addrecord')}}</span>
							</span>
						</a>
					</li>

				</ul>
			</div>
		@endif --}}
	</div>
	<div class="m-portlet__body">

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">

                    <th>{{ __('messages.id')}}</th>
                    @if(Auth::user()->role == 'Super Admin')
                        <th>{{ __('messages.employee')}}</th>
                    @endif
					<th>{{ __('messages.project')}}</th>
                    <th>{{ __('messages.timespent')}}</th>
                    <th>{{ __('messages.date')}}</th>
					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="modal fade {{$breadcrumb[0]['name']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

	// Create datatable
	var worklogDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable( {
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
		"ajax": '{{route("work_log.index")}}',
		"method":'post',
		"columns": [
            { "data": "id", "name":"id"},
            @if(Auth::user()->role == 'Super Admin')
            { "data": "employee_id", "name":"employee_id",
                "render": function(action, type, row){
                    return row['user']?row['user']['name']:'';
                }
            },
            @endif
			{ "data": "project_id", "name":"project_id",
                "render": function(action, type, row){
                    return row['project']?row['project']['project_name']:'';
                }
            },
            { "data": "time_spent", "name":"time_spent",
                "render": function(time_spent){
                    return time_spent+"h";
                },
            },
   //      { "data": "task_id", "name":"task_id",
   //          "render": function(action, type, row){
   //              return row['task']?row['task']['task_title']:'';
   //          }
   //      },
        { "data": 'log_date', "name": 'log_date',
					"render": function(log_date){
						return formatedate(log_date);
					},
				},

                // { "data": "start_time", "name":"start_time"},
                // { "data": "end_time", "name":"end_time"},
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
                        @can('delete worklog')
                        btns += `<a href="javascript:void(0)" data-original-title="Delete" id="${row['id']}" data-toggle="tooltip" data-placement="top" title="Delete" class="delete" onClick="deleteAjaxRecord(${row['id']})"><i class="la la-trash"></i></a>`;
                        @endcan

                        @if(Auth::user()->role == "Employee" || Auth::user()->role == "Super Admin")
                        // btns += '<a href="'+row['work_log_edit_url']+'" data-original-title="Edit" data-toggle="tooltip" data-placement="top" class="edit editclick" title="Edit"><i class="la la-edit"></i></a>';
                        btns += '<a href="javascript:void(0)" data-original-title="Edit" data-toggle="tooltip" data-placement="top" title="Edit" class="edit editclick" id="edit_modal_'+row['id']+'"><i class="la la-edit"></i></a>';
                        @endif
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
        deleteData(id,worklogDatatble);
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

</script>
@include('layouts.customdatatable');
@endsection
