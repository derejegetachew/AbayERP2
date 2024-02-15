{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_Requisition_Items as $ims_Requisition_Item){ if($st) echo ","; ?>			{
				"code":"<?php echo $ims_Requisition_Item['i']['description']; ?>",
				"description":"<?php echo $ims_Requisition_Item['i']['name']; ?>",
				"measurement":"<?php echo $ims_Requisition_Item['ri']['measurement']; ?>",
				"quantity":"<?php echo $ims_Requisition_Item['ri']['quantity']; ?>",
				"issued":"<?php echo $ims_Requisition_Item['ri']['issued']; ?>",
				"remark":"<?php echo $ims_Requisition_Item['ri']['remark']; ?>",
				"balance":"<?php echo $ims_Requisition_Item[0]['balance'] ?>",
				"reserved":"<?php
					$result = $ims_Requisition_Item[0]['reserved'];					
					echo '<font color=red>'.$result.'</font>'; 
				?>",
				"balance_store":"<?php echo $ims_Requisition_Item[0]['store_balance']; ?>",
				"reserved_store":"<?php
					$result1 = 		$ims_Requisition_Item[0]['store_reserved'];						
					echo '<font color=red>'.$result1.'</font>'; 
				?>"}
<?php $st = true; } ?>		]
}