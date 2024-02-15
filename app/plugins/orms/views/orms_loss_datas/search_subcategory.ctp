{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($subcategories as $subcategory){ if($st) echo ","; ?>			{
				"id":"<?php echo $subcategory['OrmsRiskCategory']['id']; ?>",
				"name":"<?php echo $subcategory['OrmsRiskCategory']['name']; ?>"		}
<?php $st = true; } ?>		]
}