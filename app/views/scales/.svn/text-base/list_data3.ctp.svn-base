{
	success:true,
	results: 10,
	rows: [
<?php $st = false; foreach($grades as $grade){ if($st) echo ","; ?>			{
				"grade-id":"<?php echo $grade['Grade']['id']; ?>",
                                "grade":"<?php echo $grade['Grade']['name']; ?>",
                                <?php 
                                $i=1;
                                foreach($steps as $step){                          
                                    echo "\t\t\t".'"'.$step['Step']['name'].'":"';
                                    echo $scales[$grade['Grade']['name']][$i];
                                    echo '",'."\n";
                                    $i++;
                                }
                                ?>
				}
<?php $st = true; } ?>		]
}