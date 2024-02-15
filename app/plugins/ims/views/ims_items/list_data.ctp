
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($items as $item){ if($st) echo ","; pr($item);?>			{
                "id":"<?php echo $item['ImsItem']['id']; ?>",
                "name":"<?php echo $item['ImsItem']['name']; ?>",
                "description":"<?php echo $item['ImsItem']['description']; ?>",
                "item_category":"<?php echo (strlen($item['ImsItemCategory']['id']) < 2? '0' . $item['ImsItemCategory']['id']: $item['ImsItemCategory']['id']) .'-'. $item['ImsItemCategory']['name']; ?>",
                "max_level":"<?php echo $item['ImsItem']['max_level']; ?>",
                "min_level":"<?php echo $item['ImsItem']['min_level']; ?>",
				"type":"<?php echo $item['ImsItem']['booked'] == true?'<font color=red>Booked</font>': '<font color=green>Expense</font>'; ?>",
				"fixed_asset":"<?php echo $item['ImsItem']['fixed_asset'] == true?'<font color=green>Yes</font>': '<font color=black>No</font>'; ?>",
				"tag_code":"<?php echo $item['ImsItem']['tag_code']; ?>",
                "created":"<?php echo $item['ImsItem']['created']; ?>",
                "modified":"<?php echo $item['ImsItem']['modified']; ?>"
           }
<?php $st = true; } ?>
        ]
}