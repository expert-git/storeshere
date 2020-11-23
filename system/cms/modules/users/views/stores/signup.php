<?php  if ( ! empty($error_string)):?>
<div class="form-res email_error_n" style="background-color: #e03e3e !important; ">
   <p> <?php echo $error_string;?> </p>
</div>
<?php endif;?>
<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <div class="form-title">
                    <span>Complete the simple online form</span>
                </div>
                <h1 class="easy-title"><i>AS EASY AS</i>  <span>1 - 2 - 3</span></h1>
                <div class="spacer10"></div>
            </div>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="content-widget">
				<?php echo form_open('users/register', array('id'=>'register','class'=>'signup horizontal-form')) ?>
                   <?php  echo form_hidden('d0ntf1llth1s1n',' ')?>
                   <div class="components signup-farm">
                        <div class="signup-title">
                            <h1>PLEASE COMPLETE THE FORM BELOW</h1>
                            <div class="info_pls_req"><span>*</span> (Mandatory fields)</div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="groups">
                            <input type="hidden" id="captcha_val" value="">
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Username (Usernombre)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" id="username" name="username" class="inputw310" maxlength="30">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">First Name (Nombre)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" name="first_name" class="inputw310" maxlength="30">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Last Name (Apellido)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" name="last_name" class="inputw310" maxlength="30">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Street Address (La dirección de la calle):</label>
                                <input type="text" placeholder="" name="street_address" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Apt. / Suite:</label>
                                <input type="text" placeholder="" name="apt_suite_no" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">City (Ciudad):</label>
                                <input type="text" placeholder="" id="city" name="city" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">State (Estado):</label>
                                <input type="text" placeholder="" id="state" name="state" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Country (Count)<font style="color:red;">*</font>:</label>
                                <select name="country" id="country" class="inputw310 inmatesList country">
                                <option value="">Select Country</option>
                                <?php foreach($country_names as $country): ?>
                                <option value="<?php echo $country['nicename']; ?>">
                                    <?php echo $country['nicename']; ?>
                                </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Zip Code (Código Postal):</label>
                                <input type="text" placeholder="" id="postcod" name="postcode" class="inputw310" 
                                autocomplete="off" minlength="5" maxlength="8">
                            </div>
                            
                            <!-- 22-06-2018 -->
                            <div class="input-group label_width_sign">
                               
                                <p class="pd">
                                    Do you have en email address?
                                    <input type="radio" name="sign_type" value="email" class="sign_type"/> YES
                                     <input type="radio" name="sign_type" value="phone" class="sign_type" checked="checked"/> No
                                </p>
                            </div>
                            <!-- 22-06-2018 -->
                            
                            <div class="input-group label_width_sign sign_ph">
                                <label class="label-signup">Cell / Phone Number (Teléfono Celular)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" id="mobile" name="mobile" class="inputw310" maxlength="15">
                            </div>
                            <div class="input-group label_width_sign sign_ph" >
                                <label class="label-signup">Confirm Cell / Phone Number (Teléfono Celular)<font style="color:red;">*</font>:</label>
                                <input type="text" id="con_mobile" placeholder="" name="con_mobile" class="inputw310" maxlength="15">
                            </div>
                            
                            <div class="input-group label_width_sign sign_em">
                                <label class="label-signup">Email Address (Dirección de Email)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" id="email" name="email" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign sign_em">
                                <label class="label-signup">Confirm Email Address (Confirmar Email)<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="" name="con_email" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Password (Contraseña)<font style="color:red;">*</font>:</label>
                                <input type="password" placeholder="" id="password12" name="password" class="inputw310" maxlength="15">
                            </div>
                             <div class="input-group label_width_sign">
                                <label class="label-signup">Confirm Password (Confirmar Contraseña)<font style="color:red;">*</font>:</label>
                                <input type="password" placeholder="" name="con_password" class="inputw310" maxlength="15">
                            </div>
                            <div class="input-group label_width_sign">
                               <div class="pd"> 
                                <div class="captcha_img"></div>
                                <img id="refresh" src="<?php echo base_url()?>system/cms/themes/storeshere/img/refresh.png">
                                  <!--22-06-2018 costa -->
                               <span id="case_in" style="margin-left: 10px;">Case Insencetive</span>
                                 <!--22-06-2018 costa -->
                                <p style="color: #fff; font-size: 15px; text-align: right; /*! margin-top: -20px; */ /*! margin-left: -30px; */display: inline-block;max-width: 190px;vertical-align: top;text-align: left;"><!-- <font style="color:red;">*</font>captcha is case sensitive.</p> -->
                               </div> 
                            </div>    
                            <div class="input-group label_width_sign">
                                <label class="label-signup">Captcha Code<font style="color:red;">*</font>:</label>
                                <input type="text" placeholder="Enter Captcha" id="captcha" name="captcha" class="inputw310">
                            </div>
                            <div class="input-group label_width_sign">
                                <p class="pd">
                                    To receive notifications from StoresHere.com about your deposits or photos status, you must enter a Cell Phone Number and an Email Address. Thank You
                                </p>
                            </div>
                            <div class="input-group label_width_sign">
                            <p class="pd">To send money to an inmate you must have a funding option. If you do not have one please click on the funding options button in the above menu. <a target="_blank" href="<?php echo base_url(); ?>fundingOptions">Funding options.</a>
                            </div>
                            <div class="input-group label_width_sign terms-signup">
                                  <!--22-06-2018 costa -->
                                <p class="pd"><label><input type="checkbox" id="accept" name="accept"> I agree to the <a href="<?php echo base_url('signup'); ?>#" onclick="termsAndConditions()"> terms & conditions.</a></label></p>
                                  <!--22-06-2018 costa -->
                            </div>
                            <div class="input-group label_width_sign">
                                 <div class="pd" id="submitDiv">
                                     <div class="signup-button-wrap2 fl-left">
                                        <button type="submit" class="transparent" id="signup">
                                            <span>
                                                Sign Up Free
                                            </span>
                                        </button>                                        
                                     </div>
                                     <div class="form-res"></div>
                                     <div class="clearfix"></div>
                                 </div>
                                 <div class="clearfix"></div>
                            </div>
                            <div id="terms-conditions" style="display: none;">
                                <h4>Terms and conditions</h4>
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
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                   </div>
                   <div class="clearfix"></div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<style type="text/css">
/** 22-06-2018 **/
.captcha_img{
    background-image: url("system/cms/themes/storeshere/img/captcha.jpg");
    border: 1px solid #cccccc;
    border-radius: 4px;    
    font-size: 16px;
    height: 40px;
    display: inline-block;
    margin-left:90px;
    letter-spacing: 1px;
    line-height: 40px;
    text-align: center;
    width: 19%;
    -webkit-user-select: none; /* Chrome/Safari */        
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE10+ */
    /* Rules below not implemented in browsers yet */
    -o-user-select: none;
    user-select: none;
    font-size:24px;
    font-weight:bold;
}
.sign_em{
    display:none;
}
/*.sign_ph{*/
/*    display:none;*/
/*}*/
/** 22-06-2018 **/

#refresh{
    width:25px;
    cursor: pointer;
}
.form-res {
        border-radius: 6px;
        margin-left: 145px;
        text-align: center;
        width: 100%;
        color: #ffffff !important;   
    }
.form-res p {padding: 2px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
    getCaptcha();

    if(  $(".form-res").is(":visible") == true )
    {  
        $(".form-res").hide(2000);
    }
    $("#signup").click(function(){
        var name = $('#username').val();
        
        if(!/[^a-zA-Z0-9]/.test(name)){
            return true;
        }
        else{
            alert("Username can't contain special characters or space.");
            return false;
        }
    });
    $('#username').on('keypress',function(e){
        
        var name = $('#username').val();
        
        if(!/[^a-zA-Z0-9]/.test(e.key)){
            return true;
        }
        else{
            alert("Username can't contain special characters or space.");
            return false;
        }
        var $element = $('#username');
        $.ajax({
            type : "POST",
            url : 'checkUser',
            dataType: "html",
            data : {username : name},
            success : function (data) {
                if(data != ''){
                    if(name == data){
                        // console.log(data.responseText);
                        extraClass = '';
                        if($element.is('#accept')) extraClass = 'radio_error';
                        var errortext = "<div class=\'error_box "+extraClass+"\'><p class=\'error_text\'>sorry this username is already taken</p></div>";
                        if($element.closest('.input-group').find('.error_box').length >= 1){
                           $element.closest('.input-group').find('.error_box').remove();
                        }
                        $element.closest('.input-group').append(errortext);
                        // $('#signup').on('click',function(){
                        //     alert('Please select some other username');
                        // });
                    }
                    else if(name != data){
                        $element.closest('.input-group').find('.error_box').remove();
                    }
                }
                else if(name == ''){
                   $element.closest('.input-group').find('.error_box').remove();   
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    })    

$('#email').on('keypress',function(){
        var email = $('#email').val();
        var $element = $('#email');
        $.ajax({
            type : "POST",
            url : 'checkEmail',
            dataType: "html",
            data : {email : email},
            success : function (data) {
                if(data != ''){
                    if(email == data.toLowerCase()){
                        extraClass = '';
                        if($element.is('#accept')) extraClass = 'radio_error';
                        var errortext = "<div class=\'error_box "+extraClass+"\'><p class=\'error_text\'>sorry this email is already taken</p></div>";
                        if($element.closest('.input-group').find('.error_box').length >= 1){
                           $element.closest('.input-group').find('.error_box').remove();
                        }
                        $element.closest('.input-group').append(errortext);
                        // $('#signup').on('click',function(){
                        //     alert('Please select some other username');
                        // });
                    }
                    else if(email != data){
                        $element.closest('.input-group').find('.error_box').remove();
                    }
                }
                else if(name == ''){
                   $element.closest('.input-group').find('.error_box').remove();   
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    })
    
    
    
     $('.sign_type').on('click',function(){
         
         var sign_type = $(this).val();
         
         if(sign_type == 'email'){
             
             $(".sign_em").css("display","block");
             $(".sign_ph").css("display","none");
             
         }else{
             $(".sign_em").css("display","none");
              $(".sign_ph").css("display","block");
         }
         
     });
    
    
    
    
});
</script>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script> -->