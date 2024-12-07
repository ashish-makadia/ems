@extends('layouts.app')
@section('subheader','Customer')
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
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
                Customer Support
				</h3>
			</div>
		</div>
	</div>
    <div class="spinnermodal" id="LoaderDiv" style="display:none;z-index: 10001">
        <div style="position: fixed; z-index: 10001; top: 50%; left: 50%; height:50px">
            <img src="{{asset('images/loader.gif')}}" alt="Loading..." />
          </div>
      </div>
	<div class="m-portlet__body">
        <p><b> Company: </b> {{ $customerSup->company }} </p>
        <p><b> Subject: </b> {{ $customerSup->subject }} </p>
        <p><b> Priority: </b>{{ $customerSup->priority }} </p>
        <p><b> Website: </b> {{ $customerSup->website }} </p>
        <p><b> Description: </b> {{ $customerSup->Description }} </p>
        <p><b> Fullname: </b>{{ $customerSup->first_name." ".$customerSup->last_name }} </p><br/>
         @if($customerSup->file && !empty($customerSup->file))
         <p><b> View Upload:</b>
            <div class="float-end">
                <a class="btn btn-primary btn-sm mt-2 mb-2 mr-1" target="_blank" href="{{ asset("storage/support/".$customerSup->file) }}"><i class="fa fa-eye"></i> View Attachment  </a>
            </div></p></b>
            @endif

            @if($customerSup->status == 1)
                @php $clss="badge badge-dark" @endphp
            @elseif($customerSup->status == 2)
                @php $clss="badge badge-warning" @endphp
            @elseif($customerSup->status == 3)
                @php $clss="badge badge-danger" @endphp
            @elseif($customerSup->status == 4)
                @php $clss="badge badge-primary" @endphp
            @elseif($customerSup->status== 5)
                @php $clss="badge badge-info" @endphp
            @elseif($customerSup->status == 6)
                @php $clss="badge badge-success" @endphp
            @endif

            <form action="{{ url("customer-support/statuschange")}}" id="changeStatusForm" method="POST">
                @csrf
                <div class="row form-group">
                  <label class="col-md-2"><b>Status : </b> <span class="{{$clss}} p-2">{{ $customerSup->status_name }}</span></label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2"><b>Delivery Date : </b></label>
                    <input type="text" class="form-control datepicker" value="{{ @$customerSup->delivery_date!=""?date('d-m-Y',strtotime(@$customerSup->delivery_date)):date('d-m-Y') }}"
                        name="delivery_date" id="delivery_date">
                </div>

            </form>

	</div>
</div>


@endsection

@section('footer_scripts')
@push('scripts')
    <script type="text/javascript">


        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
    $('.datepicker').on('change', function(e) {
        var status = "{{$customerSup->status}}";
        var ticket_id = "{{$customerSup->ticket_id}}";
        $.ajax({
            url: "{{ url("customer-support/statuschange")}}",
            type: "POST",
            dataType: "json",
            data :{"delivery_date":$(this).val(),"ticket_id":ticket_id,"status":status},

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () { $('#LoaderDiv').show(); },
            success: function(response) {
                if(response.status){
                    window.location.href = '{{ route("customer-support.index") }}';
                    // location.reload();
                } else {
                    toastr.error(response.message);
                }
                $('#LoaderDiv').hide();
            },

        });
    });

    $(document).ready(function() {
    $('#LoaderDiv').fadeOut(3000);
});
    </script>
@endpush
