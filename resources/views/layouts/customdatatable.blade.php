
<script type="text/javascript">
    $(document).ready(function() {
  // jQuery.validator.addMethod("phoneUS", function (phoneno, element) {
    //phoneno = phoneno.replace(/\s+/g, "");
   // return this.optional(element) || phoneno && phoneno.match(/^[\d]{2,4}[- ]?[\d]{3}[- ]?[\d]|([0])?(\+\d{1,2}[- ]?)?[0]{1}\d$/);
   // }, "Please Enter a valid phone number with minimum 6 digits.");
        $("#cruise_type_form").validate({

           ignore: [],
           debug: false,
              rules: {
                type_name: "required",


              },
               messages: {
                type_name: "The name field is required.",
                }

            });
});

    // delete with ajax
	$(document).on('click','.deletebtn',function()
    {
        var id = this.id;
        //alert("{{$breadcrumb[0]['url']}}/"+id);
		swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "{{__('messages.you_wont_be_able_to_revert_this')}}",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "{{__('messages.yes_delete_it')}}",
            cancelButtonText: "{{__('messages.no_cancel')}}",
            reverseButtons: !0
        }).then(function (e) {
			if(e.value)
			{
				$.ajax({
					type:'DELETE',
					url:  "{{$breadcrumb[0]['url']}}/"+id,
					data: {
					"_token": "{{ csrf_token() }}",
					"id": id
					},
					success:function(data)
					{
						if(data.status==1)
						{
							boostrapNotify("Data deleted successfull.",'Well done','la la-check','success');
							$("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
						}else if(data.status==0)
						{
							boostrapNotify(data.msg,'Oops','la la-times','danger');
						}
					},
					error: function (xhr)
					{
						boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
					},
				});
			}/*else{
				boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
			}*/

        })
    })

    function deleteData(id,datatable){
        swal({
            title: "{{__('messages.are_you_sure')}}",
            text: "{{__('messages.you_wont_be_able_to_revert_this')}}",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "{{__('messages.yes_delete_it')}}",
            cancelButtonText: "{{__('messages.no_cancel')}}",
            reverseButtons: !0
        }).then(function (e) {
			if(e.value)
			{
				$.ajax({
					type:'DELETE',
					url:  "{{$breadcrumb[0]['url']}}/"+id,
					data: {
					"_token": "{{ csrf_token() }}",
					"id": id
					},
					success:function(data)
					{
						if(data.status==1)
						{
							boostrapNotify("Data deleted successfull.",'Well done','la la-check','success');
							$("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();

						}else if(data.status==0)
						{
							boostrapNotify(data.msg,'Oops','la la-times','danger');

						}
					},
					error: function (xhr)
					{
						boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
					},
				});
			}/*else{
				boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
			}*/

        })
    }
    function resetData(id,datatable){
        swal({
            title: "{{__('messages.are_you_sure')}}",
           // text: "",
            html: '<h5>You Want to Reset Password ?</h5></br><h6 style="color:red;">User Password Will be (User@1234)</h6>',
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes Reset It",
            cancelButtonText: "{{__('messages.no_cancel')}}",
            reverseButtons: !0
        }).then(function (e) {
			if(e.value)
			{
				$.ajax({
					type:'GET',
					url:  "{{$breadcrumb[0]['url']}}/resetpassword/"+id,
					data: {
					"_token": "{{ csrf_token() }}",
					"id": id
					},
					success:function(data)
					{
						if(data.status==1)
						{
							boostrapNotify("Password Reset successfull.",'Well done','la la-check','success');
							$("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();

						}else if(data.status==0)
						{
							boostrapNotify(data.msg,'Oops','la la-times','danger');

						}
					},
					error: function (xhr)
					{
						boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
					},
				});
			}/*else{
				boostrapNotify("Data not deleted.",'Oops','la la-times','danger');
			}*/

        })
    }
    $(document).on('change','#repeated_id',function(){
        var id = $(this).val();
        //console.log(id);
        //alert('hii');
        if (id == 3) {
            $('#Weekly_days').show();
        }else{
            $('#Weekly_days').hide();
        }
         if (id == 4) {
            $('#multi_days').show();
        }else{

            $('#multi_days').hide();
        }
    });
    // delete image with ajax
	$(document).on('click','.deletebtnimg',function()
    {
        var _this = this;
		var id = this.id;
		var dataurl = $(this).attr('dataurl');
		var type = $(this).attr('btntype');
        swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
            }).then(function (e) {
                if(e.value)
                {
                    $.ajax({
                        type:'get',
                        url:  dataurl+"/"+id+'/'+type,
                        data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                        },
                        success:function(data)
                        {
                            if(data.status==1)
                            {
                                boostrapNotify(data.msg,'Well done','la la-check','success');
                                $(_this).parent().parent().remove()
                            }
                            else
                            {
                                boostrapNotify(data.msg,'Oops','la la-times','danger');
                            }
                        },
                        error: function (xhr)
                        {
                            boostrapNotify(data.msg,'Oops','la la-times','danger');
                        },
                    });
                }else{
                    boostrapNotify(data.msg,'Oops','la la-times','danger');
                }

        })
    })

	// edit with ajax
	$(document).on('click','.editclick',function()
    {
        openNewModal('{{$breadcrumb[0]["editname"]}}','{{$breadcrumb[0]["url"]}}/'+this.id.split('_')[2]+'/edit');
    })
    $(document).on('click','.cruiseeditclick',function()
    {
        openNewModal('Edit CruiseType','{{$breadcrumb[0]["url"]}}/'+this.id.split('_')[2]+'/edit');
    })

	// save and update with ajax
	function saveModalFrm(frm)
    {
        for (instance in CKEDITOR.instances)
        {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(frm);
        $.ajax({
            type:$(frm).attr('method'),
            url: $(frm).attr('action'),
            data:formData,
            cache:false,
            dataType:'json',
            contentType: false,
            processData: false,
            success:function(data){
                if(data.status==1)
                {
                    $(modal).find('.close').click();
					boostrapNotify(data.msg,'Well done','la la-check','success');
                    $("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
                }
                else
                {
					boostrapNotify(data.msg,'Oops','la la-times','danger');
                }
            },
            error: function (xhr)
            {
                $('.removedata').html('')
                $.each(xhr.responseJSON.errors, function(key,value) {
                    $('#error_'+key).append('<strong class="errors" style="color:red">*'+value+'</strong>');
                });
            },
        });
        return false;
    }

	// open modal with ajax
	var modal = $('.{{$breadcrumb[0]['name']}}');
    var modal_body = modal.find('.modal-body');
    var modal_title = modal.find('.modal-title');
    function openNewModal(title,link)
    {
        modal_body.html('');
        modal_title.html(title);
        $.ajax({
            'url':link,
            'dataType':'json',
            success:function(result)
            {
                modal_body.html(result.view);
                $(modal).modal();
                var hidden_id = $("#hidden_id").val();
                if(hidden_id == ""){
                    $('#repeated_id').val('4');
                    $('#multi_days').show();
                }
            }
        })

    }

    // status change code
    function changestatus(id)
	{
		$.ajax({
            url: "{{url($breadcrumb[0]['url'].'/statuschange')}}/"+id,
            success:function(data){
                if(data.status==1)
                {
					$("#{{$breadcrumb[0]['name']}}").DataTable().ajax.reload();
                    boostrapNotify(data.msg,'Well done','la la-check','success');

                }
                else
                {
					boostrapNotify(data.msg,'Oops','la la-times','danger');
                }
            },
            error: function (xhr)
            {
                $('.removedata').html('')
                $.each(xhr.responseJSON.errors, function(key,value) {
                    $('#error_'+key).append('<strong class="errors" style="color:red">*'+value+'</strong>');
                });
            },
        });
	}

    // image url set
	function readURL(input)
    {

    var validExtensions = ['jpg','png','jpeg']; //array of valid extensions

    if(input.files[0] == undefined){
        $('#output').attr('src', '');
        return false;
    }
    var fileName = input.files[0].name;

    //console.log(fileName);
    var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            if ($.inArray(fileNameExt, validExtensions) == -1) {
                input.type = ''
                input.type = 'file'
            $('#output').attr('src',"");
            alert("Only these file types are accepted : "+validExtensions.join(', '));
            }
            else if (input.files && input.files[0])
            {
                var reader = new FileReader();

                reader.onload = function(e) {
             $('#output').attr('src', e.target.result);
            }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
    }

	// set multiple image
	$(document).on('change','#image_gallery',function()
	{
        $('.photogallery').html('');
		var input = this;
		var placeToInsertImagePreview = "div.photogallery";
		if(input.files)
			{
			var filesAmount = input.files.length;
			for (i = 0; i < filesAmount; i++) {
				var reader = new FileReader();
				reader.onload = function(event) {
				$($.parseHTML('<img>')).attr('src',event.target.result).appendTo(placeToInsertImagePreview).addClass('gallery_main_img').after(" ");
				}
				reader.readAsDataURL(input.files[i]);
			}
		}
	});

function cruiseTypeURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#type_output').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}




</script>
