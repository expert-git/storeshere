<?php
 if (!empty($funds)): ?> 
      <button id="check_value" type="button" style="float:right;">All Prints</button>
      <span style="float:right; margin-top:10px;" >Select any users.</span>
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center" ><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all checked_value'));?></th>
				<th class="collapse">Username</th>
				<th class="collapse">Email</th>
				<th class="collapse">Inamte's Name</th>
				<th class="collapse">Facility Name</th>				
				<th class="collapse">Amount transferred</th>
				<th class="collapse">Processing Fees</th>
				<th class="collapse">Total Amount</th>
				<th class="collapse">Sent Date</th>
				<th class="collapse">Status</th>
				<th width="300">Invoice</th>
				<th >Date delivered</th>
				<th width="300"></th>
				<th >prints</th>
				<!-- <th width="450"></th> -->
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
			<?php foreach ($funds as $user): ?>				
				<tr id="row_<?php echo $user['id']; ?>">
					<td class="align-center"><?php echo form_checkbox('action_to[]', $user['id']) ?></td>
					<td>
						<?php echo $user['user_name']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['email']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['inmates_name']; ?>
					</td>
					<td class="collapse">
						<?php echo $user['facility_name']; ?>
					</td>					
					<td class="collapse">
						<?php echo $user['original_amount'].' USD'; ?>
					</td>
					<td class="collapse">
						<?php echo $user['processing_fees'].' USD'; ?>
					</td>
					<td class="collapse">
						<?php echo $user['amount'].' USD'; ?>
					</td>
					<td class="collapse">
						<?php echo $user['sent_date']; ?>
					</td>
					<td class="collapse">
						<?php if($user['status'] == 1){
							echo 'Received';
						}else if($user['status'] == 2){
							echo 'In Transit';
						}else{
							echo 'Delivered';
						} ?>
					</td>
					<td>
						<?php if($user['status'] == 3 && !empty($user['invoice'])) { ?>
							<a data-src="<?php echo base_url().'uploads/'.$user['paid_by'].'/invoice/'.$user['invoice']; ?>" class="button view_invoice fancybox">View Invoice</a>
						<?php }?>
					</td>
					<td>
						<?php echo $user['delivered_date']; ?>
					</td>

					<td class="collapse" >
						<?php if($user['status'] == 1 || $user['status'] == 2){ ?>
							<a class="button edit update_status" data-paidto = "<?php echo $user['paid_to']; ?>" data-payer="<?php echo $user['paid_by']; ?>" data-attr = "<?php echo $user['id']; ?>">
								Update Status
							</a>
						<?php }else{ ?>
							<a>
								Delivered
							</a>
						<?php } ?>
					</td>
					<td>
                      	 <button type="button" data-id = "<?php echo $user['id']; ?>" class="print_receipt">
                      	 	Print
                      	 </button>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php else : ?>
	<h1>No data found</h1>
<?php endif; ?>
<div id="stat_dialog" style="display:none;" title="Update Fund Status">
	<label for="photo_opt">
		Please select status : 
	</label>
	<div class="input">
		<select name="photo_status" id="photo_opt">
			<option value="2">In Transit</option>
			<option value="3">Delivered</option>
		</select>
		<input type="hidden" name="id" id="photo_stat_id">
		<input type="hidden" name="payer_id" id="payer_id">
		<input type="hidden" name="paid_to" id="paid_to">		
		<div id="img_upload" style="margin-top:5px;">
		</div>
	</div>
</div>