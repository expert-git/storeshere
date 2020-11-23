<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="components">
				<div class="signup-title">
					<h1>
					<?php if ($data['result'] == '0') { ?>
						<?php if ($data['status'] == 'pending') { ?>
							Thank you. You will be required to respond to a text message or E-Mail to complete this payment. Please check your email which you submitted at time of transaction.
						<?php } else { ?>
							Congratulations! you've successfully made the payment.
						<?php } ?>
					<?php }
					else if($data['status'] == 'expire'){ ?>
						Sorry Session is expired!
					<?php }
					else if($data['status'] == 'decline'){ ?>
						Sorry your payment is declined please contact merchant!
					<?php }
					else if($data['status'] == 'cancel'){ ?>
						You order is successfully canceled. do you want to try again?
					<?php } ?>
					</h1>					
						<?php if($data['status'] == 'pending') { ?>				
						<div class="white_block">							
							<p>
								<label>Details are as follows : </label>
							</p>
							<div class="border2"></div>
							<p>
								<label>Your transaction id:</label><label><?php echo $data['order_id']; ?></label>
							</p>
							<p>								
								<label>Status:</label><label><?php echo $data['status']; ?></label>
							</p>
							<p>
								<label>Request number:</label><label><?php echo $data['requestno']; ?></label>
							</p>
						</div>
						<?php } ?>
					
				</div>

				<div class="options-box clearfix py-success">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="box">
	                    <div class="box-item">
	                        <a class="btn btn-primary" href="<?php echo base_url('sendFunds'); ?>">Click Here to send funds</a>
	                    </div>
	                </div>
				</div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                	<div class="box">
	                    <div class="box-item">
	                        <a class="btn btn-primary" href="<?php echo base_url('sendPhotos'); ?>">Click Here to send photos</a>
	                    </div>
	                </div>
                </div>
			</div>
			</div>
					
		</div>
	</div>
</div>
