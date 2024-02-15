<?php //pr($purchase_orders); ?>
{
    success: true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($purchase_orders as $purchase_order){if($st) echo ","; ?>			{
        "id":"<?php echo $purchase_order['ImsPurchaseOrder']['id']; ?>",
        "name":"<?php echo $purchase_order['ImsPurchaseOrder']['name']; ?>",
		"supplier":"<?php echo $purchase_order['ImsSupplier']['name']; ?>",
		"planned":"<?php echo $purchase_order['ImsPurchaseOrder']['planned']? 'Planned':'<font color=red>Unplanned</font>'; ?>",
        "user":"<?php echo $purchase_order['User']['Person']['first_name'] . ' ' . $purchase_order['User']['Person']['middle_name'] . ' ' . 
                    $purchase_order['User']['Person']['last_name']; ?>",
		"approved_by":"<?php echo $purchase_order['ImsPurchaseOrder']['approved_by'] <> 0? $purchase_order['ApprovedUser']['Person']['first_name'] . ' ' . $purchase_order['ApprovedUser']['Person']['middle_name'] . ' ' . 
                    $purchase_order['ApprovedUser']['Person']['last_name']: ''; ?>",
        "postable":"<?php echo count($purchase_order['ImsPurchaseOrderItem']) > 0? 'True': 'False'; ?>",
        "posted":"<?php echo $purchase_order['ImsPurchaseOrder']['posted']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "approved":"<?php echo $purchase_order['ImsPurchaseOrder']['approved']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "rejected":"<?php echo $purchase_order['ImsPurchaseOrder']['rejected']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "completed":"<?php echo $purchase_order['ImsPurchaseOrder']['completed']; ?>",
        "created":"<?php echo $purchase_order['ImsPurchaseOrder']['created']; ?>",
        "modified":"<?php echo $purchase_order['ImsPurchaseOrder']['modified']; ?>"                                                                                 }
<?php $st = true; } ?>		]
}