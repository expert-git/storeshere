<script type="text/javascript">
    <?php if(isset($upload_result)): ?>
        alert('<?php echo $upload_result; ?>');
    <?php endif; ?>
</script>
<style type="text/css">
    .invoice-summary{
        table-layout: fixed;
        width: 100%;
    }
    #photo_facility_chosen{
        width: 300px !important;
    }
</style>
<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div id="photo_right_space" class="col-md-8 col-sm-8 col-xs-12 col-md-push-4 col-sm-push-4">
            <?php if(is_logged_in()) :?>
                 {{ theme:partial name="loginForms" }}
            <?php endif; ?>
            <?php if(empty($inmates)){ ?>
                <div class="col-md-12 jumbotron clearfix">
                    <h4 style="color: #FFF;">You haven't added any inmate(s) yet. Add an inmate to send photos.</h4>
                    <p style="color:#fff; font-size: 20px;" id="close-this"> 
                    <a class="showDiv btn btn-primary" href="javascript:void(0)" id="addInmates">Click Here</a> 
                    to add inmate(s) and start sending funds/photos to them.</p>
                    <span style="color:#fff; font-size:16px;">
                </div>
            <?php }else{ ?>
                    <div class="content-widget slideDiv" id="sendFundDiv">                
                        <?php echo form_open('uploadPhotos', array('id' => 'sendPhotosForm','class'=>'signup horizontal-form send-funds', 'enctype' => 'multipart/form-data')) ?>
                            <div class="components">
                                <div class="signup-title">
                                    <h1>TO SEND PHOTOS PLEASE COMPLETE THE FORM BELOW</h1>
                                </div>
                                <div class="spacer10"></div>
                                <div class="groups" id="tab1">
                                     <div class="input-group">
                                        <label class="photo-label">Facility (Instalaciones)<font style="color:red;">*</font>:</label>
                                        <select id="photo_facility" name="facility" class="inputw310 facilityList">
                                            <option value="0">SELECT FACILITY</option>
                                            <?php if(!empty($photoFacility)) :?>
                                                <?php foreach($photoFacility as $k => $v) :
												$selected =(isset($fd['facility']) && ($fd['facility'] == $v['id']))?'selected':'';
														?>
                                                     <option <?php echo $selected;?> data-photoSize="<?php echo $v['photo_size']; ?>" data-photoResolution="<?php echo $v['photo_resolution']; ?>" data-noOfPhotos="<?php echo $v['no_of_photos']; ?>" data-pricePerPhoto="<?php echo $v['price_per_photo']; ?>" data-shippingCharge="<?php echo $v['shipping_charge_per_photo']; ?>" value="<?php echo $v['id']?>">
                                                        <?php echo $v['name'];?>
                                                     </option>
                                                <?php endforeach; ?> 
                                            <?php endif; ?>    
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <label class="photo-label">Inmates Name (anombre del Reciouso)<font style="color:red;">*</font>:</label>
                                        <select id="inmate_select" name="name" class="inputw310 inmatesList">
                                            <option value="0">SELECT INMATE</option>
                                            <?php if($inmate_names): ?>
                                                <?php foreach($inmate_names as $in):
                                                $selected =(isset($fd['name']) && ($fd['name'] == $in['inmates_id']))?'selected':'';
                                                        ?>
                                                     <option <?php echo $selected;?> value="<?php echo $in['inmates_id']; ?>">
                                                <?php echo $in['inmates_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                     <div class="input-group">
                                        <label class="photo-label">Inmates Id Number (Reciouso Número de Id.)<font style="color:red;">*</font>:</label>
                                        <input type="text" class="inputw310" readonly="true" name="bookingNo" id="bookingNo" placeholder="Inmate Id Number" <?php if(isset($fd['bookingNo'])){?> value=<?php echo '"'.$fd['bookingNo'].'"'; } ?>>
                                    </div>
                                       <p id="photo_msg"></p>
                                    <div class="input-group" id="add_photo_div">
                                        <p id="label_upload" class="pd"></p>
                                        <label class="photo-label">Upload Photos (subir fotos):</label>
                                        <div class="btn_container_n">
                                            <a id="uploadMachine" href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="editPhoto();"> 
                                                Upload images to StoresHere
                                            </a>
                                            <span>&nbsp;OR&nbsp;</span>
                                            <button id="library"  type="button" class="btn btn-primary btn-lg">
                                                Select uploaded images to send
                                            </button>
                                            
    										<script>
    											function editPhoto(){
    												var fdata = $("#sendPhotosForm").serialize();
                                                    fdata = btoa(fdata);
    												window.location.href='<?php echo base_url('editPhotos'); ?>?data='+fdata;
    											}
    										</script>
                                        </div>
                                    </div>
                                    <div id="uploaded_thumbs">
                                    </div>
                                    <div class="input-group label_width pay" style="padding-bottom: 20px !important;">
                                        <label class="fund-label">Message<font style="color:red;">*</font>:</label>
                                        <div class="fund-div">
                                            <input type="radio" id="message_text" class="inputpay" name="message_medium" value="text"><label style="" for="message_text">Text message</label>
                                            <input style="margin-left: 10px;" type="radio" id="message_doc" class="inputpay" name="message_medium" value="doc">
                                            <label style="margin-left: -5px;" for="message_doc">Upload document</label>
                                        </div>
                                    </div> 
                                    <div class="input-group" id="text_message" style="display: none;">
                                        <label class="photo-label">Message (ingresar mensaje):</label>
                                        <textarea style="height:50px; width: 310px;" cols="35" id="message" name="message" placeholder="Enter message..."><?php if(isset($fd['message'])){ echo $fd['message']; } ?></textarea>
                                    </div>
                                    <!-- <div class="or_seperator">OR</div> -->

                                    <div class="input-group" style="display: none;" id="doc_message">
                                        <label class="photo-label">Upload Document (cargar documento):</label>
                                        <input type="file" name="doc" id="doc" style="width: 310px;" accept="text/plain, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        <div class="or_seperator supported-formats" style="margin-left: 260px;margin-top: 10px;">Supported formats are (doc, docx, pdf, txt)</div>
                                        
                                    </div>
                                    <div class="input-group label_width pay" style="padding-bottom: 20px !important;">
                                        <label class="fund-label">If not delievered:<font style="color:red;">*</font>:</label>
                                        <div class="fund-div">
                                            <input type="radio" id="return_msg" class="inputpay" name="return_sit" value="text"><label style="" for="return_msg">Return</label>
                                            <input style="margin-left: 10px;" type="radio" id="return_des" class="inputpay" name="return_sit" value="doc">
                                            <label style="margin-left: -5px;" for="return_des">Destroy</label>
                                        </div>
                                    </div> 
                                     <!-- <div class="input-group">
                                        <div class="or_seperator" style="margin-left: 160px;">If not delievered, return to:</div>
                                     </div> -->

                                    <div id="return_info" style="display: none;">
                                    <div class="input-group">
                                        <label class="photo-label">Name (Nombre)<font style="color:red;">*</font>:</label>
                                        <input type="text" class="inputw310 return_in" name="receipient_name" value="<?php if(isset($fd['receipient_name'])){ echo $fd['receipient_name']; } else{ echo $profile[0]['first_name']; } ?>" id="receipient_name" placeholder="Please Enter Returned to Receiver Name" maxlength="8" />
                                    </div>
                                    <div class="input-group">
                                        <label class="photo-label">Address (La dirección de la calle)<font style="color:red;">*</font>:</label>
                                        <textarea class="return_in" style="height:50px; width: 310px;" cols="35" name="address" placeholder="Please Enter Return Address"><?php if(isset($fd['message'])){ echo $fd['address']; } else { echo $profile[0]['street_address']; } ?></textarea><br>
                                    </div>
                                    <div class="input-group">
                                        <label class="photo-label">Zipcode (Código Postal)<font style="color:red;">*</font>:</label>
                                        <input type="text" class="inputw310 return_in" name="zipcode" placeholder="Please Enter your zipcode" value="<?php if(isset($fd['zipcode'])){ echo $fd['zipcode']; } else { echo $profile[0]['postcode']; } ?>" maxlength="8" />
                                    </div>
                                    <div class="input-group">
                                        <label class="photo-label">City (Ciudad)<font style="color:red;">*</font>:</label>
                                        <input type="text" class="inputw310 return_in" name="city" value="<?php if(isset($fd['city'])){ echo $fd['city']; } else { echo $profile[0]['city']; } ?>" placeholder="Please Enter your city"/>
                                    </div>
                                    <div class="input-group">
                                        <label class="photo-label">State (Estado)<font style="color:red;">*</font>:</label>
                                        <div class="country_cont">
                                        <input type="text" class="inputw310 return_in" name="state" value="<?php if(isset($fd['state'])){ echo $fd['state']; } else { echo $profile[0]['state']; } ?>" placeholder="Please Enter your state" />
                                        <label>Country: USA</label>
                                    </div>
                                    <!-- <div class="input-group">
                                        <label class="photo-label">Country (Pais)<font style="color:red;">*</font>:</label>
                                        <input type="text" class="inputw310 return_in" name="country" value="<?php if(isset($fd['country'])){ echo $fd['country']; } else { echo $profile[0]['country']; } ?>" placeholder="Please Enter your country" />
                                    </div> -->
                                    </div>
                                    </div>
                                    <div class="input-group label_width" id="return_dest" style="display: none;">
                                         <p class="pd t_C"><label><input name="destruction_clause" type="checkbox" id="destruct_cls" value="1"> I agree to the return of the package to the photo lab and authorize the lab for the destruction of the package.</label></p>
                                    </div>                                         
                                 <div class="input-group label_width pay">
                                        <label class="fund-label">Payment method<font style="color:red;">*</font>:</label>
                                        <div class="fund-div">
                                            <input type="radio" id="pay_method1" class="inputpay" name="pay_method" value="paypal" checked="checked"><label style="" for="pay_method1">Paypal</label>
                                            <input style="margin-left: 10px;display:none;" type="radio" id="pay_method2" class="inputpay" name="pay_method" value="genie">
                                            <label style="margin-left: -5px; color: #fff;display:none;" for="pay_method2">Genie Cashbox</label>
                                        </div>
                                    </div> 
                                    <!-- <div id="uploaded_thumbs">
                                    </div> -->
                              <div class="input-group label_width">
                                 <p class="pd t_C t_C2" style="display: inline-block; margin-right: 5px;padding: 0 0 0 204px;"><label><input name="accept" type="checkbox"> I agree to the terms &amp; conditions. <a href="<?php echo base_url(); ?>sendPhotos#" onclick="termsAndConditions()">
                                            Click to view  our terms and conditions
                                        </a></label></p>
                            </div>
                                    <div class="input-group">
                                         <div class="pd sbm-button">
                                             <div class="signup-button-wrap2 fl-left">
                                                <button type="button" id="continue" class="transparent">
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
                                        <table class="invoice-summary">
                                            <thead style="border-bottom: 1px solid #000;">
                                                <tr style="font-size: 1.5em; margin-bottom: 10px;">
                                                    <th>Quantity</th>
                                                    <th>Unit price (USD)</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 1.3em;">
                                                <tr style="text-align:center;">
                                                    <td><label class="no_of_photo"></label></td>
                                                    <td><label id="charge_per_photo"></label></td>
                                                    <td style="height: 5px !important;"><label id="total_photo_price"></label>(Charge per photo)</td>
                                                </tr>
                                                <tr style="text-align: center; height: 5px !important;">
                                                    <td><label class="no_of_photos"></label></td>
                                                    <td><label id="shipping_charge_per_photos"></label></td>
                                                    <td><label id="total_shipping_price"></label>(Shipping charge)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="total3 invoice-total_-"> <b><label>Total :</label> <label id="total_amount"><label></label></b>
                                    </div>
                                    <!-- <div class="emoji_wrap"> -->
                                        
                                    </div>

                                    <div style="display: none;" id="tab-2-btns" class="input-group clearfix">
                                        <div class="pd">
                                            <div class="signup-button-wrap2 fl-left">
                                                <button type="button" id="goback" class="transparent">
                                                  
                                                  <span class="back">
                                                        Go back
                                                    </span>
                                                </button>
                                            </div>
                                             <div class="signup-button-wrap2 fl-left">
                                                <button id="load-start" type="submit" class="transparent" >
                                                    <span>
                                                        Proceed to pay
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    

                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        <?php echo form_close();?>
                    </div>
                <?php } ?>
        </div>
        
        <div id="photo_left_nav" class="col-md-4 col-sm-4 col-xs-12 col-md-pull-8 col-sm-pull-8">
            <div class="content-widget">
               <div class="form-title">
                   <span id="sendFund" class="">Send Photos</span>
                   <!-- <h1>Send Funds to an Inmate</h1><p>PLEASE COMPLETE THE FORM BELOW</p> -->
               </div>

               <div class="spacer10"></div>
                <?php if(is_logged_in()) :?>
                    {{ theme:partial name="sidemenu" }}
                <?php endif; ?>
            </div>
        </div>


        <div class="clearfix"></div>
    </div>
</div>
<div id="emojidiv" style="display:none;">
    <ul>
        <?php foreach($emoji as $emo){ ?>
            <li>                
                <img class="emoji_select" src="<?php echo base_url($this->template->get_theme_path().'img/emoji/'.$emo); ?>" />
            </li>
        <?php } ?>
    </ul>
</div>
<div id="terms-conditions" style="display: none;">
    <h4>Terms and Conditions</h4>
    <br>

    <div>
        Effective Date: July 1st, 2017<br>
        Site Covered: www.storeshere.com<br>
        
        <span style = "font-size: 16px;">THE AGREEMENT</span>: The use of this website and services on this website provided by StoresHere.com (hereinafter referred to as "Company") are subject to the following Terms & Conditions (hereinafter the "Agreement"), all parts and sub-parts of which are specifically incorporated by reference here. This Agreement shall govern the use of all pages on this website (hereinafter collectively referred to as "Website") and any services provided by or on this Website ("Services").
        
        <h5>1) DEFINITIONS</h5>
        The parties referred to in this Agreement shall be defined as follows:
        <h6>a) </h6>Company, Us, We: The Company, as the creator, operator, and publisher of the Website, makes the Website, and certain Services on it, available to users. StoresHere.com, Company, Us, We, Our, Ours and other first-person pronouns will refer to the Company, as well as all employees and affiliates of the Company.
        <h6>b) </h6>You, the User, the Client: You, as the user of the Website, will be referred to throughout this Agreement with second-person pronouns such as You, Your, Yours, or as User or Client.
        <h6>c) </h6>Parties: Collectively, the parties to this Agreement (the Company and You) will be referred to as Parties.
        
        <h5>2) ASSENT & ACCEPTANCE</h5>
        By using the Website, You warrant that You have read and reviewed this Agreement and that You agree to be bound by it. If You do not agree to be bound by this Agreement, please leave the Website immediately. The Company only agrees to provide use of this Website and Services to You if You assent to this Agreement.
        
        <h5>3) LICENSE TO USE WEBSITE</h5>
        The Company may provide You with certain information as a result of Your use of the Website or Services. Such information may include, but is not limited to, documentation, data, or information developed by the Company, and other materials which may assist in Your use of the Website or Services ("Company Materials"). Subject to this Agreement, the Company grants You a non-exclusive, limited, non-transferable and revocable license to use the Company Materials solely in connection with Your use of the Website and Services. The Company Materials may not be used for any other purpose, and this license terminates upon Your cessation of use of the Website or Services or at the termination of this Agreement.
        
        <h5>4) INTELLECTUAL PROPERTY</h5>
        You agree that the Website and all Services provided by the Company are the property of the Company, including all copyrights, trademarks, trade secrets, patents, and other intellectual property ("Company IP"). You agree that the Company owns all right, title and interest in and to the Company IP and that You will not use the Company IP for any unlawful or infringing purpose. You agree not to reproduce or distribute the Company IP in any way, including electronically or via registration of any new trademarks, trade names, service marks or Uniform Resource Locators (URLs), without express written permission from the Company.
        <h6>a) </h6>In order to make the Website and Services available to You, You hereby grant the Company a royalty-free, non-exclusive, worldwide license to copy, display, use, broadcast, transmit and make derivative works of any content You publish, upload, or otherwise make available to the Website ("Your Content"). The Company claims no further proprietary rights in Your Content.
        <h6>b) </h6>If You feel that any of Your intellectual property rights have been infringed or otherwise violated by the posting of information or media by another of Our users, please contact Us and let Us know.
         
        <h5>5) USER OBLIGATIONS</h5>
        As a user of the Website or Services, You may be asked to register with Us. When You do so, You will choose a user identifier, which may be Your email address or another term, as well as a password. You may also provide personal information, including, but not limited to, Your name. You are responsible for ensuring the accuracy of this information. This identifying information will enable You to use the Website and Services. You must not share such identifying information with any third party, and if You discover that Your identifying information has been compromised, You agree to notify Us immediately in writing. Email notification will suffice. You are responsible for maintaining the safety and security of Your identifying information as well as keeping Us apprised of any changes to Your identifying information. Providing false or inaccurate information, or using the Website or Services to further fraud or unlawful activity is grounds for immediate termination of this Agreement.
        
        <h5>6) ACCEPTABLE USE</h5>
        You agree not to use the Website or Services for any unlawful purpose or any purpose prohibited under this clause. You agree not to use the Website or Services in any way that could damage the Website, Services, or general business of the Company.
        <h6>a)</h6> You further agree not to use the Website or Services:
        <h6>I)</h6> To harass, abuse, or threaten others or otherwise violate any person's legal rights;
        <h6>II) </h6>To violate any intellectual property rights of the Company or any third party;
        <h6>III) </h6>To upload or otherwise disseminate any computer viruses or other software that may damage the property of another;
        <h6>IV) </h6>To perpetrate any fraud;
        <h6>V) </h6>To engage in or create any unlawful gambling, sweepstakes, or pyramid scheme;
        <h6>VI) </h6>To publish or distribute any obscene or defamatory material;
        <h6>VII) </h6>To publish or distribute any material that incites violence, hate, or discrimination towards any group;
        <h6>VIII) </h6>To unlawfully gather information about others.
        
        <h5>7) PRIVACY INFORMATION</h5>
        Through Your Use of the Website and Services, You may provide Us with certain information. By using the Website or the Services, You authorize the Company to use Your information in the United States and any other country where We may operate.
        <h6>a)</h6> Information We May Collect or Receive: When You register for an account, You provide Us with a valid email address and may provide Us with additional information, such as Your name or billing information. Depending on how You use Our Website or Services, We may also receive information from external applications that You use to access Our Website, or We may receive information through various web technologies, such as cookies, log files, clear gifs, web beacons or others.
        <h6>b)</h6>How We Use Information: We use the information gathered from You to ensure Your continued good experience on Our website, including through email communication. We may also track certain aspects of the passive information received to improve Our marketing and analytics, and for this, We may work with third-party providers.
        <h6>c)</h6>How You Can Protect Your Information: If You would like to disable Our access to any passive information We receive from the use of various technologies, You may choose to disable cookies in Your web browser. Please be aware that the Company will still receive information about You that You have provided, such as Your email address. If You choose to terminate Your account, the Company will store information about You for the following number of days: 90. After that time, it will be deleted.
        <h5>8) SALES</h5>
        The Company may sell goods or services or allow third parties to sell goods or services on the Website. The Company undertakes to be as accurate as possible with all information regarding the goods and services, including product descriptions and images. However, the Company does not guarantee the accuracy or reliability of any product information, and You acknowledge and agree that You purchase such products at Your own risk.
        <h5>9) REVERSE ENGINEERING & SECURITY</h5>
        You agree not to undertake any of the following actions:
        <h6>a)</h6> Reverse engineer, or attempt to reverse engineer or disassemble any code or software from or on the Website or Services;
        <h6>b)</h6> Violate the security of the Website or Services through any unauthorized access, circumvention of encryption or other security tools, data mining or interference to any host, user or network.
        
        <h5>10) DATA LOSS</h5>
        The Company does not accept responsibility for the security of Your account or content. You agree that Your use of the Website or Services is at Your own risk.
        
        <h5>11) INDEMNIFICATION</h5>
        You agree to defend and indemnify the Company and any of its affiliates (if applicable) and hold Us harmless against any and all legal claims and demands, including reasonable attorney's fees, which may arise from or relate to Your use or misuse of the Website or Services, Your breach of this Agreement, or Your conduct or actions. You agree that the Company shall be able to select its own legal counsel and may participate in its own defense, if the Company wishes.
        
        <h5>12) SPAM POLICY</h5>
        You are strictly prohibited from using the Website or any of the Company's Services for illegal spam activities, including gathering email addresses and personal information from others or sending any mass commercial emails.
        
        <h5>13) THIRD-PARTY LINKS & CONTENT</h5>
        The Company may occasionally post links to third party websites or other services. You agree that the Company is not responsible or liable for any loss or damage caused as a result of Your use of any third party services linked to from Our Website.
        
        <h5>14) MODIFICATION & VARIATION</h5>
        The Company may, from time to time and at any time without notice to You, modify this Agreement. You agree that the Company has the right to modify this Agreement or revise anything contained herein. You further agree that all modifications to this Agreement are in full force and effect immediately upon posting on the Website and that modifications or variations will replace any prior version of this Agreement, unless prior versions are specifically referred to or incorporated into the latest modification or variation of this Agreement.
        <h6>a)</h6> To the extent any part or sub-part of this Agreement is held ineffective or invalid by any court of law, You agree that the prior, effective version of this Agreement shall be considered enforceable and valid to the fullest extent.
        <h6>b)</h6> You agree to routinely monitor this Agreement and refer to the Effective Date posted at the top of this Agreement to note modifications or variations. You further agree to clear Your cache when doing so to avoid accessing a prior version of this Agreement. You agree that Your continued use of the Website after any modifications to this Agreement is a manifestation of Your continued assent to this Agreement.
        <h6>c)</h6> In the event that You fail to monitor any modifications to or variations of this Agreement, You agree that such failure shall be considered an affirmative waiver of Your right to review the modified Agreement.
        
        <h5>15) ENTIRE AGREEMENT</h5>
        This Agreement constitutes the entire understanding between the Parties with respect to any and all use of this Website. This Agreement supersedes and replaces all prior or contemporaneous agreements or understandings, written or oral, regarding the use of this Website.
        
        <h5>16) SERVICE INTERRUPTIONS</h5>
        The Company may need to interrupt Your access to the Website to perform maintenance or emergency services on a scheduled or unscheduled basis. You agree that Your access to the Website may be affected by unanticipated or unscheduled downtime, for any reason, but that the Company shall have no liability for any damage or loss caused as a result of such downtime.
        
        <h5>17) TERM, TERMINATION & SUSPENSION</h5>
        The Company may terminate this Agreement with You at any time for any reason, with or without cause. The Company specifically reserves the right to terminate this Agreement if You violate any of the terms outlined herein, including, but not limited to, violating the intellectual property rights of the Company or a third party, failing to comply with applicable laws or other legal obligations, and/or publishing or distributing illegal material. If You have registered for an account with Us, You may also terminate this Agreement at any time by contacting Us and requesting termination. At the termination of this Agreement, any provisions that would be expected to survive termination by their nature shall remain in full force and effect.
        
        <h5>18) NO WARRANTIES</h5>
        You agree that Your use of the Website and Services is at Your sole and exclusive risk and that any Services provided by Us are on an "As Is" basis. The Company hereby expressly disclaims any and all express or implied warranties of any kind, including, but not limited to the implied warranty of fitness for a particular purpose and the implied warranty of merchantability. The Company makes no warranties that the Website or Services will meet Your needs or that the Website or Services will be uninterrupted, error-free, or secure. The Company also makes no warranties as to the reliability or accuracy of any information on the Website or obtained through the Services. You agree that any damage that may occur to You, through Your computer system, or as a result of loss of Your data from Your use of the Website or Services is Your sole responsibility and that the Company is not liable for any such damage or loss.
        
        <h5>19) LIMITATION ON LIABILITY</h5>
        The Company is not liable for any damages that may occur to You as a result of Your use of the Website or Services, to the fullest extent permitted by law. The maximum liability of the Company arising from or relating to this Agreement is limited to the greater of one hundred ($100) US Dollars or the amount You paid to the Company in the last six (6) months. This section applies to any and all claims by You, including, but not limited to, lost profits or revenues, consequential or punitive damages, negligence, strict liability, fraud, or torts of any kind.
        
        <h5>20) GENERAL PROVISIONS:</h5>
        <h6>a) LANGUAGE: </h6>All communications made or notices given pursuant to this Agreement shall be in the English language.
        <h6>b) JURISDICTION, VENUE & CHOICE OF LAW:</h6> Through Your use of the Website or Services, You agree that the laws of the State of California shall govern any matter or dispute relating to or arising out of this Agreement, as well as any dispute of any kind that may arise between You and the Company, with the exception of its conflict of law provisions. In case any litigation specifically permitted under this Agreement is initiated, the Parties agree to submit to the personal jurisdiction of the state and federal courts of the following county: Los Angeles, California. The Parties agree that this choice of law, venue, and jurisdiction provision is not permissive, but rather mandatory in nature. You hereby waive the right to any objection of venue, including assertion of the doctrine of forum non conveniens or similar doctrine.
        <h6>c) ARBITRATION: </h6>In case of a dispute between the Parties relating to or arising out of this Agreement, the Parties shall first attempt to resolve the dispute personally and in good faith. If these personal resolution attempts fail, the Parties shall then submit the dispute to binding arbitration. The arbitration shall be conducted in the following county: Los Angeles. The arbitration shall be conducted by a single arbitrator, and such arbitrator shall have no authority to add Parties, vary the provisions of this Agreement, award punitive damages, or certify a class. The arbitrator shall be bound by applicable and governing Federal law as well as the law of the following state: California. Each Party shall pay their own costs and fees. Claims necessitating arbitration under this section include, but are not limited to: contract claims, tort claims, claims based on Federal and state law, and claims based on local laws, ordinances, statutes or regulations. Intellectual property claims by the Company will not be subject to arbitration and may, as an exception to this sub-part, be litigated. The Parties, in agreement with this sub-part of this Agreement, waive any rights they may have to a jury trial in regard to arbitral claims.
        <h6>d) ASSIGNMENT:</h6> This Agreement, or the rights granted hereunder, may not be assigned, sold, leased or otherwise transferred in whole or part by You. Should this Agreement, or the rights granted hereunder, by assigned, sold, leased or otherwise transferred by the Company, the rights and liabilities of the Company will bind and inure to any assignees, administrators, successors, and executors.
        <h6>e) SEVERABILITY: </h6>If any part or sub-part of this Agreement is held invalid or unenforceable by a court of law or competent arbitrator, the remaining parts and sub-parts will be enforced to the maximum extent possible. In such condition, the remainder of this Agreement shall continue in full force.
        <h6>f) NO WAIVER: </h6>In the event that We fail to enforce any provision of this Agreement, this shall not constitute a waiver of any future enforcement of that provision or of any other provision. Waiver of any part or sub-part of this Agreement will not constitute a waiver of any other part or sub-part.
        <h6>g) HEADINGS FOR CONVENIENCE ONLY: </h6>Headings of parts and sub-parts under this Agreement are for convenience and organization, only. Headings shall not affect the meaning of any provisions of this Agreement.
        <h6>h) NO AGENCY, PARTNERSHIP OR JOINT VENTURE:</h6> No agency, partnership, or joint venture has been created between the Parties as a result of this Agreement. No Party has any authority to bind the other to third parties.
        <h6>i) FORCE MAJEURE:</h6> The Company is not liable for any failure to perform due to causes beyond its reasonable control including, but not limited to, acts of God, acts of civil authorities, acts of military authorities, riots, embargoes, acts of nature and natural disasters, and other acts which may be due to unforeseen circumstances.
        <h6>j) ELECTRONIC COMMUNICATIONS PERMITTED:</h6> Electronic communications are permitted to both Parties under this Agreement, including e-mail or fax. For any questions or concerns, please email Us at the following address: storeshere.com@gmail.com.

    </div>
</div>
<div id="library_content" style="display:none;">
    <h1 class="gallery_main_title"></h1>
    <?php if(!empty($photoLibrary)){ ?>
        <ul class="gallery_wrap">
        <?php foreach($photoLibrary as $pho => $lib){ ?>
            <?php $path = base_url('uploads/'.$this->current_user->id.'/photos/'.$lib['photo_name']); ?>
            <li>
                <div class="thumb">
                    <img id="delete-image" data-userid="<?php echo $this->current_user->id; ?>" data-img="<?php echo $lib['photo_name']; ?>" width="25" height="25" data-id="<?php echo $path; ?>" src="<?php echo base_url($this->template->get_theme_path()).'/img/close.png'; ?>">
                    <div class="thumb_inner">
                        <img data-imgname="<?php echo $lib['photo_name']; ?>" data-imgid="<?php echo $lib['id']; ?>" data-id="img<?php echo $pho; ?>" class="lib_images" src="<?php echo $path; ?>" />
                    </div>
                </div>
            </li>
        <?php } ?>
        </ul>        
    <?php } ?>
    <p class="gallery_sub_title">Done</p>
</div>
<div id="imagediv" style="display:none;"></div>
<input type="hidden" value="" id="canvas_id" />
<input type="hidden" value="<?php echo $v['no_of_photos']; ?>" id="noofphotos_input" />
<?php //print_r(base_url());die; ?>
<!-- <script type="text/javascript" src=""></script> -->
<style type="text/css">
.gallery_main_title {background-color: #1d99d7; position: inherit; font-size: 22px;color: #ffffff;margin: 0 0 10px 0; padding: 10px;}
.gallery_sub_title {background-color: #1d99d7; width: 70px; height: 30px; position: inherit; float: right; font-size: 18px;color: #ffffff;margin: 0 5px 10px 0; padding: 5px 5px 5px 17px; cursor: pointer;}
.gallery_wrap{display: table;width: 100%;}
.gallery_wrap li{width: 20%;display: inline-block;float: left;}
.gallery_wrap .thumb{position: relative;overflow: hidden;padding: 5px;}
.gallery_wrap .thumb .thumb_inner{position: relative;overflow: hidden;display: block;height: 120px;border:1px solid rgba(0,0,0,0.1);cursor:pointer;}
.gallery_wrap .thumb .thumb_inner img{display: table;height: 100%;width: auto;margin: 0 auto;vertical-align: middle;object-fit: contain;}
.gallery_wrap .thumb_inner.selected{border: 4px solid rgb(1, 189, 76);}
</style>
<script type="text/javascript">
    
$(document).ready(function(){
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    
    // if($(window).height() < 500 || $(window).width() < 400) {
        $('#uploadMachine').text("Upload from mobile");
        $('#uploadMachine').removeAttr('onclick');
        $('#uploadMachine').removeAttr('href');
        $('<form enctype="multipart/form-data" method="post" id="upload_photo" formnovalidate><input type="file" name="imgData" accept="image/*" id="phone_photo_up" style="display: none;"/></form>').insertAfter('#uploadMachine');

        var form = $('#upload_photo');
        var formData = new FormData();
        var fdata;
        $('#uploadMachine').click(function(){

            fdata = $("#sendPhotosForm").serialize();
            fdata = btoa(fdata);
            var validator = $( "#sendPhotosForm" ).validate();
            validator.destroy();
            $("input[id='phone_photo_up']").click();
        });
        $("input[id='phone_photo_up']").change(function() {
            formData.append('imgData', $('input[type=file]')[0].files[0]);
            $.ajax({
                url: 'https://www.storeshere.com/phoneImages',
                data: formData,
                type: 'POST',
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                var uploaded = parseInt((e.loaded / e.total) * 100);
                                $('#up').html(uploaded);
                            }
                        } , false);
                    }
                    return myXhr;
                },
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                success: function (data){
                    var d = JSON.parse(data);
                    console.log(d.status);
                    if(d.status == 1){
                        alert('Image uploaded successfully. Now you can select image from library.');
                        // location.reload();
                        window.location.href = window.location.href + "/" + fdata;
                    } else {
                        console.log(data);
                        alert('Some error occured! please try again.');
                    }
                },
                error: function (data){
                    console.log(data);
                    alert('Some error occured! please try again.');
                }
            });
            var box = $("html");
            var height = box.outerHeight();
            var h1 = box.innerHeight();
            var margin = (height/2) - 59;
            var html = '<div id="load"><div><img alt="" src="<?php echo base_url(); ?>system/cms/themes/storeshere/img/loading.gif"><p><span id="up"></span>% Uploading please wait . . . .</p></div></div>';
            box.append(html);
        });
    // }
}

    function setCookie(cname, cvalue) {
        console.log('set cookie');
        var d = new Date();
        d.setTime(d.getTime() + (5 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    $(document).on('click','#message_text',function(){
        $('#text_message').show();
        $('#doc_message').hide();
        $('#doc').val('');
        $('#doc').attr('disabled','disabled');
        $('#message').attr('disabled',false);
    });
    $(document).on('click','#message_doc',function(){
        $('#text_message').hide();
        $('#doc_message').show();
        $('#message').val('');
        $('#message').attr('disabled','disabled');
        $('#doc').attr('disabled',false);
    });

    $(document).on('click','#return_msg',function(){
        $('#return_info').show();
        $('#return_dest').hide();
        $('#destruct_cls').attr('checked', false);
        $('#destruct_cls').attr('disabled','disabled');
        $('#return_info').attr('disabled',false);
        $('.return_in').attr('disabled',false);
    });
    $(document).on('click','#return_des',function(){
        $('#return_info').hide();
        $('#return_dest').show();
        $('.return_in').attr('disabled','disabled');
        $('#destruct_cls').attr('disabled',false);
    });

    $(document).on('change','#pay_method1',function(){
        $('#sendPhotosForm').attr('action','<?php echo base_url(); ?>uploadPhotos');
    });

    $(document).on('change','#pay_method2',function(){
        $('#sendPhotosForm').attr('action','<?php echo base_url(); ?>upload_photos');
    });

   
    $(document).on('click','#load-start',function (){
        if($('#sendFundForm').valid()){
            var box = $("html");
            var height = box.outerHeight();
            var h1 = box.innerHeight();
            var margin = (height/2) - 59;
            var html = '<div id="load"><div><img alt="" src="<?php echo base_url(); ?>system/cms/themes/storeshere/img/loading.gif"><p>Please Wait . . . .</p></div></div>';
            box.append(html);
        }
        // $('#load').css('display','inline');
    });

    $(document).on('click','#library',function(){

        var photo_facility = $('#photo_facility').val();
		if(photo_facility == undefined || photo_facility == '' || photo_facility == 0){
			alert('Please select facility first!');
		}else{
			$.fancybox({
				href : '#library_content',
				autoDimensions : false,
				autoSize : false,
				width : 700,
				height : 'auto'
			});
	}
    });

    $(document).on('click','.lib_images',function(){
        var no_of_photos = $('#noofphotos_input').val();
        var totalDivs = $('div.selected').length;
        if($(this).parent().hasClass('selected')){
            totalDivs = totalDivs - 1;
            $(this).parent().removeClass('selected');
            var id = $(this).attr('data-id');
            $('#div_'+id).remove();
            $('#photoselected_'+id).remove();
            $('#photonameselected_'+id).remove();
        }else{
            totalDivs = totalDivs + 1;
            if(no_of_photos >= totalDivs){
                $(this).parent().addClass('selected');
                var src = $(this).attr('src');
                var id = $(this).attr('data-id');
                var photo_name = $(this).attr('data-imgname');
                var photo_id = $(this).attr('data-imgid');
                $('#uploaded_thumbs').append('<div id="div_'+id+'" class="uploaded-thumb"><div id="uploaded-close"><img id="'+id+'" src="<?php echo base_url($this->template->get_theme_path()).'/img/close.png'; ?>"></div><div class="uploaded-thumb-inner"><img id="'+id+'" src="'+src+'"/><input id="photoselected_'+id+'" type="hidden" name="photo_id[]" value="'+photo_id+'" /><input id="photonameselected_'+id+'" type="hidden" name="photo_name[]" value="'+photo_name+'" /></div></div>');
            }
        }
    });

    $(document).on('click','#uploaded-close',function(){
        console.log('here');
        // var no_of_photos = $('#noofphotos_input').val();
        // var totalDivs = $('div.selected').length;        
        // if($('.lib_images').parent().hasClass('selected')){
            // totalDivs = totalDivs - 1;
            var id = $(this).children().attr('id');
            $('img[data-id='+id+']').parent().removeClass('selected');
            $('#div_'+id).remove();
            $('#photoselected_'+id).remove();
            $('#photonameselected_'+id).remove();
        // }
    });




    $('.photoInput').val('');
    var photo_size = "";
    var photo_resolution = "";    
    var width = '';
    var height = '';    
    var no_of_photos = "";
    var price_per_photo = "";
    var shipping_charge_per_photo = "";

    $(document).on('click','#continue', function(){
        $('.signup-title').html('<h1>Package Summary</h1>');
        if($('#sendPhotosForm').valid()){       
            // var photos_uploaded = $('#sendPhotosForm input[type="file"].photoInput:empty');
            var photos_uploaded = $('#uploaded_thumbs img').length;
            total_photo_count = photos_uploaded;
            total_photo_count = total_photo_count / 2;
            // var total_photo_count = 0;
            // $.each(photos_uploaded, function(k,v){
            //     if($(v).val() != ''){
            //         total_photo_count++;
            //     }
            // });
            if(total_photo_count > 0){
                $('#photo_left_nav').hide();
                $('#photo_right_space').removeClass('col-md-8 col-sm-8 col-xs-12').addClass('col-md-12 col-sm-12 col-xs-12');
                $('#charge_per_photo').text(price_per_photo);
                $('#shipping_charge_per_photo').text(shipping_charge_per_photo);
                var total_price = (price_per_photo*parseFloat(total_photo_count))+(parseFloat(shipping_charge_per_photo));
                var total_price_limit = total_price.toFixed(2);
                var total_photo_price = price_per_photo*parseFloat(total_photo_count);
                var total_photoprice_limit = total_photo_price.toFixed(2);
                $('#total_amount').text(total_price_limit+' USD');
                $('.no_of_photo').text(total_photo_count);
                $('#total_photo_price').text(total_photoprice_limit);
                // $('#total_shipping_price').text(shipping_charge_per_photo*parseFloat(total_photo_count));
                $('#total_shipping_price').text(shipping_charge_per_photo);
                $('#tab1').hide();
                $('#tab2').show();
                $('#tab-2-btns').show();
            }else{
                alert('Please select at least one photo');
            }
        }
    });
    $(document).on('click','#goback', function(){
        $('#tab1').show();
        $('#tab2').hide();
        $('#tab-2-btns').hide();
        $('#photo_left_nav').show();
        $('#photo_right_space').addClass('col-md-8 col-sm-8 col-xs-12').removeClass('col-md-12 col-sm-12 col-xs-12');
    });

    $(document).on('click','#delete-image',function(){
        var path  = $(this).attr('data-id');
        var imageName  = $(this).attr('data-img');
        var r = confirm("Are you sure you want to delete this image?");
        if (r == true) {
            path = path.substring(35);
            $.post("/deleteImage",
            {
                path: path,
                imageName: imageName
            },
            function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
                if(data == 'done' && status == 'success'){
                    $('img[data-img="'+imageName+'"]').parent().parent().remove();
                }
            });
        } else {
            
        } 
    });

    $(document).on('change','#photo_facility',function(e){ 
        if($('#photo_facility option:selected').val() > 0){
			photo_size = $('#photo_facility option:selected').data('photosize');        
            photo_resolution = $('#photo_facility option:selected').data('photoresolution');
            var split = photo_resolution.split('x');
            width = split[0];
            height = split[1];
            no_of_photos = $('#photo_facility option:selected').data('noofphotos');
            $('#noofphotos_input').val(no_of_photos);
            var no_of_input_fields = $('#sendPhotosForm input[type="file"].photoInput').length;
            
           
            price_per_photo = $('#photo_facility option:selected').data('priceperphoto');
            shipping_charge_per_photo = $('#photo_facility option:selected').data('shippingcharge');        
            // var html = 'Max uploads : '+no_of_photos+' Max Dimension : '+photo_resolution+' Max Size : '+photo_size+' MB';
            $('.gallery_main_title').html('Maximum '+no_of_photos+' photos can be uploaded');

            // $('#label_upload').html(html);
            /*$('#library').removeAttr('disabled');*/
            <?php if(empty($photoLibrary)){?>
                $("#library_content").html('<h3>Looks like you don\'t have any pics in library. start adding them from <a id="uploadMachine" href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="editPhoto();">editor</a>.</h3>');
            <?php } ?>
            // test
            // $('#add_photo_div_inner').html('');
            // for (i = 0; i < no_of_photos; i++) {
            //     if(i == 0){
            //         var itemclass = '';
            //     }else{
            //         var itemclass = 'upload-item';                    
            //     }
            //     var btn_html = '<input type="hidden" name="editedphoto[]" id="img_save'+i+'"/><input data-id="'+i+'" type="file" style="width: 310px;" name="photo_file" id="photo'+i+'"  class="photoInput '+itemclass+'" /></div>'+'<div class="input-group photo_input_wrap"><textarea style="height:50px; margin-left: 4px; margin-top: 5px; width: 310px;" cols="35" id="msg_photo'+i+'" name="msg[]" class="getData upload-item" placeholder="Enter Photo Content"></textarea>';
            //     $('#add_photo_div_inner').append(btn_html);
            // } 
        }else{
            /*$('#library').attr('disabled','disabled');*/
            $('#noofphotos_input').val(0);
        }
    });

    <?php if(isset($fd)){ ?>
        $( "#photo_facility" ).trigger( "change" )
    <?php } ?>

    $('.gallery_sub_title').on('click',function(){
        $.fancybox.close();
    })

    $('#sendPhotosForm').validate({
        ignore:':hidden:not("select")',
        rules : {
            facility : {
                required : true,
                checkValue : 0
            },
            name : {
                required : true,
                checkValue : 0
            },
            bookingNo : {
                required : true
            },
            // photo_file : {
            //     required : true,
            //     extension : 'jpg|jpeg|png|gif'                
            // },
            message_medium : {
                required : true
            },
            message : {
                required : true
            },
            return_sit : {
                required : true
            },
            pay_method : {
                required : true
            },
            accept : {
                required : true
            },
            doc : {
                required : true,
                extension : 'doc|docx|txt|pdf'
            },
            address : {
                required : true
            },
            city : {
                required : true
            },
            state : {
                required : true
            },
            zipcode : {
                required : true,
                minlength: 5,
                maxlength: 8
            },
            country : {
                required :true
            },
            destruction_clause : {
                required : true
            }
        },
        messages : {
            facility : {
                required : "Please Select Facility",
                checkValue : "Please Select Facility"
            },
            name : {
                required : "Please Select Inmate Name",
                checkValue : "Please Select Inmate Name"
            },
            bookingNo : {
                required: "Please Enter ID number"
            },
            // photo_file : {
            //     required : 'Photo is required',
            //     extension : 'Only jpg,gif,png formats allowed'
            // },
            accept : {
                required : "Please Accept terms and conditions"
            },
            doc : {
                required : "Please upload document",
                extension : "Only doc / docx / pdf / txt files allowed"
            },
            address : {
                required : "Please Enter Address"
            },
            city : {
                required : "Please Enter City"
            },
            state : {
                required : "Please Enter State"
            },
            message_medium : {
                required : "Please select a message mode"
            },
            message : {
                required : "Please enter message"
            },
            return_sit : {
                required : "Please select what do you want if not delivered"
            },
            pay_method : {
                required : "Please select payment method"
            },
            zipcode : {
                required : "Please Enter Zipcode",
                minlength: "Only 5 to 8 numbers allowed",
                maxlength: "This field contain only 8 characters"
            },
            country : {
                required :"Please Enter Country"
            },
            destruction_clause : {
                required : "Please Accept the clause"
            }
        },
        showErrors: function(errorMap, errorList) {
            jQuery.each(this.validElements(), function (index, element) {
                var $element = jQuery(element);                
                $element.closest('.input-group').find('.error_box').remove();                
            });
            jQuery.each(errorList, function (index, error) {
                var $element = jQuery(error.element);                
                var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+error.message+"</p></div>";
                if($element.closest('.input-group').find('.error_box').length >= 1){
                   $element.closest('.input-group').find('.error_box').remove();
                }
                $element.closest('.input-group').append(errortext);
            });
        }
    });


    jQuery.validator.addMethod("checkValue", function(value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

    $(document).on('change',".photoInput",function(){
        var id = $(this).attr('data-id');
        readURL(this,id);
    });

    //  $(document).on('change',"#.getData",function(){
    //     var msg = $(this).val();
    //     $('.msg_photo').val(msg);
    // });
    
    function readURL(input,id) {        
        if (input.files && input.files[0]) {
            if(checkImageformat(input.files)){
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);                
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function () {
                        //Determine the Height and Width.
                        var img_height = this.height;
                        var img_width = this.width;
                        if (img_height > height || img_width > width) {
                            var msg = 'file dimension should not be more than '+ photo_resolution
                            showError(input,msg);
                            $('#photo'+id).val('');
                             $('#img_save'+id).val(image.src);
                            return false;
                        }else if(input.files[0].size > parseFloat(photo_size)*1000000){
                            var msg = 'file size should be less than '+photo_size+' MB.'
                            showError(input,msg);
                            $('#photo'+id).val('');
                            $('#img_save'+id).val(image.src);
                            return false;
                        }
                        // createCanvas(image,id);
                        // initiateEditor(image,id);
                        console.log(id);
                        $('#img_save'+id).val(image.src);
                        return true;
                    };
                };                                                
            }else{
                showError();
            }
        }
    }
     function checkImageformat(file){
        var filename = file[0].name;
        var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
        if(valid_extensions.test(filename)){
            return true;
        }else{
            return false;
        }        
    }

    function getLocation(){
        var value = $('#postcode').val();
        console.log(value);
        if(value >= 5 && value.length >= 5){
            getAddressInfoByZip(value);
        }else{
           $('#city').val('');
           $('#state').val('');
           $('#country').val('');
        }
    } 

    function getAddressInfoByZip(zip){
      if(zip.length >= 5 && typeof google != 'undefined'){
            var addr = {};
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': zip }, function(results, status){
                if (status == google.maps.GeocoderStatus.OK){
                    if (results.length >= 1) {
                        for (var ii = 0; ii < results[0].address_components.length; ii++){
                            var street_number = route = street = city = state = zipcode = country = formatted_address = '';
                            var types = results[0].address_components[ii].types.join(",");
                            if (types == "street_number"){
                              addr.street_number = results[0].address_components[ii].long_name;
                            }
                            if (types == "route" || types == "point_of_interest,establishment"){
                              addr.route = results[0].address_components[ii].long_name;
                            }
                            if (types == "sublocality,political" || types == "locality,political" || types == "neighborhood,political" || types == "administrative_area_level_3,political"){
                              addr.city = (city == '' || types == "locality,political") ? results[0].address_components[ii].long_name : city;
                            }
                            if (types == "administrative_area_level_1,political"){
                              addr.state = results[0].address_components[ii].short_name;
                            }
                            if (types == "postal_code" || types == "postal_code_prefix,postal_code"){
                              addr.zipcode = results[0].address_components[ii].long_name;
                            }
                            if (types == "country,political"){
                              addr.country = results[0].address_components[ii].long_name;
                            }
                        }
                        addr.success = true;
                        response(addr);
                    }else{
                      response({success:false});
                    }
                } else {
                    response({success:false});
                }
            });
      }else{
        response({success:false});
      }

    }

    $(document).on('click','#ret_add_my', function(){
        $('ret_address_pt').slideUp('slow');
    });

    $(document).on('click','#ret_add_ot', function(){
        $('ret_address_pt').slideDown('slow');
    });

    function response(obj){
        if(obj.success){
            var city = obj.city;
            var state = obj.state;
            var country = obj.country;
            // if(country == 'United States'){
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
            // }else{
            //     return false;
            // }        
        }else{
          return false;
        }
    }

    // $(document).on('click','#library',function () {
    //     if(!$('#photo_facility').is(':selected')){
    //         alert('Please select facility first');
    //         return;
    //         throw new Error("my error message");
    //     }
    // })

    function showError(element,msg){
        element = $(element);
        var errortext = "<div class=\'error_box\'><p class=\'error_text\'>"+msg+"</p></div>";
        if(element.closest('.input-group').find('.error_box').length >= 1){
           element.closest('.input-group').find('.error_box').remove();
        }
        element.closest('.input-group').append(errortext);
    }

    function initiateEditor(image){
        console.log(image);
    }

    $(document).on('click','.uploaded-thumb-inner',function(){
        var href = $(this).children().attr('src');
        $.fancybox({
            href : href,
            autoDimensions : false,
            autoSize : false,
            width : 700,
            height : 'auto'
        });
    });

});
</script> 
<style>
.canvas-container {background-color: white !important;}
</style>
