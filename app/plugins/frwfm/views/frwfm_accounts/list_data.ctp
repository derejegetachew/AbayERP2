{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php App::import('Sanitize'); $st = false; foreach($frwfm_accounts as $frwfm_account){ if($st) echo ","; ?>			{
				"id":"<?php echo $frwfm_account['FrwfmAccount']['id']; ?>",
				"frwfm_application":"<?php echo $frwfm_account['FrwfmApplication']['id']; ?>",
				"acc_no":"<?php echo $frwfm_account['FrwfmAccount']['acc_no']; ?>",
				"name":"<?php echo Sanitize::paranoid($frwfm_account['FrwfmAccount']['name'],array(' ')); ?>",
				"branch":"<?php echo $frwfm_account['FrwfmAccount']['branch']; ?>",
				"amount":"<?php echo $frwfm_account['FrwfmAccount']['amount']; ?>",
				"currency":"<?php echo $frwfm_account['FrwfmAccount']['currency']; ?>",
				"type":"<?php echo $frwfm_account['FrwfmAccount']['type']; ?>",
				"type_desc":"<?php echo $frwfm_account['FrwfmAccount']['type_desc']; ?>",
				"created":"<?php echo $frwfm_account['FrwfmAccount']['created']; ?>",
				"modified":"<?php echo $frwfm_account['FrwfmAccount']['modified']; ?>"		}
<?php $st = true; } ?>		]
}