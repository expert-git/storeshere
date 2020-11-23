<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div id="photo_left_nav" class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
               <div class="form-title">
                   <span id="sendFund" class="showDiv">Send Photos</span>
                   <!-- <h1>Send Funds to an Inmate</h1><p>PLEASE COMPLETE THE FORM BELOW</p> -->
               </div>

               <div class="spacer10"></div>
                <?php if(is_logged_in()) :?>
                    {{ theme:partial name="sidemenu" }}
                <?php endif; ?>
            </div>
        </div>
        <div id="photo_right_space" class="col-md-8 col-sm-8 col-xs-12">
            <?php if(is_logged_in()) :?>
                 {{ theme:partial name="loginForms" }}
            <?php endif; ?>

            <div class="content-widget slideDiv" id="sendFundDiv">                
                <?php echo form_open('uploadPhotos', array('id' => 'sendPhotosForm','class'=>'signup horizontal-form send-funds', 'enctype' => 'multipart/form-data')) ?>
                    <div class="components">
                        <div class="signup-title">
                            <h1>PLEASE COMPLETE THE FORM BELOW</h1>
                        </div>
                        <div class="spacer10"></div>
                        <div class="groups" id="tab1">
                             <div class="input-group">
                                <label class="photo-label">Facility<font style="color:red;">*</font>:</label>
                                <select id="photo_facility" name="facility" class="inputw310 facilityList">
                                    <option value="0">SELECT FACILITY</option>
                                    <?php if(!empty($photoFacility)) :?>
                                        <?php foreach($photoFacility as $k => $v) :?>
                                             <option data-photoSize="<?php echo $v['photo_size']; ?>" data-photoResolution="<?php echo $v['photo_resolution']; ?>" data-noOfPhotos="<?php echo $v['no_of_photos']; ?>" data-pricePerPhoto="<?php echo $v['price_per_photo']; ?>" data-shippingCharge="<?php echo $v['shipping_charge_per_photo']; ?>" value="<?php echo $v['id']?>">
                                                <?php echo $v['name'];?>
                                             </option>
                                        <?php endforeach; ?> 
                                    <?php endif; ?>    
                                </select>
                            </div>
                            <div class="input-group">
                                <label class="photo-label">Inmates Name<font style="color:red;">*</font>:</label>
                                <select name="name" class="inputw310 inmatesList">
                                    <option value="0">SELECT INMATE</option>
                                </select>
                            </div>
                             <div class="input-group">
                                <label class="photo-label">Inmates ID Number:</label>
                                <input type="text" class="inputw310" readonly="true" name="bookingNo" id="bookingNo" placeholder="Inmate Booking Number">
                            </div>
                            <div class="input-group">
                                <label class="photo-label">Upload Document:</label>
                                <input type="file" name="doc" id="doc" />
                            </div>
                            <div class="input-group">
                                <label class="photo-label">Enter Message:</label>
                                <textarea style="height:50px;" cols="35" id="message" name="message" placeholder="Enter some message..."></textarea>
                            </div>
                            <div class="input-group" id="add_photo_div">
                                <p id="label_upload" class="pd"></p>
                                <label class="photo-label">Upload Photos:</label>                                
                                <input id="photo0" type="file" name="photo_file[]" class="photoInput" required data-id="0" />
                                <?php if($photoFacility[0]['no_of_photos'] > 1){ ?>
                                    <button type="button" class="add_more_photos_btn" id="add_more_photos" data-id="0" >+</button>
                                <?php } ?>                                
                            </div>                            
                            <div class="input-group" id="insertbefore">
                                <p class="pd"><span><a href="javascript:void(0);">Click to View  Our Terms and Conditions</a></span></p>
                            </div>
                            <div class="input-group">
                                <p class="pd" style="display: inline-block; margin-right: 5px;">
                                    <label>
                                        <input type="radio" name="accept"> I agree terms &amp; conditions.
                                    </label>
                                </p>
                            </div>
                            <div class="input-group">
                                 <div class="pd">
                                     <div class="signup-button-wrap2 fl-left">
                                        <button type="button" id="continue" class="transparent">
                                            <span>
                                                Continue
                                            </span>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>                                            
                        </div>
                        <div class="groups" id="tab2" style="display:none;">
                            <div class="white_block">
                                <p><label>&nbsp;</label><label>Price</label><label>Unit</label><label>Total</label></p>
                                <div class="border2"></div>
                                <p><label>Charge per photo:</label> <label id="charge_per_photo"></label><label class="no_of_photo"></label><label id="total_photo_price"></label></p>
                                <p><label>Shipping Charge:</label> <label id="shipping_charge_per_photo"></label><label class="no_of_photo"></label><label id="total_shipping_price"></label></p>
                                <p class="total3"> <b><label>Total :</label> <label id="total_amount"><label></label></b>

                            </div>
                            <div class="emoji_wrap">
                                
                            </div>

                            <div class="input-group">
                                <div class="pd">
                                    <div class="signup-button-wrap2 fl-left">
                                        <button type="button" id="goback" class="transparent">
                                          
                                          <span class="back">
                                                Go back
                                            </span>
                                        </button>
                                    </div>
                                     <div class="signup-button-wrap2 fl-left">
                                        <button type="submit" class="transparent" >
                                            <span>
                                                Proceed to pay
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div id="emojidiv" style="display:none;">
    <ul>
        <?php foreach($emoji as $emo){ ?>
            <li>                
                <img class="emoji_select" src="<?php echo base_url($this->template->get_theme_path().'img/emoji/'.$emo); ?>" />
            </li>
        <?php } ?>
    </ul>
</div>
<div id="imagediv" style="display:none;"></div>
<input type="hidden" value="" id="canvas_id" />
<script type="text/javascript">
$(document).ready(function(){
    $('.photoInput').val('');
    var photo_size = "";
    var photo_resolution = "";    
    var width = '';
    var height = '';    
    var no_of_photos = "";
    var price_per_photo = "";
    var shipping_charge_per_photo = "";

    $(document).on('click','#continue', function(){
        if($('#sendPhotosForm').valid()){
            $('#photo_left_nav').hide();
            $('#photo_right_space').removeClass('col-md-8 col-sm-8 col-xs-12').addClass('col-md-12 col-sm-12 col-xs-12');
            $('#charge_per_photo').text(price_per_photo);
            $('#shipping_charge_per_photo').text(shipping_charge_per_photo);
            var photos_uploaded = $('#sendPhotosForm input[type="file"].photoInput:empty');
            var total_photo_count = 0;
            $.each(photos_uploaded, function(k,v){
                if($(v).val() != ''){
                    total_photo_count++;
                }
            });
            // var total_price = (price_per_photo*parseFloat(total_photo_count))+(shipping_charge_per_photo*parseFloat(total_photo_count));
              var total_price = (price_per_photo*parseFloat(total_photo_count))+(parseFloat(shipping_charge_per_photo));
              var total_price_limit = total_price.toFixed(2);
              var total_photo_price = price_per_photo*parseFloat(total_photo_count);
              var total_photoprice_limit = total_photo_price.toFixed(2);
            $('#total_amount').text(total_price_limit+' USD');
            $('.no_of_photo').text(total_photo_count);
            $('#total_photo_price').text(total_photoprice_limit);
            // $('#total_shipping_price').text(shipping_charge_per_photo*parseFloat(total_photo_count));
            $('#total_shipping_price').text(shipping_charge_per_photo);
            $('#tab1').hide();
            $('#tab2').show();
        }
    });
    $(document).on('click','#goback', function(){
        $('#tab1').show();
        $('#tab2').hide();
        $('#photo_left_nav').show();
        $('#photo_right_space').addClass('col-md-8 col-sm-8 col-xs-12').removeClass('col-md-12 col-sm-12 col-xs-12');
    }); 

    $(document).on('change','#photo_facility',function(e){
        photo_size = $('#photo_facility option:selected').data('photosize');
        photo_resolution = $('#photo_facility option:selected').data('photoresolution');
        var split = photo_resolution.split('x');
        width = split[0];
        height = split[1];
        no_of_photos = $('#photo_facility option:selected').data('noofphotos');
        var no_of_input_fields = $('#sendPhotosForm input[type="file"].photoInput').length;
        
        if(no_of_photos < no_of_input_fields){            
            $('#add_photo_div').nextUntil(insertbefore,"div").remove();            
            $('#add_more_photos').show();
        }else{
            $('#add_more_photos').show();
        }
        price_per_photo = $('#photo_facility option:selected').data('priceperphoto');
        shipping_charge_per_photo = $('#photo_facility option:selected').data('shippingcharge');        
        var html = 'Max uploads : '+no_of_photos+' Max Dimension : '+photo_resolution+' Max Size : '+photo_size+' MB';
        $('#label_upload').html(html);
    });

    $(document).on('click','#add_more_photos', function(){
        var length = $('#sendPhotosForm input[type="file"].photoInput').length;        
        if(length < no_of_photos){
            var btn_html = '<div class="input-group photo_input_wrap"><label></label><input data-id="'+length+'" type="file" name="photo_file['+length+']" id="photo'+length+'"  class="photoInput" required /><button data-id="'+length+'" type="button" class="remove_file add_more_photos_btn">-</button></div>';
            $(btn_html).insertBefore($('#insertbefore'));
            $('#photo'+length).rules("add", {
                required : true,
                extension : 'jpg|jpeg|png|gif',
                messages : {
                    required : 'Photo is required',
                    extension : 'Only jpg,gif,png formats allowed'
                }
            });            
            if(length+1 == no_of_photos){
                $(this).hide();
            } 
        }
    });

    $(document).on('click','.remove_file', function(){
        var length = $('#add_photo_div input[type="file"].photoInput').length;        
        if(length <= no_of_photos){
            $('#add_photo_div button').show();            
        }
        var closest_div = $(this).parent('.input-group'); 
        var id = $(this).attr('data-id');        
        $('.emoji_wrap div.row').eq(id).remove();
        window['canvas'+id] = '';
        $(closest_div).remove();
    });

    $('#sendPhotosForm').validate({
        ignore:':hidden:not("select")',
        rules : {
            facility : {
                required : true,
                checkValue : 0
            },
            name : {
                required : true,
                checkValue : 0
            },
            bookingNo : {
                required : true
            },
            'photo_file[]' : {
                required : true,
                extension : 'jpg|jpeg|png|gif'                
            },
            accept : {
                required : true
            },
            doc : {
                extension : 'doc|docx'
            }
        },
        messages : {
            facility : {
                required : "Please Select Facility",
                checkValue : "Please Select Facility"
            },
            name : {
                required : "Please Select Inmate Name",
                checkValue : "Please Select Inmate Name"
            },
            bookingNo : {
                required: "Please Select Inmate Name"
            },
            'photo_file[]' : {
                required : 'Photo is required',
                extension : 'Only jpg,gif,png formats allowed'
            },
            accept : {
                required : "Select this"
            },
            doc : {
                extension : "Only docx/doc files allowed"
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


    jQuery.validator.addMethod("checkValue", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please specify a different (non-default) value");


   /* $.validator.addMethod("checkValue", function(value, element, param){
        console.log(param);
        console.log(validate);
        return this.optional(element) || value != param;
    }, "Value must not equal arg.");
*/
    $(document).on('change',".photoInput",function(){
        var id = $(this).attr('data-id');
        readURL(this,id);
    });
    
    function readURL(input,id) {
        if (input.files && input.files[0]) {
            if(checkImageformat(input.files)){
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);                
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function () {
                        //Determine the Height and Width.
                        var img_height = this.height;
                        var img_width = this.width;
                        if (img_height > height || img_width > width) {
                            var msg = 'file dimension should not be more than '+ photo_resolution
                            showError(input,msg);
                            $('#photo'+id).val('');
                            return false;
                        }else if(input.files[0].size > parseFloat(photo_size)*1000000){
                            var msg = 'file size should be less than '+photo_size+' MB.'
                            showError(input,msg);
                            $('#photo'+id).val('');
                            return false;
                        }
                        createCanvas(image,id);
                        return true;
                    };
                };                                                
            }else{
                showError();
            }
        }
    }

    function createCanvas(image,len){        
        var canvasId = 'canvas'+len;
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        var height = (window.innerHeight > 0) ? window.innerHeight : screen.height;        
        if(width < 657 ){
            width = width-50;
        }else{
            width = 1000;
        }
        if(height > 500){
            height = 500;
        }
        if($('#row-'+len).length == 0){ 
            var html = '<div class="row" id="row-'+len+'">'+
                        '<div class="col-md-11"><canvas width="'+width+'" height="'+height+'" class="col-md-12 col-sm-12 col-xs-12"  id="'+canvasId+'"></canvas></div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" data-id="'+len+'" class="btn-primary custom_text" ></button>'+'<br>'+
                            '<button type="button" data-id="'+len+'" class="btn-primary insert_emoji" ></button>'+'<br>'+                       
                            '<button type="button" class="deleteObject btn-primary del-icon" data-id="'+canvasId+'" ></button>'+'<br>'+
                            '<input type="color" data-id="'+len+'" class="text_color" value="#FF0914" />'+
                        '</div>'+
                        '<img id="img'+len+'" src="'+image.src+'" style="display:none;" />'+
                        '<input type="hidden" id="output'+len+'" name="editedphoto[]" />'+
                    '</div>';
            $(".emoji_wrap").append( html );
        }else{
            $('#img'+len).attr('src',image.src);
        }
        window[canvasId] = '';
        AttachFabric(canvasId, len);
    }

    $(document).on('submit','#sendPhotosForm', function(event){        
        var div = $('.emoji_wrap div.row');
        var ret = false;
        div.each(function(k,v){
            var getId = v.id;
            var split = getId.split('-');
            var id = split[1];
            var img = window['canvas'+id].toDataURL({format: 'png', quality: 0.9});
            $('#output'+id).val(img);
            ret = true;
        });
        return ret;
    });

     function checkImageformat(file){
        var filename = file[0].name;
        var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
        if(valid_extensions.test(filename)){
            return true;
        }else{
            return false;
        }        
    }

    function showError(element,msg){
        element = $(element);
        var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+msg+"</p></div>";
        if(element.closest('.input-group').find('.error_box').length >= 1){
           element.closest('.input-group').find('.error_box').remove();
        }
        element.closest('.input-group').append(errortext);
    }

    // $.validator.addMethod('checkDimensions', function(value, element, minWidth) {
    //   return ($(element).data('imageWidth') || 0) > minWidth;
    // }, function(minWidth, element) {
    //   var imageWidth = $(element).data('imageWidth');
    //   return (imageWidth)
    //       ? ("Your image's width must be less than " + minWidth + "px")
    //       : "Selected file is not an image.";
    // });


});
</script>





<!-- <div class="container middle-content canvas_page">
    <div class="row">
        <div class="spacer20"></div>
       
       <div class="col-md-6 col-sm-6 col-xs-12"> 
       <div class="row">    
    <div class="col-md-6 col-sm-6 col-xs-12">    
        <div class="content-widget slideDiv" id="contactDiv">
            <input type="file" name="user_image" id="file" />
        </div>
    </div>    
    <div class="col-md-6 col-sm-6 col-xs-12">    
        <button id="custom_text" class="btn-primary" >Add Custom Text</button>
    </div>
    </div>
    </div>    
    </div>
      <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="components">
        <div style="background-color:#fff;">
        <canvas id="canvas" width="540px" height="540px"></canvas>
        </div>
            <a href='' id='txt' target="_blank">preview</a>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="components" id="preview_area" style="display:none;">    
        <img id="preview" />    
        <button id="upload_btn" class="btn-primary" >Upload Image</button>
    </div>
    </div>
    </div>
</div> -->
<script type="text/javascript">
function AttachFabric(canvasid, id_no){    
        window[canvasid] = new fabric.Canvas(canvasid,{
                preserveObjectStacking : true,                 
                lockSkewingX : true,
                lockSkewingY : true
                });
        var data = $('#img'+id_no).attr('src');
        // console.log(data);
        fabric.Image.fromURL(data, function (img) {
            // set image height width            
            var cw = $('#'+canvasid).width();
            var ch = $('#'+canvasid).height();
            var ratio = cw/ch;
            ratio = ratio.toFixed(2);            
            var iw = img.width/ratio;
            var ih = img.height/ratio;
            img.setWidth(iw.toFixed(2)-10);
            img.setHeight(ih.toFixed(2)-10);
            img.lockUniScaling = true;
            img.centeredScaling = true;            
            // img.setWidth(img.width);
            // img.setHeight(img.height);            

            // set text parametres
            var text = new fabric.IText('Tap and Type',{
              fontFamily: 'Comic Sans',
              fontSize: 20,
              fill : '#FF0914'
            });                
            text.set("top", (img.getBoundingRectHeight() / 2) - (text.width / 2));
            text.set("left", (img.getBoundingRectWidth() / 2) - (text.height / 2));
            var group = new fabric.Group([img], {
              left: 100,
              top: 25,
            });
            window[canvasid].add(group).renderAll();
            var a = window[canvasid].setActiveObject(group);                
            var dataURL = window[canvasid].toDataURL({format: 'jpg', quality: 0.9});
            $('#output'+id_no).val(dataURL);
            // selectedCanvas(id_no);
        });
}
$(document).on('click','.custom_text',function(){
    var id = $(this).attr('data-id');        
    var oText = new fabric.IText('Tap and Type', {
        left: 100,
        top: 100,
        fontFamily : 'Comic Sans',
        fontSize : 20,
        fill : '#FF0914'
    });    
    window['canvas'+id].add(oText);
    window['canvas'+id].setActiveObject(oText);
    window['canvas'+id].renderAll();
    var dataURL = window['canvas'+id].toDataURL({format: 'jpg', quality: 0.9});
    $('#output'+id).val(dataURL);
});

$(document).on('click','.emoji_select',function(){
    var id = $('#canvas_id').val();
    var src = $(this).attr('src');
    fabric.Image.fromURL(src, function (img) {
        img.setWidth(img.width);
        img.setHeight(img.height);
        window['canvas'+id].add(img);
    });
    window['canvas'+id].renderAll();
    var dataURL = window['canvas'+id].toDataURL({format: 'jpg', quality: 0.9});
    $('#output'+id).val(dataURL);
    $.fancybox.close();
});

$(document).on('change','.text_color', function(){
    var id = $(this).attr('data-id');
    window['canvas'+id].getActiveObject().set("fill",$(this).val());
    window['canvas'+id].renderAll();    
    var dataURL = window['canvas'+id].toDataURL({format: 'jpg', quality: 0.9});
    $('#output'+id).val(dataURL);
});

$(document).on('click','.insert_emoji',function(){
    var id = $(this).attr('data-id');
    $('#canvas_id').val(id);
    $.fancybox({ 
        href : '#emojidiv',
        autoDimensions : false,
        autoSize : false,
        width : 700,
        height : 'auto'
    });
});

$(document).on('click','.deleteObject', function(){
    var id = $(this).attr('data-id');    
    var activeObject = window[id].getActiveObject();
    if (activeObject) {
        if (confirm('Are you sure?')) {
            activeObject.remove(id);        
        }
    }else if (activeGroup>1) {
        if (confirm('Are you sure?')) {
            var activeGroup = window[id].getAllbject();
            activeGroup.remove(id);        
        }
    }
});
function selectedCanvas(id){    
    window['canvas'+id].on('object:selected', function(event) {
        var object = event.target;
        console.log(window['canvas'+id]);
        console.log(object);
        console.log("Selected");
        window['canvas'+id].sendBackwards(object);
    });
}

// $(document).ready(function(){
//     var canvas = new fabric.Canvas('canvas');
//     document.getElementById('file').addEventListener("change", function (e) {
//         var file = e.target.files[0];
//         var reader = new FileReader();        
//         reader.onload = function (f) {
//             var data = f.target.result;
//             fabric.Image.fromURL(data, function (img) {
//                 var oImg = img.set({left: 70, top: 100, width: 250, height: 200, angle: 0}).scale(0.9);
//                 canvas.add(oImg).renderAll();
//                 var a = canvas.setActiveObject(oImg);
//                 var dataURL = canvas.toDataURL({format: 'png', quality: 0.8});
//             });
//         };
//         reader.readAsDataURL(file);
//     });
//     document.querySelector('#txt').onclick = function (e) {
//         e.preventDefault();
//         canvas.deactivateAll().renderAll();
//         document.querySelector('#preview').src = canvas.toDataURL();
//     };
// });
// $(document).ready(function(){
//     var canvas = new fabric.Canvas('canvas');    
//     document.getElementById('file').addEventListener("change", function (e) {
//         var file = e.target.files[0];
//         var reader = new FileReader();        
//         reader.onload = function (f) {
//             var data = f.target.result;
//             fabric.Image.fromURL(data, function (img) {
//                 // set imag height width
//                 img.setWidth(250);
//                 img.setHeight(200);

//                 // set text parametres
//                 var text = new fabric.IText('Tap and Type',{
//                   fontFamily: 'Comic Sans',
//                   fontSize: 20,
//                   fill : 'navy'
//                 });                
//                 text.set("top", (img.getBoundingRectHeight() / 2) - (text.width / 2));
//                 text.set("left", (img.getBoundingRectWidth() / 2) - (text.height / 2));
//                 var group = new fabric.Group([img], {
//                   left: 100,
//                   top: 25,
//                 });
//                 img.sendToBack();                
//                 canvas.add(group).renderAll();
//                 var a = canvas.setActiveObject(group);                
//                 var dataURL = canvas.toDataURL({format: 'jpg', quality: 0.8});
//             });            
//         };
//         reader.readAsDataURL(file);
//     });
    
    // document.querySelector('.custom_text').onclick = function(e){
    //     var oText = new fabric.IText('Tap and Type', {
    //         left: 100,
    //         top: 100,
    //         fontFamily : 'Comic Sans',
    //         fontSize : 20,
    //         fill : 'navy'
    //     });
    //     canvas.add(oText);
    //     canvas.setActiveObject(oText);
    //     $('#fill, #font').trigger('change');
    // }


//     document.querySelector('#txt').onclick = function (e) {
//         e.preventDefault();
//         canvas.deactivateAll().renderAll();
//         if($('#file').val() != ''){
//             document.querySelector('#preview').src = canvas.toDataURL();
//             $('#preview_area').show();
//         }else{
//             alert('Please upload an image');
//         }
//     };
//     canvas.on("object:selected", function(options) {
//         options.target.sendToBack();           
//     });

//     $(document).on('click','#upload_btn', function(){
//         var image = $('#preview').attr('src');
//         $.ajax({
//             url : Base_URL+'addImage',
//             type : 'POST',
//             data : {image : image},
//             success : function(res){
//                 console.log(res);
//             }
//         })
//     });

// });

    $(document).ready(function(){
        // $('#amount').val('');
        // $('.inmatesList').val('');
        $('.facilityList').val('');
    });

</script>
<style>
.canvas-container {background-color: white !important;}
</style>