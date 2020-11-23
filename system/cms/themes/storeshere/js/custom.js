function heightforcontent(){
    var windowheght = $(window).height();
    var WebHeader = $('.webheader').height();
    //var MobileHeader = $('.mobileheader').height();
    var MenusContainer = $('.container.menus').height();

    var TotalHeight = windowheght - WebHeader - MenusContainer;
    //alert(WebHeader);
    $('#content').css('min-height', TotalHeight);
}

jQuery(window).resize(function() {
    heightforcontent();
});
jQuery(document).ready(function() {
    heightforcontent();
    $('.forget-pass').on('click', function(){
        $.fancybox({
            href : '#forget_box',
            autoDimensions : false,
            autoSize : false,
            width : 330,
            height : 'auto'
        });
    });

    if($('.post.clearfix').children().text() == 'Page missingWe cannot find the page you are looking for, please click here to go to the homepage.'){
        $('.post.clearfix').css({'width':'1170px','margin':'0 auto','padding-left':'10px'})
    }

    $.validator.addMethod("phoneUS", function (phone_number, element) {
        return true;
            // phone_number = phone_number.replace(/\s+/g, "");
            // return this.optional(element) || phone_number.length > 9 &&
            //       phone_number.match(/\(?[\d\s]{3}\)[\d\s]{3}-[\d\s]{4}$/);
        }, "Invalid phone number");

    $('.mobileheader .right li').click(function(){
        var tab_id = $(this).attr('data-tab');
        $(this).toggleClass('current').siblings().removeClass('current');
        $("#"+tab_id).toggleClass('current').siblings().removeClass('current');
    })

    $.validator.addMethod("validEmail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
    }, "Email Address is invalid: Please enter a valid email address.");

    $.validator.addMethod("checkPass", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /\d/.test(value) // has a digit
    });

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
      return arg != value;
  }, "Value must not equal arg.");

    $('#captcha').keyup(function(){
        $('#captcha').val($('#captcha').val().toLowerCase());
    })

    $('#register').validate({
        rules : {
            username : {
                required : true,
                maxlength: 30
            },
            first_name : {
            	required : true,
                maxlength: 30
            },
            last_name : {
            	required : true,
                maxlength: 30
            },
            middle_name : {
                minlength: 3,
                maxlength: 30,
                lettersonly: true
            },
            postcode : {
                // digits: true,
                minlength: 5,
                maxlength: 8
            },
            country : {
                required : true
            },
            mobile : {
                required : true,
                minlength: 10,
                maxlength: 15
            },
            office_phone : {
                digits: true
            },
            phone : {
                digits: true
            },
            con_mobile :{
                required: true,
                 // minlength: 8,
                 equalTo: '#mobile'
             }, 
             email : {
                required: true,
                validEmail: true
            },
            con_email :{
                required: true,
                 // minlength: 8,
                 equalTo: '#email'
             }, 
             password : {
                required : true,
                minlength : 8,
                checkPass : true
            },

            con_password :{
                required: true,
                 // minlength: 8,
                 equalTo: '#password12'
             }, 
             captcha : {
                required : true,
                equalTo : '#captcha_val'
            },
            accept : {
                required : true
            }
        },
        messages :{
            username : {
                required : "Username required"
            },
            first_name : {
                required : "First Name required"
            },
            last_name : {
                required : "Last Name required"
            },
            postcode : {
                // digits: "This field can only contain numbers",
                minlength: "Only 5 to 8 numbers allowed",
                maxlength: "This field contain only 8 characters"
            },
            country : {
                required : "Please enter you country"
            },
            mobile : {
                required : "Phone number is required",
            },
            office_phone : {
                digits : "Only numbers allowed"
            },
            phone : {
                digits : "Only numbers allowed"
            },
            email : {
                required : "Email is required",
                validEmail : "Please enter a valid email address"
            },
            password : {
                required : "Password is required",
                minlength : "Min. 8 char, lowercase letter & digit",
                checkPass : "Must contain a lowercase letter & a digit"
            },
            con_password : {
                required : "Enter password to confirm",
                equalTo : "Password must be same"
                // checkPass : "Must contain a lowercase letter & a digit"
            },
            con_mobile : {
                required : "Enter phone number to confirm",
                equalTo : "Phone number must be same"
                // checkPass : "Must contain a lowercase letter & a digit"
            },
            con_email : {
                required : "Enter email to confirm",
                equalTo : "Email must be same"
                // checkPass : "Must contain a lowercase letter & a digit"
            },
            captcha : {
                required : "Please Enter Captcha",
                equalTo :  "You entered wrong code"
            },
            accept : {
                required : "Please accept terms and conditions"
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

$('#country').change(function(){
    if($('#country').closest('.input-group').find('.error_box').length >= 1){
        $('#country').closest('.input-group').find('.error_box').remove();
    }
});

$('#signup').click(function(){
    var errortext = "<div class=\'error_box radio_error\'><p class=\'error_text\'>Please enter your country</p></div>";
    if($('#country').val() == ''){
        $('#country').closest('.input-group').append(errortext);
    }
});

    // $('#register').ajaxForm({
    //     beforeSubmit : validateRegistration,
    //     success :  validateRegistration_res
    // });

    $('#login').validate({
        rules : {
            username : {
                required: true
            },
            password : {
                required : true
            },
            postcode : {
                required: "Zip code is required",
                // digits: "This field can only contain numbers",
                minlength: "Only 5 to 8 numbers allowed",
                maxlength: "This field contain only 8 characters"
            },
            mobile : {
                digits : "Only numbers allowed"
            }

        },
        messages :{
            username : {
                required : "username is required"
            },
            password : {
                required : "Password is required"
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

    $('#login').ajaxForm({
        beforeSubmit : validateLogin,
        success :  validateLogin_res
    });

    $('#login2').validate({
        rules : {
            username : {
                required: true
            },
            password : {
                required : true
            }
        },
        messages :{
            username : {
                required : "Username is required"
            },
            password : {
                required : "Password is required"
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

    $('#login2').ajaxForm({
        beforeSubmit : validateLoginPage,
        success :  validateLoginPage_res
    });

    $('#mob-login').validate({
        rules : {
            username : {
                required: true
            },
            password : {
                required : true
            }
        },
        messages :{
            username : {
                required : "Username is required"
            },
            password : {
                required : "Password is required"
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

    $('#mob-login').ajaxForm({
        beforeSubmit : validateMoblogin,
        success :  validateMoblogin_res
    });
    

    $.validator.addMethod("eitherEmailPhone", function(value, element) {
        phone_number = value.replace(/\s+/g, ""); 
        isPhone =this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
        isEmail = this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
        return isPhone || isEmail;
    }, "Please enter either phone or Email");

    $('#forget_form').validate({
        rules : {
            email : {
                required: true,
                eitherEmailPhone:true
            }
        },
        // messages :{
        //     email : {
        //         required : "Email is required",
        //         //validEmail: "Please Enter Valid Email."
        //     }
        // },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.valid-error').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                var errortext = "<div class=\'error_box \'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.valid-error').find('.error_box').length >= 1){
                   $element.closest('.valid-error').find('.error_box').remove();
               }
               $element.closest('.valid-error').append(errortext);
           });
        }
    });

    $('#forget_form').ajaxForm({
        beforeSubmit : validateforgetPass,
        success :  validateforgetPass_res
    });

    $('#setPassword').validate({
        rules : {
            password : {
                required : true,
                minlength : 8,
                checkPass : true
            },
            c_password : {
                required: true,
                equalTo: '#password1'
            }
        },
        messages :{
            password : {
                required : "Password is required",
                minlength : "Password must contain 8 characters",
                checkPass : "It must contain a lowercase letter & a digit" 
            },
            c_password : {
                required : "Enter password to confirm",
                equalTo : "Password must be same"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);
                var errortext = "<div class=\'error_box \'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
               }
               $element.closest('.input-group').append(errortext);
           });
        }
    });

    $('#setPassword').ajaxForm({
        beforeSubmit : validateSetPassword,
        success :  validateSetPassword_res
    });

    $('#contactForm').validate({
        rules : {
            name : {
                required: true
            },
            email : {
                required: true,
                validEmail: true
            },
            mobile : {
                required: true,
                phoneUS : true
            },
            subject : {
                required: true,
                valueNotEquals: 0
            }
        },
        messages :{
            name : {
                required : "Please Enter Name"
            },
            email : {
                required : "Email is required",
                validEmail : "Please Enter Valid Email"
            },
            mobile : {
                required : "Phone number is required.",
                phoneUS : "Plase Enter Valid Phone number"
            },
            subject : {
                required : "Please Select Subject",
                valueNotEquals: "Please Select Subject"
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
        // submitHandler: function(form) {
        //     if (grecaptcha.getResponse()) {
        //         //form.submit();
        //         $('.recaptcha_error_div').hide()
        //     } else {
        //         $('.recaptcha_error_div').show();
        //     }
        // }
    });

    $('#contactForm').ajaxForm({
        beforeSubmit : validateContact,
        success :  validateContact_res
    }); 

    function validateContact(){
        if (grecaptcha.getResponse()) {                
                $('.recaptcha_error_div').hide()
                return $('#contactForm').valid();
            } else {
                $('.recaptcha_error_div').show();
                return false;
            }    
        }

        function validateContact_res(res){
           if(res){
               var parse = $.parseJSON(res);
               var status = parse.status;
               var message = parse.message;
               var msg = $(message).text();
               if(status){
            //.css('color','#007b03')
            $('.form-res').css('display','inline').text('Your information is successfully sent to support you will be contacted shortly').delay(3000).fadeOut("slow");
            $('#contactForm')[0].reset();
        }else{
          $('.form-res').css({'display':'inline','background-color':'#ea1e1e','color':'#E7080F'}).text(message).delay(3000).fadeOut("slow");
      }
  }
}

function validateRegistration(){
 return $('#register').valid();
}

function validateRegistration_res(res){
    if(res){
       var parse = $.parseJSON(res);
       var status = parse.status;
       var message = parse.message;
       var msg = $(message).text();
       if(status){
          $('.form-res').css('color','#007b03').text('Registration Successfull. Check you email to activate your Account');
          $('#register')[0].reset();
      }else{
          $('.form-res').css('color','#E7080F').html(msg);
      }
  }
} 

function validateLogin(){
    return $('#login').valid();
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function validateLogin_res(res){
   if(res){
    var test = IsJsonString(res);
    if(test == true){
        var parse = $.parseJSON(res);
        if(parse.status && test == true){
            if(which_click == 'fund'){
                window.location = Base_URL+'sendFunds';
            }else{
                window.location = Base_URL+'sendPhotos';
            }
        }
    }
    if(test == false){
        var message = "invalid login";
        var msg = '<p>Wrong username or password</p>';
        $('.login-res').css('color','#ffffff').html(msg).show();
            // $.fancybox.close();
            // $('.fancybox #load').remove();
        }
    }
} 

// if(res){
//    var parse = $.parseJSON(res);
//    if(parse.status){
//        window.location = Base_URL+'profile';
//    }else{
//        var message = parse.message;
//        var msg = '<p>'+$(message).text()+'</p>'; 
//        $('.login-res').html(msg);
//    }
// }

function validateLoginPage(){
    return $('#login2').valid();
}

function validateLoginPage_res(res){
   if(res){        
       var parse = $.parseJSON(res);
       if(parse.status){
           window.location = Base_URL+'profile';
       }else{
           var message = parse.message;
           var msg = '<p>'+$(message).text()+'</p>'; 
           $('.loginpage-res').html(msg);
       }
   }
} 

function validateMoblogin(){
    return $('#mob-login').valid();
}

function validateMoblogin_res(res){
   if(res){
    var test = IsJsonString(res);
    if(test == true){
        var parse = $.parseJSON(res);
        if(parse.status && test == true){
            if(which_click == 'fund'){
                window.location = Base_URL+'sendFunds';
            }else{
                window.location = Base_URL+'sendPhotos';
            }
        }
    }
    if(test == false){
        var message = "invalid login";
        var msg = '<p>Wrong username or password</p>';
        $('.login-res').css('color','#ffffff').html(msg).show();
            // $.fancybox.close();
            // $('.fancybox #load').remove();
        }
    }
} 

function validateforgetPass(){
    return $('#forget_form').valid();
}

function validateforgetPass_res(res){
    if(res){
        var parse = $.parseJSON(res);
        var status = parse.status;
        var m1 = parse.message;
        if(status){
           $('#resetBox').hide();
           $('#resetSuccess').show();
       }else{
           var msg = m1.replace(/\"/g, "");
           $('#forget_pass_msg').css('color','#FF0000').text(msg).show().delay(3000).fadeOut("slow");
       }
   }
} 

function validateSetPassword(){
    return $('#setPassword').valid();
}

function validateSetPassword_res(res){
    if(res){
        var parse = $.parseJSON(res);
        var status = parse.status;
        if(status){
            $('#resetformDiv').hide();
            $('#loginformDiv').fadeIn("slow");
        }
    }
} 

$(document).ajaxStart(function () {
    var box = $('.fancybox');
    var height = (box.outerHeight())/2 - 52;
    var html = '<div id="load" style="display:block;width:100%; height:100%; top:0;'+
    'position:absolute; background-color:rgba(255, 255, 255, 0.8);text-align: center;">'+
    '<img style="width: 26%; margin-top: '+height+'px;" alt="" '+
    'src="'+IMG_PATH+'loading.gif">'+
    '<p>Please Wait . . . .</p></div>';
    box.append(html);        
}).ajaxStop(function () {
    $('.fancybox #load').remove();
});

$('#refresh').on('click',function(){
    getCaptcha();
});

});
var which_click = 'fund';
$(document).on('click','#showSendFund',function(){
    var id = 'sendFund';
    which_click = 'fund';
    if(c_user != ''){
        window.location = Base_URL+'sendFunds';
    }else{
        $.fancybox({
            href : '#login_box',
            autoDimensions : false,
            autoSize : false,
            width : 330,
            height : 'auto',
            beforeClose : function(){
                $('#login_form div.error_box').remove();
                $('#login_msg p').remove();
                $('#login_form input').val('');
            }
        });
    }    
});
$(document).on('click','#showBtnLogin',function(){
    
        $.fancybox({
            href : '#login_box',
            autoDimensions : false,
            autoSize : false,
            width : 330,
            height : 'auto',
            beforeClose : function(){
                $('#login_form div.error_box').remove();
                $('#login_msg p').remove();
                $('#login_form input').val('');
            }
        });
        
});

$(document).on('click','#showSendPhotos',function(){
    which_click = 'photo';
    var id = 'sendPhotos';
    if(c_user != ''){
        window.location = Base_URL+'sendPhotos';
    }else{
        $.fancybox({
            href : '#login_box',
            autoDimensions : false,
            autoSize : false,
            width : 330,
            height : 'auto',
            beforeClose : function(){
                $('#login_form div.error_box').remove();
                $('#login_msg p').remove();
                $('#login_form input').val('');
            }
        });
    }    
});

function getCaptcha(){
    $.ajax({
        async : false,
        type : 'post',
        url  : Base_URL+'getCaptcha',
        success : function(res){
           $('.captcha_img').html($.trim(res));
           $('#captcha_val').val($.trim(res).toLowerCase());
       }
   });
}

function getLocation(){
    var value = $('#postcode').val();
    if(value >= 5 && value.length >= 5){
        getAddressInfoByZip(value);
    }else{
       $('#city').val('');
       $('#state').val('');
       $('#country').val('');
   }
} 

// $(".country").chosen({
//     display_selected_options: true,
// });

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
        var state = obj.state;
        var country = obj.country;
        // if(country == 'United States'){
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
        // }else{
        //     return false;
        // }        
    }else{
      return false;
  }
}

function resetMailSent(){            // After Password Reset mail Sent
   $.fancybox.close();
   $('#resetSuccess').css('display','none');
   $('#resetBox').css('display','block');
}

function termsAndConditions(){
    $.fancybox({
     href : '#terms-conditions',
     autoDimensions : false,
     autoSize : false,
     width : 330,
     height : 'auto'
 });
}

$(document).ready(function(){
    $('#mobile').mask('(000) 000-0000');
});

$(document).ready(function(){
    $('#con_mobile').mask('(000) 000-0000');
});

document.addEventListener("touchstart", function() {},false);