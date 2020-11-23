<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <div class="form-title">
                    <span class="showDiv" >Edit Inmate</span>
                </div>
                <div class="spacer10"></div>
            </div>
        </div>
		<div class="col-md-8 col-sm-8 col-xs-12">
			<div class="components">
				<div class="signup-title">
					<h1>						
						Edit Inmate details
					</h1>
				</div>				
				<?php echo form_open('updateInmate', array('id' => 'editInmatesForm','class'=>'signup horizontal-form')) ?>			       		
			            <div class="spacer10"></div>
			            <div class="groups">
			                <div class="input-group">
			                    <label class="inmate-label">Inmate Name (anombre del Reciouso)<font style="color:red;">*</font>:</label><br><br>
			                   
			                    <div class = "inmates_name_field" style="margin-left: 220px;"><label>First: </label><input type="text" name="name" maxlength="10" style="width: 100px;" value="<?php echo $data[0]['inmates_name']; ?>"></div>
                                <div class = "inmates_name_field"><label>Middle: </label><input type="text" value="<?php echo $data[0]['inmates_middle_name']; ?>" name="middle_name" maxlength="10" style="width: 100px;"></div>
                                <div class = "inmates_name_field"><label>Last: </label><input type="text" value="<?php echo $data[0]['inmates_last_name']; ?>" name="last_name" maxlength="10" style="width: 100px;"></div>
			                </div><br><br>
			                <div class="input-group">
			                    <label>Booking Number (número de reserva)<font style="color:red;">*</font>:</label>
			                    <input type="text" placeholder="" value="<?php echo $data[0]['inmates_booking_no']; ?>" id="bookingId" name="bookingId" class="inputw310">
			                </div>
			                <div class="input-group">
			                    <label>Confirm Booking No. (confirmar número de reserva)<font style="color:red;">*</font>:</label>
			                    <input type="text" placeholder="" value="<?php echo $data[0]['inmates_booking_no']; ?>" name="c_bookingId" class="inputw310">
			                </div>
			                <div class="input-group">
			                    <label>Facility (Instalaciones)<font style="color:red;">*</font>:</label>
			                    <select id="facility" name="facility" class="inputw310 facilityList">
			                        <option value="">Select Facility (Instalaciones)</option>
			                        <?php if(!empty($facility)) :?>
			                            <?php foreach($facility as $k => $v) :?>
			                                 <option <?php if($data[0]['facility_id'] == $v['id']){ ?> selected="selected" <?php } ?> value="<?php echo $v['id']?>">
			                                    <?php echo $v['name'];?>
			                                 </option>
			                            <?php endforeach; ?> 
			                        <?php endif; ?>    
			                    </select>
			                    <input type="hidden" name="id" value="<?php echo $data[0]['inmates_id']; ?>">
			                </div>
			                <div class="input-group">
			                     <div class="pd" id="submitDiv">
			                         <div class="signup-button-wrap2 fl-left">
			                            <button type="submit" class="transparent">
			                            	<span>Update Inmate</span>
			                            </button>
			                         </div>
			                         <div class="form-res"></div>
			                         <div class="clearfix"></div>
			                     </div>
			                     <div class="clearfix"></div>
			                </div>
			                <div class="clearfix"></div>
			            </div>
			            <div class="clearfix"></div>				       
			       <div class="clearfix"></div>
			    <?php echo form_close();?>				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#editInmatesForm').validate({
		rules : {
			name : {
				required : true
			},
			bookingId : {
				required : true
			},
			c_bookingId : {
				required : true,
				equalTo : '#bookingId'
			},
			facility : {
                required: true
            }
		},
		messages :{
            name : {
                required : "Name required"
            },
            bookingId : {
                required : "Booking number required"
            },
            c_bookingId : {
                required: "Please Enter Booking no. to confirm",
                equalTo: "Booking number must be same"
            },
            facility : {
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
	$('#editInmatesForm').ajaxForm({
        beforeSubmit : validateEditInmates,
        success :  validateEditInmates_res
    });

    function validateEditInmates(){
        return $('#editInmatesForm').valid();
    }
      
    function validateEditInmates_res(res){
       if(res){
           var parse = $.parseJSON(res);
           var status = parse.status;
           var message = parse.message;
           if(status == true){
              $('.form-res').css({'background-color':'#07c145','display':'inline'}).text(message).delay(3000).fadeOut("slow");
              $('#editInmatesForm')[0].reset();
              $('.chosen-single span').html('Select Facility');
              $('.chosen-select option').prop('selected', false).trigger('chosen:updated');
              window.history.back();
              // window.location.reload(true);
           }else{
              $('.form-res').css({'background-color':'#ea1e1e','color':'#E7080F'}).text(message).delay(3000).fadeOut("slow");
           }
       }
    }

});
</script>
<style type="text/css">
    .form-res {
        border-radius: 6px;
        margin-left: 145px;
        padding: 15px;
        text-align: center;
        width: 100%;
        color: #ffffff !important;   
    }
    .form-res p {padding: 4px;}
</style>