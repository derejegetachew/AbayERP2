{
        success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php  $st = false; foreach($purchase_order_items as $purchase_order_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['id']; ?>",
				"purchase_order":"<?php echo $purchase_order_item['ImsPurchaseOrder']['name']; ?>",
				"item":"<?php echo $purchase_order_item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['measurement']; ?>",
				"ordered_quantity":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['ordered_quantity']; ?>",
				"purchased_quantity":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['purchased_quantity']; ?>",
				"unit_price":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['unit_price']; ?>",
				"remark":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['remark']; ?>",
				"created":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['created']; ?>",
                                "modified":"<?php echo $purchase_order_item['ImsPurchaseOrderItem']['modified']; ?>",
				"total_price":"<?php echo ($purchase_order_item['ImsPurchaseOrderItem']['ordered_quantity'] * $purchase_order_item['ImsPurchaseOrderItem']['unit_price']) ; ?>"
                                      }
<?php $st = true; } ?>		]
}