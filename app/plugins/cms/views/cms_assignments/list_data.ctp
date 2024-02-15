{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($cms_assignments as $cms_assignment){ if($st) echo ","; ?>			{
				"id":"<?php echo $cms_assignment['CmsAssignment']['id']; ?>",
				"cms_case":"<?php echo $cms_assignment['CmsCase']['name']; ?>",
				"assigned_by":"<?php echo $cms_assignment['CmsAssignment']['assigned_by']; ?>",
				"assigned_to":"<?php echo $cms_assignment['CmsAssignment']['assigned_to']; ?>",
				"created":"<?php echo $cms_assignment['CmsAssignment']['created']; ?>"			}
<?php $st = true; } ?>		]
}