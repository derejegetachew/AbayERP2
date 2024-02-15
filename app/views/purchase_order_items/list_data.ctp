{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($purchase_order_items as $purchase_order_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $purchase_order_item['PurchaseOrderItem']['id']; ?>",
				"purchase_order":"<?php echo $purchase_order_item['PurchaseOrder']['name']; ?>",
				"item":"<?php echo $purchase_order_item['Item']['name']; ?>",
				"measurement":"<?php echo $purchase_order_item['PurchaseOrderItem']['measurement']; ?>",
				"ordered_quantity":"<?php echo $purchase_order_item['PurchaseOrderItem']['ordered_quantity']; ?>",
				"purchased_quantity":"<?php echo $purchase_order_item['PurchaseOrderItem']['purchased_quantity']; ?>",
				"unit_price":"<?php echo $purchase_order_item['PurchaseOrderItem']['unit_price']; ?>",
				"created":"<?php echo $purchase_order_item['PurchaseOrderItem']['created']; ?>",
				"modified":"<?php echo $purchase_order_item['PurchaseOrderItem']['modified']; ?>"			}
<?php $st = true; } ?>		]
}