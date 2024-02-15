{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($mis_letters as $mis_letter){ if($st) echo ","; ?>			{
				<?php 
					$today = date("Y-m-d"); 
					$blue = date("Y-m-d", strtotime('+2 days'));
					$color = 'black';
					if($mis_letter['MisLetter']['deadline'] < $today)
						$color = 'red';
					else if ($mis_letter['MisLetter']['deadline'] <= $blue)
						$color = 'blue';
				?>
				"id":"<?php echo $mis_letter['MisLetter']['id']; ?>",
				"ref_no":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['ref_no'].'</font>'; ?>",
				"applicant":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['applicant'].'</font>'; ?>",
				"defendant":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['defendant'].'</font>'; ?>",
				"letter_no":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['letter_no'].'</font>'; ?>",
				"date":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['date'].'</font>'; ?>",
				"deadline":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['deadline'].'</font>'; ?>",
				"source":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['source'].'</font>'; ?>",
				"office":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['office'].'</font>'; ?>",
				"messenger":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['messenger'].'</font>'; ?>",
				"file":"<?php if($mis_letter['MisLetter']['file']!='No file') {
					echo '<font color = '.$color.'>' . 'Yes'.'</font>';
				}else echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['file'].'</font>'; ?>",
				"status":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['status'].'</font>'; ?>",
				"created_by":"<?php echo '<font color = '.$color.'>' . $mis_letter['CreatedUser']['Person']['first_name'].' '.$mis_letter['CreatedUser']['Person']['middle_name'].' '.$mis_letter['CreatedUser']['Person']['last_name'].'</font>'; ?>",
				"created":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['created'].'</font>'; ?>",
				"modified":"<?php echo '<font color = '.$color.'>' . $mis_letter['MisLetter']['modified'].'</font>'; ?>"			}
<?php $st = true; } ?>		]
}