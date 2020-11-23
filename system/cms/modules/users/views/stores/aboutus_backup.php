<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <div class="form-title">
                    <span class="showDiv" >About Us</span>
                </div>
                <!-- <h1 class="easy-title"><span>Fill This Form We Contact You Soon</span></h1> -->
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
            <div class="components pd20 content-widget slideDiv" id="sendFundDiv">
                <p class="about-para">
              The Stores Here website was created to provide jail inmate family and friends an easy and convenient way to deposit funds in an inmates store account. We know, from experience, how difficult and time consuming it can be to find the time necessary to travel to the jail, sometimes very long distance, wait in line and then go through the bureaucratic process necessary to deposit cash in the inmates account.
Stores Here will do the traveling, waiting in line, and deposit the cash for you. It’s simple, just create a Stores Here account, fill out the on-line deposit slip, and deposit the funds that you want to go in the inmates account (plus a $10 fee*), using your PayPal Account, and leave the rest to us. The monies will normally be deposited in the inmates store account within 24 hours. You will be notified by email or text when the deposit has taken place.
Additionally, separate from the inmate stores deposit, we offer a capability for inmate family and friends to send photographs/emojis**, with text, to almost any jail facility in the country.

                </p>
                <div class="signup-title">
                            <h1>*Note: This $10 fee is what we charge to manually do the cash deposit for you.</h1>
                </div>
                     <div class="spacer10"></div>       
                <div class="signup-title">            
                        <h1>**Note: The number of photographs/emojis, photograph sizes, and the amount of text allowed, depends on each individual jail facility regulations. </h1>
                        </div>
            </div>
        </div>
    </div>    




    <div class="clearfix"></div>
</div>