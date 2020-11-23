<?php
 if (!empty($data)):?> 	
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th class="collapse">#</th>
				<th class="collapse">Customer Name</th>
				<th class="collapse" style="display:none;">Email</th>
				<th class="collapse">Inamte's Name</th>
				<th class="collapse">Facility Name</th>
				<th class="collapse">Booking No.</th>
				<th class="collapse">Photos Sent</th>
				<th class="collapse">Amount</th>
				<th class="collapse" style="display:none;">Payment Type</th>
				<th class="collapse">If not delivered</th>
				<th class="collapse">Sent Date</th>
				<th class="collapse">Status</th>
				<th width="450"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php $link_profiles = Settings::get('enable_profiles'); ?>
			<?php foreach ($data as $user): ?>
				<tr id="row_<?php echo $user['id']; ?>">
					<td class="align-center"><?php echo form_checkbox('action_to[]', $user['id']) ?></td>
					<td>
						<?php echo "P".$user['id']; ?>
					</td>
					<td>
						<?php echo $user['user_name']; ?>
					</td>
					<td class="collapse"  style="display:none;">
						<?php echo $user['email']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['inmates_name']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['facility_name']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['inmates_booking_no']; ?>
					</td>
					<td class="collapse">
						<!-- <a type="button" id="preview_photos" href="<?php echo base_url().'admin/order/getImages/'.$user['id']; ?>" data-fancybox-type="iframe"> -->
						<a style="cursor:pointer;" type="button" class="preview_photos" data-id="<?php echo $user['id']; ?>" >
							<?php echo $user['no_of_photos']; ?>
						</a>
						<!-- <a style="cursor:pointer;" id="preview_photos" data-id="<?php //echo $user['id']; ?>" data-p-id="<?php echo $user['sent_by']; ?>">
							<?php //echo $user['no_of_photos']; ?>
						</a> -->
					</td>
					<td class="collapse">
						$ <?php echo $user['amount']; ?>
					</td>
					<td class="collapse"  style="display:none;">
						<?php echo $user['payment_type']; ?>
					</td>
					<td class="collapse">
						<?php if($user['destruction_clause'] == 1) {
								echo "Destroy data";
							}
							else{
								echo "Return to address";
							}
						?>
					</td>
					<td class="collapse">
					    <?php echo date('M-d-Y', strtotime($user['sent_date']));?>
						
					</td>
					<td class="collapse">
						<?php 
						
						if($user['status'] == 0){
							echo 'Not Received';
						}else if($user['status'] == 1){
							echo 'Received';
						}else if($user['status'] == 2){
							echo 'In Transit';
						}else{
							echo 'Delivered';
						} ?>
					</td>
					<td class="actions">						
						<?php if(!is_null($user['invoice']) && $user['invoice'] != ''){ ?>
							<a class="button view_invoice fancybox" data-src="<?php echo base_url().'uploads/'.$user['sent_by'].'/invoice/'.$user['invoice']; ?>">
								View Invoice
							</a>
						<?php }else if($user['status'] == 2 || $user['status'] == 1 ){ ?>
							<a class="button edit update_stat" data-attr = "<?php echo $user['id']; ?>">
								Update Status
							</a>
						<?php }else{?>
							
						<?php } ?>
						<a class="button" href= "<?php echo base_url().'admin/order/downloadZip/'.$user['id']; ?>" >
							Download Zip
						</a>
						<a class="button" href= "<?php echo base_url().'admin/order/emailZip/'.$user['id']; ?>" >
							Email zip
						</a>
						<?php if(!empty($user['document'])){ ?>
							<?php $dwnPath = base_url().'uploads/'.$user['sent_by'].'/docs/'.$user['document']; ?>
							<a class="button" type="download" href="<?php echo $dwnPath; ?>">
								Doc
							</a>
						<?php } ?>
						<?php if(!empty($user['text_message'])){ ?>
							<a data-msg = "<?php echo $user['text_message']; ?>" class="button msg_btn" type="button" id="dc">
								Msg
							</a>
						<?php } ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif; ?>
<div id="stat_dialog" style="display:none;" title="Update Photo Status">
	<label for="photo_opt">
		Please select status : 
	</label>
	<div class="input">
		<select name="photo_status" id="photo_opt">
			<option value="2">In Transit</option>
			<option value="3">Delivered</option>
		</select>
		<input type="hidden" name="id" id="photo_stat_id">
		<div id="img_upload" style="margin-top:5px;">
	</div>
</div>