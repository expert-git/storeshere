<div class="container middle-content">
    <div class="row">
        <div class="spacer20"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <div class="form-title">
                    <span class="showDiv" >Funding Options</span>
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
              Stores Here helps you to send funds or photos to your inmates in several registered facilities with convenience. To create an order and to process it Stores here allows you to use several funding options. Some of those funding options available at the moment are <br>
              <ul>
                  <li><a href="http://www.paypal.com" style="text-decoration: underline;" target="_blank"><h4>PayPal</h4></a></li>
                  <li><a href="https://geniecashbox.com/signup2/checking.php?gc=BHChecking&reference_no=8002091243" style="text-decoration: underline;" target="_blank"><h4>Genie Cashbox</h4></a></li>
              </ul>

                <p>If you don't have an account with these services, click on their name to create a free account so you can fund your orders for your inmate on Stores Here</p>
 
                </p>
            </div>
        </div>
    </div>    




    <div class="clearfix"></div>
</div>
<style type="text/css">
    ul li{
        list-style-type: none;
    }
    h4 {
        color: #ffffff;
    }
</style>