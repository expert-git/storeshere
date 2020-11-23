<?php
 if (!empty($data)):?> 	
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				
				<th class="collapse">#</th>
				<th class="collapse">Customer Name</th>
				<th class="collapse" style="display:none;">Email</th>
				<th class="collapse">Inamte's Name</th>
				<th class="collapse">Facility Name</th>
				<th class="collapse">Photos Sent</th>
				<th class="collapse">Amount</th>
				<th class="collapse" style="display:none;">Payment Type</th>
				<th class="collapse">If not delivered</th>
				<th class="collapse">Sent Date</th>
				<th class="collapse">Status</th>
				
			</tr>
		</thead>
		
		<tbody>
			<?php $link_profiles = Settings::get('enable_profiles'); ?>
			<?php foreach ($data as $user): ?>
				<tr id="row_<?php echo $user['id']; ?>">
					
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
					
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif; ?>
