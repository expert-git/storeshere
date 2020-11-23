<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
               <div class="form-title">
                   <span id="sendFund" class="showDiv">Send Funds</span>
                   <!-- <h1>Send Funds to an Inmate</h1><p>PLEASE COMPLETE THE FORM BELOW</p> -->
               </div>

               <div class="spacer10"></div>
                <?php if(is_logged_in()) :?>
                    {{ theme:partial name="sidemenu" }}
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <?php if(is_logged_in()) :?>
                 {{ theme:partial name="loginForms" }}
            <?php endif; ?>

            <div class="content-widget slideDiv" id="sendFundDiv">
                <!-- echo form_open($paypalURL, array('id' => 'sendFundForm','class'=>'signup horizontal-form send-funds')) -->
                <?php echo form_open('payThroughPaypal', array('id' => 'sendFundForm','class'=>'signup horizontal-form send-funds')) ?>
                    <div class="components">
                        <div class="signup-title">
                            <h1>PLEASE COMPLETE THE FORM BELOW</h1>
                        </div>
                        <div class="spacer10"></div>
                        <div class="groups" id="tab1">
                             <div class="input-group label_width">
                                <label class="fund-label">Facility (Instalaciones)<font style="color:red;">*</font>:</label>                                
                                <select name="facility" class="inputw310 facilityList">
                                    <option value="0">SELECT FACILITY</option>
                                    <?php if(!empty($moneyFacility)) :?>
                                        <?php foreach($moneyFacility as $k => $v) :?>
                                             <option value="<?php echo $v['id']?>">
                                                <?php echo $v['name'];?>
                                             </option>
                                        <?php endforeach; ?> 
                                    <?php endif; ?>    
                                </select>
                            </div>
                            <div class="input-group label_width" >
                                <label class="fund-label">Inmates Name (anombre del Reciouso):</label>
                                <select name="name" class="inputw310 inmatesList">
                                    <option value="">SELECT INMATE</option>
                                </select>
                            </div>
                             <div class="input-group label_width">
                                <label class="fund-label">Inmates ID Number(Reciouso Número de Id.):</label>
                                <input type="text" class="inputw310" name="bookingNo" id="bookingNo" placeholder="Enter Inmate Booking Number">
                            </div>
                            <div class="input-group label_width">
                                <label class="fund-label">Enter Amount (Introducir importe):</label>
                                <input type="text" id="amount" class="inputw310" name="amount" placeholder="Enter Amount in Dollar" autocomplete="off">
                            </div>                            
                            <div class="input-group label_width">
                                <p class="pd" style="display: inline-block; margin-right: 5px;">
                                    <span>
                                        <a href="javascript:void(0);">
                                            Click to View  Our Terms and Conditions
                                        </a>
                                    </span>
                                </p>
                            </div>                            
                            <div class="input-group label_width">
                                 <p class="pd" style="display: inline-block; margin-right: 5px;"><label><input type="radio" name="accept"> I have read the terms &amp; conditions and agree.</label></p>
                            </div>
                            <div class="input-group label_width">
                                 <div class="pd">
                                     <div class="signup-button-wrap2 fl-left">

                                        <input type="hidden" name="cmd" value="_xclick">
                                        <input type="hidden" name="upload" value="1">
                                        <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
                                        <input type="hidden" name="currency_code" value="USD">                                        
                                        <!-- Specify URLs -->
                                        <input type='hidden' name='cancel_return' value='<?php echo base_url();?>paypal_cancel'>
                                        <input type='hidden' name='return' value='<?php echo base_url();?>paypal_success'>
                                        <button class="transparent" type="button" id="continue">
                                            <span>
                                                Continue
                                            </span>
                                        </button>                                                                                    
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>                                            
                        </div>

                        <div class="groups" id="tab2" style="display:none;">
                            <div class="white_block">
                                <!-- <p><label>&nbsp;</label><label>Heading1</label><label>Heading2</label></p> -->
                                <div class="border2"></div>
                                
                                <p><label>Amount submitted:</label> <label id="org_amount"></label></p>
                                <p><label id="_unit">Processing Fees:</label> <label id="proc_amount"></label></p>
                                
                                <p class="total3"> <b><label>Total :</label> <label id="total_amount"><label></label></b>
                                
                            </div>
                            <div class="signup-button-wrap2 fl-left">
                                <button type="button" id="goback" class="transparent">
                                    <span class="back">
                                        Go back
                                    </span>
                                </button>
                            </div>
                             <div class="signup-button-wrap2 fl-left">
                                <button type="submit" class="transparent" >
                                    <span>
                                        Proceed to pay
                                    </span>
                                </button>
                            </div> 
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div id="price-data"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#amount').val('');
        $('.inmatesList').val('');
        $('.facilityList').val('');
    });

    $(document).on('click','#continue', function(){
        if($('#sendFundForm').valid()){
            $('#tab1').hide();
            $('#tab2').show();
        }
    });
    $(document).on('click','#goback', function(){
        $('#tab1').show();
        $('#tab2').hide();
    });

    $(document).on('click', '#continue', function(){
        var finalAmount = '';
        var data = $("#price-data");
        var fees = parseInt(data.attr('data-fee'));
        var amount = parseInt($('#amount').val());
        var unit = data.attr('data-unit'); //1:fixed, 2:percentage        
        var fees_text = fees+' USD';
        if(unit == 1){
            finalAmount = parseInt(amount) + fees;
            $('#_unit').text('Processing Fees:');
        }else{
            var fee = (fees/100) * parseInt(amount);
            finalAmount = parseInt(amount) + parseFloat(fee.toFixed(2));
            fees_text = fee.toFixed(2)+' USD';
            $('#_unit').text('Processing Fees ('+fees+'%):');
        }
        $('#org_amount').text(amount+' USD');
        $('#proc_amount').text(fees_text);
        $('#total_amount').text(finalAmount+' USD');
    });
</script>