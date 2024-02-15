<?php //print_r($grn_items); ?>{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($grn_items as $grn_item){ if($st) echo ","; ?>			{
            "id":"<?php echo $grn_item['GrnItem']['id']; ?>",
            "grn":"<?php echo $grn_item['Grn']['name']; ?>",
            "purchase_order_item":"<?php echo $grn_item['PurchaseOrderItem']['Item']['name']; ?>",
            "quantity":"<?php echo $grn_item['GrnItem']['quantity']; ?>",
            "unit_price":"<?php echo $grn_item['GrnItem']['unit_price']; ?>",
            "created":"<?php echo $grn_item['GrnItem']['created']; ?>",
            "modified":"<?php echo $grn_item['GrnItem']['modified']; ?>"           }
<?php $st = true; } ?>		]
}