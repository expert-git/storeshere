<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="components">
				<div class="signup-title">
					<h1>						
						Your payment was successfull.
					</h1>					
					<?php if(isset($data) && !empty($data)){ ?>						
						<div class="white_block">							
							<p>
								<label>Details are as follows : <?php //echo print_r($data); ?></label>
							</p>
							<div class="border2"></div>
							<p>
								<label>Your Order Id:</label><label>
								    <?php if($data->from == 'photos'){ echo "P";} else { echo "F";} ?>
								    
								    <?php echo $data->order_id; ?></label>
							</p>
							<p>
								<label>Sent By</label><label><?php echo $data->fname;?> <?php echo $data->lname;?></label>
							</p>
							<p>								
								<label>Amount submitted:</label><label>$ <?php echo $data->amount; ?> </label>
							</p>
							
							<p>
								<label>Sent Email</label><label><?php //echo $data->sent_by; ?>  <?php echo $data->sentby;?> </label>
							</p>
							<p>
								<label>Inmate Name</label><label><?php echo $data->sentto;?> </label>
							</p>
							<p style="display:none;">
								<label>Your PayPal Id:</label><label><?php echo $data->paypal_payer_id; ?></label>
							</p>
							<p>
								<label>PayPal Token:</label><label><?php echo $data->paypal_token; ?></label>
							</p>
							<?php if($data->from == 'photos'){ ?>
								<p>
									<label>Number of Photos</label><label><?php echo $data->no_of_photos; ?></label>
								</p>
							<?php } ?>
						</div>
                        <div class="signup-button-wrap2 fl-left">
                        	<?php
                        		$url =  base_url().'sendFunds';
                        		if($data->from == 'photos'){ 
                        			$url =  base_url().'sendPhotos';
                        		}
                        	?>
                            <!-- <a href="<?php echo $url; ?>" class="transparent">
                                <span class="back">
                                    Return Back
                                </span>
                            </a> -->
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
