<?php 
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 3))); // 1 hour//print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($people as $person){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $person['viewemployee']['Record Id']; ?>",
            "full_name":"<?php echo $pre . $person['viewemployee']['First Name'].' '.$person['viewemployee']['Middle Name'].' '.$person['viewemployee']['Last Name'] . $post; ?>",			
            "position":"<?Php echo $person['viewemployement']['Position'].' / '.$person['viewemployement']['Branch']; ?>",
			"photo":"<?Php if($person['viewemployee']['photo']==''){
			if($person['viewemployee']['Sex']=='M')
			   echo 'http://10.1.85.11/AbayERP/img/employee_photos/male.jpg';
            else
			   echo 'http://10.1.85.11/AbayERP/img/employee_photos/female.jpg';
			}
			else echo 'http://10.1.85.11/AbayERP/img/employee_photos/'.$person['viewemployee']['photo']; ?>",
            "user_id":"<?Php echo $person['viewemployee']['user_id']; ?>"
        }
<?php $st = true; } ?>		
        ]
}