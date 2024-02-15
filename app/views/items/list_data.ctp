{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($items as $item){ if($st) echo ","; ?>			{
                "id":"<?php echo $item['Item']['id']; ?>",
                "name":"<?php echo $item['Item']['name']; ?>",
                "description":"<?php echo $item['Item']['description']; ?>",
                "item_category":"<?php echo $item['ItemCategory']['name']; ?>",
                "max_level":"<?php echo $item['Item']['max_level']; ?>",
                "min_level":"<?php echo $item['Item']['min_level']; ?>",
                "created":"<?php echo $item['Item']['created']; ?>",
                "modified":"<?php echo $item['Item']['modified']; ?>"			
           }
<?php $st = true; } ?>
        ]
}