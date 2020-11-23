<div class="form-res" style="display: none !important;"></div>
<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>

        <?php if ( ! empty($error_string)):?>
          <!-- Woops... -->
          <div class="error-box">
             <?php echo $error_string;?>
         </div>
     <?php endif;?>

     <div class="col-md-8 col-sm-8 col-xs-12 col-md-push-4 col-sm-push-4">
        <?php if(is_logged_in()) :?>
           {{ theme:partial name="loginForms" }}
       <?php endif; ?>

       <div class="content-widget slideDiv" id="contactDiv">
        <?php echo form_open('users/contact', array('id' => 'contactForm','class'=>'signup horizontal-form')) ?>
        <div class="components">
            <div class="signup-title">
                <h1>PLEASE COMPLETE THE FORM BELOW</h1>
            </div>
            <div class="spacer10"></div>
            <div class="groups">
                <input type="hidden" id="captcha_val" value="">
                <div class="input-group">
                    <label>Name (Nombre)<font style="color:red;">*</font> :</label>
                    <input type="text" placeholder="" name="name" class="inputw310">
                </div>
                <div class="input-group">
                    <label>Email (Dirección de Email)<font style="color:red;">*</font> :</label>
                    <input type="text" placeholder="" id="email" name="email" class="inputw310" autocomplete="off">
                </div>
                <div class="input-group">
                    <label>Phone (Teléfono Celular)<font style="color:red;">*</font> :</label>
                    <input type="text" autocomplete="off" placeholder="e.g : (123) 456-7890" id="mobile" name="mobile" class="inputw310">
                </div>
                <div class="input-group">
                    <label>Subject (tema)<font style="color:red;">*</font> :</label>
                    <select name="subject" class="inputw310">
                        <option value="0">Select Subject</option>
                        <option value="Contact Us">Contact Us</option>
                        <option value="Enquiry For Franchisee">Enquiry For Franchisee</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Message (mensaje):</label>
                    <textarea name="message" class="inputw310" style="min-height:100px;"></textarea>
                </div>

                <div class="input-group">

                    <label class="col-md-6" style="padding-left: 0;">Varify you are a human:</label>

                    <div class="col-md-6 row">
                        <div class="g-recaptcha" data-sitekey="6LejsJoUAAAAAL7N99OYrDr9awvcChpGf2ukhdi_"></div>
                        <div class="error_box recaptcha_error_div" style="display: none;"><p class="error_text">Please confirm captcha to proceed</p></div>                        
                    </div>
                </div>
                <div class="input-group">
                   <div class="pd" id="submitDiv">
                       <div class="signup-button-wrap2 fl-left">
                        <button type="submit" class="transparent">
                            <span>
                                Submit
                            </span>
                        </button>                                        
                    </div>
                    <!-- <div class="form-res"></div> -->
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <?php echo form_close();?>
</div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12 col-md-pull-8 col-sm-pull-8">
    <div class="content-widget">
        <div class="form-title">
            <span id="contact" class="showDiv">Contact Us</span>
        </div>
        <!-- <h1 class="easy-title"><span>Fill This Form We Contact You Soon</span></h1> -->
        <div class="spacer10"></div>


        <?php if(is_logged_in()) :?>
            {{ theme:partial name="sidemenu" }}
        <?php endif; ?>
    </div>
</div>


</div>
<div class="clearfix"></div>
</div>
<style type="text/css">
    .form-res {
        background-color: #07c145;
        border-radius: 6px;
        margin-left: 145px;
        padding: 15px;
        text-align: center;
        width: 100%;
        color: #ffffff !important;   
    }
    .form-res p {padding: 4px;}
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    $('.mobile-menu-icons').click(function(){
        if($('.mobile-menu-icons').parent().data('tab') == 'tab-1'){
            if($('#tab-1').hasClass('current')) {
                $('#tab-1').attr('class','menu-slider');
            } else {
                $('#tab-1').attr('class','menu-slider current');
            }
        }
    });
    $('#heds').click(function(){
        if($('#tab-2').hasClass('current')) {
            $('#tab-2').attr('class','menu-slider');
        } else {
            $('#tab-2').attr('class','menu-slider current');
        }
    });
</script>