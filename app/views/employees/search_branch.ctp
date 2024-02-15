<?php //print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($branchs as $branch){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $branch['branches']['id']; ?>",
            "full_name":"<?php echo $pre . $branch['branches']['name'] ;  ?>",			
          
			
        }
<?php $st = true; } ?>		
        ]
}