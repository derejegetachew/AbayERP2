{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grn_items as $grn_item){ if($st) echo ","; ?>{
<?php //print_r($grn_item);?>
            "id":"<?php echo $grn_item['ImsGrnItem']['id']; ?>",
            "grn":"<?php echo $grn_item['ImsGrn']['name']; ?>",
            "purchase_order_item":"<?php echo $grn_item['ImsPurchaseOrderItem']['ImsItem']['name']; ?>",
            "quantity":"<?php echo $grn_item['ImsGrnItem']['quantity']; ?>",
            "unit_price":"<?php echo $grn_item['ImsGrnItem']['unit_price']; ?>",
			"remark":"<?php echo $grn_item['ImsPurchaseOrderItem']['remark']; ?>",
            "created":"<?php echo $grn_item['ImsGrnItem']['created']; ?>",
            "modified":"<?php echo $grn_item['ImsGrnItem']['modified']; ?>"           }
<?php $st = true; } ?>		]
}