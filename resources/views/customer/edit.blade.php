@extends('layouts.app')
@section('subheader','Customer')
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
	</div>
	<div class="m-portlet__body">
        <form id="customerForm" action="{{ route("customer.update", ['customer' => $customer->id]) }}" method="POST" class="userForm" enctype="multipart/form-data">
            
            @include('customer.form')
             @method('patch')
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                        <button type="submit" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>


@endsection

@section('footer_scripts')
@push('scripts')
    <script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor2',
    {
        on:
       {
           'instanceReady': function(evt) {
               evt.editor.document.on('keyup', function() {
                   document.getElementById('editor2').value = evt.editor.getData();
               });

              evt.editor.document.on('paste', function() {
                  document.getElementById('editor2').value = evt.editor.getData();
               });
           }
       }
    });
    });
        $('#customerForm').on('submit', function(e) {
        e.preventDefault();
         $('.error_label').text('');
        var frm = $('#customerForm');
        var fd = new FormData(frm[0]);
        url = $(this).attr('action');
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: fd,
            success: function(response) {
                if(response.status){
                    window.location.href = '{{ route("customer.index") }}';
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
    </script>
@endpush
