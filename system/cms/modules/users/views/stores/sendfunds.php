<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-title">
               <span id="sendFund" class="showDiv">Send Funds</span>
               <!-- <h1>Send Funds to an Inmate</h1><p>PLEASE COMPLETE THE FORM BELOW</p> -->
           </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="content-widget">
                       
                       <div class="spacer10"></div>
                       <?php if(is_logged_in()) :?>
                        {{ theme:partial name="sidemenu" }}
                    <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                    <h2 class="easy-title-funds">Inmate Money</h2>
                    <p class="desc-funds">Money may be deposited into an inmate's account. Inmates may use the money to purchase snacks, hygiene items, phone cards, and writing materials. Inmates may also use the money for co-payments if they request medical, non-emergency services</p>
                    <p class="desc-funds"><i><strong>You will need the inmate's Name, Facility, and booking number to complete these transactions.</strong></i></p>
                    
                    
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h2 class="easy-title-funds">Bonded Courier Service</h2>
                    <p class="desc-funds">Our StoresHere <i><strong>Bonded Courier</strong></i> service allows you to deposit inmate money directly into an inmate’s commissary account. The inmate can then use those funds, just like cash, to make a variety of purchases at their facility’s commissary (items vary by facility location).</p>
                    <p class="desc-funds">All inmate money is deposited in the inmates account within 24 hours. Inmate deposits are made daily, <i><strong>7 days  a week</strong></i>.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if(is_logged_in()) :?>
                 {{ theme:partial name="loginForms" }}
            <?php endif; ?>

            <div class="content-widget slideDiv" id="sendFundDiv">
             <?php if(empty($inmates)){ ?>
                <div class="col-md-12 jumbotron clearfix">
                    <h4 style="color: #FFF;">You haven't added any inmate(s) yet. Add an inmate to send photos.</h4>
                    <p style="color:#fff; font-size: 20px;" id="close-this">
                    <a class="showDiv btn btn-primary" href="javascript:void(0)" id="addInmates">Click Here</a> 
                    to add inmate(s) and start sending funds/photos to them.</p>
                    <span style="color:#fff; font-size:16px;">
                </div>
            <?php } else { ?>
                <?php
                 echo form_open('payThroughPaypal', array('id' => 'sendFundForm','class'=>'signup horizontal-form send-funds')) ?>
                    <div class="components">
                        <div class="signup-title">
                            <h1>TO SEND FUNDS PLEASE COMPLETE THE FORM BELOW</h1>
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
                                <label class="fund-label">Inmates Name (anombre del Reciouso)<font style="color:red;">*</font>:</label>
                                <select name="name" class="inputw310 inmatesList">
                                    <option value="">SELECT INMATE</option>
                                </select>
                            </div>
                             <div class="input-group label_width">
                                <label class="fund-label">Inmates ID Number (Reciouso Número de Id.)<font style="color:red;">*</font>:</label>
                                <input type="text" class="inputw310" name="bookingNo" id="bookingNo" placeholder="Enter Inmate Id Number">
                            </div>
                            <div class="input-group label_width">
                                <label class="fund-label">Amount (Introducir importe)<font style="color:red;">*</font>:</label>
                                <input type="text" id="amount" class="inputw310" name="amount" placeholder="Enter Amount in Dollar" autocomplete="off">
                            </div> 
                            <div class="input-group label_width pay">
                                <label class="fund-label paylabel">Payment method<font style="color:red;">*</font>:</label>
                                <div class="fund-div">
                                    <input type="radio" id="pay_method1" class="inputpay" name="pay_method" value="paypal" checked="checked"><label style="" for="pay_method1">Paypal</label>
                                    <input style="margin-left: 10px;display:none;" type="radio" id="pay_method2" class="inputpay" name="pay_method" value="genie">
                                    <label style="margin-left: -5px; color: #fff;display:none" for="pay_method2">Genie Cashbox</label>
                                </div>
                            </div>                              
                        <div class="input-group label_width">
                                 <p class="pd t_C" style="display: inline-block; margin-right: 5px;"><label><input name="accept" type="checkbox"> I agree to the terms &amp; conditions. <a href="<?php echo base_url(); ?>sendFunds#" onclick="termsAndConditions()">
                                            Click to view  our terms and conditions
                                        </a></label></p>
                            </div>
                            <div class="input-group label_width">
                                 <div class="pd sn_button">
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
                        <div class="groups" id="tab2" style="display:none;">
                            <div class="white_block">
                                <!-- <p><label>&nbsp;</label><label>Heading1</label><label>Heading2</label></p> -->
                                <div class="border2"></div>
                                
                                <p><label>Amount submitted:</label> <label id="org_amount"></label></p>
                                <p><label id="_unit">Processing Fee:</label> <label id="proc_amount"></label></p>
                                
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
                                <button type="submit" class="transparent" id="load-start">
                                    <span>
                                        Proceed to pay
                                    </span>
                                </button>
                            </div> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                <?php echo form_close(); }?>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <a href="http://www.joshhermanbailbonds.com/index.html"> <img src="https://storeshere.com/system/cms/modules/pages/img/securedeposits_banner.jpg" alt="Deposit Inmate Funds"> </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <a href="http://www.joshhermanbailbonds.com/index.html"> <img src="https://storeshere.com/system/cms/modules/pages/img/Bail-Bonds.jpg" alt="Josh Herman Bail Bonds and Inmate Funds"> </a>     
                    </div>
                </div>
        </div>
    </div>
</div>

<style type "text/css">
<!--
/* @group Blink */
.blink {
    color: red !important;
    font-size: 30px;
	-webkit-animation: blink .75s linear infinite;
	-moz-animation: blink .75s linear infinite;
	-ms-animation: blink .75s linear infinite;
	-o-animation: blink .75s linear infinite;
	 animation: blink .75s linear infinite;
}
@-webkit-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-moz-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-ms-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-o-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
/* @end */
-->
.limit_msg{
    width: 500px;
}
</style>


<div id="price-data"></div>
<!-- <div id="load" style="display:none;width:100%; height:100%; top:0; position:absolute; background-color:rgba(255, 255, 255, 0.8);text-align: center;"><img style="width: 10%; margin-top: '+margin+'px;" alt="" src="<?php echo base_url(); ?>/system/cms/themes/storeshere/img/loading.gif"><p>Please Wait . . . .</p></div> -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#amount').val('');
        $('.inmatesList').val('');
        $('.facilityList').val('');
        $(document).on('click','#load-start',function (){
            // $('#load').css('display','inline');
            if($('#sendFundForm').valid()){
                var box = $("body");
                var height = box.outerHeight();
                var h1 = box.innerHeight();
                var margin = (height/2) - 59;
                var html = '<div id="load"><div><img alt="" src="<?php echo base_url(); ?>system/cms/themes/storeshere/img/loading.gif"><p class="blink">Please wait for the transaction to complete</p></div></div>';
                box.append(html);
            }
        });
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

    $(document).on('change','#pay_method1',function(){
        $('#sendFundForm').attr('action','<?php echo base_url(); ?>payThroughPaypal');
    });

    $(document).on('change','#pay_method2',function(){
        $('#sendFundForm').attr('action','<?php echo base_url(); ?>payThroughGenie');
    });
    
    $("#amount").keyup(function(){
        if($(this).val() > 150){
            var html = '<div class="limit_msg"><p>Inmates have a limit of $300 on their books and when a deposit to an inmates account exceeds $300, the deposit is rejected and we are hit with a fee.</p><p>These refunds are getting very costly, so for that reason, we are limiting a single deposit to $150.</p><p>We are sorry for the inconvenience, but it is a necessity …</p>Storeshere Admin</div>';
			$.fancybox.open(html);
        }
    });

    $(document).on('click', '#continue', function(){
        var finalAmount = '';
        var data = $("#price-data");
        var fees = parseInt(data.attr('data-fee'));
        var amount = parseFloat($('#amount').val());
        var unit = data.attr('data-unit'); //1:fixed, 2:percentage        
        var fees_text = fees+' USD';
        if(unit == 1){
            finalAmount = parseFloat(amount) + fees;
            $('#_unit').text('Processing Fees:');
        }else{
            var fee = (fees/100) * parseFloat(amount);
            finalAmount = parseFloat(amount) + parseFloat(fee.toFixed(2));
            fees_text = fee.toFixed(2)+' USD';
            $('#_unit').text('Processing Fees ('+fees+'%):');
        }
        $('#org_amount').text(amount+' USD');
        $('#proc_amount').text(fees_text);
        $('#total_amount').text(finalAmount+' USD');
    });
</script>