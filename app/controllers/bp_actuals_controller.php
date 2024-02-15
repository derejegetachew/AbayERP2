<?php

ini_set('max_execution_time',0);
//error_reporting(E_ALL);

require "Utility.php";

class BpActualsController extends AppController {

	var $name = 'BpActuals';
	
	function index() {
		$this->BpActual->Branch->recursive=0;
		$branches = $this->BpActual->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function getBranch() {
		$this->autoRender = false;
		$this->BpActual->Branch->recursive=0;
		$branches = $this->BpActual->Branch->find('all');
		
		$ar=array();
		foreach($branches as $user=>$j){
			//echo $j["User"];
			array_push($ar,array("id"=>$j["Branch"]["id"],"name"=>$j["Branch"]["name"]));
		}
		$final=array(
		     "num"=>count($ar),
			 "data"=>$ar
			 );
			 
		echo  json_encode($final);
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function fetch($id = null) {
  $this->layout = 'ajax';
		try{
		$this->loadModel('BpPlan');
		$this->set('parent_id', $id);
		$branch_id=$this->BpPlan->query('select branch_id from bp_plans where id='.$id);
		$month_id=$this->BpPlan->query('select bp_month_id from bp_plans where id='.$id);
		$branch_id=$branch_id[0]['bp_plans']['branch_id'];
		$month_id=$month_id[0]['bp_plans']['bp_month_id'];
	//	echo $branch_id;
		$this->BpActual->Branch->recursive=0;
		$branches = $this->BpActual->Branch->find('all');
		
		
		$this->set(compact('branches','id','branch_id','month_id'));
		}catch(Exception $e)
		{ echo $e->getMessage();}
		
	}
	
	function finalize($id=null,$plan=null,$branch=null){
		
		$this->autoRender = false;
		$this->loadModel('BpActualDetail');
		$this->loadModel('BpPlan');
	    //	return  "Branch: ". $_GET["branch"]. " Plan ". $_GET["plan"]. " Finally Actual ID:". $_GET["id"];
	    $branch=$_GET["branch"];
	    $plan=$_GET["plan"];
	    $actuals=array();
	    $actuals=explode('_',$_GET["id"]);
	     $count=0;
	    foreach($actuals as $a){
			
			$cmd="SELECT  month FROM  bp_actual_details WHERE id =$a";
			$month=$this->BpActual->query($cmd);
			//var_dump($month);
			$month=$month[0]['bp_actual_details']['month'];
			//$month=$this->GetmonthId($month);
			
			$cmd="SELECT GLCode FROM  `bp_actual_details` WHERE id =$a";
			$ItemId=$this->BpActual->query($cmd);
			$ItemId=$this->GetItemId($ItemId[0]['bp_actual_details']['GLCode']);
			
			$this->BpPlan->read('budget_year_id',$plan);
			$budgetYear_id=$this->BpPlan->data;
			$budgetYear_id=$budgetYear_id['BpPlan']['budget_year_id'];
			
			$this->BpActualDetail->read('Amount',$a);
			$ActualAmount=$this->BpActualDetail->data;
			$ActualAmount=$ActualAmount['BpActualDetail']['Amount'];
			
			if($count==0){
				$BBF=$this->GetCumulative($month,$budgetYear_id,$ItemId,$plan);
				$count++;
			}
			
			//INSERT  ACTUALS.
			$cmd="INSERT INTO bp_actuals (amount,bp_month_id,branch_id,bp_item_id,accont_no,bp_plan_id,remark,bp_actual_detail_id,created,budget_year_id)".
			     " SELECT Amount,$month,".
                 " $branch,$ItemId,GLCode,$plan,Description,id,CURRENT_TIMESTAMP as date,$budgetYear_id FROM  `bp_actual_details` WHERE id =$a ";
			
			
			if($this->BpActual->query($cmd)==1){
				
				 $cmd="select last_insert_id() as id;";
				 $lid=$this->BpActualDetail->query($cmd);
				 var_dump($lid);
			     // UPDATE Actual Details
				 $cmd="UPDATE bp_actual_details set status=1 where id=$a ";
				 $this->BpActualDetail->query($cmd);
				 $BBF= $BBF+$ActualAmount;
				 
				   $checkId=$this->ckeckMonthForCumulative($month,$ItemId,$plan,$budgetYear_id);
				   if($checkId==-1){
					   $this->InsertCumulative($month,$ItemId,$plan,$ActualAmount,$BBF);
				   }else{
					    $this->UpdateCumulativeById($checkId,$ActualAmount,$BBF);
					  // $this->UpdateCumulative($plan,$month,$ItemId,$budgetYear_id,$ActualAmount,$BBF);
				   }
			}
		}
		 
	}

function search(){
 ini_set('max_execution_time',600);
 set_time_limit(600);
 
 //var_dump(file_get_contents('http://10.1.10.86/index2.php'));
//die();
//var_dump('9090');die();

    $this->data['BpActual']['from_date']=$_POST['from'];
			$this->data['BpActual']['to_date']=$_POST['to'];
				$this->data['BpActual']['bp_item_id']=$_POST['ac'];
 //var_dump($_POST);die();
	   try{
		     $this->loadModel('BpItem');
			 $this->loadModel('BpMonth');
			 if (!empty($this->data)){
				$StartDate=$this->data['BpActual']['from_date'];
				$EndDate=$this->data['BpActual']['to_date'];
				$AccountNo=$this->data['BpActual']['bp_item_id'];
				$cmd="SELECT accoun_no FROM bp_items where id=$AccountNo";
				
				//$StartDate = strtoupper(date('Y-m-d', strtotime($StartDate)));
               // $EndDate = strtoupper(date('Y-m-d', strtotime($EndDate)));
				
				
			    //var_dump($StartDate);
				//var_dump($EndDate);
				
				
				$result=$this->BpItem->query($cmd);
				$AccountNo=$result[0]['bp_items']['accoun_no'];
				
			/*	$query=" SELECT  DL.AC_NO AS GL_CODE,GM.GL_DESC,DL.VALUE_DT AS V_DATE,DL.TRN_DT as T_DATE,DL.TRN_REF_NO AS REF_NO,DL.AC_CCY AS CCY,DL.DRCR_IND AS DR,DL.DRCR_IND AS CR, ".
					   " DL.TRN_CODE,TC.TRN_DESC,DL.LCY_AMOUNT AS AMOUNT,DL.INSTRUMENT_CODE,'' AS CPO,NT.Narrative as DESCRIPTION".
					   " FROM abyfclive.actb_daily_log  DL LEFT JOIN ABYFCLIVE.DETB_RTL_TELLER  NT ".
					   " ON DL.TRN_REF_NO=NT.TRN_REF_NO    LEFT JOIN ABYFCLIVE.STTM_TRN_CODE TC ".
					   " ON DL.TRN_CODE=TC.TRN_CODE    INNER JOIN abyfclive.GLTM_GLMASTER GM ".
					   " ON DL.AC_NO=GM.GL_CODE WHERE (DL.TRN_DT  ".
					   " BETWEEN TO_DATE('$StartDate','DD-MM-YYYY') AND TO_DATE('$EndDate','DD-MM-YYYY') )".
					   " AND DL.AC_NO='$AccountNo'";*/
					   
					   $query="SELECT 
					           MAIN.AC_NO AS GL_CODE,
							   GL.GL_DESC,  
							   MAIN.VALUE_DT as V_DATE,
					           MAIN.TRN_DT as T_DATE,							   
                               MAIN.TRN_REF_NO AS REF_NO,
                               MAIN.AC_CCY AS CCY,
								DECODE(DRCR_IND,'D',MAIN.LCY_AMOUNT,0) DR,
								DECODE(DRCR_IND,'C',MAIN.LCY_AMOUNT,0) CR,
								MAIN.TRN_CODE,
								TC.TRN_DESC,
								CASE WHEN DECODE(DRCR_IND,'C',MAIN.LCY_AMOUNT,0)>0 THEN  -1*MAIN.LCY_AMOUNT  ELSE  MAIN.LCY_AMOUNT END AS AMOUNT,
								CAT.ADDL_TEXT as DESCRIPTION
							FROM ABYFCLIVE.ACVW_ALL_AC_ENTRIES MAIN 
								LEFT JOIN ABYFCLIVE.STTM_TRN_CODE TC ON TC.TRN_CODE=MAIN.TRN_CODE
								LEFT JOIN ABYFCLIVE.CSTB_ADDL_TEXT CAT ON CAT.REFERENCE_NO=MAIN.TRN_REF_NO
								LEFT JOIN ABYFCLIVE.ISTM_INSTR_TXN INST ON MAIN.TRN_REF_NO = INST.CONTRACT_REF_NO
								LEFT JOIN ABYFCLIVE.GLTM_GLMASTER GL on GL.GL_CODE=MAIN.AC_NO
							WHERE  MAIN.AC_NO ='$AccountNo' 
								AND MAIN.TRN_DT BETWEEN TO_DATE('$StartDate','DD-MM-YYYY') AND TO_DATE('$EndDate','DD-MM-YYYY')
								AND MAIN.AUTH_STAT = 'A' 
								AND MAIN.AC_BRANCH='000'
							ORDER BY MAIN.AC_ENTRY_SR_NO";
					   
					   //error_reporting(0);
					   $fs=fsockopen("fcubsdb0-scan",1521,$errno,$errstr,10);
					//var_dump($query);die();
			if($fs){
     
      //  var_dump($fs);die();
      //	$con=oci_connect("sms_notification","smsnotification1","ABAYDB_LIVE");
	// $con=oci_connect("sms_notification","smsnotification1",'(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = fcubsdb0-scan)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = ABAYDB)))');
   
$con = oci_connect("sms_notification", "Smsnotification#123", '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = fcubsdb0-scan)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = ABAYDB) (SID = ABAYDB)))');



    //var_dump($con);die();
       if(!$con){
       $e = oci_error();
       var_dump($e['message']);//exit();
      // trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
       }else{
			//	var_dump($query);die();
				  
					$res=oci_parse($con,$query);
					oci_execute($res);
					$finalResult=array();
					while(($r=oci_fetch_array($res,OCI_BOTH+OCI_RETURN_NULLS))!= false ){
                                          
						 $u=new Utility();
						 if(!$u->IsActualExist($r[4],$AccountNo)){
						    
							$cmd="select id from bp_months where name in( SELECT MONTHname( STR_TO_DATE( '$r[2]',  '%d-%b-%y' )))";
							$m=$this->BpMonth->query($cmd);
							$month_id=$m[0]['bp_months']['id'];
							$description=str_replace(array("\n","\r"),' ',trim($r[11]));
              $description=str_replace("'","`",$description);
							$cmd=" INSERT INTO bp_actual_details (GLCode,GLDescription,TDate,VDate,RefNo,CCY,DR,CR,TranCode,TranDesc,Amount,Description,month)".
								 " VALUES ('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]','$r[6]','$r[7]','$r[8]','$r[9]',$r[10],'$description',$month_id)";
                	                                                                                                                                 
							$this->save_fetch($cmd);
						 }
					
					 }
					 $this->Session->setFlash(__('The bp actual has been saved', true), '');
						$this->render('/elements/success');
                                                      }
			 }else{
						 $this->Session->setFlash(__('Connecting to server failed. ' , true), '');
					     $this->render('/elements/failure');
					 }
			 }
			
			
			$this->set('parent_id', 0);
		}catch(\Exception $e)
		{ 
		    $this->Session->setFlash(__($e->getMessage(), true), '');
			$this->render('/elements/failure');
			}
	}
  
 
	function add_actual($id=null){
		
		$this->loadModel('BpPlan');
	
	   // Two transaction will occure.
	   // 1. Reduce the Amount from current  Branch (Branch from thej Context).
	   // 2. Add the same amount to the selected branch (Selected from the Form).
			if (!empty($this->data)) {  
				if($this->PlanExist($this->data['BpActual']['branch_id'])){
					$otherPlanId=$this->GetPlanByBranchAndMonth($this->data['BpActual']['branch_id'],$this->data['BpActual']['bp_month_id']);
						if($otherPlanId>0){
								$otherAmount=$this->data['BpActual']['amount'];
								$Amount=$otherAmount * -1;
								$month=$this->data['BpActual']['bp_month_id'];
								$params=explode('_',$id);
								$Branch=$params[0];
								$plan_id=$params[1];
								$otherBranch=$this->data['BpActual']['branch_id'];
								$account=$this->data['BpActual']['bp_item_id'];
								$remark=$this->data['BpActual']['remark'];
								$account_detail=$this->BpPlan->query("select * from bp_items where id=$account");
								$gl_code=$account_detail[0]['bp_items']['accoun_no'];
								$gl_desc=$account_detail[0]['bp_items']['name'];
								
								$this->BpPlan->read('budget_year_id',$plan_id);
								$budgetYear_id=$this->BpPlan->data;
								$budgetYear_id=$budgetYear_id['BpPlan']['budget_year_id'];
								$bbf=$this->GetCumulative($month,$budgetYear_id,$account,$plan_id);
								
								$this->BpPlan->read('budget_year_id',$otherPlanId);
								$OtherbudgetYear_id=$this->BpPlan->data;
								$OtherbudgetYear_id=$OtherbudgetYear_id['BpPlan']['budget_year_id'];
								$bbf_other=$this->GetCumulative($month,$OtherbudgetYear_id,$account,$otherPlanId);
								
								
								$row_id=0;
								
							

							$dt="INSERT INTO bp_actual_details (GLCode,GLDescription,TDate,	CCY,TranCode,TranDesc,Amount,Description,status,month) value('$gl_code','$gl_desc',CURRENT_TIMESTAMP,'ETB','ERP','ERP-ADJUSTMENT',$Amount,'$remark',1,'$month')";

							if($this->BpPlan->query($dt)==1){
							$row_id=	$this->BpPlan->query("SELECT LAST_INSERT_ID() as row");
							$row_id=$row_id[0][0]['row'];
							$ac="INSERT INTO bp_actuals (amount,bp_month_id,branch_id,bp_plan_id,bp_item_id,remark,bp_actual_detail_id,created,budget_Year_id)".
									 "VALUES ($Amount,'$month',$Branch,$plan_id,$account,'$remark',$row_id,CURRENT_TIMESTAMP,$budgetYear_id)";
							//$this->BpActual->query($ac);
									}



							$dt1="INSERT INTO bp_actual_details (GLCode,GLDescription,TDate,	CCY,TranCode,TranDesc,Amount,Description,status,month) value('$gl_code','$gl_desc',CURRENT_TIMESTAMP,'ETB','ERP','ERP-ADJUSTMENT',$otherAmount,'$remark',1,'$month')";

							if($this->BpPlan->query($dt1)==1){
								$row_id++;
							$ac1="INSERT INTO bp_actuals (amount,bp_month_id,branch_id,bp_plan_id,bp_item_id,remark,bp_actual_detail_id,created,budget_Year_id) VALUES ".
									 "($otherAmount,'$month',$otherBranch,$otherPlanId,$account,'$remark',$row_id,CURRENT_TIMESTAMP,$OtherbudgetYear_id)";
							//$this->BpActual->query($ac1);
									}

									 
							  if($this->BpActual->query($ac1)==1 && $this->BpActual->query($ac))
							  {								
							  $checkId=$this->ckeckMonthForCumulative($month,$account,$plan_id,$budgetYear_id);
								if($checkId==-1){
								  $this->InsertCumulative($month,$account,$plan_id,$Amount,$bbf+($Amount));
								}else{
									$this->UpdateCumulativeById($checkId,$Amount,$bbf+($Amount));
								  //$this->UpdateCumulative($plan_id,$month,$account,$budgetYear_id,$Amount,$bbf+($Amount));
								}
								
								$otherCheckId=$this->ckeckMonthForCumulative($month,$account,$otherPlanId,$OtherbudgetYear_id);
								if($otherCheckId==-1){
								  $this->InsertCumulative($month,$account,$otherPlanId,$otherAmount,$bbf_other+$otherAmount);
								}else{
								  $this->UpdateCumulativeById($otherCheckId,$otherAmount,$bbf_other+$otherAmount);
								  //$this->UpdateCumulative($otherPlanId,$month,$account,$OtherbudgetYear_id,$otherAmount,$bbf_other+$otherAmount);
								}
								  
								  
								  //$this->UpdateCumulative($month,$account,$plan_id,$otherAmount);
								  $this->Session->setFlash(__('The bp actual has been saved', true), '');
								  $this->render('/elements/success');
							  }
							  else {
								$this->Session->setFlash(__('The bp actual could not be saved. Please, try again.', true), '');
								$this->render('/elements/failure');
							  }
						}else{
					     $this->Session->setFlash(__('Other Branch is approved. can not transfer amount.', true), '');
						 $this->render('/elements/failure');
						}
				}
				else {
						$this->Session->setFlash(__('There is no Active Plan For the Selected Banch. Please Create Plan.', true), '');
						$this->render('/elements/failure');
					  }
				
			}
			
		if ($id!=null) {
			$br= explode('_',$id);
			if($br){
				$brr=$br[1];
				$plan=$br[0];
				
				$this->BpPlan->read('bp_month_id',$plan);
				$mid=$this->BpPlan->data;
				$mid=$mid['BpPlan']['bp_month_id'];
			   }
			else{
				$br=""; 
				$plan=0;
			}
			
			$this->set('parent_id', $plan);
			$this->set('brr', $brr);
			$this->set('plan', $plan);
		}
		else{
			echo $id;
			$this->set('parent_id', 0);
			$this->set('brr', 0);
			$this->set('plan', 0);
		}
			
		
		$branches = $this->BpActual->Branch->find('list',array('conditions'=>array('Branch.id !='=>$brr)));
		$bp_items = $this->BpActual->BpItem->find('list');
		$bp_month = $this->BpActual->BpMonth->find('list',array('conditions'=>array('BpMonth.id ='=>$mid)));
		$this->set(compact('branches', 'bp_items','bp_month'));
		
	}
	
	
	function search_fetch(){
		
		$bp_items = $this->BpActual->BpItem->find('list');
	    $bp_month = $this->BpActual->BpMonth->find('list');
		$this->set(compact('bp_items','bp_month'));
	}
		function save_fetch($cmd=null){
			try{
         // var_dump($cmd);die();
				$this->loadModel('BpActualDetail');
		  
			//$cmd="  INSERT INTO Bp_Actual_Details (GLCode,GLDescription,TDate,VDate,RefNo,CCY,DR,CR,TranCode,TranDesc,Amount,InstrumentCode,CPO,Description)";
			    // " VALUES($r['GL_CODE'],$r['GL_DESC'],$r['T_DATE'],$r['V_DATE'],$r['REF_NO'],$r['CCY'],$r['DRCR_IND'],$r['DRCR_IND'],$r['TRN_CODE'],$r['TRN_DESC'],$r['AMOUNT'],$r['INSTRUMENT_CODE'],$r['CPO'],$r['DESCRIPTION'])";
           
				$this->BpActualDetail->query($cmd);
			}catch(Exception $e){echo $e.getMessage();}
	}
	function list_data($id = null) {
		$this->loadModel('BpPlan');
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1){
            $conditions['BpPlan.branch_id'] = $branch_id;
			$conditions['BpPlan.status'] = true;
        }
		$conditions['BpPlan.status'] = 0;
		$this->BpActual->recursive=0;
		$this->set('bp_plans', $this->BpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		//$this->set('bp_actuals', $this->BpActual->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlan->find('count', array('conditions' => $conditions)));
	
	}
	
		function list_data1($id = null) {
			
		
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['parent_id'])) ? $_REQUEST['parent_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1){
            $conditions['bp_plan_id'] = $branch_id;
        }
		$this->BpActual->recursive=0;
		//$this->set('bp_plans', $this->BpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('bp_actuals', $this->BpActual->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpActual->find('count', array('conditions' => $conditions)));
	
	}

	function view($id = null) {
		try{
		$this->loadModel('BpPlan');
		$this->set('parent_id', $id);
		$branch_id=$this->BpPlan->query('select branch_id from bp_plans where id='.$id);
		$month_id=$this->BpPlan->query('select bp_month_id from bp_plans where id='.$id);
		$branch_id=$branch_id[0]['bp_plans']['branch_id'];
		$month_id=$month_id[0]['bp_plans']['bp_month_id'];
	//	echo $branch_id;
		$this->BpActual->Branch->recursive=0;
		$branches = $this->BpActual->Branch->find('all');
		
		
		$this->set(compact('branches','id','branch_id','month_id'));
		}catch(Exception $e)
		{ echo $e->getMessage();}
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpActual->create();
			$this->autoRender = false;
			if ($this->BpActual->save($this->data)) {
				$this->Session->setFlash(__('The bp actual has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp actual could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->BpActual->Branch->find('list');
		$bp_items = $this->BpActual->BpItem->find('list');
		$this->set(compact('branches', 'bp_items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp actual', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpActual->save($this->data)) {
				$this->Session->setFlash(__('The bp actual has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp actual could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__actual', $this->BpActual->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->BpActual->Branch->find('list');
		$bp_items = $this->BpActual->BpItem->find('list');
		$this->set(compact('branches', 'bp_items'));
	}

	function delete($id = null) {
		$this->loadModel('BpActualDetail');
		$this->loadModel('BpCumulative');
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp actual', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpActual->delete($i);
                }
				$this->Session->setFlash(__('Bp actual deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp actual was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$flex_id=$this->BpActual->query('select bp_actual_detail_id from bp_actuals where id='.$id);
			$All=$this->BpActual->query('select amount,budget_year_id,bp_plan_id,bp_item_id from bp_actuals where id='.$id);
			$Amount=$All[0]['bp_actuals']['amount'];
			$Plan=$All[0]['bp_actuals']['bp_plan_id'];
			$budget=$All[0]['bp_actuals']['budget_year_id'];
			$Item=$All[0]['bp_actuals']['bp_item_id'];
            if ($this->BpActual->query('delete from bp_actuals where id='.$id)==1) {
				$this->BpActualDetail->query('update  bp_actual_details set status=0 where id='.$flex_id[0]['bp_actuals']['bp_actual_detail_id']);
			
			    $this->BpCumulative->query("update bp_cumulatives set actual=actual-($Amount), cumilativeActual=cumilativeActual-($Amount) where bp_plan_id=$Plan and bp_item_id=$Item and budget_year_id=$budget");
				$this->Session->setFlash(__('Bp actual deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp actual was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

    function show_split($id=null,$amount=null){
        $id=$_GET["id"];
        $amount= $_GET["amount"];
        $plan_id= $_GET["plan_id"];
        $this->set(compact('id','amount','plan_id'));
    }

	function split($id=null,$amount=null){
     
	    if(isset($_GET["id"])){
	        $split=$_GET["split"];
	        $id=$_GET["id"];
	        $amount= $_GET["amount"];
            $plan_id= $_GET["plan_id"];
	        $splits=range(1,$split);
	     }


		if(!empty($this->data)){
			$status=false;

			
			foreach($this->data as $data=>$p){
				$uid=$p['id'];
				$isNew=false;
				//var_dump($p);
				foreach(range(1,sizeof($p)-1) as $l){
					if($l==1)
						$isNew=true;
					else
						$isNew=false;
					$this->SaveSplit($uid,$p[$l],$isNew,$l,$this->data['Branch'][$l]);
					//var_dump($this->data['Branch'][$l]);
                 }
                 $status=true;
                 break;

			}

            if($status){
				$this->Session->setFlash(__('Spliting Complited!', true), '');
				$this->render('/elements/success');
		    }else{
			    $this->Session->setFlash(__('Spliting Failed', true), '');
				$this->render('/elements/failure');
		    }

		}

		$this->BpActual->Branch->recursive=0;
		$branches = $this->BpActual->Branch->find('all');
      
        $this->set(compact('branches','id','splits', 'amount','plan_id'));
	}

	function PlanExist($branch_id){
		$this->loadModel('BpPlan');
		try{
			$cmd="select id from bp_plans where branch_id=$branch_id and status=0";
			//var_dump($this->BpPlan->query($cmd));
			if($this->BpPlan->query($cmd)>=1){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e)
		{ $this->Session->setFlash(__($e->getMessage(), true), ''); }
	}
	function GetPlanByBranchAndMonth($branch_id,$month){
		$this->loadModel('BpPlan');
		try{
			$cmd="select id from bp_plans where branch_id=$branch_id and bp_month_id=$month and status=0";
			$plan=$this->BpPlan->query($cmd);
			//var_dump(count($plan));
			if($this->BpPlan->query($cmd)>=1 && count($plan)>0){
				
				return $plan[0]['bp_plans']['id'];
			}else{
				return 0;
			}
		}catch(Exception $e)
		{ return 0; }
	}
	public function UpdateCumulativeOLD($Month_Id,$Item_Id,$Plan_Id,$Amount){
		try{
             $this->loadModel('BpCumulative');
             $cmd="UPDATE  bp_cumulatives SET actual=actual+$Amount where bp_item_id=$Item_Id and bp_plan_id=$Plan_Id and bp_month_id=$Month_Id";
             $u=new Utility();   
             $u->IsApproved($Plan_Id,$Month_Id);			 
			 $u->UpdateCumulative($cmd);
             
		}catch(Exception $e){$e->getMessage();}
	}
	public function GetmonthId($MonthName){
		
		try{
            $this->loadModel('BpItem');
           	$cmd="select id from bp_months where name='$MonthName'";
             $result=$this->BpItem->query($cmd);
			
             if($result!=null)
             	return $result[0]['bp_months']['id'];
             else
             	return 0;
		}catch(Exception $e){$e->getMessage();}
		
		
	}
	
	public function GetItemId($AccountNo){
		try{
             $this->loadModel('BpItem');
             $cmd="SELECT  id FROM bp_items where accoun_no=$AccountNo";
             $result=$this->BpItem->query($cmd);
			 //var_dump($result);
             if($result!=null)
             	return $result[0]['bp_items']['id'];
             else
             	return 0;
		}catch(Exception $e){$e->getMessage();}
	}
	public function InsertCumulative($Month_Id,$Item_Id,$Plan_Id,$Amount,$BBF){
		try{
             $this->loadModel('BpCumulative');
			 $this->loadModel('BpPlan');
             $cmd="SELECT budget_year_id FROM bp_plans where id=$Plan_Id;";
			 $budgt=$this->BpPlan->query($cmd);
			 $budgt=$budgt[0]['bp_plans']['budget_year_id'];
			 $cmd="INSERT INTO bp_cumulatives (bp_plan_id,bp_item_id,bp_month_id,budget_year_id,actual,cumilativeActual)".
			      " VALUES($Plan_Id,$Item_Id,$Month_Id,$budgt,$Amount,$BBF)";
             $result=$this->BpCumulative->query($cmd);
             if($result==1)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	public function UpdateCumulative($Plan,$Month_Id,$Item_Id,$budget_year,$Amount,$BBF){
		try{
             $this->loadModel('BpCumulative');
			 $this->loadModel('BpPlan');
			 $this->BpPlan->read('branch_id',$plan);
			 $branch=$this->BpPlan->data;
			 $branch=$branch['BpPlan']['branch_id'];
			 
             $cmd="UPDATE  bp_cumulatives SET actual=ifnull(actual,0)+($Amount),cumilativeActual=$BBF where branch_id=$branch and   bp_item_id=$Item_Id and budget_year_id=$budget_year and bp_month_id=$Month_Id;";
             $result=$this->BpCumulative->query($cmd);
			 print_r($cmd);
             if($result==1)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	public function UpdateCumulativeById($Id,$Amount,$BBF){
		try{
             $this->loadModel('BpCumulative');
             $cmd="UPDATE  bp_cumulatives SET actual=ifnull(actual,0)+($Amount),cumilativeActual=$BBF where id=$Id ;";
             $result=$this->BpCumulative->query($cmd);
			
             if($result==1)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	public function ckeckMonthForCumulative($Month_Id,$Item_Id,$Plan,$budget_year){
		try{
               $this->loadModel('BpCumulative');
              // $cmd="SELECT id FROM bp_cumulatives where bp_month_id=$month_id and bp_item_id=$item_id ";
             $result=$this->BpCumulative->find('first',array('conditions'=>array('BpCumulative.bp_plan_id'=>$Plan,'BpCumulative.bp_month_id'=>$Month_Id,'BpCumulative.bp_item_id'=>$Item_Id,'BpCumulative.budget_year_id'=>$budget_year) ));
             if($result["BpCumulative"]["id"]!=null)
             	return $result["BpCumulative"]["id"];
             else
             	return -1;
		}catch(Exception $e){$e->getMessage(); return -1;}
	}
	public function GetCumulative($Month,$Budget_id,$Item,$plan){
		try{
			//sum(amount) amount
             $this->loadModel('BpActual');
			 $this->loadModel('BpPlan');
			 $this->BpPlan->read('branch_id',$plan);
			 $branch=$this->BpPlan->data;
			 $branch=$branch['BpPlan']['branch_id'];
             $cmd="select sum(amount) amount from bp_actuals  where branch_id=$branch and  bp_month_id<=$Month and budget_year_id=$Budget_id and bp_item_id=$Item;";
             $result=$this->BpActual->query($cmd);
			// var_dump($result);
             if($result!=null)
             	return $result[0][0]['amount'];
             else
             	return 0;
		}catch(Exception $e){$e->getMessage();}
	}

	public function SaveSplit($id=null,$amount=null,$update=null,$index=null,$branch=null){
      try{
          $this->loadModel('BpActualDetail');
           $ids=explode("_", $id);   
           $id=$ids[0];
           $plan=$ids[1];

           


          if($update){
          	$cmd="UPDATE bp_actual_details  SET Amount=$amount WHERE id=$id";
          }
          else{
          	$cmd="INSERT into bp_actual_details (RefNo,Amount,GLCode, GLDescription, TDate,".
          	     " VDate, CCY, DR, CR, TranCode, TranDesc, InstrumentCode, CPO, Description, month)".
          	     " SELECT concat(RefNo,'-',$index),$amount,GLCode, GLDescription, TDate, VDate, CCY, DR, CR,".
          	     " TranCode,TranDesc, InstrumentCode, CPO, Description, month".
          	     " from bp_actual_details WHERE id=$id ";
          }
          
          $details=$this->getPlanId($branch,$plan);

          if($this->BpActualDetail->query($cmd)==1){
          	   if($details!=null){
		          	   $index=$this->lastIndex();
		               if($update) {
		                  $index=$id;
		               }

                  	$itemId=$this->getItemIdNew($id);
                    if($this->InsertDetail($index,$details[0]['bp_plans']['id'],$branch,$details[0]['bp_plans']['budget_year_id'],$details[0]['bp_plans']['bp_month_id'],$itemId)!=null){
                         $this->UpdateStatus($id);

                    }
                }
        
               }

          

         // update the amount of the existing,
      	// and create new instances.

         }catch(Exception $e){$e->getMessage();}
	}

	public function InsertDetail($detailId=null,$plan=null,$branch=null,$budgetYear_id=null,$month=null,$ItemId=null){
		try{
			 // plan is need to be created for each branches.
			 // $PLAN ?    from plan using month,budget_year,and branch
             // $ItemId ?  from item using accountno
		    
		    //INSERT  ACTUALS.
			$cmd="INSERT INTO bp_actuals (amount,bp_month_id,branch_id,bp_item_id,accont_no,bp_plan_id,remark,bp_actual_detail_id,created,budget_year_id)".
			     " SELECT Amount,$month,".
                 " $branch,$ItemId,GLCode,$plan,Description,id,CURRENT_TIMESTAMP as date,$budgetYear_id FROM  `bp_actual_details` WHERE id=$detailId ";

           $result=$this->BpActual->query($cmd);
           
           return $result;
           
		}catch(Exception $e){$e->getMessage();}
	}

	public function lastIndex(){
		         $cmd="select last_insert_id() as id;";
				 $lid=$this->BpActualDetail->query($cmd);
				 return $lid;
	}

	public function getItemIdNew($id=null){
		         $this->loadModel('BpItem');
		          $this->loadModel('BpActualDetail');

		         $cmd="select GLCode from bp_actual_details where id=$id ";
		         $acct=$this->BpActualDetail->query($cmd);
		       
				 $acct= $acct[0]['bp_actual_details']['GLCode'];


		         $cmd="select id from bp_items where accoun_no=$acct";
				 $lid=$this->BpItem->query($cmd);
				 return $lid[0]['bp_items']['id'];
	}

	public function getPlanId($branchId=null,$OtherPlanId=null){
            $this->loadModel('BpPlan');

            $this->BpPlan->read('budget_year_id',$OtherPlanId);
			$Budget_Year=$this->BpPlan->data;
			$Budget_Year=$Budget_Year['BpPlan']['budget_year_id'];


			$this->BpPlan->read('bp_month_id',$OtherPlanId);
			$Month=$this->BpPlan->data;
			$Month=$Month['BpPlan']['bp_month_id'];


            $cmd="SELECT id,budget_year_id,bp_month_id FROM bp_plans WHERE bp_month_id=$Month".
                 " AND budget_year_id=$Budget_Year AND branch_id=$branchId";  

            $result=$this->BpPlan->query($cmd);
            if($result!=null){
            return $result;
        }else{
             return null;
	       }
        }

        public function UpdateStatus($id){
        	    $this->loadModel('BpActualDetail');
        	     $cmd="UPDATE bp_actual_details set status=1 where id=$id";
				 $this->BpActualDetail->query($cmd);
        }


	
	
}
?>