var csrf_token = $('meta[name="csrf-token"]').prop('content');
$("#product_category").select2();
$("#subcategory").select2();
$("#agent_id").select2({ placeholder: "--agents--"});
$("#agent_email").select2({ placeholder: "--email--"});
$("#s_agent_region").select2({ placeholder: "--region--"});
$("#s_agent_province").select2({ placeholder: "--province--"});
$("#s_agent_municipality").select2({ placeholder: "--municipality--"});

$(document).on('change','.mail_attachment_file',function(e){
    e.preventDefault();
    var orderID = $(this).parents().find('.hidden_order_id').val();
    var id = $(".hidden_user_id").val();
    var file_data = $('#mail_attachment_file').prop('files')[0];
    var formData = new FormData();
    formData.append('file', file_data);
    formData.append('orderID', orderID);
    $.ajax({
        type:'POST',
        headers:{'X-CSRF-Token' : csrf_token },
        url: site_url + 'agents/add_attachment_file',
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            $(".hidden_file_url").val(data);
            //alert('File has been uploaded successfully');
            console.log("success");
        },
        error: function(data){
            //console.log(data);
            console.log("error");
        }
    });
});

$(document).on("click",".Send-agent-mail", function (e){
    var id = $(this).attr('id');
    $(".hidden_user_id").val(id);
    $("#m_modal_agent_mail").modal('show');
});
$(document).on('change','#mail_attachment_status',function(){
    if($("#mail_attachment_status").is(':checked') == true){
        $("#Check_fileupload").show();
    }else{
        $("#Check_fileupload").hide();
    }
});

$(document).on('click','.save_agent_email',function(){
    searchIDs = $('#agents input[name="id[]"]:checked').map(function(){
            return $(this).val();   
        }).get();
    var id =  $(".hidden_user_id").val();
    if($("#mail_attachment_status").is(':checked') == true){
        var checkedbox = "1";
    }else{
        var checkedbox = "0";
    }
    var pdf_url = $(".mail_attachment_file").parents().find('.hidden_file_url').val();
    var message_content = CKEDITOR.instances.m_message_content.getData();
    $.ajax({
        type: "POST",
        url: site_url + 'agents/send_mail_confirmation',
        data: { _token: csrf_token,id:id,pdf_url:pdf_url,multiple_id:searchIDs,checkedbox:checkedbox,message_content:message_content},
        success: function(response) {
            $("#m_modal_agent_mail").modal('hide');
            boostrapNotify(response.data, 'Well done', 'la la-check', 'success');
        },
    });

});

$(document).on('click','.detail_sent_amail', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        url: site_url+'agents/getmaildetails',
        data: {
            id: id,
            _token: csrf_token,
        },
        success: function(data) {
            $(".email_listing").html(data.result);
            $("#m_modal_detailmail").modal();
        },
    });
});
jQuery(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    if (typeof success_message !== 'undefined') {
        boostrapNotify(success_message, 'Well done', 'la la-check', 'success');
    }
    if (typeof error_message !== 'undefined') {
        boostrapNotify(error_message, 'Oops', 'la la-times', 'danger');
    }
    if (typeof info_message !== 'undefined') {
        boostrapNotify(info_message, 'Information', 'la la-info', 'info');
    }

    if ($('#role-form').length) {

        $('#role-form').validate();
    }
    if ($('#permission-form').length) {
        $('#permission-form').validate();
    }
    if ($('#addform').length) {
        $('#addform').validate();
    }

});

//language translator
$(document).on('change','#langauge_locale',function(){
    var lang = $(this).val();
    window.location.href = site_url+'user/changelocale/'+lang+'';
});

$(document).ready(function(){
    $(document).on("blur",".dynamic_input",function(){
        var new_row_value = $(this).val(); 
        var data_name = $(this).data("name");
        var id = $(this).data("id"); 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: site_url+'agents/update_inline_data',
            data: { _token: csrf_token, data_name : data_name, data_value : new_row_value , agent_id : id},
            success: function(data) {
                if(new_row_value){
                  $("."+data_name+"_"+id+"").text(new_row_value);
                    boostrapNotify('Agent details updated successfully !!','Well done','la la-check','success');
                }
            },
        });
    });
});

$(document).on("click",".get_mapInfo",function(){
    var id = $(this).attr("data-id"); 
    $.ajax({
        type: "POST",
       
        url: site_url+'agents/get_mp_info',
        data: { _token: csrf_token, id : id},
        success: function(data) {
            $("#m_modal_details").modal('show');
            $(".map_data").html(data);
        },
    });
});

$(document).on('click','.change_inline_edit_status', function () {
    //alert($(this).val());
    var status = $(this).val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+'agents/update_status',
        data: {
            id: $(this).data('id'),
            status: $(this).prop('checked'),
            _token: csrf_token,
        },
        success: function(response) {
            if(response.status){
                if(response.state=="1"){
                    boostrapNotify('Inline Edit Activated Successfully','Well done','la la-check','success');
                    setTimeout(function(){ window.location.reload(); }, 500);
                }else{
                    boostrapNotify('Inline Edit Deactivated!! !!','Well done','la la-check','warning');
                    setTimeout(function(){ window.location.reload(); }, 500);
                }
                
            }else{
                boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
            }
        },
        error: function(result) {
            boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
        }
    });
}); 
$(document).on('click','.submit_inline_data',function(){
    var formData = new FormData($("#agentsinline_form")[0]);
    var id = $(this).attr('data-id');
    formData.append("id", id);
    $.ajax({
        type: "POST",
        headers:{'X-CSRF-Token' : csrf_token },
        url: site_url+'agents/save_inline_data',
        //data: form+'&_token={{csrf_token()}}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            if(data){
                $("#update_Inlineedit").modal('hide');
                $("#restaurants").DataTable().ajax.reload();
                boostrapNotify('Inline edit change successfully!','Well done','la la-check','success');
            }else{
                boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
            }
        },
        error: function(response) {
            $('#error_company').text(response.responseJSON.errors.company_name);
            $('#error_mobile').text(response.responseJSON.errors.mobile);
            $('#error_email').text(response.responseJSON.errors.email);
            $('#error_coupon').text(response.responseJSON.errors.reseller_coupon_code);
            $('#error_commission').text(response.responseJSON.errors.reselling_per);
            $('#error_discount').text(response.responseJSON.errors.discount);
        },
    });
});
$(document).on('click','.submit_map_data',function(){
    var formData = new FormData($("#map_agent_form")[0]);
    var id = $(this).attr('data-id');
    var type = "map_form";
    formData.append("id", id);
    formData.append("type", type);
    $.ajax({
        type: "POST",
        headers:{'X-CSRF-Token' : csrf_token },
        url: site_url+'agents/save_inline_data',
        //data: form+'&_token={{csrf_token()}}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            if(data){
                $("#m_modal_details").modal('hide');
                $("#restaurants").DataTable().ajax.reload();
                boostrapNotify('Inline edit change successfully!','Well done','la la-check','success');
            }else{
                boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
            }
        },
        error: function(response) {
            $('#error_meeting_point').text(response.responseJSON.errors.meeting_point);
            $('#error_lat').text(response.responseJSON.errors.lat);
            $('#error_long').text(response.responseJSON.errors.long);
            $('#error_region').text(response.responseJSON.errors.region);
            $('#error_province').text(response.responseJSON.errors.province);
            $('#error_country').text(response.responseJSON.errors.country);
            $('#error_municipality').text(response.responseJSON.errors.municipality);
        },
    });
});

$(document).on('click','.submit_order_data',function(){
    var formData = new FormData($("#agent_modl_form")[0]);
    var id = $(this).attr('data-id');
    formData.append("id", id);
    $.ajax({
        type: "POST",
        headers:{'X-CSRF-Token' : csrf_token },
        url: site_url+'orderbooking/save_assign_agent',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            if(data){
                $("#m_agnt_details").modal('hide');
                $("#orderbooking").DataTable().ajax.reload();
                boostrapNotify('Save data successfully!','Well done','la la-check','success');
            }else{
                boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
            }
        },
    });
});

$(document).on('click','.get-agents-details',function(){
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: site_url+'orderbooking/get_order_details',
            data: {
                _token: csrf_token,
                id: id,
            },
            success: function(data) {
                $(".booking_modal_data").html(data);
                $("#m_modal_details").modal('show');
            },
        });
    });

$(document).on('click','.company_id',function(){
    var id = $(this).attr("data-id"); 
    $.ajax({
        type: "POST",
        url: site_url+'orderbooking/assign_agent',
        data: { _token: csrf_token, id : id},
        success: function(data) {
            $("#m_agnt_details").modal('show');
            $(".agent_data").html(data);
        },
    });
});
$(document).on('click','.delete_booking_code',function(){
    var delete_url = $(this).data("url");
    var delete_row = $(this).parents('tr');
    var $this = $(this);
    swal({
        title: "Are you sure you want to perform this action?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-danger",
        confirmButtonText: 'Yes, Delete it.',
        cancelButtonText: 'No, Cancel it.',
        showLoaderOnConfirm: true,
        closeOnConfirm: false,
        }).then(function(e) {
        if (e.value) {
            $.ajax({
                url: delete_url,
                type: "DELETE",
                dataType: "json",
                data: {
                    //id: id,
                    _token: csrf_token,
                },
                success: function(response) {
                    if(response.status){
                        delete_row.css('background','tomato');
                        delete_row.fadeOut(1000,function(){
                            delete_row.remove();
                            boostrapNotify("Booking Deleted Successfully", 'Well done', 'la la-check', 'success');
                        });
                    }else{
                        boostrapNotify("Booking Deleted Successfully", 'Well done', 'la la-check', 'success');
                    }
                },
            });
        } else {            
            return false;
        }
    });
    return false;
});
$(document).on('click','.export_excel_agent',function(){
    var agent_id = $("#agent_id").val();
    var region = $("#s_agent_region").val();
    //var cruise_date = $("#cruise_date").val();
    var from_date = $("#search_fromdate").val();
    var to_date = $("#search_todate").val();
    var province = $("#s_agent_province").val();
    var municipality = $("#s_agent_municipality").val();
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: site_url + 'agents/export_xls',
        type: 'POST',
        data: {_token: csrf_token , region:region , agent_id:agent_id , province:province ,municipality : municipality , from_date:from_date , to_date:to_date ,type:'normal',id:'All'},
        success: function(result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'agents.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
    });
});
$(document).on('click','.export-row',function(e){
    var agent_id = $("#agent_id").val();
    var region = $("#s_agent_region").val();
    //var cruise_date = $("#cruise_date").val();
    var from_date = $("#search_fromdate").val();
    var to_date = $("#search_todate").val();
    var province = $("#s_agent_province").val();
    var municipality = $("#s_agent_municipality").val();
    var id = $(this).data('id');
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: site_url + 'agents/export_xls',
        type: 'POST',
        data: {_token: csrf_token , region:region , agent_id:agent_id , province:province ,municipality : municipality , from_date:from_date , to_date:to_date , type:'row_wise',id:id},
        success: function(result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'agents.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
    });
});
$(document).on('click','.order_details_editor',function(e){
    var id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: site_url+'orderbooking/detail_editor',
        data: { _token: csrf_token, id : id},
        success: function(data) {
            $("#m_agnt_editor").modal('show');
            $(".Order_data").html(data);
        },
    });
});
$(document).on('click','.send_order_mail',function(e){
    var id = $(this).data('id');
    var data = CKEDITOR.instances['m_message_content'].getData();
    $.ajax({
        type: "POST",
        url: site_url+'orderbooking/orderMail',
        data: { _token: csrf_token, id : id,data : data},
        success: function(data) {
            $('#m_agnt_editor').modal('hide');
            boostrapNotify("Sent Mail Successfully !", 'Well done', 'la la-check', 'success');
        },
    });
});
$(document).on('click','.export_order_booking',function(e){
    var agent_id = $("#agent_id").val();
    var from_date = $("#search_fromdate").val();
    var to_date = $("#search_todate").val();
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: site_url + 'orderbooking/export_xls',
        type: 'POST',
        data: {_token: csrf_token , agent_id:agent_id , from_date:from_date, to_date:to_date},
        success: function(result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'orderbooking.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
    });
});

$(document).on("click",".import_button",function(){
    var formData = new FormData($("#importform")[0]);
    $('#loader_img').show();
    $.ajax({
        type: "POST",
        headers:{'X-CSRF-Token' : csrf_token },
        url: site_url + 'import/orders',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(res) {
            if(res.status == true){
                $('#loader_img').hide();
                boostrapNotify('Imported data successfully!','Well done','la la-check','success');
            } else if(res.status == false) {
                $('#loader_img').hide();
                boostrapNotify('Data import failed !!','Oops','la la-times','danger');
            } else {
                $('#loader_img').hide();
                boostrapNotify('something went to wrong !!','Oops','la la-times','danger');
            }
        },
        error: function(response) {
            $('#loader_img').hide();
            $('#error_import_file').text(response.responseJSON.errors.file[0]).fadeIn().delay(2000).fadeOut();
        },
    });
});
function boostrapNotify(message, title, icon, type) {
    if ($('[data-notify="container"]').length) {
        $('[data-notify="container"]').remove();
    }
    var e = { message: message, title: title + ' !!!', icon: "icon " + icon };
    $.notify(e, {
        type: type,
        allow_dismiss: !0,
        showProgressbar: !1,
        spacing: 10,
        timer: 2000,
        placement: {
            from: 'top',
            align: 'right'
        },
        offset: {
            x: '30',
            y: '30'
        },
        animate: {
            enter: "animated bounceInDown",
            exit: "animated bounceOutUp"
        }
    });
}