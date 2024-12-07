@extends('layouts.app')
@section('subheader',"Customer")
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Customer
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				@can('add customer')
				<li class="m-portlet__nav-item">
					<a href="{{route('customer.create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>{{ __('messages.addrecord')}}</span>
						</span>
					</a>
				</li>
				@endcan
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">
					<th>{{__('messages.id')}}</th>
					<th>Company Name</th>
					<th>Category</th>
					<th>Sub Category</th>
					<th>Zip Code</th>
					<th>Email</th>
					<th>{{__('messages.status')}}</th>
					<th class="text-center">{{__('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
	// Create datatable
	$("#{{$breadcrumb[0]['name']}}").dataTable({
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
		"ajax": '{{route("customer.index")}}',
		"method": 'post',
		"columns": [{
				"data": "id",
				"name": "id"
			},
			{
				"data": "company_name",
				"name": "company_name"
			},
			{
				"data": "category",
				"name": "category",
				"render": function(action, type, row) {
					return row['category'] ? row['category']['name'] : '';
				}
			},
			{
				"data": "subCategory",
				"name": "subCategory",
				"render": function(action, type, row) {
					return row['subCategory'] ? row['sub_category']['name'] : '';
				}
			},
			{
				"data": "zipcode",
				"name": "zipcode"
			},
			{
				"data": "company_email",
				"name": "company_email"
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

					btns += '<a href="' + row['customer_edit_url'] + '" data-original-title="Edit" data-toggle="tooltip" data-placement="top" title="Edit" class="edit editclick" id="edit_modal_' + row['id'] + '"><i class="la la-edit"></i></a>';

					btns += '<a href="javascript:void(0)" data-original-title="Delete" id="' + row['id'] + '" data-toggle="tooltip" data-placement="top" title="Delete" class="delete deletebtn"><i class="la la-trash"></i></a>';

					return btns;
				},
			}
		],
		"order": [0, 'asc'],
		"columnDefs": [{
			"targets": [3],
			"orderable": false,
			"searchable": true
		}],
	});
</script>
@include('layouts.customdatatable');
@endsection