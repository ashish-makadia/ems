@extends('layouts.app')
@section('subheader',"Sub Category Listing")
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
				Sub Category
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				@can('add sub_categories')
				<li class="m-portlet__nav-item">
					<a  data-toggle="modal" onclick="openNewModal('Add Sub Category','{{route('sub_categories.create')}}')" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
					<th>Sub Category</th>
					<th>Category</th>
					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!--begin::Modal-->
<div class="modal fade {{$breadcrumb[0]['name']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
		</div>
	</div>
</div>

<!--end::Modal-->
@endsection

@section('footer_scripts')
<script type="text/javascript">

	// Create datatable
	$('#{{$breadcrumb[0]['name']}}').dataTable({
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
		"ajax": '{{route("sub_categories.index")}}',
		"method":'post',
		"columns": [
			{ "data": "name", "name":"name"},
			{ "data": "category_name", "name":"category_name"},
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
				@can('edit sub_categories')
				btns += '<a href="javascript:void(0)" data-original-title="Edit" data-toggle="tooltip" data-placement="top" title="Edit" class="edit editclick" id="edit_modal_'+row['id']+'"><i class="la la-edit"></i></a>';
				@endcan
				@can('delete sub_categories')
				btns += '<a href="javascript:void(0)" data-original-title="Delete" id="'+row['id']+'" data-toggle="tooltip" data-placement="top" title="Delete" class="delete deletebtn"><i class="la la-trash"></i></a>';
				@endcan
				return btns;
					},
				}
		],
		"order": [ 0, 'asc' ],
		"columnDefs": [
			{
				"targets": [ 3 ],
				"orderable": false,
				"searchable": true
			}
		],
	});

</script>
@include('layouts.customdatatable');
@endsection
