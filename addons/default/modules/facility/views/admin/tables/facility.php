<?php if (!empty($facility)): ?>
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<!-- <th with="30" class="align-center"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th> -->
				<th>Facility Name</th>
				<th class="collapse">Facility Address</th>
				<th></th>
				<th class="collapse">Facility County</th>
				<!-- <th class="collapse">Money Accept</th> -->
				<!-- <th class="collapse">Photo Accept</th> -->
				<th class="collapse">Facility Active</th>
				<th width="200"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($facility as $k=> $v): ?>
				<tr>
					<!-- <td class="align-center"><?php //echo form_checkbox('action_to[]', $v['id']) ?></td> -->
					<td><?php echo $v['name'];?></td>
					<td class="collapse"><?php echo $v['address'];?></td>
					<td></td>
					<td class="collapse"><?php echo $v['county'];?></td>
					<!-- <td class="collapse">
						<label class="toggle-switch-yn<?php if($v['money_option'] == 1)echo ' on';?>">
							<span>
								<input class="switch-yn money_option" type="checkbox" data-id="<?php echo $v['id'];?>" <?php if($v['money_option'] == 1){echo 'data-value="0"';}else{ echo 'data-value= "1"';}?>/>
							</span>
						</label>
					</td>
					<td class="collapse">
						<label class="toggle-switch-yn<?php if($v['photo_option'] == 1)echo ' on';?>">
							<span>
								<input class="switch-yn photo_option" type="checkbox" data-id="<?php echo $v['id'];?>" <?php if($v['photo_option'] == 1){echo 'data-value="0"';}else{ echo 'data-value= "1"';}?>/>
							</span>
						</label>
					</td> -->
					<td class="collapse">
					    <label class="toggle-switch<?php if($v['active'] == 1)echo ' on';?>">
					    	<span>
					    		<input class="switch" data-id="<?php echo $v['id'];?>" type="checkbox" <?php if($v['active'] == 1){echo 'data-value="0"';}else{ echo 'data-value="1"';}?>/>
				    		</span>
				    	</label>
					</td>
					<td class="actions" style="text-align:center;">
						<?php echo anchor('admin/facility/edit/' . $v['id'], lang('global:edit'), array('class'=>'button edit')) ?>
						<?php echo anchor('admin/facility/delete/' . $v['id'], lang('global:delete'), array('class'=>'confirm button delete')) ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>