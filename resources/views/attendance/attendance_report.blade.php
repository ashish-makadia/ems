@extends('layouts.app')
@section('subheader',"Attendance Report")
@section('content') 
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Attendance Report
				</h3>
			</div>
		</div>
		
	</div>
	<div class="booking-button-wrapper">
		<ul class="m-portlet__nav">
			<li class="m-portlet__nav-item">
				<select class="form-control m-input m-input--square custom-select" id="user_id" name="user_id" data-placeholder="Select User"/>
				@foreach($users as $user)
						<option value="{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</li>
			<li class="m-portlet__nav-item" id="li_1">	
				<input type="text" class="form-control m-input m_datepicker_5" name="start" id="search_fromdate" placeholder="{{__('messages.fromdate')}}">
				<div class="input-group-append">
					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
				</div>
				<input type="text" class="form-control m_datepicker_5" name="end" id="search_todate" placeholder="{{__('messages.todate')}}">
			</li>
		</ul>
		<button id="search" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">Search</button>
		
	</div>

	<div class="m-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="orderbooking">
			<thead>
				<tr class="heading">
					<th>ID</th>
					<th>Employee Name</th>
					<th>Date Time In</th>
					<th>Date Time Out</th>
					<th>Loaction</th>
					<th>Browser</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">$(".m_datepicker_custom").datepicker({format:'dd-mm-yyyy',autoclose:true,weekStart: 1});$(".m_datepicker_5").datepicker({format:'dd-mm-yyyy',autoclose:true,weekStart: 1});</script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript">
		
	// Create datatable
	$('#orderbooking').dataTable({
		language: {
	        emptyTable:  "{{__('messages.no_data')}}",
	        info:        "{{__('messages.showing')}} _START_ {{__('messages.to')}} _END_ {{__('messages.of')}} _TOTAL_ {{__('messages.entries')}}",
	        infoEmpty:   "{{__('messages.showing')}} 0 {{__('messages.to')}} 0 {{__('messages.of')}} 0 {{__('messages.entries')}}",
	        infoFiltered:"({{__('messages.filtered')}} _MAX_ {{__('messages.total')}} {{__('messages.entries')}})",
	        lengthMenu:  "{{__('messages.show')}} _MENU_ {{__('messages.entries')}}",
	        search:      "{{__('messages.search')}}",
      	},
		responsive:!0,
		"processing": true,
		"serverSide": true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	
		"ajax":{
			"url": "{{ route('attendances.report') }}",
			"dataType": "json",
			"type": "GET",
			data: function(data){
				data.user_id = $("#user_id").val();
				data.fromdate = $('#search_fromdate').val();
				data.todate = $('#search_todate').val();
			}
		},
		//"method":'post',
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
		"order": [ 0, 'desc' ],
		"columnDefs": [
			{
				"targets": -1,
				"orderable": false,
				"searchable": true
			}
		],
		drawCallback:function(data){

		}
	   
	});
	$(document).on('change','#user_id',function(){
		$('#orderbooking').DataTable().ajax.reload();
	});
	$(document).on('click','#search',function(){
		var abcd = $('#search_fromdate').val();
		alert(abcd);
		$('#orderbooking').DataTable().ajax.reload();
	});
</script>

<style type="text/css">
	/*.m-portlet .m-portlet__head .m-portlet__head-tools .m-portlet__nav .m-portlet__nav-item {
	width: 20%;
}*/
.m-portlet .m-portlet__head .m-portlet__head-tools .m-portlet__nav .m-portlet__nav-item ul.select2-selection__rendered {
padding: 8px 1.15rem;
border-radius: 0;
min-height: 40px;
/*line-height: 23px;*/
}
.m-portlet .m-portlet__head .m-portlet__head-tools .m-portlet__nav .m-portlet__nav-item span.select2-selection.select2-selection--multiple {
border-radius: 0;
}
.m-portlet .m-portlet__head .m-portlet__head-tools .m-portlet__nav .m-portlet__nav-item span.select2.select2-container.select2-container--default.select2-container--below ul.select2-selection__rendered {
line-height: 23px;
}
.booking-button-wrapper {
    width: 100%;
    text-align: right;
    padding: 0.8rem 2.2rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.booking-button-wrapper ul {
	margin: 0;
	padding: 0;
	display: flex;
	flex: 1;
}
.booking-button-wrapper ul li {
	display: flex;
	max-width: 350px;
	padding: 0 5px;
	flex: 1;
}
button#search_save_booking {
    margin: 0 10px;
}
.booking-button-wrapper ul li span.select2-selection__rendered {
	text-align: left;
}
.booking-button-wrapper ul li .select2-selection__arrow:before {
	margin-right: 10px;
}
.booking-button-wrapper a#cruise_booking_resetData {
    margin-right: 5px;
}
.m-portlet .m-portlet__head .m-portlet__head-tools .m-portlet__nav .m-portlet__nav-item:nth-of-type(3) {
    width: 35%;
}
.count_email{
	z-index: 9;
	color: #fff;
	font-family: arial;
	cursor: pointer;
	background: red;
	border-radius: 50%;
	width: 14px;
	text-align: center;
	vertical-align: bottom;
	padding: 2px;
	font-size: 10px;
	display: block;
	font-weight: bold;
}
span.detail_sent_mail span.count_email {
	position: absolute;
	right: -8px;
	top: -11px;
}
span.detail_sent_mail {
	position: relative;
}
</style>
@endsection
