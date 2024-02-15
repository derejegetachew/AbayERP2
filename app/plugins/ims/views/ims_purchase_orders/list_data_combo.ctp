<?php //pr($purchase_orders); ?>
{
    success: true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($purchase_orders as $purchase_order){ if($st) echo ","; ?>			{
        "id":"<?php echo $purchase_order['ImsPurchaseOrder']['id']; ?>",
        "name":"<?php echo $purchase_order['ImsPurchaseOrder']['name']; ?>",
		"items":"<?php foreach($purchase_order['ImsPurchaseOrderItem'] as $poi){ echo $poi['ImsItem']['name']." , Ordered=".$poi['ordered_quantity']." | "; } ?>"
                                                                                }
<?php $st = true; } ?>		]
}