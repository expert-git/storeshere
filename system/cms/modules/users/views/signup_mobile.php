<div class="container middle-content signupsucess">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="components">
				<div class="signup-title">
					<h1>
						You have been successfully registered .
						Please enter OTP which you have received in your registered phone number, for futher verification.
					</h1>					
				</div>
			</div>			
		</div>
	</div>
</div>
<div class="form-res email_error_n" id="status_div" style="display: none;">
   <p id="status"></p>
</div>

<div class="container middle-content">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <div class="form-title">
                    <span>Complete the verification step</span>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="content-widget">
				<?php //echo form_open('users/register', array('id'=>'register','class'=>'signup horizontal-form')) ?>

				<input type="hidden" name="user_id" value="<?php echo $this->uri->segment(2); ?>" id="user_id" />
                  
                   <div class="components signup-farm">
                        <div class="signup-title">
                            <h1>PLEASE COMPLETE THE VERIFICATION</h1>
                            <div class="info_pls_req"><span>*</span> (Mandatory fields)</div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="groups">
                            <div class="input-group label_width_sign">
                                <label class="label-signup" style="color:#fff;">Enter Otp<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" id="otp" name="otp" class="inputw310" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="margin-left: 10px;">
                            </div>
                            
                            <div class="input-group label_width_sign">
                                 <div class="pd" id="submitDiv">
                                     <div class="signup-button-wrap2 fl-left">
                                        <button type="submit" class="transparent" id="verify">
                                            <span>
                                                Verify
                                            </span>
                                        </button>                                        
                                     </div>
                                     <div class="form-res"></div>
                                     <div class="clearfix"></div>
                                 </div>
                                 <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                   </div>
                   <div class="clearfix"></div>
                <?php //echo form_close();?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#verify').on('click',function(){

        var otp = $('#otp').val();
        var user_id = $('#user_id').val();
        $.ajax({
            type : "POST",
            url : 'verifyOTP',
            data : {otp : otp,user_id:user_id},
            dataType:"json",
            success : function (data) {

            	$("#status_div").css("display","block");
            	
                if(data.status == true){

                	$("#status").html(''); 
                	$("#otp").val(''); 
                	$("#status_div").addClass("background");
                	$("#status").html(data.message); 

                	setTimeout(function(){ window.location.href="<?php echo site_url(); ?>"; }, 2000);

                }else{

                	$("#status").html(''); 
                	$("#status_div").removeClass("background");
                	$("#status").html(data.message);    
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});
</script>
<style type="text/css">
	#status_div{
		background-color: #e03e3e;
	}
	.background{
		background-color: green !important;
	}
</style>


