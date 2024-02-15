{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($compositions as $composition){ if($st) echo ","; ?>			{
				"id":"<?php echo $composition['Branch']['id']; ?>",
				"branch":"<?php echo $composition['Branch']['name']; ?>",
				"count":"<?php echo $composition[0]['SUM(Composition.count)']; ?>",
				"region":"<?php echo $composition['Branch']['region']; ?>",				
				"created":"<?php echo $composition['Composition']['created']; ?>",		}
<?php $st = true; } ?>		]
}