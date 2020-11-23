<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 jumbotron success-login-container clearfix">
				<div class="welcome-message">
				<?php  $userid= $this->uri->segment(2);?>
						<h1> You have been successfully registered. </h1><br>
						<!-- <h4>Please check your email for futher verification.
						If you have not received email, please check your junk or Spam folder.</h4> -->
						<h4>Please check your email for further verification and click on the URL to verify your <br/> account before you can start using it to send funds or photos. If you have not received a<br> verification email please check your spam or junk folder. Click here to <?php  echo "<span style='background-color: #ffffff;border-radius: 4px;'>". anchor('users/ressend_email/'.$userid.'', 'Re-send')."</span>";?> the<br> verification email.</h4>
						
				</div>
			</div>			
		</div>
	</div>
</div>

<!-- <h2 class="page-title" id="page_title"><?php echo lang('user:login_header') ?></h2>

<div class="success-box">
	<?php echo $this->lang->line('user:activated_message') ?>
</div>

<?php echo form_open('users/login', array('id'=>'login')) ?>
<ul>
	<li>
		<label for="email"><?php echo lang('global:email') ?></label>
		<?php echo form_input('email') ?>
	</li>
	
	<li>
		<label for="password"><?php echo lang('global:password') ?></label>
		<?php echo form_password('password') ?>
	</li>
	
	<li class="form_buttons">
		<input type="submit" value="<?php echo lang('user:login_btn') ?>" name="btnLogin" />
	</li>
</ul>
<?php echo form_close() ?> -->