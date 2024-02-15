{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($purchase_order_items as $po_item){ if($st) echo ","; ?> {
            "id":"<?php echo $po_item['PurchaseOrderItem']['id']; ?>",
            "grn_id":"<?php echo $po_item['PurchaseOrderItem']['grn_id']; ?>",
            "item":"<?php echo $po_item['Item']['name']; ?>",
            "ordered_quantity":"<?php echo $po_item['PurchaseOrderItem']['ordered_quantity']; ?>",
            "purchased_quantity":"<?php echo $po_item['PurchaseOrderItem']['purchased_quantity']; ?>",
            "ordered_unit_price":"<?php echo $po_item['PurchaseOrderItem']['unit_price']; ?>",
            "purchased_unit_price":"<?php echo $po_item['PurchaseOrderItem']['unit_price']; ?>"  }
<?php $st = true; } ?>		]
}