<?php if (!empty($sends[0])): ?>

<h1>Fund Orders</h1>
    <table>
		<thead>
			<tr>
				<th>#</th>
				
				<th>Name</th>
				
				<th class="collapse">Inmate's Name</th>
				
				<th class="collapse">Facility Name</th>
				
				<th>Amount</th>
				
				<th class="collapse">Processing Fees</th>
				
				<th class="collapse">Total Amount</th>
				
				<th class="collapse">Sent Date</th>
				
				<th class="collapse">Status</th>
			</tr>
		</thead>
		<tbody>
	    <?php foreach ($sends[0] as $send): ?>
	        <tr>
				<td class="align-center"><?php echo "F".$send['id']; ?></td>
				<td class="align-center">
					<?php echo $send['username']; ?>
				</td>
				<td class="align-center"><?php echo $send['inmates_name'] ?></td>
				<td class="align-center"><?php echo $send['facility_name'] ?></td>
				<td class="align-center"><?php echo $send['amount']."$"; ?></td>
				<td class="align-center"><?php echo $send['processing_fees']."$"; ?></td>
				<td class="align-center"><?php echo $send['total_amount']."$" ?></td>
				<td class="align-center"><?php echo $send['sent_date'] ?></td>
				<td class="align-center">
					<?php 
					    if($send['status'] == 1){ 
					        echo 'Received by Admin';} 
					    else if($send['status'] == 2){
					        echo 'In Transit';} 
				        else { 
				            echo 'Delivered';
			            }
		            ?>
				</td>
			</tr>
	    <?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>

<?php if (!empty($sends[1])): ?>
<h1>Photo Orders</h1>
    <table>
		<thead>
			<tr>
				<th>#</th>
				
				<th>Name</th>
				
				<th class="collapse">Inmate's Name</th>
				
				<th class="collapse">Facility Name</th>
				
				<th>Photos Sent</th>
				
				<th class="collapse">Amount</th>
				
				<th class="collapse">If not delivered</th>
				
				<th class="collapse">Sent Date</th>
				
				<th class="collapse">Status</th>
			</tr>
		</thead>
		<tbody>
	    <?php foreach ($sends[1] as $send): ?>
	        <tr>
				<td class="align-center"><?php echo "F".$send['id']; ?></td>
				<td class="align-center">
					<?php echo $send['username']; ?>
				</td>
				<td class="align-center"><?php echo $send['inmates_name'] ?></td>
				<td class="align-center"><?php echo $send['facility_name'] ?></td>
				<td class="align-center"><?php echo $send['photos_sent'] ?></td>
				<td class="align-center"><?php echo $send['amount']."$"; ?></td>
				<td class="align-center">
				    <?php if($send['if_not_delivered'] == 1) {
							echo "Destroy data";
						}
						else{
							echo "Return to address";
						}
					?>
				</td>
				<td class="align-center"><?php echo $send['sent_date'] ?></td>
				<td class="align-center">
					<?php 
					    if($send['status'] == 1){ 
					        echo 'Received by Admin';} 
					    else if($send['status'] == 2){
					        echo 'In Transit';} 
				        else { 
				            echo 'Delivered';
			            }
		            ?>
				</td>
			</tr>
	    <?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
<style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    table, th, td {
      border: 1px solid black;
      text-align: center;
    }
</style>