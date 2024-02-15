<?php  //print_r($leamods); ?>
{
	success:true,
	results:2000 <?php // echo $results; ?>,
	rows: [
<?php $st = false; foreach($holidays as $holiday){ if($st) echo ","; ?>			{
				"id":"<?php echo $holiday['Holiday']['id']; ?>",
				"employee":"<?php echo $holiday['Employee']['User']['Person']['first_name'].' '.$holiday['Employee']['User']['Person']['middle_name'].' '.$holiday['Employee']['User']['Person']['last_name']; ?>",
				"leave_type":"<?php echo $holiday['LeaveType']['name']; ?>",
				"from_date":"<?php echo $holiday['Holiday']['from_date'];?>",
				"to_date":"<?php if($holiday['Holiday']['status']=='Resubmitted for Correction') echo $holiday['Holiday']['to_date'].' to '.$leamods[$holiday['Holiday']['id']]['LeaveModification']['to_new']; else echo $holiday['Holiday']['to_date']; ?>",
				"filled_date":"<?php echo $holiday['Holiday']['filled_date']; ?>",
				"status":"<?php echo $holiday['Holiday']['status']; ?>",
                "no_of_dates":"<?php if($holiday['Holiday']['status']=='Resubmitted for Correction' && $holiday['Holiday']['leave_type_id']==1) echo  $holiday['Holiday']['no_of_dates'].' to '.$leamods[$holiday['Holiday']['id']]['no_of_dates_full']; elseif($holiday['Holiday']['status']=='Resubmitted for Correction' && $holiday['Holiday']['leave_type_id']==2) echo  $holiday['Holiday']['no_of_dates'].' to '.($leamods[$holiday['Holiday']['id']]['no_of_dates_half']/2); else echo  $holiday['Holiday']['no_of_dates']; ?>"}
<?php $st = true; } ?>		]
}