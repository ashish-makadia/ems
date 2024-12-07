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
		@if(Auth::user()->role == 'Super Admin')
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					@can('add user')
					<li class="m-portlet__nav-item">
						<a href='{{route('employee.create')}}' class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>{{ __('messages.addrecord')}}</span>
							</span>
						</a>
					</li>
					@endcan
				</ul>
			</div>
		@endif
	</div>
	<div class="m-portlet__body">

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">
					<th>{{ __('messages.name')}}</th>
					<th>{{ __('messages.email')}}</th>
					<th>{{ __('messages.mobileno')}}</th>
					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.createddate')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>


@endsection
@section('footer_scripts')
<script type="text/javascript">

	// Create datatable
	var employeeDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable( {
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
		"ajax": '{{route("employee.index")}}',
		"method":'post',
		"columns": [
			{ "data": "name", "name":"name"},
			{ "data": "email", "name":"email"},
			{ "data": "phone", "name":"phone"},
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

			{ "data": 'created_at', "name": 'created_at',
					"render": function(created_at){
						return formatedate(created_at);
					},
				},
			{ "data": 'action', "name": 'action',
					"render": function(action, type, row){
						var btns = '';
				@can('edit user')
				btns += '<a href="'+row['employee_edit_url']+'" data-original-title="Edit" data-toggle="tooltip" data-placement="top" class="edit editclick" title="Edit"><i class="la la-edit"></i></a>';
				@endcan
				@can('delete user')
				btns += `<a href="javascript:void(0)" data-original-title="Delete" id="${row['id']}" data-toggle="tooltip" data-placement="top" title="Delete" class="delete" onClick="deleteAjaxRecord(${row['id']})"><i class="la la-trash"></i></a>`;
				btns += `<a href="javascript:void(0)" data-original-title="Password Reset" id="${row['user_id']}" data-toggle="tooltip" data-placement="top" title="Reset Password" class="delete" onClick="ResetPasswordAjaxRecord(${row['user_id']})"><i class="la la-retweet"></i></a>`;
				@endcan
                btns += '<a href="'+row['employee_show_url']+'" data-original-title="Show Project Detail" data-toggle="tooltip" data-placement="top" class="edit editclick" title="Show Project Detail"><i class="la la-info-circle" aria-hidden="true"></i></a>';
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
        deleteData(id,employeeDatatble);
    }
	function ResetPasswordAjaxRecord(id){
        resetData(id,employeeDatatble);
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
