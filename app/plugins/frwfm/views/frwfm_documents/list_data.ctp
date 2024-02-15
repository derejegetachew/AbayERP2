{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($frwfm_documents as $frwfm_document){ if($st) echo ","; ?>			{
				"id":"<?php echo $frwfm_document['FrwfmDocument']['id']; ?>",
				"frwfm_application":"<?php echo $frwfm_document['FrwfmApplication']['id']; ?>",
				"name":"<?php echo $frwfm_document['FrwfmDocument']['name']; ?>",
				"file_path":"<?php echo $frwfm_document['FrwfmDocument']['file_path']; ?>",
				"created":"<?php echo $frwfm_document['FrwfmDocument']['created']; ?>"			}
<?php $st = true; } ?>		]
}