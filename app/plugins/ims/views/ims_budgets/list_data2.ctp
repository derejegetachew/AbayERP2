{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($purchase_order_items as $po_item){ if($st) echo ","; ?> {
            "id":"<?php echo $po_item['ImsPurchaseOrderItem']['id']; ?>",
            "ims_grn_id":"<?php echo $po_item['ImsPurchaseOrderItem']['ImsGrnItem']['ims_grn_id']; ?>",
            "item":"<?php echo $po_item['ImsItem']['name']; ?>",
            "ordered_quantity":"<?php echo $po_item['ImsPurchaseOrderItem']['ordered_quantity']; ?>",
            "purchased_quantity":"<?php echo $po_item['ImsPurchaseOrderItem']['purchased_quantity']; ?>",
            "ordered_unit_price":"<?php echo $po_item['ImsPurchaseOrderItem']['unit_price']; ?>",
            "purchased_unit_price":"<?php echo $po_item['ImsPurchaseOrderItem']['unit_price']; ?>"  }
<?php $st = true; } ?>		]
}