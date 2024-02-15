<?php //print_r($employees);?>
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employees as $employee){ if(!empty($employee['User'])){ if($st) echo ","; $pre = ""; $post = '';  ?>			{
            "id":"<?php echo $employee['Employee']['id']; ?>",
            "employee_name":"<?php echo $pre . $employee['User']['Person']['first_name'] . ' ' . $employee['User']['Person']['middle_name'] . ' ' . $employee['User']['Person']['last_name'] . $post; ?>",
            "identification_card_number":"<?php echo $pre . $employee['Employee']['card'] . $post; ?>",
            "date_of_employment":"<?php echo $pre . $employee['Employee']['date_of_employment'] . $post; ?>",
            "terms_of_employment":"<?php echo $pre . $employee['Employee']['terms_of_employment'] . $post; ?>",
            "created":"<?php echo $pre . date('F d, Y', strtotime($employee['Employee']['created'])) . $post; ?>"			
        }
<?php $st = true; } } ?>		]
}