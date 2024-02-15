<?php //print_r($employees);
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
?>
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employees as $employee){ if(!empty($employee['User'])){ if($st) echo ","; $pre = ""; $post = '';  ?>			{
            "id":"<?php echo $employee['Employee']['id']; ?>",
            "employee_name":"<?php echo $pre . $employee['User']['Person']['first_name'] . ' ' . $employee['User']['Person']['middle_name'] . ' ' . $employee['User']['Person']['last_name'] . $post; ?>",
            "identification_card_number":"<?php echo $pre . $employee['Employee']['card'] . $post; ?>",
            "date_of_employment":"<?php array_sort_by_column($employee['EmployeeDetail'],"start_date"); echo $pre . $employee['EmployeeDetail'][0]['start_date'] . $post; ?>",
            "terms_of_employment":"<?php echo $pre . $employee['Employee']['terms_of_employment'] . $post; ?>",
            "experience":"<?php echo count($employee['Experience']); ?>",
            "education":"<?php echo count($employee['Education']); ?>",
            "children":"<?php echo count($employee['Offspring']); ?>",
            "language":"<?php echo count($employee['Language']); ?>",
            "EmployeeDetail":"<?php echo count($employee['EmployeeDetail']); ?>",
            "created":"<?php echo $pre . date('F d, Y', strtotime($employee['Employee']['created'])) . $post; ?>"			
        }
<?php $st = true; } } ?>		]
}