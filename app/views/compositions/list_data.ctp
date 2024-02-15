{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($compositions as $composition){ if($st) echo ","; ?>			{
				"id":"<?php echo $composition['Composition']['id']; ?>",
				"position":"<?php echo $composition['Position']['name']; ?>",
				"branch":"<?php echo $composition['Branch']['name']; ?>",
				"count":"<?php echo $composition['Composition']['count']; ?>",
				"hired":"<?php echo $composition['Composition']['hired']; ?>",
        "vacant":"<?php 
        if($composition['Composition']['count']-$composition['Composition']['hired']<0){
         echo 0; 
         }else{
           echo $composition['Composition']['count']-$composition['Composition']['hired'];
         }
        
        
        ?>",
        
        "additional":"<?php  
        if($composition['Composition']['hired']-$composition['Composition']['count']<0){
        echo 0;
        }else{
         echo $composition['Composition']['hired']-$composition['Composition']['count'];
        } ; 
        
        ?>",
				"created":"<?php echo $composition['Composition']['created']; ?>",
				"modified":"<?php echo $composition['Composition']['modified']; ?>"			}
<?php $st = true; } ?>		]
}