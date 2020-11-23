<link rel="stylesheet" type="text/css" href="<?php echo base_url().$this->template->get_theme_path();?>css/admin/switchery.css">
<section class="title">
	<h4><?php echo "Facilities"//lang('user:list_title') ?></h4>
</section>

<section class="item">
	<div class="content">
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#facility-list-tab" id="showFacilitylist"><span>Facility Listing</span></a></li>
				<li><a href="#add-facility-tab"><span>Add Facility</span></a></li>
			</ul>
	
			<!-- Content tab -->
			<div class="form_inputs" id="facility-list-tab">
				<fieldset>
					<?php template_partial('filters') ?>
	
					<?php echo form_open('admin/users/action') ?>
					
						<div id="filter-stage">
							<?php template_partial('tables/facility') ?>
						</div>
					
						<!-- <div class="table_action_buttons">
							<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
						</div> -->
				
					<?php echo form_close() ?>
				</fieldset>
			</div>
	
			<div class="form_inputs" id="add-facility-tab">
	        	<?php echo form_open('admin/facility/addFacility','id=addFacilityForm') ?>
					<fieldset>
						<ul>
							<li class="even">
								<label for="name">Facility Name <span>*</span></label>
								<div class="input">
									<input type="text" name="name">
								</div>
							</li>

							<!-- <li class="even">
								<label for="name">Facility Email <span>*</span></label>
								<div class="input">
									<input type="email" name="email">
								</div>
							</li> -->


							
							<li>
								<label for="address">Facility Address <span>*</span></label>
								<div class="input">
									<input type="text" name="address">
								</div>
							</li>
		
							<li>
								<label for="zip">Facility Zip <span>*</span></label>
								<!--<div class="input">-->
								<!--	<input type="text" id="postcode" name="postcode" onkeyup="getLocation()" onchange="getLocation()">-->
								<!--</div>-->
								<div class="input">
									<input type="text" id="postcode" name="postcode">
								</div>
							</li>
							
							<li class="even">
								<label for="city">City</label>
								<div class="input">
									<input type="text"  id="city" name="city">
								</div>
							</li>
							<li class="even">
								<label for="county">County</label>
								<div class="input">
									<input type="text"  id="county" name="county">
								</div>
							</li>
							<li class="even">
								<label for="state">State</label>
								<div class="input">
									<input type="text" id="state" name="state">
								</div>
							</li>
							<li class="even">
								<label for="country">Country</label>
								<div class="input">
									<input type="text" id="country" name="country">
								</div>
							</li>
							<li class="even">
								<label for="money">Accept Money</label>
								<div class="input">Yes&nbsp;<input type="radio" name="money_option" value="1" checked="true" style="min-width: unset !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								No&nbsp;<input type="radio" name="money_option" value="0" style="min-width: unset !important;"></div>
							</li>
							<li class="even">
								<label for="photo">Accept Photo</label>
								<div class="input">Yes &nbsp;<input type="radio" name="photo_option" value="1" checked="true" style="min-width: unset !important;" media="screen">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								No&nbsp;<input type="radio" name="photo_option" value="0" style="min-width: unset !important;"></div>
								<div id="fund_params">
									<div>
										<h3>
											Set Fund Parameters
										</h3>
									</div>
									<label>Select Processing fees</label>
									<div class="input">
										<input type="text" name="processing_fee" style="vertical-align: bottom;" />
										<select name="fee_unit">
											<option value="1">Fixed Amount</option>
											<option value="2">Percentage(%)</option>
										</select>
									</div>
									<label>Add min. and max. amount</label>
									<div class="input">
										<input type="text" name="amount" id="amount" readonly="">
										<div id="slider-range" style="width : 38%;"></div>
									</div>
								</div>
								<div id="photo_params">
									<div>
										<h3>
											Set Photo Parameters
										</h3>
									</div>
									<label>Photo Lab Email</label>
									<div class="input">
										<input type="text" name="photo_email" />
									</div>
									<label>Max Photo upload Size (MB)</label>
									<div class="input">
										<input type="text" name="photo_size" />
									</div>
									<label>Max Photo resolution</label>
									<div class="input">
										<input type="text" name="photo_resolution" placeholder="e.g. 1024x768" />
									</div>
									<label>Max. no. of photos</label>
									<div class="input">
										<input type="text" name="no_of_photos" />
									</div>
									<label>Price per photo</label>
									<div class="input">
										<input type="text" name="photo_price" />
									</div>
									<label>Shipping Charge per instance</label>
									<div class="input">
										<input type="text" name="photo_shipping_price" />
									</div>
								</div>

							</li>
						</ul>
						<div class="buttons">
							<button class="btn blue" value="add" name="btnAction" type="submit">
								<span>Add Facility</span>
							</button>
							<div class="form-res"></div>
						</div>
					</fieldset>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript">
$(document).ready(function(){
	// photo_params
	if($('input[name="photo_option"]:checked').val() == 1){
		$('#photo_params').show();
	}else{
		$('#photo_params').hide();
	}
	if($('input[name="money_option"]:checked').val() == 1){
		$('#fund_params').show();
	}else{
		$('#fund_params').hide();
	}

	$(document).on('click','input[name="photo_option"]', function(){
		if(this.value == 1){
			$('#photo_params').show();
		}else{
			$('#photo_params').hide();
		}
	});
	$(document).on('click','input[name="money_option"]', function(){    
      if(this.value == 1){
         $('#fund_params').show();
      }else{
         $('#fund_params').hide();
      }
   });

	$( "#slider-range" ).slider({
    	range: true,
     	min: 1,
      	max: 1000,
      	values: [ 1, 300 ],
      	slide: function( event, ui ) {
        	$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      	}
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );

});
</script>
<style type="text/css">
.error_text {color: red;font-size: 13px;font-weight: bold;}
.form-res {float: right;font-size: 15px;font-weight: bold;margin-right: 8%;}
</style>