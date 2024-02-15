{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($delinquents as $delinquent){ if($st) echo ","; ?>			{
				"id":"<?php echo $delinquent['Delinquent']['id']; ?>",
				"Name":"<?php echo $delinquent['Delinquent']['Name']; ?>",
				"letter_no":"<?php echo $delinquent['Delinquent']['letter_no']; ?>",
				"Soundex_Name":"<?php echo $delinquent['Delinquent']['Soundex_Name']; ?>",
				"Closing_Bank":"<?php echo $delinquent['Delinquent']['Closing_Bank']; ?>",
				"Branch":"<?php echo $delinquent['Delinquent']['Branch']; ?>",
				"Date_Account_Closed":"<?php echo $delinquent['Delinquent']['Date_Account_Closed']; ?>",
				"Tin":"<?php echo $delinquent['Delinquent']['Tin']; ?>",
                                "created":"<?php echo $delinquent['Delinquent']['created']; ?>",
                                "type":"<?php  if ($delinquent['Delinquent']['type']==1){
                                 echo "Delinquent";
                                 }else if($delinquent['Delinquent']['type']==2) {
                                 echo "PEP";
                                 }else if($delinquent['Delinquent']['type']==3) {
                                 echo "Terminated";
                                 } ?>",
                                "holder":"<?php 
                               if ($delinquent['Delinquent']['holder']==1){
                                 echo "Individual";
                                 }else if($delinquent['Delinquent']['holder']==2) {
                                 echo "Company";
                                 } ?>",
				"Reason_For_Closing":"<?php echo $delinquent['Delinquent']['Reason_For_Closing']; ?>"}
<?php $st = true; } ?>		]
}