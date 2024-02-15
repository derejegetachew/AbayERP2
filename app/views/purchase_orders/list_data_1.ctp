<?php //pr($purchase_orders); ?>
{
    success: true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($purchase_orders as $purchase_order){ if($st) echo ","; ?>			{
        "id":"<?php echo $purchase_order['PurchaseOrder']['id']; ?>",
        "name":"<?php echo $purchase_order['PurchaseOrder']['name']; ?>",
        "user":"<?php echo $purchase_order['User']['username'] . ' (' . 
            $purchase_order['User']['Person']['first_name'] . ' ' . $purchase_order['User']['Person']['middle_name'] . ' ' . 
            $purchase_order['User']['Person']['last_name'] . ')'; ?>",
        "posted":"<?php echo $purchase_order['PurchaseOrder']['posted']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "approved":"<?php echo $purchase_order['PurchaseOrder']['approved']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "rejected":"<?php echo $purchase_order['PurchaseOrder']['rejected']? '<font color=green>True</font>': '<font color=red>False</font>'; ?>",
        "created":"<?php echo $purchase_order['PurchaseOrder']['created']; ?>",
        "modified":"<?php echo $purchase_order['PurchaseOrder']['modified']; ?>"			}
<?php $st = true; } ?>		]
}