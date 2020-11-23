<?php if (!empty($inmates)): ?>
<div class="col-md-8 col-sm-8 col-xs-12">
            <div class="content-widget slideDiv" id="inmatesListDiv" style="display:block">
               <div class="components">
                    <div class="signup-title">
                        <!-- <h1>Inmates List</h1> -->
                    </div>
                    <div class="spacer10"></div>
                    <div class="groups">
                        <?php if(!empty($inmates)) : ?>
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Booking Number</th>
                                        <th>Facility</th>
                                        <th>Verified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                  
                                <tbody>
                                        <?php foreach ($inmates as $k => $v) :?>
                                            <tr>
                                                <td><?php echo $v['inmates_name']." ".$v['inmates_middle_name']." ".$v['inmates_last_name']?></td>
                                                <td><?php echo $v['inmates_booking_no']?></td>
                                                <td><?php echo $v['facility_name']?></td>
                                                <td><?php echo (($v['is_verified'])?"Yes":"No");?></td>
                                                <td class="centerTd">
                                                    <?php echo anchor('users/admin/edit_inmate/' . $v['inmates_id'], lang('global:edit'), array('class'=>'button edit')) ?>
                                                    <?php //echo anchor('admin/users/delete/' . $v['inmates_id'], lang('global:delete'), array('class'=>'confirm button delete')) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else :?>
                            <h4 style="color: #fff">User have not added any inmates yet.</h4>
                            
                        <?php endif ;?>    
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
               </div>
               <div class="clearfix"></div>
            </div>
        </div>

        <div class="fancybox overlay-container" id="alert" style="display:none;">
            <div id="resetBox">
                <h2>Are you Sure ? </h2>
                <p style="color:black;">You can't recover the inmate once's deleted</p>        
                <form action="<?php echo base_url();?>deleteInmate" method="post" role="form" id="delete_form" novalidate="novalidate" class="popup_form">            
                    <input type="hidden" name="del_inmate" id="del_inmate" />
                    <div class="signup-button-wrap2"> 
                        <span>                
                            <button class="btn btn-highlight" type="button" id="cancel_btn" onclick="$.fancybox.close();"> Cancel </button>
                        </span>
                    </div>
                    <div class="signup-button-wrap2"> 
                        <span>                
                            <button class="btn btn-highlight" type="submit" id=""> Delete Inmate </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
<?php endif ?>        