$(document).ready(function(){

    $('#showFacilitylist').on('click',function(){
        form_data = pyro.filter.$filter_form.serialize();
        pyro.filter.do_filter(pyro.filter.f_module, form_data);
    });

    $('#addFacilityForm').validate({
         ignore:":hidden",
         rules : {
            name : {
              required : true
            },
            address : {
              required : true
            },
            postcode : {
                required : true,
                digits: true,
                minlength: 5,
                maxlength: 5
            },
            money_option : {
                required: true
            },
            photo_option : {
                required: true
            },
            photo_size : {
                required : true,
                number : true
            },
            photo_resolution : {
                required : true,
                resolutionFormat : true
            },
            no_of_photos : {
                required : true,
                number : true
            },
            photo_price : {
                required : true,
                mynumber : true
            },
            photo_shipping_price : {
                required : true,
                mynumber : true
            },
            processing_fee : {
                required : true,
                number : true
            },
            photo_email : {
                required : true,
                email : true
            }
         },
         messages :{
            name : {
                required : "Facility Name required"
            },
            address : {
                required : "Facility Address required"
            },
            postcode : {
                required: "Zip code is required",
                digits: "This field can only contain numbers",
                minlength: "This field must contain 5 characters",
                maxlength: "This field contain only 5 characters"
            },
            money_option : {
                required : "Please Select Money Option"
            },
            photo_option : {
                required : "Please Select Photo Option"
            },
            photo_size : {
                required : "Please Select photo size",
                number : "Only numbers allowed"
            },
            photo_resolution : {
                required : "Please Select resolution"
            },
            photo_price : {
                required : "Please enter photo price",
                number : "Only numbers allowed"
            },
            photo_shipping_price : {
                required : "Please enter shipping charge",
                number : "Only numbers allowed"
            },
            processing_fee : {
                required : "Please enter amount",
                number : "Only numbers allowed"
            },
            photo_email : {
                required : "Photo lab Email required",
                email : "Please enter valid Email"
            }
         },
         showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                extraClass = '';
                if($element.is('#accept')) extraClass = 'radio_error';
                var errortext = "<div class=\'error_box "+extraClass+"\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input').find('.error_box').length >= 1){
                   $element.closest('.input').find('.error_box').remove();
                }
                $element.closest('.input').append(errortext);
            });
         }
    });

    jQuery.validator.addMethod("resolutionFormat", function(value, element) {
      return this.optional(element) || /^(\d+x\d+)/.test(value);
    }, "Please use format like (e.g. 1024x768)");

    jQuery.validator.addMethod("mynumber", function (value, element) {
        return this.optional(element) || /\d+(\.\d{1,2})?/.test(value);
    }, "Please specify the correct number format");

    $('#addFacilityForm').ajaxForm({
      beforeSubmit : validateaddFacility,
      success :  validateaddFacility_res
    });

    function validateaddFacility(){
       return $('#addFacilityForm').valid();
    }
      
    function validateaddFacility_res(res){
      if(res){
          var refresh = $('input[name=id]').val();
          var parse = $.parseJSON(res);
          var status = parse.status;
          var message = parse.message;
          if(status){
              $('.form-res').css('color','#007b03').text(message);
              if(refresh != undefined){
                 setTimeout(window.location.href= BASE_URL+'admin/facility',3000);
              }else{
                 $('#addFacilityForm')[0].reset();                 
                 $('input:radio:first').trigger('click');
              }
          }else{
              $('.form-res').css('color','#E7080F').html(message);
          }
      }
    }
 
});

function getLocation(){
    var value = $('#postcode').val();
    if(value >= 5 && value.length >= 5){
        getAddressInfoByZip(value);   
    }else{
       $('#city').val('');
       $('#county').val('');
       $('#state').val('');
       $('#country').val('');
    }
} 

function getAddressInfoByZip(zip){
  if(zip.length >= 5 && typeof google != 'undefined'){
        var addr = {};
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': zip }, function(results, status){
            if (status == google.maps.GeocoderStatus.OK){
                if (results.length >= 1) {
                    for (var ii = 0; ii < results[0].address_components.length; ii++){
                        var street_number = route = street = city = state = zipcode = country = formatted_address = '';
                        var types = results[0].address_components[ii].types.join(",");
                        if (types == "street_number"){
                          addr.street_number = results[0].address_components[ii].long_name;
                        }
                        if (types == "route" || types == "point_of_interest,establishment"){
                          addr.route = results[0].address_components[ii].long_name;
                        }
                        if (types == "sublocality,political" || types == "locality,political" || types == "neighborhood,political" || types == "administrative_area_level_3,political"){
                          addr.city = (city == '' || types == "locality,political") ? results[0].address_components[ii].long_name : city;
                        }
                        if (types == "administrative_area_level_1,political"){
                          addr.state = results[0].address_components[ii].short_name;
                        }
                        if (types == "administrative_area_level_2,political"){
                          addr.county = results[0].address_components[ii].short_name;
                        }
                        if (types == "postal_code" || types == "postal_code_prefix,postal_code"){
                          addr.zipcode = results[0].address_components[ii].long_name;
                        }
                        if (types == "country,political"){
                          addr.country = results[0].address_components[ii].long_name;
                        }
                    }
                    addr.success = true;
                    response(addr);
                }else{
                  response({success:false});
                }
            } else {
                response({success:false});
            }
        });
  }else{
    response({success:false});
  }
}

function response(obj){
    if(obj.success){
        var city = obj.city;
        var county = obj.county;
        var state = obj.state;
        var country = obj.country;
        $('#city').val(city);
        $('#county').val(county);
        $('#state').val(state);
        $('#country').val(country);
    }else{
      return false;
    }
}

$(document).on('click','.switch',function(){
    var switchClass = $(this);
    var action = $(this).attr('data-value');
    var value = $(this).attr('data-id');
    var key = 'active';
    ajaxCall(value,action,key);
    switchToggle(switchClass);
});

$(document).on('click','.money_option',function(){
    var switchClass = $(this);
    var action = $(this).attr('data-value');
    var value = $(this).attr('data-id');
    var key = 'money_option';
    ajaxCall(value,action,key);
    switchYesNoToggle(switchClass);
});

$(document).on('click','.photo_option',function(){
    var switchClass = $(this);
    var action = $(this).attr('data-value');
    var value = $(this).attr('data-id');
    var key = 'photo_option';
    ajaxCall(value,action,key);
    switchYesNoToggle(switchClass);
});

function switchToggle(arg){
    //ele = arg.target || arg;
    var ele = $(arg).parent().parent();
    var eClass = ele.hasClass('on');
    if(eClass == true){
      $(arg).attr('data-value','1');
        ele.removeClass('on');
    }else{
      $(arg).attr('data-value','0');
        ele.addClass('on');
    }
}

function switchYesNoToggle(arg){
    //ele = arg.target || arg;
    var ele = $(arg).parent().parent();
    var eClass = ele.hasClass('on');
    if (eClass == true) {
      $(arg).attr('data-value','1');
        ele.removeClass('on');
    } else {
      $(arg).attr('data-value','0');
        ele.addClass('on');
    }
}

function ajaxCall(value,action,key){
  $.ajax({
    type : 'post',
    url  : BASE_URL+'admin/facility/updateFacilityTable',
    async : false,
    data : {'action':action,'id':value,'key':key}
  });
}