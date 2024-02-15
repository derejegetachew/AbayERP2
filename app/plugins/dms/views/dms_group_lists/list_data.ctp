<?php //print_r($dms_group_lists); ?>
{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($dms_group_lists as $dms_group_list){ if($st) echo ","; ?>			{
				"id":"<?php echo $dms_group_list['DmsGroupList']['id']; ?>",
				"user":"<?php 
				if($dms_group_list['DmsGroupList']['type']=='position')
				echo $dms_group_list['Position']['name'];
				elseif($dms_group_list['DmsGroupList']['type']=='branch')
				echo $dms_group_list['Branch']['name'];
				else
				echo $dms_group_list['User']['Person']['first_name'].' '.$dms_group_list['User']['Person']['middle_name'].' '.$dms_group_list['User']['Person']['last_name']; ?>",
				"type":"<?php echo strtoupper($dms_group_list['DmsGroupList']['type']); ?>"			}
<?php $st = true; } ?>		]
}