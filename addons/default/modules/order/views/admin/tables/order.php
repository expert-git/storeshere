<?php
 if (!empty($funds)): ?> 
      <button id="check_value" type="button" style="float:right;">All Prints</button>
      <span style="float:right; margin-top:10px;" >Select any users.</span>
      <button id = "total_amt_cal" type="button">Total Amt</button>
      <span id = "total_amt_value"></span>
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center" ><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all checked_value'));?></th>
				<th class="collapse">#</th>
				<th class="collapse">Username</th>
				<th class="collapse">Inmate's Name</th>
				<th>Facility Name</th>	
				<th>Booking No.</th>
				<th class="collapse">Amount</th>
				<th class="collapse">Processing Fees</th>
				<th class="collapse">Total Amount</th>
				<th class="collapse" style="display:none;">Payment type</th>
				<th class="collapse">Sent Date</th>
				<th class="collapse">Status</th>
				<th width="300">Invoice</th>
				<th >Date delivered</th>
				<th width="300">
				    <a class="button edit updates">
						Update Status
					</a>
				</th>
				<th >Prints</th>
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
					    <?php echo "F".$user['id']; ?>
					</td>
					<td>
						<?php echo anchor('admin/users/user_inmates/'.$user['user_id'] , $user['user_name'], 'target="_blank" class="modal-large"') ?>
					</td>
					<td class="collapse">
						<?php 
						    if($user['is_verified']==0){
						        echo anchor('admin/order/inmate_user/'.$user['inmates_booking_no'] , $user['inmates_name'], 'target="_blank" class="modal-large"');
						    }else {
						        echo anchor('admin/order/inmate_user/'.$user['inmates_booking_no'] ,  "<b>".$user['inmates_name']."</b>", 'target="_blank" class="modal-large"');
						    }
					    ?>
					</td>
					<td>
						<?php echo $user['facility_name']; ?>
					</td>
					<td>
						<?php echo $user['inmates_booking_no']; ?>
					</td>
					<td class="collapse">
						$ <?php echo $user['original_amount']; ?>
					</td>
					<td class="collapse">
						$ <?php echo $user['processing_fees']; ?>
					</td>
					<td class="collapse">
						$ <?php echo $user['amount']; ?>
					</td>
					<td class="collapse" style="display:none;">
						<?php echo $user['payment_type']; ?>
					</td>
					<td class="collapse">
						<?php echo date('M-d-Y', strtotime($user['sent_date']));?>
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
					    <?php if($user['delivered_date']!="") {echo date('M-d-Y', strtotime($user['delivered_date']));}?>
					</td>

					<td class="collapse">
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
                      	 <button type="button" data-id = "<?php echo $user['id']; ?>" class="print_receipt" id="<?php echo $user['id']; ?>">
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
<!--multi updates dialog-->
<div id="stats_dialog" style="display:none;" title="Update Fund Status">
	<label for="photo_opt1">
		Please select status : 
	</label>
	<div class="input">
		<select name="fund_status" id="photo_opt1">
			<option value="2">In Transit</option>
			<option value="3">Delivered</option>
		</select>
		<input type="hidden" name="id" id="funds_id">
		</div>
	</div>
</div>
<style type="text/css">

table th, table td {
    padding: 6px !important;
    
}
</style>