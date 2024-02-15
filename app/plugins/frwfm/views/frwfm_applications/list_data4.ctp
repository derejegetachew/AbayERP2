{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($frwfm_applications as $frwfm_application){ if($st) echo ","; ?>			{
				"id":"<?php echo $frwfm_application['FrwfmApplication']['id']; ?>",
				"branch":"<?php echo $frwfm_application['Branch']['name']; ?>",
				"user":"<?php echo $frwfm_application['User']['Person']['first_name'].' '.$frwfm_application['User']['Person']['middle_name']; ?>",
				"status":"<?php echo $frwfm_application['FrwfmApplication']['status']; ?>",
				"order":"<?php echo $frwfm_application['FrwfmApplication']['order']; ?>",
				"name":"<?php echo $frwfm_application['FrwfmApplication']['name']; ?>",
				"date":"<?php echo $frwfm_application['FrwfmApplication']['date']; ?>",
				"location":"<?php echo $frwfm_application['Location']['name']; ?>",
				"mobile_phone":"<?php echo $frwfm_application['FrwfmApplication']['mobile_phone']; ?>",
				"email":"<?php echo $frwfm_application['FrwfmApplication']['email']; ?>",
				"amount":"<?php echo $frwfm_application['FrwfmApplication']['amount']; ?>",
				"currency":"<?php echo $frwfm_application['FrwfmApplication']['currency']; ?>",
				"expiry_date":"<?php echo $frwfm_application['FrwfmApplication']['expiry_date']; ?>",
				"license":"<?php echo $frwfm_application['FrwfmApplication']['license']; ?>",
				"created":"<?php echo $frwfm_application['FrwfmApplication']['created']; ?>",
				"color":"<?php echo $frwfm_application['FrwfmApplication']['color']; ?>",
				"modified":"<?php echo $frwfm_application['FrwfmApplication']['modified']; ?>"			}
<?php $st = true; } ?>		]
}