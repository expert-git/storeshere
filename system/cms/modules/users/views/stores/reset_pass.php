<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        
        <div class="col-md-8 col-sm-8 col-xs-12" id="resetformDiv">
            <div class="content-widget">
				<?php echo form_open('setPassword', array('id' => 'setPassword','class'=>'signup horizontal-form')) ?>
                   <?php  echo form_hidden('id',$code)?>
                   <div class="components">
                        <div class="signup-title">
                            <h1>Reset Your Password</h1>
                        </div>
                        <div class="spacer10"></div>
                        <div class="groups">
                            <div class="input-group">
                                <label>New Password<font style="color:red;">*</font>:</label>
                                <input type="password" placeholder="" name="password" id="password1" class="inputw310" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <label>Confirm Password<font style="color:red;">*</font>:</label>
                                <input type="password" placeholder="" name="c_password" class="inputw310" autocomplete="off">
                            </div>
                            <div class="input-group">
                                 <div class="pd" id="submitDiv">
                                     <div class="signup-button-wrap2 fl-left">
                                        <!-- <input type="submit" value="Submit"> -->
                                      <button class="transparent" type="submit">
                                        <span> Submit</span>
                                     </div>


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

        <div class="col-md-8 col-sm-8 col-xs-12" id="loginformDiv" style="display:none;">
            <div class="content-widget">
                <?php echo form_open('users/login', array('id' => 'login2','class'=>'signup horizontal-form')) ?>
                   <div class="components">
                        <div class="signup-title">
                            <h1>Reset Password Successfully! Now You Can Login With Your New Password</h1>
                        </div>
                        <div class="spacer10"></div>
                        <!-- <div class="groups">
                            <div class="input-group">
                                <label>Enter Your Email<font style="color:red;">*</font>:</label>
                                <input type="email" placeholder="" name="email" id="email" class="inputw310" autocomplete="false">
                            </div>
                            <div class="input-group">
                                <label>Enter Password<font style="color:red;">*</font>:</label>
                                <input type="password" placeholder="" name="password" class="inputw310" autocomplete="off">
                            </div>
                            <div class="input-group">
                                 <div class="pd" id="submitDiv">
                                     <div class="signup-button-wrap2 fl-left">
                                        <!-- <input type="submit" value="Login"> -
                                         <button class="transparent" type="submit">
                                        <span> Login</span>
                                     </div>
                                     <div class="loginpage-res"></div>
                                     <div class="clearfix"></div>
                                 </div>
                                 <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div> -->
                        <div class="clearfix"></div>
                   </div>
                   <div class="clearfix"></div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>