@extends('layouts.app')
@section('subheader',__('messages.activitylogs'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.activitylogs')}}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['datatable']}}">
			<thead>
				<tr class="heading">
					<th>{{ __('messages.subject')}}</th>
					<th>{{ __('messages.url')}}</th>
					<th>{{ __('messages.method')}}</th>
					<th>{{ __('messages.ip')}}</th>
					<th>{{ __('messages.agent')}}</th>
					<th>{{ __('messages.user')}}</th>
					<th>{{ __('messages.createddate')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('footer_scripts')
<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	
	// Create datatable
	$('#{{$breadcrumb[0]['datatable']}}').dataTable({
		language: {
	        emptyTable:  "{{__('messages.no_data')}}",
	        info:        "{{__('messages.showing')}} _START_ {{__('messages.to')}} _END_ {{__('messages.of')}} _TOTAL_ {{__('messages.entries')}}",
	        infoEmpty:   "{{__('messages.showing')}} 0 {{__('messages.to')}} 0 {{__('messages.of')}} 0 {{__('messages.entries')}}",
	        infoFiltered:"({{__('messages.filtered')}} _MAX_ {{__('messages.total')}} {{__('messages.entries')}})",
	        lengthMenu:  "{{__('messages.show')}} _MENU_ {{__('messages.entries')}}",
	        search:      "{{__('messages.search')}}",
      	},
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"ajax": '{{route("logactivity.index")}}',
		"method":'post',
		"columns": [

			{ "data": "subject", "name":"subject"},
			{ "data": "url", "name":"url"},
			{ "data": "method", "name":"method"},
			{ "data": "ip", "name":"ip"},
			{ "data": "agent", "name":"agent"},
			{ "data": "user", "name":"user"},
			{ "data": "date.0", "name":"date"},

		],
		"order": [ 0, 'desc' ],
		"columnDefs": [
			{
				"targets": [ 6 ],
				"orderable": false,
				"searchable": true
			}
		],
	});

</script>
@include('layouts.customdatatable');
@endsection