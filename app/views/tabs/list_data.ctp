{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($tabs as $tab){ if($st) echo ","; ?>			{
				"id":"<?php echo $tab['Tab']['id']; ?>",
				"name":"<?php echo $tab['Tab']['name']; ?>",
				"content":"<?php echo $tab['Tab']['content']; ?>",
				"created":"<?php echo $tab['Tab']['created']; ?>",
				"modified":"<?php echo $tab['Tab']['modified']; ?>"			}
<?php $st = true; } ?>		]
}