<section class="title">
   <h4><?php echo "Edit Facilities"//lang('user:list_title') ?></h4>
</section>

<section class="item">
   <div class="content">
   
      <div class="tabs">
   
         <ul class="tab-menu">
            <li><a href="#edit-facility-tab"><span>Edit Facility</span></a></li>
         </ul>
   
         <!-- Content tab -->
         <div class="form_inputs" id="edit-facility-tab">
            <?php echo form_open('admin/facility/editFacility','id=addFacilityForm') ?>
               <input type="hidden" name="id" value="<?php echo $facility['id'];?>">
               <fieldset>
                  <ul>
                     <li class="even">
                        <label for="name">Facility Name <span>*</span></label>
                        <div class="input">
                           <input type="text" name="name" value="<?php echo $facility['name'];?>" >
                        </div>
                     </li>
                     
                     <li>
                        <label for="address">Facility Address <span>*</span></label>
                        <div class="input">
                           <input type="text" name="address" value="<?php echo $facility['address'];?>" >
                        </div>
                     </li>
      
                     <li>
                        <label for="zip">Facility Zip <span>*</span></label>
                        <!--<div class="input">-->
                        <!--   <input type="text" id="postcode" value="<?php echo $facility['zip_code'];?>" name="postcode" onkeyup="getLocation()" onchange="getLocation()">-->
                        <!--</div>-->
                        <div class="input">
                           <input type="text" id="postcode" value="<?php echo $facility['zip_code'];?>" name="postcode">
                        </div>
                     </li>
                     
                     <li class="even">
                        <label for="city">City</label>
                        <div class="input">
                           <input type="text" id="city" value="<?php echo $facility['city'];?>" name="city">
                        </div>
                     </li>
                     <li class="even">
                        <label for="county">County</label>
                        <div class="input">
                           <input type="text" id="county" value="<?php echo $facility['county'];?>" name="county">
                        </div>
                     </li>
                     <li class="even">
                        <label for="state">State</label>
                        <div class="input">
                           <input type="text" id="state" value="<?php echo $facility['state'];?>" name="state">
                        </div>
                     </li>
                     <li class="even">
                        <label for="country">Country</label>
                        <div class="input">
                           <input type="text" id="country" value="<?php echo $facility['country'];?>" name="country">
                        </div>
                     </li>
                     <li class="even">
                        <label for="money">Accept Money</label>
                        <div class="input">Yes&nbsp;<input type="radio" name="money_option" value="1" <?php if($facility['money_option'] == 1){echo 'checked';}?> style="min-width: unset !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No&nbsp;<input type="radio" name="money_option" value="0" <?php if($facility['money_option'] == 0){echo 'checked';}?> style="min-width: unset !important;"></div>
                     </li>
                     <li class="even">
                        <label for="photo">Accept Photo</label>
                        <div class="input">Yes&nbsp;<input type="radio" name="photo_option" value="1" <?php if($facility['photo_option'] == 1){echo 'checked';}?> style="min-width: unset !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No&nbsp;<input type="radio" name="photo_option" value="0" <?php if($facility['photo_option'] == 0){echo 'checked';}?> style="min-width: unset !important;">
                        </div>

                        <div id="fund_params" <?php if($facility['money_option'] == 0){ ?> style="display:none;" <?php } ?> >
                            <div>
                                <h3>
                                    Set Fund Parameters
                                </h3>
                            </div>
                            <label>Select Processing fees </label>
                            <div class="input">
                                <input type="text" name="processing_fee" value="<?php echo $facility['processing_fee']; ?>" style="vertical-align: bottom;" />
                                <select name="fee_unit">
                                    <option value="1" <?php if($facility['fee_unit'] == 1){ echo 'selected="selected"';} ?> >Fixed Amount</option>
                                    <option value="2" <?php if($facility['fee_unit'] == 2){ echo 'selected="selected"';} ?> >Percentage(%)</option>
                                </select>
                            </div>
                            <label>Add min. and max. amount</label>
                            <div class="input">
                                <input type="text" name="amount" id="amount" readonly="">
                                <div id="slider-range" style="width : 38%;"></div>
                            </div>
                        </div>

                        <div id="photo_params" <?php if($facility['photo_option'] == 0){ ?> style="display:none;" <?php } ?> >
                           <div>
                              <h3>
                                 Set Photo Parameters
                              </h3>
                           </div>
                           <label>Photo Lab Email</label>
                            <div class="input">
                                <input type="text" name="photo_email" value="<?php echo $facility['photo_lab_email'];?>" />
                            </div>
                           <label>Max Photo upload Size (MB)</label>
                           <div class="input">
                              <input type="text" name="photo_size" value="<?php echo $facility['photo_size'];?>" />
                           </div>
                           <label>Max Photo resolution</label>
                           <div class="input">
                              <input type="text" name="photo_resolution" placeholder="e.g. 1024x768" value="<?php echo $facility['photo_resolution'];?>" />
                           </div>
                           <label>Max. no. of photos</label>
                           <div class="input">
                              <input type="text" name="no_of_photos" value="<?php echo $facility['no_of_photos'];?>" />
                           </div>
                           <label>Price per photo</label>
                           <div class="input">
                              <input type="text" name="photo_price" value="<?php echo $facility['price_per_photo'];?>" />
                           </div>
                           <label>Shipping Charge per instance</label>
                           <div class="input">
                              <input type="text" name="photo_shipping_price" value="<?php echo $facility['shipping_charge_per_photo'];?>" />
                           </div>
                        </div>

                     </li>
                  </ul>
                  <div class="buttons">
                     <button class="btn blue" value="add" name="btnAction" type="submit">
                        <span>Update Facility</span>
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
    var amount = "<?php echo $facility['amount']; ?>";    
    var min_amount = 1;
    var max_amount = 1000;    
    if(amount != ''){
        var split = amount.split('-');        
        min_amount = split[0].trim();
        max_amount = split[1].trim();        
    }

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
        values: [ min_amount, max_amount ],
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