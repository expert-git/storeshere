<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="components">
				<div class="signup-title">
					<h1>						
						You order is successfully canceled. do you want to try again?
					</h1>
				</div>
				<div class="white_block">							
					<p>
						<label>Details are as follows : </label>
					</p>
					<div class="border2"></div>
					<p>
						<label>Your transaction id:</label><label><?php echo $token; ?></label>
					</p>
					<p>								
						<label>Status:</label><label><?php echo "canceled" ?></label>
					</p>
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