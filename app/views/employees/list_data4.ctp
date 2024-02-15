<?php //print_r($employees);?>
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employees as $employee){ if(!empty($employee['EmpEmployee']['User']) && $employee['EmpEmployee']['status']=='active'){ if($st) echo ","; $pre = ""; $post = '';  ?>			{
            "id":"<?php echo $employee['EmpEmployee']['id']; ?>",
            "user_id":"<?php echo $employee['EmpEmployee']['user_id']; ?>",
            "employee_name":"<?php echo $pre . $employee['EmpEmployee']['User']['Person']['first_name'] . ' ' . $employee['EmpEmployee']['User']['Person']['middle_name'] . ' ' . $employee['EmpEmployee']['User']['Person']['last_name'] . $post; ?>",
            "identification_card_number":"<?php echo $pre . $employee['EmpEmployee']['card'] . $post; ?>",
            "date_of_employment":"<?php echo $pre . $employee['EmpEmployee']['date_of_employment'] . $post; ?>",
            "terms_of_employment":"<?php echo $pre . $employee['EmpEmployee']['terms_of_employment'] . $post; ?>",
            "created":"<?php echo $pre . date('F d, Y', strtotime($employee['EmpEmployee']['created'])) . $post; ?>"			
        }
<?php $st = true; } } ?>		]
}