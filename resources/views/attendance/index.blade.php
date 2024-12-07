@extends('layouts.app')
@section('subheader',"Attendance Listing")
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Attendance
				</h3>
			</div>
		</div>
		{{--@if(Auth::user()->role == 'Super Admin')
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					@can('add user')
					<li class="m-portlet__nav-item">
						<a href="{{route('attendance.create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
		<span>
			<i class="la la-plus"></i>
			<span>{{ __('messages.addrecord')}}</span>
		</span>
		</a>
		</li>
		@endcan
		</ul>
	</div>
	@endif--}}
</div>
<div class="m-portlet__body">

	<!--begin: Datatable -->
	<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
		<thead>
			<tr class="heading">
				<th>{{ __('messages.name')}}</th>
				<th>Date Time IN</th>
				<th>Date Time OUT</th>
				<th>Location</th>
				<th>Browser</th>
			</tr>
		</thead>
	</table>
</div>
</div>


@endsection
@section('footer_scripts')
<script type="text/javascript">
	// Create datatable
	var attendanceDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable({
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
		"ajax": '{{route("attendance.index")}}',
		"method": 'post',
		"columns": [{
				"data": "username",
				"name": "username"
			},
			{
				"data": "DateTimePunchedIn",
				"name": "DateTimePunchedIn"
			},
			{
				"data": "DateTimePunchedOut",
				"name": "DateTimePunchedOut"
			},
			{
				"data": "location",
				"name": "location"
			},
			{
				"data": "browser",
				"name": "browser"
			},
		
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

	function formatedate(date) {
		date1 = date.split('T');
		date = date1[0]
		date = new Date(date);
		return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
	}
</script>
@include('layouts.customdatatable');
@endsection