jQuery(document).ready(function() {
	
    $('#example').DataTable( {
        //"pagingType": "full_numbers"
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5
    });
    $('#photo_order_table').DataTable( {
        //"pagingType": "full_numbers"
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5,
        //"scrollX": true
    });
    $('#fund_order_table').DataTable( {
        //"pagingType": "full_numbers"
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5
    });

    // var fundTable = $('#fund_order_table').DataTable({
    //     "bProcessing": true,
    //        "serverSide": true,
    //        "language": {
    //             'search': '_INPUT_',
    //              'searchPlaceholder': 'Search'
    //            },
    //        "ajax":{
    //           url :'getSentPhotosListing',
    //           type: "post",
    //           data :  function(d){
    //             // d['client_id'] = $('#clientlist').val();
    //             // return d;
    //           },
    //           error: function(){  // error handling code
    //             $("#fund_order_table").css("display","none");
    //           }
    //         },            
    // });

    $(document).on('click','.preview_photos', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url : Base_URL+'getImagesFromId',
            type : 'POST',
            data : {id : id},
            success : function(res){
                $.fancybox.open($.parseJSON(res));
                $('.fancybox-overlay').css('z-index','9999');
            }           
        });
    });

    $.validator.addMethod("validEmail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
    }, "Email Address is invalid: Please enter a valid email address.");

	$.validator.setDefaults({ ignore: ":hidden:not(select)" })

	$('#updateProfile').validate({
        rules : {
            first_name : {
                required : true,
                maxlength : 30
            },
            middle_name : {
                required : true,
                maxlength : 30,
                minlength : 3
            },
            last_name : {
                required : true,
                lettersonly: true,
                maxlength : 30
            },
            postcode : {
                // digits: true,
                minlength: 5,
                maxlength: 8
            },
            mobile : {
                required: true,
                minlength: 10,
                maxlength: 15
            },
            country : {
                required: true,
            },
            user_email : {
                required: true,
                validEmail: true
            }
        },
        messages :{
            first_name : {
                required : "First Name required"
            },
            last_name : {
                required : "Last Name required"
            },
            postcode : {
                required: "Zip code is required",
                digits: "This field can only contain numbers",
                minlength: "This field must contain 5 characters",
                maxlength: "This field contain only 5 characters"
            },
            mobile : {
                required : "Please enter phone number",
                digits : "This field can only contain numbers",
                maxlength : "This field required not more than 15 characters",
                minlength : "This field required atleast 10 charactes"
            },
            country : {
                required: "Please enter you country",
            },
            user_email : {
                required : "Email is required",
                validEmail : "Please enter a valid email address"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                extraClass = '';
                if($element.is('#accept')) extraClass = 'radio_error';
                var errortext = "<div class=\'error_box "+extraClass+"\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
                }
                $element.closest('.input-group').append(errortext);
            });
        }
    });

    $('#updateProfile').ajaxForm({
        beforeSubmit : validateUpdate,
        success :  validateUpdate_res
    });

    function validateUpdate(){
        return $('#updateProfile').valid();
    }
      
    function validateUpdate_res(res){
       if(res){
           // var parse = $.parseJSON(res);
           // var status = parse.status;
           // var message = parse.message;
           // if(status){
              $('.form-res').css({'background-color':'#07c145','display':'inline'}).html("Profile updated successfully").delay(3000).fadeOut("slow");
           }else{
              $('.form-res').css({'background-color':'#ea1e1e','color':'#E7080F'}).html("Some error occured").delay(3000).fadeOut("slow");
           }
       }
    //}

    $('#addInmatesForm').validate({
        ignore : ":hidden:not(select)",
        rules : {
            name : {
                required : true,
                minlength: 3,
                maxlength: 30
            },
            bookingId : {
                required : true,
                maxlength: 15
            },
            c_bookingId : {
                required : true,
                equalTo: '#bookingId',
                maxlength: 15
            },
            facility : {
                required: true
            }
        },
        messages :{
            name : {
                required : "Please Enter Name"
            },
            bookingId : {
                required : "Please Enter Booking number"
            },
            c_bookingId : {
                required: "Please Enter Booking no. to confirm",
                equalTo: "Booking ID must be same"
            },
            facility : {
                required : "Plase select facility",
                facilityValue : "Please Select Facility"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
                }
                $element.closest('.input-group').append(errortext);
            });
        }
    });

    $('#addInmatesForm').ajaxForm({
        beforeSubmit : validateInmates,
        success :  validateInmates_res
    });

    function validateInmates(){
        return $('#addInmatesForm').valid();
    }
      
    function validateInmates_res(res){
       if(res){
           var parse = $.parseJSON(res);
           var status = parse.status;
           var message = parse.message;
           if(status == true){
              $('.form-res').css({'background-color':'#07c145','display':'inline'}).text(message).delay(3000).fadeOut("slow");
              $('#addInmatesForm')[0].reset();
              $('.chosen-single span').html('Select Facility');
              $('.chosen-select option').prop('selected', false).trigger('chosen:updated');
              window.location.reload(true);
           }else{
              $('.form-res').css({'background-color':'#ea1e1e','color':'#E7080F'}).text(message).delay(3000).fadeOut("slow");
           }
       }
    }    

    $('#delete_form').ajaxForm({
        success :  deleteInmates_res
    });
      
    function deleteInmates_res(res){
       if(res){
           var parse = $.parseJSON(res);
           var status = parse.status;
           var message = parse.message;
           if(status == true){
              $('.form-res').css({'background-color':'#07c145','display':'inline'}).text(message).delay(3000).fadeOut("slow");
              $.fancybox.close();
           }else{
              $('.form-res').css({'background-color':'#ea1e1e','color':'#E7080F'}).text(message).delay(3000).fadeOut("slow");
              $.fancybox.close();
           }
       }
    }

    $('#changePassForm').validate({
        rules : {
            current_pass : {
                required : true
            },
            new_pass : {
                required : true,
                minlength: 8,
                checkPass: true
            },
            c_pass : {
                required : true,
                equalTo: '#new_pass'
            }
        },
        messages :{
            current_pass : {
                required : "Enter Your Current Password"
            },
            new_pass : {
                required : "Enter New Password",
                minlength : "Password must contain 8 characters",
                checkPass : "It must contain a lowercase letter & a digit"
            },
            c_pass : {
                required: "Enter Password to confirm",
                equalTo: "This field must be same as new password"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
                }
                $element.closest('.input-group').append(errortext);
            });
        }
    });

    $('#changePassForm').ajaxForm({
        beforeSubmit : validateChangePass,
        success :  validateChangePass_res
    });

    function validateChangePass(){
        return $('#changePassForm').valid();
    }
      
    function validateChangePass_res(res){
       if(res){
           var parse = $.parseJSON(res);
           var status = parse.status;
           var message = parse.message;
           if(status == true){
              $('#changePassForm')[0].reset();
              $('.form-res').css({'background-color':'#07c145','display':'inline'}).text(message).delay(3000).fadeOut("slow");
           }else{
              $('.form-res').css({'background-color':'#ea1e1e','display':'inline'}).text(message).delay(3000).fadeOut("slow");
           }
       }
    }

    $('#sendFundForm').validate({
        rules : {
            facility : {
                required : true,
                valueNotEquals : 0
            },
            name : {
                required : true,
                valueNotEquals : 0
            },
            bookingNo : {
                required : true
            },
            amount : {
                number: true
            },
            accept : {
                required : true
            },
            pay_method : {
                required : true
            }
        },
        messages :{
            facility : {
                required : "Please Select Facility",
                valueNotEquals : "Please Select Facility"
            },
            name : {
                required : "Please Select Inmate Name",
                valueNotEquals : "Please Select Inmate Name"
            },
            bookingNo : {
                required: "Enter Inmate Booking Id"
            },
            amount : {
                number : "Please enter valid value"
            },
            accept : {
                required : "Please accept terms and conditions"
            },
            pay_method : {
                required : "Please select payment options"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
                }
                $element.closest('.input-group').append(errortext);
            });
        }
    });

    $(document).on('click','.showDiv',function(){
    	var id = $(this).attr('id');
        showForm(id);
    });

    var ChosenOptionsForClient = {
	    placeholder_text_multiple: "Please Select Client",
	    no_results_text: "Oops, No result found!"
	};
  
    $('#facility').chosen(ChosenOptionsForClient).change(function(){
        $(this).valid();
    });
	
	$(".facilityList").chosen({
		display_selected_options: true,
	});
	$(".inmatesList").chosen({
		display_selected_options: true,
	});

    $(".country").chosen({
        display_selected_options: true,
    });
  
    $('.facilityList').chosen(ChosenOptionsForClient).change(function(){
        var val = $(this).val();
        if(val > 0){
            $.ajax({
                type : "post",
                url  : Base_URL+'getFacilityInmates',
                data : { 'id': c_user, 'facility':val, 'getamount': true},
                success : function(res){
                    var parse = $.parseJSON(res);
                    var status = parse.status;
                    var data = parse.resp;
                    $('.inmatesList').html('');
                    if(status){
                        var option = '<option value="0">SELECT INMATE</option>';
                        $('.inmatesList').append(option);
                        $.each(data,function(k,v){                            
                           $('.inmatesList').append(makeSelectOption(v));                            
                        });                        
                    }else{
                        var option = '<option value="0">NO INMATE ADD FOR THIS FACILITY</option>';
                        $('.inmatesList').append(option);
                    }
                    $('.inmatesList').trigger("chosen:updated");
                    if(parse.amount){
                        var amount_obj = parse.amount;
                        var amount = amount_obj[0].amount;
                        var fees = amount_obj[0].processing_fee;
                        var unit = amount_obj[0].fee_unit;
                        var split = amount.split('-');
                        var amount_min = parseInt(split[0].trim());
                        var amount_max = parseInt(split[1].trim()); 
                        var div = $('#price-data');
                        div.attr({'data-fee' : fees, 'data-unit' : unit});
                        
                        $('#amount').rules("add",{
                            required : true,
                            range : [amount_min, amount_max],
                            min : amount_min,
                            max : amount_max,
                            messages : {
                                required : "Enter Amount",
                                number : "Only numbers",
                                min : "Only $"+amount_min+' to $'+amount_max+' allowed',
                                max : "Only $"+amount_min+' to $'+amount_max+' allowed'
                            }
                        });                        
                    }
                }
            });
        }else{
            $('.inmatesList').html('');
            var option = '<option value="0">SELECT INMATE</option>';
            $('.inmatesList').append(option);
            $('.inmatesList').trigger("chosen:updated");
            $('#bookingNo').val('');
        }
        $(this).valid();
    });

    $('.inmatesList').chosen(ChosenOptionsForClient).change(function(){
        var val = $(this).val();
        if(val > 0){
            var option = $('option:selected', this).attr('data-id');
            $('#bookingNo').val(option);
            $('#bookingNo').valid();
        }else{
            $('#bookingNo').val('');
        }
        $(this).valid();
    });

});

$(document).ready(function(){
    $('#mobile').mask('(000) 000-0000');
});

function showForm(id){
    $('.slideDiv').hide();
    $('.form-res').html('');
    $('.error_box').remove();
    var checkForm = ['inmatesList','myAccount','sendPhotos','ordersList','fundList'];
    // console.log($.inArray(id,checkForm));
    if($.inArray(id,checkForm) == -1){
       $('#'+id+'Form')[0].reset();
    }
    // $('#'+id+'Div').animate({width:'toggle'});
    $('#'+id+'Div').show();
}

function makeSelectOption(val){
    var html =  '<option value="'+val.inmates_id+'" data-id="'+val.inmates_booking_no+'">'+val.inmates_name+' '+val.inmates_middle_name+' '+val.inmates_last_name+'</option>';
    return html;
}