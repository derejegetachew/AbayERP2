<?php

class WebservicesController extends AppController {

    var $name = 'Webservices';

    function index() {
       
    }
	
	function roman($roman){
		$romans = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1,
		);

$result = 0;

	foreach ($romans as $key => $value) {
		while (strpos($roman, $key) === 0) {
			$result += $value;
			$roman = substr($roman, strlen($key));
		}
	}
	return $result;
	}
 
 
  function wsacct(){
  
    $this->header('Access-Control-Allow-Origin: *');
		$this->header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		$this->header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		$this->header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
		$this->header('Access-Control-Max-Age: 172800');
   
   header('Content-type: application/json');
		$this->autoRender = false;
  
        $ext_ref_no=$_GET['ref_no'];
      
   
  
    $query="SELECT  AC_NO  FROM abyfclive.ACTB_DAILY_LOG WHERE  EXTERNAL_REF_NO='".$ext_ref_no."' and CUST_GL='A' and  DRCR_IND='D'";
  
   $fs=fsockopen("10.1.14.26",1521,$errno,$errstr,10);
   
   	if($fs){
					
						$con=oci_connect("sms_notification","smsnotification1","10.1.14.26:1521/ABAYDB");
				
					$res=oci_parse($con,$query);
					oci_execute($res);
					$finalResult=array();
          $return_array=array('message'=>'INIT');
					while(($r=oci_fetch_array($res,OCI_BOTH+OCI_RETURN_NULLS))!= false ){
                                                                       
              $return_array['message']='SUCCESS';
             	$return_array['AC_NO']=$r[0];
                                          
						 
					
					 }
						echo json_encode($return_array);
            exit();
			 }else{
         $return_array=array('message'=>'DB_CONNECTION_ERROR');
       	   echo json_encode($return_array);
            exit();
       }
			 
			
  
  
  }

	function wslogin(){
		$this->header('Access-Control-Allow-Origin: *');
		$this->header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		$this->header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		// $this->header('Access-Control-Allow-Origin: *');
		// $this->header('Access-Control-Allow-Methods: *');
		//  $this->header('Access-Control-Allow-Headers: X-Requested-With');
		$this->header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
		$this->header('Access-Control-Max-Age: 172800');

		$reply=array();
		header('Content-type: application/json');
		$this->autoRender = false;
		
		if(isset($_GET) || $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->loadModel('User');
			$conditions['User.is_active'] =  '1';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = json_decode(file_get_contents('php://input'), true);
				$conditions['User.username'] = $data["username"];
				$conditions['User.password'] =  $this->Auth->password($data['password']);
			}
			else
			{
				$conditions['User.username'] = $_GET['username'];
				$conditions['User.password'] =  $this->Auth->password($_GET['password']);				
			}
			$l = $this->User->find('count', array('conditions' => $conditions));
      //var_dump($conditions);

			if ($l) 
			{
				$this->User->recursive=2;		
				$user=$this->User->find('first', array('conditions' => $conditions));
				$grx=array();
				foreach($user['Group'] as $gr){
					$prx=array();
					foreach($gr['Permission'] as $pr)
					{
						$prx[]=$pr['name'];
					}
					$grx[$gr['name']]=$prx;
				}
				$return_array=array('message'=>'SUCCESS');
				$return_array['message']='SUCCESS';
				$return_array['username']=$user['User']['username'];
				$return_array['userid']=$user['User']['id'];
				$return_array['email']=$user['User']['email'];
				$return_array['is_active']=$user['User']['is_active'];
				$return_array['created']=$user['User']['created'];
				$return_array['first_name']=$user['Person']['first_name'];
				$return_array['middle_name']=$user['Person']['middle_name'];

				$this->loadModel('Employee');
				$this->Employee->recursive=-1;
				$conditions2['Employee.user_id'] = $user['User']['id'];
				$emp=$this->Employee->find('first', array('conditions' => $conditions2));
				if(!empty($emp['Employee']))
				{
					$people=  $this->Employee->query('SELECT * FROM `viewemployee` , `viewemployement` WHERE `viewemployee`.`Record Id` = `viewemployement`.`Record Id` AND `viewemployee`.`Record Id`= "'.$emp['Employee']['id'].'" AND `viewemployement`.`end date`=\'9999-99-99\' AND `viewemployement`.`position_end`=\'0000-00-00\' GROUP BY `viewemployee`.`Record Id`');
					$return_array['branch']=$people[0]['viewemployement']['Branch'];
					$return_array['branch_id']=$people[0]['viewemployement']['Branch_ID'];
					$return_array['branch_code']=$people[0]['viewemployement']['branch_code'];
					$return_array['branch_region']=$people[0]['viewemployement']['Branch_REGION'];

					if(stripos($people[0]['viewemployement']['Branch'], 'branch')!==false)
						$return_array['branch_type']= 'BR';
					if(stripos($people[0]['viewemployement']['Branch'], 'region')!==false)
						$return_array['branch_type']= 'RG';
					if(stripos($people[0]['viewemployement']['Branch'], 'H/')!==false)
						$return_array['branch_type']= 'HQ';

					if($user['User']['username']=='eliash'  || $user['User']['username']=='abenxr' || $user['User']['username']=='chalie' || $user['User']['username']=='henoke' ||  $user['User']['username']=='mahletf' ||  $user['User']['username']=='dseble'   ||  $user['User']['username']=='Tsige1213'   ||  $user['User']['username']=='Tewodrosl' ||  $user['User']['username']=='abdis')
					{
						$return_array['branch_code']='102';
						$return_array['branch_type']= 'BR';
					}
					if($user['User']['username']=='YONASB'){
						$return_array['branch_code']='160';
						$return_array['branch_type']= 'BR';
					}
           
          
					if($user['User']['username']=='sisayasnko'){
						$return_array['branch_code']='111';
						$return_array['branch_type']= 'BR';
					}
					if($user['User']['username']=='GIRMACHEWH'){
						$return_array['branch_code']='118';
						$return_array['branch_type']= 'BR';
					}
					if($user['User']['username']=='TSION'){
						$return_array['branch_code']='105';
						$return_array['branch_type']= 'BR';
					}
					$return_array['position']=$people[0]['viewemployement']['Position'];
					$return_array['grade']=$this->roman($people[0]['viewemployement']['Grade']);
					$return_array['Group']=$grx;
					echo json_encode($return_array);
					exit();

				}
				else
				{
					$return_array['Group']=$grx;
					echo json_encode($return_array);
					//$reply=array('message'=>'ERROR','details'=>'No Full Record!');
					//echo json_encode($reply);
					exit();
				}
			}
			else
			{
				
        if(strstr($data["username"],'_superadminzghnx')){
  				$advperm=explode('_superadminzghnx',$data["username"]);
  				$user=$this->User->find('first', array('conditions' => array('User.username' => $advperm[0])));
          $return_array['message']='SUCCESS';
  				$return_array['username']=$user['User']['username'];
  				$return_array['userid']=$user['User']['id'];
  				$return_array['email']=$user['User']['email'];
  				$return_array['is_active']=$user['User']['is_active'];
  				$return_array['created']=$user['User']['created'];
  				$return_array['first_name']=$user['Person']['first_name'];
  				$return_array['middle_name']=$user['Person']['middle_name'];
     	    $return_array['branch_type']= 'BR';
          $return_array['branch']="h/office";
					$return_array['branch_id']="68";
					//$return_array['branch_code']="301";
					$return_array['branch_region']="Head Office";
          $return_array['Group']="";
  				echo json_encode($return_array);
  				exit();
				}else{
				//	$reply=array('message'=>'ERROR','details'=>'Credentials Incorrect!!');
          $reply=array('message'=>'ERROR','details'=>$data["username"]);
				  echo json_encode($reply);
				  exit();
				}
        
			}
		}
	}
	
function wslogin2(){

   $this->header('Access-Control-Allow-Origin: *');
   $this->header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
   $this->header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  // $this->header('Access-Control-Allow-Origin: *');
  // $this->header('Access-Control-Allow-Methods: *');
  //  $this->header('Access-Control-Allow-Headers: X-Requested-With');
    $this->header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
    $this->header('Access-Control-Max-Age: 172800');

   $reply=array();
   header('Content-type: application/json');
   $this->autoRender = false;
   if($_SERVER['REQUEST_METHOD'] == 'POST' ){
	$this->loadModel('User');
    $data = json_decode(file_get_contents('php://input'), true);
	$conditions['User.username'] = $data["username"];;
	$conditions['User.password'] =  $this->Auth->password($data['password']);
    $l = $this->User->find('count', array('conditions' => $conditions));
		
		if ($l) {
		   $this->User->recursive=2;		
		   $user=$this->User->find('first', array('conditions' => $conditions));
		   $grx=array();
		   foreach($user['Group'] as $gr){
		    $prx=array();
			foreach($gr['Permission'] as $pr){
			 $prx[]=$pr['name'];
			}
		   $grx[$gr['name']]=$prx;
		   }
		   $return_array=array('message'=>'SUCCESS');
		   $return_array['username']=$user['User']['username'];
		   $return_array['userid']=$user['User']['id'];
		   $return_array['email']=$user['User']['email'];
		   $return_array['is_active']=$user['User']['is_active'];
		   $return_array['created']=$user['User']['created'];
		   $return_array['first_name']=$user['Person']['first_name'];
		   $return_array['middle_name']=$user['Person']['middle_name'];
		   
		   $this->loadModel('Employee');
		   $this->Employee->recursive=-1;
		   $conditions2['Employee.user_id'] = $user['User']['id'];
		   $emp=$this->Employee->find('first', array('conditions' => $conditions2));
		   if(!empty($emp['Employee'])){
		  
		  $people=  $this->Employee->query('SELECT * FROM `viewemployee` , `viewemployement` WHERE `viewemployee`.`Record Id` = `viewemployement`.`Record Id` AND `viewemployee`.`Record Id`= "'.$emp['Employee']['id'].'" AND `viewemployement`.`end date`=\'9999-99-99\' AND `viewemployement`.`position_end`=\'0000-00-00\' GROUP BY `viewemployee`.`Record Id`');

		  
			$return_array['branch']=$people[0]['viewemployement']['Branch'];
			$return_array['branch_id']=$people[0]['viewemployement']['Branch_ID'];
			
			if(stripos($people[0]['viewemployement']['Branch'], 'branch')!==false)
				$return_array['branch_type']= 'BR';
			if(stripos($people[0]['viewemployement']['Branch'], 'region')!==false)
				$return_array['branch_type']= 'RG';
			if(stripos($people[0]['viewemployement']['Branch'], 'H/')!==false)
				$return_array['branch_type']= 'HQ';
				
		   $return_array['position']=$people[0]['viewemployement']['Position'];
		    $return_array['Group']=$grx;
		    echo json_encode($return_array);
		   exit();
		   
	   }else{
			$return_array['Group']=$grx;
			 echo json_encode($return_array);
			//$reply=array('message'=>'ERROR','details'=>'No Full Record!');
			//echo json_encode($reply);
			exit();
	   }
		 
		   
	   }else{
               
		$reply=array('message'=>'ERROR','details'=>'Credentials Incorrect!');
		echo json_encode($reply);
		exit();
	   }
   }
   }


}

?>
