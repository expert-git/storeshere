<div class="container middle-content">
	<div class="row">
		<div class="spacer20"></div>
		<div class="col-md-12 col-sm-12 col-xs-12">								
					<?php if(isset($from) && !empty($from)){ ?>
						<div class="col-md-12 jumbotron success-login-container clearfix">
							<?php 
								if($from == 'funds'){ 
									$text = 'Your funds were successfully transferred';
								}else{
									$text = 'Your photos were successfully transferred';
								}
							?>
							<div class="welcome-message">
		                        <!-- <h1>Your payment was successfull.</h1>  -->
		                        <h4><?php echo $text; ?></h4>   		                        
		                    </div>
							<div class="options-box">								
								<div class="box">
		                            <div class="box-item">
		                                <a href="<?php echo base_url('sendFunds'); ?>">
		                                    <div class="item-icon"><img width="125" height="125" src="<?php echo base_url($this->template->get_theme_path()).'/img/send_funds.jpeg'; ?>"/></div>
		                                    <div class="item-name">Send More funds to your inmate</div>
		                                </a>
		                            </div>
		                        </div>
		                        <div class="box">
		                            <div class="box-item">
		                                <a href="<?php echo base_url('sendPhotos'); ?>">
		                                    <div class="item-icon"><img width="125" height="125" src="<?php echo base_url($this->template->get_theme_path()).'/img/send_photos.jpeg'; ?>"/></div>
		                                    <div class="item-name">Send photos to your inmate</div>
		                                </a>
		                            </div>
		                        </div>
		                        <div class="box">
		                            <div class="box-item">
		                             	<?php if($from == 'funds'){ ?>
		                             		<a href="<?php echo base_url('funds_sent'); ?>">
			                                    <div class="item-icon"><img src="<?php echo base_url($this->template->get_theme_path()).'/img/send_photos.png'; ?>"/></div>
			                                    <div class="item-name">View All previously send funds </div>
			                                </a>
		                             	<?php }else{ ?>
		                             		<a href="<?php echo base_url('photos_sent'); ?>">
			                                    <div class="item-icon"><img src="<?php echo base_url($this->template->get_theme_path()).'/img/send_photos.png'; ?>"/></div>
			                                    <div class="item-name">View All previously send photos </div>
			                                </a>
		                             	<?php } ?>		                                
		                            </div>
		                        </div>								
							</div>
						</div>	
					<?php } ?>									
		</div>
	</div>
</div>
