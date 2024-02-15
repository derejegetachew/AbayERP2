<?php //print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($positions as $position){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $position['positions']['id']; ?>",
            "full_name":"<?php echo $pre . $position['positions']['name'] ?>",			
           
			
        }
<?php $st = true; } ?>		
        ]
}