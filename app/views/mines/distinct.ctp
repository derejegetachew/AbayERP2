<?php //print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($distincts as $distinct){ if($st) echo ",";  ?>	
        {
            "distinct":"<?php echo $distinct; ?>"
        }
<?php $st = true; }  ?>		
        ]
}