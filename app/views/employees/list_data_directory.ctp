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
<?php $st = false; foreach($employees as $employee){ if(true){ if($st) echo ","; $pre = ""; $post = '';  
    ?>			{
            
            "id":"<?php echo $employee['e']['Record Id']; ?>",
            "employee_name":"<?php echo $pre . $employee['e']['First Name'] . ' ' . $employee['e']['Middle Name'] . ' ' . $employee['e']['Last Name'] . $post; ?>",
            "identification_card_number":"<?php echo $employee['e']['Card']  ?>",
            "phone":"<?php echo $employee['e']['Telephone']; ?>",
            "photo":"<?php echo $employee[0]['photoX']; ?>",
            "Position":"<?php echo $employee['ve']['Position']; ?>",
            "Branch":"<?php echo $employee['ve']['Branch']; ?>",
            "Sex":"<?php echo $employee['e']['Sex']; ?>",
            "Branch_Phone":"<?php echo $employee['ve']['branch_phone']; ?>",
            "current_status":"<?php   if (( date("Y-m-d") >= $employee['m']['from_date']) && (date("Y-m-d") <= $employee['m']['to_date'])){
               echo "On Leave";
                 }else{
                echo "On Duty";  
                     }  ?>",
            
                  }
<?php $st = true; } } ?>		]
}