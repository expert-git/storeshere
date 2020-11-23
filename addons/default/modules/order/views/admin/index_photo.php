<?php echo Asset::js('sweet_alert/sweetalert.min.js'); ?>
<?php echo Asset::js('sweet_alert/sweetalert-dev.js'); ?>
<section class="title">
		<h4>
		Send Photos Listing <span style="color:green; color:green;margin: 15px;     font-weight: bold;" id="msg"></span>
	</h4>
</section>

<section class="item">
	<div class="content">
	
		<?php echo template_partial('filters') ?>
	
		<?php echo form_open('admin/users/action') ?>
		
			<div id="filter-stage">
				<?php echo template_partial('tables/photo_order') ?>
			</div>
	
		<?php echo form_close() ?>
	</div>
</section>
<div class="overlay-container" style="display:none;">
</div>
<script type="text/javascript">
$(document).ready(function(){

	$(document).on('click','.preview_photos', function(){
		var id = $(this).attr('data-id');
		$.ajax({
			url : BASE_URL+'admin/order/getImages',
			type : 'POST',
			data : {id : id},
			success : function(res){
				$.fancybox.open($.parseJSON(res));
				$('.fancybox-overlay').css('z-index','9999');
			}			
		});
	});

	$(document).on('click','.update_stat',function(){
		var id = $(this).attr('data-attr');		
		$('#photo_stat_id').val(id);
		$('#stat_dialog').dialog({
			width: 600,
			height:300,			
			modal : true,
			buttons : {
				"Submit" : updatePhotoStatus,
				Cancel : function(){
					$('#file').val('');
					$('#invoice').val('');
					$('#stat_dialog').dialog("close");
				}
			}
		});
	});

	function updatePhotoStatus(){
		var status = $('#photo_opt').val();
		var id = $('#photo_stat_id').val();
		var invoice = $('#invoice').val();
		var text = "In Transit";		
		// if(status == 3){
		// 	if(invoice == ''){
		// 		showError('Please upload Receipt');
		// 		return false;
		// 	}			
		// }
		$.ajax({
			url : BASE_URL+'admin/order/updatePhotoStatus',
			type : 'POST',
			data : {status : status, id : id, invoice : invoice},
			success : function(res){
				var parse = $.parseJSON(res);	
				if(status == 3){
					text = "Delivered";
					var td = $('#row_'+id+' td').eq(12).find('a.update_stat');
					$('#row_'+id+' td').eq(11).html('<a>Delivered</a>');
					if(parse.file != ''){						
						$('<a class="button view_invoice fancybox" data-src="'+parse.file+'">View Invoice</a>').insertBefore(td);						
					}else{
						// $('<a></a>').insertBefore(td);
					}
					td.remove();
				}
				if(status == 2){
				    //window.location.href = window.location.href;
				    text = "In Transit";
					$('#row_'+id+' td').eq(11).html('<a>In Transit</a>');
				}
			//	$('#row_'+id+' td').eq(8).html(text);
				$('#msg').html("Status updated successfully.");
				$('#file').val('');
				$('#invoice').val('');
				$('#stat_dialog').dialog("close");

               //  if (parse.status == true) {
                //	 swal("Successfully!", "your status successfully updated!", "success")
                	 	// $('#stat_dialog').dialog("close");
                        // alert('your status successfully updated');
                        //	$('#msg').html("Status updated successfully.");
              //  }else{
                //	sweetAlert("Oops...", "Something went wrong!", "error");
                //	$('#msg').html("Status updated successfully.");
              //  }


			}
		});
	}

	// $(document).on('change','#photo_opt', function(){
	// 	if($('#photo_opt').val() == 3){
	// 		$('#img_upload').append('<label for="file">Upload Receipt : </label><div class="input"><input type="file" name="file" id="file" /><input type="hidden" name="invoice" id="invoice" /></div>');
	// 	}else{
	// 		$('#img_upload').html('');
	// 	}
	// });

	$(document).on('change','#file', function(){
		readURL(this);
	});

	function readURL(input){
		if(input.files && input.files[0]){
			if(checkImageformat(input.files)){
				$('#error').remove();
				var reader = new FileReader();
				reader.onload = function (e) {
                    $('#invoice').val(e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
			}else{
				showError('Only jpg,jpeg,png.gif files allowed');
			}
		}
	}

	function showError(msg){
		if($('#error').length == 0){
			$('#img_upload').append('<p id="error" style="color:red">'+msg+'</p>');	
		}else{
			$('#error').html(msg);
		}		
	}

	function checkImageformat(file){
        var filename = file[0].name;
        var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
        if(valid_extensions.test(filename)){
            return true;
        }else{
            return false;
        }        
    }

    $(document).ajaxStart(function () {
	    showLoading();
	}).ajaxStop(function () {
	    hideLoading();
	});

	function showLoading(){
	    var box = $('.ui-dialog');
	    var height = box.outerHeight();
	    var margin = (height/2) - 59;
	    var html = '<div id="load" style="display:block;width:100%; height:100%; top:0; position:absolute; background-color:rgba(255, 255, 255, 0.8);text-align: center;"><img style="width: 26%; margin-top: '+margin+'px;" alt="" src="'+BASE_URL+'/system/cms/themes/storeshere/img/loading.gif"><p>Please Wait . . . .</p></div>';
	    box.append(html);
	}

	function hideLoading(){
	    $('.ui-dialog #load').remove();
	}

	$(document).on('click','.view_invoice', function(){
    	var src = $(this).attr('data-src');
    	$.fancybox.open(src);
    	$('.fancybox-overlay').css('z-index','9999');
    });

    $(document).on('click','.msg_btn',function(){
    	var msg = $(this).attr('data-msg');
    	$.fancybox.open(msg);
    	$('.fancybox-overlay').css('z-index','9999');
    	$('.fancybox-inner').attr('id','printContent');
    	$('<div class="printDiv" style="position: absolute; z-index: 1000; cursor: pointer; top: -11%; left: -9%;"><img src="<?php echo base_url();?>addons/default/modules/order/views/admin/print.png" height="30px" title="please print"; width="30px";></img></div>').insertBefore($('.fancybox-skin'));
    });

    $(document).on('click','.printDiv',function(){    	
    	printJS('printContent', 'html');    	
    });

});
</script>