{
    success:true,
    results: <?php echo $results; ?>,
    rows: [
<?php $st = false; foreach($cards as $card){ if($st) echo ","; ?>			{
        "id":"<?php echo $card['Card']['id']; ?>",
        "item":"<?php echo $card['Item']['name'] . ' - ' . $card['Item']['description']; ?>",
        "in_quantity":"<?php echo $card['Card']['in_quantity']; ?>",
        "out_quantity":"<?php echo $card['Card']['out_quantity']; ?>",
        "balance":"<?php echo $card['Card']['balance']; ?>",
        "in_unit_price":"<?php echo $card['Card']['in_unit_price']; ?>",
        "out_unit_price":"<?php echo $card['Card']['out_unit_price']; ?>",
        "grn":"<?php echo $card['Grn']['name']; ?>",
        "created":"<?php echo $card['Card']['created']; ?>",
        "modified":"<?php echo $card['Card']['modified']; ?>"			}
<?php $st = true; } ?>		]
}