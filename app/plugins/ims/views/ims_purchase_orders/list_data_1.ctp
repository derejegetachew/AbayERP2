<?php //pr($purchase_orders); ?>
{
    success: true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($purchase_orders as $purchase_order){ if($st) echo ","; ?>			{
        "id":"<?php echo $purchase_order['ImsPurchaseOrder']['id']; ?>",
        "name":"<?php echo $purchase_order['ImsPurchaseOrder']['name']; ?>",
		"supplier":"<?php echo $purchase_order['ImsSupplier']['name']; ?>",
		"planned":"<?php echo $purchase_order['ImsPurchaseOrder']['planned']? 'Planned':'<font color=red>Unplanned</font>'; ?>",
        "user":"<?php echo $purchase_order['User']['username'] . ' (' . 
            $purchase_order['User']['Person']['first_name'] . ' ' . $purchase_order['User']['Person']['middle_name'] . ' ' . 
            $purchase_order['User']['Person']['last_name'] . ')'; ?>",
        "posted":"<?php echo $purchase_order['ImsPurchaseOrder']['posted']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "approved":"<?php echo $purchase_order['ImsPurchaseOrder']['approved']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "rejected":"<?php echo $purchase_order['ImsPurchaseOrder']['rejected']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "created":"<?php echo $purchase_order['ImsPurchaseOrder']['created']; ?>",
        "modified":"<?php echo $purchase_order['ImsPurchaseOrder']['modified']; ?>"			}
<?php $st = true; } ?>		]
}