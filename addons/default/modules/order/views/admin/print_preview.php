  <?php if(isset($style)){
  		$float = "float:right;";
  	}else{
  		$float = "float:left;";
  	} 
  ?>
  <?php $abc = 1; ?>
  <div id="printReceipt" style="width:300px; border:2px solid black; padding-left:15px; <?php echo $styleFloat; ?>
  <?php if($styleFloat=="float:left;"){ ?>
  margin-left:30px;
  <?php } else {?> 
  margin-right:30px;
  <?php } ?>
  
  ;margin-top:90px;" >
       <br><br>

                      <h1 align="center" style="margin-top:-30px;">DEPOSIT SLIP</h1>
               
                
                    <?php foreach ($value as $user){ }  ;?>         
                      
                   
                        <!-- <p><u>Please Print</u>&nbsp;&nbsp;&nbsp;&nbsp;<u>Por favor escribe en model</u></p> -->
                        <p><u><?php echo ucfirst($user['inmates_name']);?></u><br><b>INMATES NAME</b><br>(NOMBRE DEL PRESO)</p>
                         <br>  
                        <p><u><?php echo $user['inmates_booking_no'];?></u><br><b>BOOKING NUMBER</b><br>(NUMERO DEL PRESO)</p>
                          <br>  
                         <p>$&nbsp;<u><?php echo $user['original_amount'];?>&nbsp;USD</u><br><b>AMOUNT</b><br>(CANTIDA)</p>
                         <br>
                         <p><u><?php echo $user['user_name'];?></u><br><b>DEPOSITED BY</b> (DEPOSITADO POR)<br>PRINT (EN LETRA DE MOLDE)</p>
                     	
 </div>       
<?php if(isset($whichkey)){
	echo '<div class="clearfix;"></div>';
} ?>
