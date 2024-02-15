<?php 


 class Utility extends AppController{
	
	function __construct(){
		
	}
	
	
	public function UpdateCumulative($cmdText){
		try{
			$this->loadModel('BpCumulative');
			$this->BpCumulative->query($cmdText);
			if($this->BpCumulative->query($cmdText)==1)
				return true;
			else
				return false;
		}catch(Exception $e)
		{$e->getMessage();}
	}
	
	public function IsApproved($PlanId,$MonthId){
		try{
			$this->loadModel('BpPlan');
			$cmd="SELECT id FROM BpPlan WHERE bp_month_id=$MonthId and id=$PlanId";
			$id=$this->BpPlan->find('first',array('conditions'=>array('BpPlan.bp_month_id'=>$MonthId,'BpPlan.id'=>$PlanId)));
			var_dump($id);
			if(true)
				return true;
			else
				return false;
		}catch(Exception $e)
		{$e->getMessage();}
	}
	
	public  function IsActualExist($RefNo,$AccountNo){
		try{
				$this->loadModel('BpActualDetail');
				$cmd="select RefNo from bp_actual_details where RefNo='$RefNo' and GLCode='$AccountNo'";
				$reuslt=$this->BpActualDetail->query($cmd);
				if(count($reuslt)>=1){
					return true;
				}else{
					return false;
				}
			
		}catch(Exception $e){$e->getMessage();}
	}
	
	public function export($json_data=null,$table_name=null,$model_name=null){

		//$this->autoRender = false;
		//$json_like_string=$_GET['ob'];
		//$json=json_decode($json_like_string);

       
		$json=$json_data;
		$result_array=array();
		
		try{
			header("Content-Type: text/xls;charset=utf-8");
			header('Content-disposition: attachment; filename=Performance.csv');
			
			$output=fopen("php://output", "w");
			  // if plan is for all months.
           $values=Utility::getTableColumns($table_name);
          
			fputcsv($output, $values);
             foreach ($json as $item => $j){
                 $arr=(array)$j;
                 if($model_name!=null){
                foreach ($values as $k => $v) {
                	if(isset($arr[$model_name][$v])){
                	if($arr[$model_name][$v]!=null)
                		$result_array[]=$arr[$model_name][$v];
                	else
                		$result_array[]="";
                   }else{
                   	$result_array[]="";
                   }
                }
            }else{
 				foreach ($values as $k => $v) {
                	if(isset($arr[$v])){
                	if($arr[$v]!=null)
                		$result_array[]=$arr[$v];
                	else
                		$result_array[]="";
                   }else{
                   	$result_array[]="";
                   }
                }


            }
             	
		    fputcsv($output, $result_array);
			   $result_array=array();
			 }
			
			fclose($output);
			exit();

		}catch(Exception $e){

		}
		
	}

 private function getTableColumns($tableName=null){
	$this->loadModel('IbdImportPermit');
   $values= array();
   $cmd=" select COLUMN_NAME from information_schema.COLUMNS WHERE TABLE_SCHEMA='hr' AND TABLE_NAME='$tableName';";
   $result=$this->IbdImportPermit->query($cmd);
   
   foreach ($result as $key => $value) {
   $values[]=$value['COLUMNS']['COLUMN_NAME'];
   }
   return $values;
}
public function Log($ref_no,$user_name,$stat,$date){
		$this->loadModel('IbdLog');
        $cmd="INSERT INTO ibd_logs (user_name,ref_no,stat,`date`) values('$user_name','$ref_no','$stat','$date')";
		$this->IbdLog->query($cmd);
	}
	
	
	
}




?>