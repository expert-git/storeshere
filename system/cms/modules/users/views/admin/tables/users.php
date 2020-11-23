<?php if (!empty($users)): ?>
<div>
	<table border="0" class="table-list display dataTable" cellpadding="0" cellpadding="0" id="table555">
	    <style>
	        tbody td{
	            text-align: center;
	        }
	        #search_column{
	            position: absolute; 
	            right: 250px; 
	            top: 210px; 
	            z-index: 100;
	        }
	    </style>
	    <div id = "search_column">
            <select>
                <option value="name">Name</option>
                <option value="email_phone">Email / Phone</option>
                <option value="active">Active</option>
                <option value="created_on">Joined</option>
                <option value="last_login">Last Visit</option>
            </select>
        </div>
		<thead>
			<tr>
				<th with="30" class="align-center no-sort"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				
				<th><?php echo lang('user:name_label');?></th>
				
				<th class="collapse"><?php echo lang('user:funds_photos_label');?></th>
				
				<th class="collapse"><?php echo lang('user:email_phone_label');?></th>
				
				<th><?php echo lang('user:group_label');?></th>
				
				<th class="collapse no-sort"><?php echo lang('user:inmates');?></th>
				
				<th class="collapse"><?php echo lang('user:active') ?></th>
				
				<th class="collapse"><?php echo lang('user:joined_label');?></th>
				
				<th class="collapse"><?php echo lang('user:last_visit_label');?></th>
				
				<th width="200"></th>
			</tr>
		</thead>
	</table>
</div>
	
<?php endif ?>
<script>
    $(document).ready(function(){
        var search_column = 'name'
        var ajax_url = "<?php echo current_url(); ?>"+"/ajax";
        filter();
        function filter(){
            var table = $('#table555').DataTable( {
              "pageLength": 25,
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  url: ajax_url,
                  type: "POST",
                  data: {
                      search_column_name: $("#search_column select").val()
                  },
              },
              'columns': [
                 { data: 'checkbox', "orderable": false, "targets": 0 },
                 { data: 'first_name' },
                 { data: 'funds/photos' },
                 { data: 'email/phone' },
                 { data: 'group_name' },
                 { data: 'inmates' },
                 { data: 'active' },
                 { data: 'created_on' },
                 { data: 'last_login' },
                 { data: 'edit/delete', "orderable": false, "targets": 0},
              ]
            });
            table.order([9, 'desc']).draw();
        }
        
        $("#table555_filter input").attr("placeholder", "Search...");
        
        $("#search_column select").change(function(){
            $('#table555').DataTable().destroy();
            filter();
        });
    });
</script>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        color: black !important;
    }
    #filters>form>ul>li:nth-child(3),
    #filters>form>ul>li:nth-child(4)
    {
        display: none;
    }
    #table555_filter input{
        height: 35px;
        width: 200px;
        font-size: 16px;
    }
    #table555>tbody>tr>td:nth-child(2),
    #table555>tbody>tr>td:nth-child(4)
    {
        text-align: left;
    }
</style>
