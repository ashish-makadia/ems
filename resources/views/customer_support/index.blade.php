@extends('layouts.app')
@section('subheader',__('Customer Support'))
<style>
    .spinnermodal {
        background-color: #FFFFFF;
        height: 100%;
        left: 0;
        opacity: 0.5;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 100000;
    }
    </style>
@section('content')
<div class="m-portlet m-portlet--mobile">
    <div class="spinnermodal" id="LoaderDiv" style="display:none;z-index: 10001">
        <div style="position: fixed; z-index: 10001; top: 50%; left: 50%; height:50px">
            <img src="{{asset('images/loader.gif')}}" alt="Loading..." />
          </div>
      </div>
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{__('Customer Support') }}
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				{{-- @can('add designatiion') --}}
				{{-- <li class="m-portlet__nav-item">
					<a  data-toggle="modal" onclick="openNewModal('{{ __('messages.add').' '.__('messages.asignmember')}}','{{route('team-lead.create')}}')" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>{{ __('messages.asignmember')}}</span>
						</span>
					</a>
				</li> --}}
				{{-- @endcan --}}
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">
		<div class="row">


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
                <div class="col-md-2">
                    <div class="text-center" style="margin-top: 25px;">
                        <button type="button" id="searchBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px"><i class="fa fa-search fa-fw "></i> Search</button>
                    </div>
                </div>
            @endif

		</div>
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
                <tr
                 class="heading">
                 <th>Customer Name</th>
                    <th>Ticket No</th>
                    <th>Assigned By</th>
                    <th>Assigned To</th>
					<th>{{ __('messages.subject')}}</th>
                    <!-- <th>{{ __('messages.Description')}}</th> -->
                    <th>{{ __('messages.url')}}</th>
					<th>{{ __('messages.status')}}</th>
					<th>{{ __('messages.actions')}}</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!--begin::Modal-->
@include("customer_support.modals")

<!--end::Modal-->
@endsection

@section('footer_scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript">
    $("#searchBtn").on("click",function(){
        $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
    })
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
        "ajax": {
            url: '{{route("customer-support.index")}}',
            "dataType": "json",
            "type": "get",
            data: function(data) {
                // data._token = $('meta[name="csrf-token"]').attr('content');
                data.designation = true;
                data.team_member = $('#team_member').val();

            },
        },
		// "ajax": '{{route("employee.index")}}',
		// "method":'post',
		"columns": [
            { "data": null, "name":null,"render": function(data,type, row){

                return data.first_name+" "+data.last_name;
            }},
            { "data": "ticket_id", "name":"ticket_id"},
            { "data": null, "name":null,"render": function(data,type, row){
                return data.user?data.user.name:"Not Assigned";
            }},
            { "data": null, "name":null,"render": function(data,type, row){
                return (data.team_members_name!=""&&data.team_members_name!=null)?data.team_members_name:"Not Assigned";
            }},
			{ "data": "subject", "name":"subject"},
			// { "data": "Description", "name":"Description"},

			{ "data": "url", "name":"url",	"render": function(url,type, row){
                return `<a href="${url}" target="_blank">${url}</a>`;
            }},

            { "data": null, "name": null,
					"render": function(data,type, row){
                        var status = data.status_name;
                        var clss="";
                        var html = "";
						if(status=='Todo')
						{
                            isDisable = "";
							clss="btn btn-dark";
						} else if(status=='In Progress') {
                            isDisable = "";
                            clss="btn btn-warning";
                        }
                        else if(status=='Backlog') {
                            isDisable = "";
                            clss="btn btn-danger";
                        }
                        else if(status=='Done') {
                            isDisable = "";
                            clss="btn btn-primary";
                        }
                        else if(status=='Tested') {
                            isDisable = "";
                            clss="btn btn-info";
                        }
                        else if(status=='Completed') {
                            isDisable = "disabled";
                            clss="btn btn-success";
                        }
                        html +=`<div class="btn-group">
                            <button type="button" ${isDisable} class="${clss} btn-sm dropdown-toggle statuschange" data-id="${data.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               ${status}
                            </button>
                            <div class="dropdown-menu">`;
                                @foreach ($statuses as $key => $sts)
                                    html +=`<a class="dropdown-item" onclick="statuschange('${data.ticket_id}',{{$key}})" href="#">{{ $sts }}</a>`;
                                @endforeach
                                html +=`</div>
                        </div>`;
                        return html;
                        // return `<span class="${clss} p-2 text-white fw-bold">${status}</span>`;
					},
				},
			{ "data": 'action', "name": 'action',
					"render": function(action, type, row){
						var btns = '';
						btns += '<a href="'+'customer-support/show/'+row['ticket_id']+'"  data-original-title="View" data-toggle="tooltip" data-placement="top" title="View"><i class="la la-eye"></i></a>';
						btns += '<a href="javascript:void(0)" data-original-title="Delete" id="' + row['id'] + '" data-toggle="tooltip" data-placement="top" title="Delete" class="delete deletebtn"><i class="la la-trash"></i></a>';
                        @if(Auth::user()->role == 'Super Admin')
						    btns += `&nbsp;<a href="javascript:void(0)" onclick='openModel1(${row['id']})' class="attachment-btn" id="${row['id']}"><i class="fa fa-user"></i></a>`;
                            btns += `&nbsp;<a href="javascript:void(0)" onclick='openRequestModel(${row['id']})' class="request-btn" id="${row['id']}"><i class="fa fa-retweet"></i></a>`;
                        @endif
						return btns;
					},
				}
		],
		"order": [ 1, 'desc' ],
		// "columnDefs": [
		// 	{
		// 		"targets": [ 5 ],
		// 		"orderable": false,
		// 		"searchable": true
		// 	}
		// ],
	});

    function openModel(id){
        $("#customer_id").val(id);
        $("#attachment-model").modal();
        console.log("Fgdfgdfgdf"+id);
    }

    function openRequestModel(id){
        $("#customer_id").val(id);
        $("#request-model").modal();
        console.log("Fgdfgdfgdf"+id);
    }
    function openModel1(id){
        // var id = $(this).attr("id");
        $("#customer_id").val(id);

        $("#employee_id").select2();
        $.ajax({
            url: "{{route('getCustomer')}}",
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
       var cus_id = $("#customer_id").val();
        var employee_id = $("#employee_id").val();
        $.ajax({
            url: "{{route('customer-support.assignmember')}}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'cus_id':cus_id,'employee_id':employee_id},
            beforeSend: function () { $('#LoaderDiv').show(); },
            success: function(response) {
                $('#LoaderDiv').hide();
                if(response.status){
                    toastr.success("Assgin employee for project "+response.project+" Successfully");
                    $("#employee_id").html('');
                    $("#assign-member").modal("hide");
                    $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
                }

            },
            error:function(error){
                $('#LoaderDiv').hide();
            }

        });
    });

    function statuschange(ticket_id,status){
		$.ajax({
            url: "{{ url('customer-support/statuschange')}}",
            type:"POST",
            data:{'ticket_id':ticket_id,'status':status},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () { $('#LoaderDiv').show(); },
            success:function(response){
                $('#LoaderDiv').hide();
                if(response.status){
                    toastr.success(response.Msg);
                    $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr)
            {
                $('#LoaderDiv').hide();
                $('.removedata').html('')
                $.each(xhr.responseJSON.errors, function(key,value) {
                    $('#error_'+key).append('<strong class="errors" style="color:red">*'+value+'</strong>');
                });
            },
        });
    }
</script>
@include('layouts.customdatatable');
@endsection
