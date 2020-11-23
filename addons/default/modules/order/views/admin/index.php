<?php echo Asset::js('sweet_alert/sweetalert.min.js'); ?>
<?php echo Asset::js('sweet_alert/sweetalert-dev.js'); ?>
<section class="title">
	<h4>
		Send Fund Listings <span style="color:green; color:green;margin: 15px;     font-weight: bold;" id="msg"></span>
	</h4>
</section>

<section class="item">
	<div class="content">
	
		<?php echo template_partial('filters') ?>
	
		<?php echo form_open('admin/users/action') ?>
		
			<div id="filter-stage">
				<?php echo template_partial('tables/order') ?>
			</div>
	
		<?php echo form_close() ?>
	</div>
</section>
<script type="text/javascript">

$(document).ready(function(){
    
    $(document).on('click','#total_amt_cal',function(){
        total_amt = 0;
        i = 0;
    	$("input:checkbox[name=action_to[]]:checked").each(function(){
		    if($(this).val() != ''){
		    	total_amt += parseInt($(this).parent().parent().children("td:nth-child(8)").text().replace("$", ""));
		    	i++;
			}
		});
		// alert(checkBox.length);
		if(total_amt > 0){
		    $("#total_amt_value").text("$"+total_amt+" : "+i);
        }else{       	  
  		    alert('Select at least one checkbox');
        }
    });

	$(document).on('click','.update_status',function(){
	    if($(this).attr('data-attr')) {
	        var id = $(this).attr('data-attr');
    		var payer_id = $(this).attr('data-payer');	
    		var paid_to = $(this).attr('data-paidto');
    		console.log("test");
	    }
	    else{
	        
	    }
	    $('#photo_stat_id').val(id);
		$('#payer_id').val(payer_id);
		$('#paid_to').val(paid_to);
		$('#stat_dialog').dialog({
			width: 600,
			height:300,			
			modal : true,
			buttons : {
				"Submit" : updateFundStatus,
				Cancel : function(){
					$('#file').val('');
					$('#invoice').val('');
					$('#stat_dialog').dialog("close");
				}
			}
		});
	});
    
    
    $(document).on('click','.updates',function(){
        id = [];
        i = 0;
        $("input:checkbox[name=action_to[]]:checked").each(function(){
		    if($(this).val() != '' && $(this).parent().parent().children('td:nth-child(16)').find(".update_status").attr('data-payer')){
		        id.push($(this).val());
			}
            i++;
		});
		
		if(i != id.length){
		    if(i == 0){
    		    alert('Select at least one checkbox');
    		    return false;
    		}
		    alert("Please select only Update Status");
 		    return false;
		}
		$("#funds_id").val(id);
		$('#stats_dialog').dialog({
			width: 600,
			height:300,			
			modal : true,
			buttons : {
				"Submit" : multiUpdateFundStatus,
				Cancel : function(){
					$('#file').val('');
					$('#invoice').val('');
					$('#stats_dialog').dialog("close");
				}
			}
		});
    });
    
    function multiUpdateFundStatus(){
        var status = $("#photo_opt1").val();
        var id = $("#funds_id").val();
        
        $.ajax({
            url : BASE_URL+'admin/order/multiFundStatusUpdate',
			type : 'POST',
			data : {status : status, id : id },
			success : function(res){
			    console.log(res);
			    console.log(status);
				// var parse = $.parseJSON(res);	

				if(status == 3){
				    text = "Delivered";
				    $("input:checkbox[name=action_to[]]:checked").each(function(){
    					$('#row_'+$(this).val()+' td').eq(12).html(text);
    					$('#row_'+$(this).val()+' td').eq(15).html('<a>'+text+'</a>');
				    });
					
				}
				if(status == 2){
				    text = "In Transit";
				    $("input:checkbox[name=action_to[]]:checked").each(function(){
				        
    					$('#row_'+$(this).val()+' td').eq(12).html('<a>'+text+'</a>');
    					$('#row_'+$(this).val()+' td').eq(13).html('<a>'+text+'</a>');
				    });
				    //window.location.href = window.location.href;
				}
				$('#msg').html("Status updated successfully.");
				$('#file').val('');
				$('#invoice').val('');
				$('#stats_dialog').dialog("close");

			}
        });
    }    
    
	function updateFundStatus(){
		var status = $('#photo_opt').val();
		var id = $('#photo_stat_id').val();
		var invoice = $('#invoice').val();
		var payer_id = $('#payer_id').val();
		var paid_to = $('#paid_to').val();
		var text = "In Transit";
		// if(status == 3){
		// 	if(invoice == ''){
		// 		showError('Please upload Receipt');
		// 		return false;
		// 	}			
		// }		
		$.ajax({
			url : BASE_URL+'admin/order/updateFundStatus',
			type : 'POST',
			data : {status : status, id : id, invoice : invoice, payer_id : payer_id, paid_to : paid_to },
			success : function(res){
				var parse = $.parseJSON(res);	

				if(status == 3){					
					text = "Delivered";
					$('#row_'+id+' td').eq(12).html(text);
					if(parse.file != ''){
						$('#row_'+id+' td').eq(10).html('<a class="button view_invoice fancybox" data-src="'+parse.file+'">View Invoice</a>');	
					}
					else{
					    $('#row_'+id+' td').eq(15).html('<a>'+text+'</a>');
					}
				}
				if(status == 2){
				    //window.location.href = window.location.href;
				    text = "In Transit";
					$('#row_'+id+' td').eq(12).html('<a>'+text+'</a>');
					$('#row_'+id+' td').eq(13).html('<a>'+text+'</a>');
				}
			//	$('#row_'+id+' td').eq(9).html(text);
				// $('#row_'+id+' td').eq(8).html();
				$('#msg').html("Status updated successfully.");
				$('#file').val('');
				$('#invoice').val('');
				$('#stat_dialog').dialog("close");
			
               // sweet alert
               // console.log(parse.status);
               // if (parse.status == true) {
                //	 swal("Successfully!", "your status successfully updated!", "success")
                	 	// $('#stat_dialog').dialog("close");
                        // alert('your status successfully updated');
               // }else{
                //	sweetAlert("Oops...", "Something went wrong!", "error");
               // }

			}
		});
	}

	$(document).on('change','#photo_opt', function(){
		if($('#photo_opt').val() == 3){
			if($('#img_upload label').length == 0){
				$('#img_upload').append('<label for="file">Upload Receipt : </label><div class="input"><input type="file" name="file" id="file" /><input type="hidden" name="invoice" id="invoice" /></div>');
			}
		}else{
			$('#img_upload').html('');
		}
	});

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

    $(document).on('click','.view_invoice', function(){
    	var src = $(this).attr('data-src');
    	console.log(src);
    	$.fancybox.open(src);    	
    	$('.fancybox-overlay').css('z-index','9999');
    	$('<div class="printthis" style="position:absolute; z-index:1000; padding:5px; cursor:pointer;">print</div>').insertBefore($('.fancybox-skin'));
    });

    $(document).on('click','.printthis',function(){
    	var path = $('.fancybox-image').attr('src');
    	printJS(path, 'image');
    	// $('.fancybox-image').printThis({
    	// 	header: "<h1>Amazing header</h1>"
    	// });
    	// var html = $('iframe').clone();
    	// $('body').append(html);
    });

    $(document).on('click','.print_receipt', function(){
    	var id = $(this).attr('data-id');
    	console.log(id);
    	$("#"+id).hide();
    	setTimeout(function(){ 
    	    $("#"+id).show();
    	}, 1000);
    	
    	$.ajax({
			url : BASE_URL+'admin/order/print_value',
			type : 'POST',
			data : {id : id },
			success : function(res){
				var html = res;
				$.fancybox.open(res);
				$('.fancybox-overlay').css('z-index','9999');
    	$('<div class="printDiv" style="position:absolute; z-index:1000; padding:25px; cursor:pointer; width:200px;"><img src="<?php echo base_url();?>addons/default/modules/order/views/admin/print.png" height="30px" title="please print"; width="30px";></img></div>').insertBefore($('.fancybox-skin'));

 
			}
		});
    });

    $(document).on('click','.printDiv',function(){    	
    	printJS('printReceipt', 'html');
    });

    $(document).on('click','.printMultiple',function(){    	
    	printJS('print_multiple', 'html');
    });

    $(document).on('click','#check_value', function(){
    	checkBox = [];
    	$("input:checkbox[name=action_to[]]:checked").each(function(){
		    if($(this).val() != ''){
		    	checkBox.push($(this).val());
			}
		});
		// alert(checkBox.length);
		if(checkBox.length > 0){		
            $.ajax({
			url : BASE_URL+'admin/order/checked_values',
			type : 'POST',
			data : {checkBox : checkBox },
			success : function(res){
				var html = '<div id="print_multiple">'+res+'</div>';
				$.fancybox.open(html);
				$('.fancybox-overlay').css('z-index','9999');
    	$('<div class="printMultiple" style="position:absolute; z-index:1000; padding:25px; cursor:pointer; width:200px;"><img src="<?php echo base_url();?>addons/default/modules/order/views/admin/print.png" height="30px" title="please print"; width="30px";></img></div>').insertBefore($('.fancybox-skin'));

					}
		});  
      }else{       	  
      		alert('Select at least one checkbox');
      }
    });

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

});





</script>