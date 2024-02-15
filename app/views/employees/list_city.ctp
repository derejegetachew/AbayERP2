<?php //print_r($employees);?>
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employees as $employee){ if($st) echo ","; $pre = ""; $post = ''; ?>			{
            "id":"<?php echo $employee['Employee']['id']; ?>",
            "city":"<?php echo $pre . $employee['Employee']['city'] . $post; ?>"			
        }
<?php $st = true; } ?>		]
}