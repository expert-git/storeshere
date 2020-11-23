<!--<h4 class = "error_message">The Apt Suite No. field must contain an integer.</h4>-->
<style>
    /*.error_message{*/
    /*    display: none;*/
    /*    background: rgb(223, 92, 84); */
    /*    padding: 1%; */
    /*    padding-left: 20px; */
    /*    color: white; */
    /*    border-radius: 5px;*/
    /*}*/
</style>
<section class="title">
	<?php if ($this->method === 'create'): ?>
		<h4><?php echo lang('user:add_title') ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('user:edit_title'), $member->username) ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud"') ?>
		<?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#user-basic-data-tab"><span><?php echo lang('profile_user_basic_data_label') ?></span></a></li>
				<li><a href="#user-profile-fields-tab"><span><?php echo lang('user:profile_fields_label') ?></span></a></li>
			</ul>
	
			<!-- Content tab -->
			<div class="form_inputs" id="user-basic-data-tab">
				<fieldset>
					<ul>
						<li class="even">
							<label for="email"><?php echo lang('global:email') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('email', $member->email, 'id="email"') ?>
							</div>
						</li>
						
						<li>
							<label for="username"><?php echo lang('user:username') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('username', $member->username, 'id="username"') ?>
							</div>
						</li>
	
						<li>
							<label for="group_id"><?php echo lang('user:group_label') ?></label>
							<div class="input">
								<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'id="group_id"') ?>
							</div>
						</li>
						<li id="facility_dynamic"></li>
						<li class="even">
							<label for="active"><?php echo lang('user:activate_label') ?></label>
							<div class="input">
								<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
								<?php echo form_dropdown('active', $options, $member->active, 'id="active"') ?>
							</div>
						</li>
						<li class="even">
							<label for="password">
								<?php echo lang('global:password') ?>
								<?php if ($this->method == 'create'): ?> <span>*</span><?php endif ?>
							</label>
							<div class="input">
								<?php echo form_password('password', '', 'id="password" autocomplete="off"') ?>
							</div>
						</li>						
					</ul>
				</fieldset>
			</div>
	
			<div class="form_inputs" id="user-profile-fields-tab">
	
				<fieldset>
					<ul>
	
						<li>
							<label for="display_name"><?php echo lang('profile_display_name') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('display_name', $display_name, 'id="display_name"') ?>
							</div>
						</li>
	
						<?php foreach($profile_fields as $field): ?>
						<li>
							<label for="<?php echo $field['field_slug'] ?>">
								<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?>
								<?php if ($field['required']){ ?> <span>*</span><?php } ?>
							</label>
							<div class="input">
								<?php echo $field['input'] ?>
							</div>
						</li>
						<?php endforeach ?>
	
					</ul>
				</fieldset>
			</div>
		</div>
		<input type="hidden" name="facility" id="hid_val" value="" />
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>

	</div>
</section>

<script type="text/javascript">
$(document).ready(function(){
    // $("#apt_suite_no").attr("pattern", "[0-9]");
    // $("#apt_suite_no").keyup(function(){
    //     var $regex = /^[0-9]+$/;
    //     if (!$(this).val().match($regex)) {
    //         $(".error_message").show();
    //     }
    //     else{
    //         $(".error_message").hide();
    //     }
    // });
	var str_array = '';
	if($('#group_id').val() == 3){		
		var facility_data = '<?php print_r( implode(',', json_decode($member->facility_id)) ); ?>';				
			if(facility_data != ''){
				str_array = facility_data.split(',');
			    for (var i = 0; i < str_array.length; i++) {
			        str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
			    }
			    $('#hid_val').val(str_array);
			    makeFacility(str_array);
			}else{
				makeFacility(str_array);
			}
		// $("#facilities").val(str_array).trigger("liszt:updated");		
	}

	$(document).on('change','#group_id', function(){
		var val = $(this).val();
		hasList = $('#thisinsert').length;
		if(val == 3){
			if( hasList == 0){				
				makeFacility(str_array);
			}
		}else{
			$('#thisinsert').remove();
		}
	});

	function makeFacility(data = ''){		
		$.ajax({
			url : BASE_URL+'admin/users/getAllFacilities',
			type : 'POST',
			success : function(res){
				if(res){
					var option = '';
					var parse = $.parseJSON(res);
					$.each(parse,function(k,v){
						option += '<option value="'+v.id+'">'+v.name+'</option>';							
					});
					var html = '<li id="thisinsert"><label for="facility_id">Facility <span style="color:#ff0000;">*</span></label><div class="input"><select name="facilities" id="facilities" multiple>'+option+'</select></div></li>';						
					$('#facility_dynamic').append(html);
					if(data != ''){
						console.log(data);
						$("#facilities").val(data).trigger("liszt:updated");
					}						
				}
			}
		});
	}

	$(document).on('change','#facilities',function(){
		var myValues = $(this).chosen().val();
		$('#hid_val').val(myValues);		
		str_array = myValues;
	});

});
</script>