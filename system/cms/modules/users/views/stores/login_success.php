<?php
    $segment = $this->uri->segment(1);
?>
<div class="container middle-content">
    <div class="row allDiv">
        <div class="spacer20"></div>
        <div class="col-md-12">
            <!-- <div class="signup-title">
                <p>You have successfully logged into your account.</p>
                <p>Send money/Photos to your inmate.</p>
            </div> -->

            <div class="alert alert-success fade in signup-title">
               <span id='close' >x</span>
                  <?php  $info = $this->current_user;?>
                <p>Welcome,&nbsp;&nbsp; <span><?php echo ucfirst($info->first_name).' '.ucfirst($info->last_name)?></span></p>
                <p>You have successfully logged into your account.<br/>
            </div>
            <?php if(empty($inmates)){ ?>
                <div>
                    You haven't added an inmate yet. Add an inmate to send funds or photos.
                </div>
            <?php }else{ ?>
                <div>
                    <p>Please choose an action, what you want to do : </p>
                    <p><a>Click Here</a> to send funds to your inmate.</p>
                    <p><a>Click Here</a> to send photos to your inmate.</p>
                </div>
            <?php } ?>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="content-widget">
                <!-- <div class="form-title">
                    <span id="updateProfile" class="showDiv">My Profile</span>
                </div> -->
                <div class="spacer10"></div>
              
                <!-- {{ theme:partial name="sidemenu" }} -->
                
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            
            {{ theme:partial name="loginForms" }}

        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- <script type="text/javascript">
    window.onload = function(){
    document.getElementById('close').onclick = function(){
        this.parentNode.parentNode.parentNode
        .removeChild(this.parentNode.parentNode);
        return false;
    };
};
</script> -->
<style type="text/css">
    .alert-success {
    background-color: #398439;
    border-color: #d6e9c6;
    color: #3c763d;
}
.alert {
    padding: 0px 30px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
#close {
        position: absolute;
    right: 30px;
    top: 6px;
    font-size: 22px;
    color: #fff;
}
#close:hover {cursor: pointer;}

</style>