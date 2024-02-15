<?php




class SpPlansController extends AppController {

	var $name = 'SpPlans';
	var $parent=13;
	var $final_list=array();


	
	function index() {
                $this->loadModel('Branch');
		$this->Branch->recursive=0;
		$branches = $this->Branch->find('all',array('conditions'=>array('Branch.id'=>$this->getBranchId())));

        $active=!$this->is_active();

        $b_id= $this->getBranchId();
     

		$this->set(compact('branches','active','b_id'));

	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function index3($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
	$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		//var_dump($this->getPlanHdId($this->getBranchId(),$this->getBudgetYear()));die();
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : $this->getBranchId();
		if($id)
			$branch_id = ($id) ? $id : $this->getBranchId();
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
			  $conditions['SpPlan.sp_plan_hd_id']=$this->getInitPlanHdId($branch_id,$this->getBudgetYear());
        }else{
            $conditions['SpPlan.sp_plan_hd_id']=$this->getInitPlanHdId($this->getBranchId(),$this->getBudgetYear());
        }
         
        //$conditions['SpPlan.approved']="init";


       // var_dump($start);
		$this->SpPlan->recursive=2;
		$sp_plans=$this->SpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		
		$this->set('sp_plans', $sp_plans);
		//var_dump($this->SpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->SpPlan->find('count', array('conditions' => $conditions)));
}
function list_data1($id = null) {
	$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		//var_dump($this->getPlanHdId($this->getBranchId(),$this->getBudgetYear()));die();
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : $this->getBranchId();
		if($id)
			$branch_id = ($id) ? $id : $this->getBranchId();
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
			  $conditions['SpPlan.sp_plan_hd_id']=$branch_id;
        }else{
            $conditions['SpPlan.sp_plan_hd_id']=$this->getInitPlanHdId($this->getBranchId(),$this->getBudgetYear());
        }


        //$conditions['SpPlan.approved']="init";

		$this->SpPlan->recursive=2;
		$this->set('sp_plans', $this->SpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		//var_dump($this->SpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->SpPlan->find('count', array('conditions' => $conditions)));
}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp plan', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpPlan->recursive = 2;
		$this->set('spPlan', $this->SpPlan->read(null, $id));
	}
	function alert($branch_id = null){
		$this->autoRender = false;
		if($branch_id == null){
			$user_id=$this->Auth->User('id');
			$this->loadModel('Employee');
			$this->loadModel('EmployeeDetail');
			$this->Employee->recursive=0;
			$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$user_id)));
            $branch_id=$this->EmployeeDetail->find('all',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp[0]['Employee']['id']),'order'=>array('EmployeeDetail.end_date asc LIMIT 1;')));
            $branch_id=$branch_id[0]['EmployeeDetail']['branch_id'];
		}
		$plan_id=$this->getPlanHdId($this->getBranchId(),$this->getBudgetYear());
		$sp_plan_items = $this->SpPlan->find('all',array('conditions'=>array('SpPlan.sp_plan_hd_id'=>$plan_id)));
		//print_r($sp_plan_items);
		echo '<b style="color:darkred">Warnings: </b><br><ul>';
		//check incrementals
		$all = $this->SpPlan->SpItem->SpItemGroup->children(16);
		$allcat[]=16;
		foreach($all as $aa){
			$allcat[]=$aa['SpItemGroup']['id'];
		}
		foreach($sp_plan_items as $sp){
			if(array_search($sp['SpItem']['sp_item_group_id'],$allcat)!==false){
				$incr=array();
				$incr=array($sp['SpPlan']['march_end'],$sp['SpPlan']['june_end'],$sp['SpPlan']['july'],$sp['SpPlan']['august'],$sp['SpPlan']['september']
				,$sp['SpPlan']['october'],$sp['SpPlan']['november'],$sp['SpPlan']['december'],$sp['SpPlan']['january'],$sp['SpPlan']['february'],$sp['SpPlan']['march']
				,$sp['SpPlan']['april'],$sp['SpPlan']['may'],$sp['SpPlan']['june']);
				$start=0;
				foreach($incr as $key=>$val){
					if($val!=0)
						$start=1;
					if($val <= $incr[$key-1] && $start==1){
						$start=2;	break; }				
				}
				if($start==2){
					echo '<li style="color:red">The budget plan with S.N. ('.$sp['SpPlan']['id'].') required to be incremental!</li>';
				}
			}
		}
		echo '</ul>';
	//	print_r($allcat);
		echo '<b style="color:#29717B">Suggestions: </b><br><ul>';
		//employee desk and items
		echo '</ul>';
	}
	function add($id = null) {

		$this->loadModel('SpItem');
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
    $this->loadModel('SpPlanHd');

		if (!empty($this->data)) {
			foreach($this->data['SpPlan'] as $key=>$value){
				if($key!='sp_item_id'){
					if($value=='')
						$this->data['SpPlan'][$key]= 0;
					else
						$this->data['SpPlan'][$key] = str_replace(',','',$value);
				}
			}
			$this->SpPlan->create();
			$this->autoRender = false;

			$branch_dt=$this->getBranchId();
			$budget=$this->getBudgetYear();

   		    $detail[]=null;
            $detail['SpPlanHd']['user_id']=$this->Auth->User('id');
            $detail['SpPlanHd']['branch_id']=$branch_dt;
			$detail['SpPlanHd']['budget_year_id']=$budget;
			$detail['SpPlanHd']['approved']='init';
			$ok=false;
			$is_active=true;



			  $this->SpPlanHd->create();
             $exist= $this->SpPlanHd->find('list',array('conditions'=>array('SpPlanHd.branch_id'=>$branch_dt,'SpPlanHd.budget_year_id'=>$budget)));
             //var_dump($exist);die();

             foreach ($exist as $key) {
             		$plan_id=$key;
             		break;
             	}

             if($exist){
             	
             		$this->data['SpPlan']['sp_plan_hd_id']=$plan_id; 
             		$ok=true;

             		$plan=$this->SpPlanHd->read('approved',$plan_id);
             		$plan=$plan['SpPlanHd']['approved'];
             		$is_active=$plan=='init'?true:false;

             }else{
               $ok= $this->SpPlanHd->save($detail);
               $this->data['SpPlan']['sp_plan_hd_id']=$this->SpPlanHd->getInsertId();
             }

                    
                if($ok && $is_active){
			            $this->data['SpPlan']['user_id']=$this->Auth->User('id');
			           $p=$this->SpPlan->find('count',array('conditions'=>array('SpPlan.sp_plan_hd_id'=>$plan_id,'SpPlan.sp_item_id'=> $this->data['SpPlan']['sp_item_id'])));
			           if($p<1){
			           	$this->data['SpPlan']['remark']=str_replace("'", "`",	$this->data['SpPlan']['remark']);
						if ($this->SpPlan->save($this->data)) {
							$this->Session->setFlash(__('The sp plan has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
					}else{

						$this->Session->setFlash(__('plan exists', true), '');
							$this->render('/elements/failure');
					}

                }else {
					$this->Session->setFlash(__('The sp plan could not saved', true), '');
					$this->render('/elements/failure');
				}


		}
		if($id)
			$this->set('parent_id', $id);

		$array[] = null;
		$array2[] = null;

        if($this->parent==13)
        	$sp_items = $this->SpItem->find('all');
        else
        	$sp_items = $this->getChildItems($this->parent);

		$sp_plan_items = $this->SpPlan->SpItem->find('all');

		$i=0;
		foreach($sp_items as $item){
		$item['SpItem']['desc']=$item['SpItemGroup']['name'];
			$array[$i] = $item['SpItem'];			
			$i++;
		}

		if(!empty($sp_plan_items)){
		foreach($sp_plan_items as $item){			
			$array2[] = $item['SpItem'];			
		}
	  }

	  $list_group[]=null;
	  $i=0;

	   $groups = $this->SpPlan->SpItem->SpItemGroup->find('all',array('conditions'=>array('SpItemGroup.parent_id'=>13)));

	   foreach ($groups as $key => $value) {
	   	 $list_group[$i]=$groups[$key]['SpItemGroup'];
	   	 $i++;
	   }

       
	  // var_dump($list_group);die();



       $sp_items=$array;

		//$branches = $this->SpPlan->Branch->find('list');
		//$sp_items =$array;
		//$budget_years = $this->SpPlan->BudgetYear->find('list');
		//$users = $this->SpPlan->User->find('list');
		$this->set(compact( 'sp_items','list_group'));
	}
 	function add2($id = null) {

		$this->loadModel('SpItem');
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
    $this->loadModel('SpPlanHd');

		if (!empty($this->data)) {
			foreach($this->data['SpPlan'] as $key=>$value){
				if($key!='sp_item_id'){
					if($value=='')
						$this->data['SpPlan'][$key]= 0;
					else
						$this->data['SpPlan'][$key] = str_replace(',','',$value);
				}
			}
			$this->SpPlan->create();
			$this->autoRender = false;

			$branch_dt=$this->getBranchId();
			$budget=$this->getBudgetYear();

   		    $detail[]=null;
            $detail['SpPlanHd']['user_id']=$this->Auth->User('id');
            $detail['SpPlanHd']['branch_id']=$branch_dt;
			$detail['SpPlanHd']['budget_year_id']=$budget;
			$detail['SpPlanHd']['approved']='init';
			$ok=false;
			$is_active=true;



			  $this->SpPlanHd->create();
             $exist= $this->SpPlanHd->find('list',array('conditions'=>array('SpPlanHd.id'=>$id)));
             //var_dump($exist);die();

             foreach ($exist as $key) {
             		$plan_id=$key;
             		break;
             	}

             if($exist){
             	// 
             		$this->data['SpPlan']['sp_plan_hd_id']=$id; 
             		$ok=true;

             		$plan=$this->SpPlanHd->read('approved',$plan_id);
             		$plan=$plan['SpPlanHd']['approved'];
             		$is_active=$plan=='init'?true:false;
                // since it passed the init stage.
                $is_active=true;

             }else{
             
                // Since this is adding from region and branch operation level, the header is allready created at the btanch level.
               // $ok= $this->SpPlanHd->save($detail);
                $this->data['SpPlan']['sp_plan_hd_id']=$id;
                $ok=true;
             }

                    
                if($ok && $is_active){
			            $this->data['SpPlan']['user_id']=$this->Auth->User('id');
			           $p=$this->SpPlan->find('count',array('conditions'=>array('SpPlan.sp_plan_hd_id'=>$id,'SpPlan.sp_item_id'=> $this->data['SpPlan']['sp_item_id'])));
			           if($p<1){
			           	$this->data['SpPlan']['remark']=str_replace("'", "`",	$this->data['SpPlan']['remark']);
						if ($this->SpPlan->save($this->data)) {
							$this->Session->setFlash(__('The sp plan has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
					}else{

						$this->Session->setFlash(__('plan exists', true), '');
							$this->render('/elements/failure');
					}

                }else {
					$this->Session->setFlash(__('The sp plan could not saved', true), '');
					$this->render('/elements/failure');
				}


		}
		if($id)
			$this->set('parent_id', $id);

		$array[] = null;
		$array2[] = null;

        if($this->parent==13)
        	$sp_items = $this->SpItem->find('all');
        else
        	$sp_items = $this->getChildItems($this->parent);

		$sp_plan_items = $this->SpPlan->SpItem->find('all');

		$i=0;
		foreach($sp_items as $item){
		$item['SpItem']['desc']=$item['SpItemGroup']['name'];
			$array[$i] = $item['SpItem'];			
			$i++;
		}

		if(!empty($sp_plan_items)){
		foreach($sp_plan_items as $item){			
			$array2[] = $item['SpItem'];			
		}
	  }

	  $list_group[]=null;
	  $i=0;

	   $groups = $this->SpPlan->SpItem->SpItemGroup->find('all',array('conditions'=>array('SpItemGroup.parent_id'=>13)));

	   foreach ($groups as $key => $value) {
	   	 $list_group[$i]=$groups[$key]['SpItemGroup'];
	   	 $i++;
	   }

       
	  // var_dump($list_group);die();



       $sp_items=$array;

		//$branches = $this->SpPlan->Branch->find('list');
		//$sp_items =$array;
		//$budget_years = $this->SpPlan->BudgetYear->find('list');
		//$users = $this->SpPlan->User->find('list');
		$this->set(compact( 'sp_items','list_group'));
	}
	function add1($id = null) {

		$this->loadModel('SpItem');
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
               $this->loadModel('SpPlanHd');

		if (!empty($this->data)) {
			foreach($this->data['SpPlan'] as $key=>$value){
				if($key!='sp_item_id'){
					if($value=='')
						$this->data['SpPlan'][$key]= 0;
					else
						$this->data['SpPlan'][$key] = str_replace(',','',$value);
				}
			}
			$this->SpPlan->create();
			$this->autoRender = false;

			$branch_dt=$this->getBranchId();
			$budget=$this->getBudgetYear();

   		    $detail[]=null;
            $detail['SpPlanHd']['user_id']=$this->Auth->User('id');
            $detail['SpPlanHd']['branch_id']=$branch_dt;
			$detail['SpPlanHd']['budget_year_id']=$budget;
			$detail['SpPlanHd']['approved']='init';
			$ok=false;
			$is_active=true;



			  $this->SpPlanHd->create();
             $exist= $this->SpPlanHd->find('list',array('conditions'=>array('SpPlanHd.id'=>$id)));
      

             foreach ($exist as $key) {
             		$plan_id=$key;
             		break;
             	}

             if($exist){
             	
             		$this->data['SpPlan']['sp_plan_hd_id']=$plan_id; 
             		$ok=true;

             		$plan=$this->SpPlanHd->read('approved',$plan_id);
             		$plan=$plan['SpPlanHd']['approved'];
             		$is_active=$plan=='init'?true:false;

             		 

             }else{
               $ok= $this->SpPlanHd->save($detail);
               $this->data['SpPlan']['sp_plan_hd_id']=$this->SpPlanHd->getInsertId();
             }

                    
                if($ok && $is_active){
                	
			            $this->data['SpPlan']['user_id']=$this->Auth->User('id');
			           $p=$this->SpPlan->find('count',array('conditions'=>array('SpPlan.sp_plan_hd_id'=>$plan_id,'SpPlan.sp_item_id'=> $this->data['SpPlan']['sp_item_id'])));
			           if($p<1){
						if ($this->SpPlan->save($this->data)) {
							$this->Session->setFlash(__('The sp plan has been saved', true), '');
							$this->render('/elements/success');
						} else {
							$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
							$this->render('/elements/failure');
						}
					}else{

						$this->Session->setFlash(__('plan exists', true), '');
							$this->render('/elements/failure');
					}

                }else {
					$this->Session->setFlash(__('The sp plan could not saved', true), '');
					$this->render('/elements/failure');
				}


		}
		if($id)
			$this->set('parent_id', $id);

		$array[] = null;
		$array2[] = null;

        if($this->parent==13)
        	$sp_items = $this->SpItem->find('all');
        else
        	$sp_items = $this->getChildItems($this->parent);

		$sp_plan_items = $this->SpPlan->SpItem->find('all');

		$i=0;
		foreach($sp_items as $item){
		$item['SpItem']['desc']=$item['SpItemGroup']['name'];
			$array[$i] = $item['SpItem'];			
			$i++;
		}

		if(!empty($sp_plan_items)){
		foreach($sp_plan_items as $item){			
			$array2[] = $item['SpItem'];			
		}
	  }

	  $list_group[]=null;
	  $i=0;

	   $groups = $this->SpPlan->SpItem->SpItemGroup->find('all',array('conditions'=>array('SpItemGroup.parent_id'=>13)));

	   foreach ($groups as $key => $value) {
	   	 $list_group[$i]=$groups[$key]['SpItemGroup'];
	   	 $i++;
	   }

       
	  // var_dump($list_group);die();



       $sp_items=$array;

		//$branches = $this->SpPlan->Branch->find('list');
		//$sp_items =$array;
		//$budget_years = $this->SpPlan->BudgetYear->find('list');
		//$users = $this->SpPlan->User->find('list');
		$this->set(compact( 'sp_items','list_group'));
	}

function finalize($id=null){
		$this->loadModel('SpPlanHd');
		$this->autoRender = false;
		/*if (!$id) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}*/


		//else  {
			 $plan_id=$this->getPlanHdId($this->getBranchId(),$this->getBudgetYear());
  			$this->SpPlanHd->read(null,$plan_id);
  			$this->SpPlanHd->set(array('approved'=>'created','rollback_comment'=>'Plan Created'));
  
			if ($this->SpPlanHd->save()) {
				$this->Session->setFlash(__('The sp plan hd has been finailzed', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be finailze. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			
		//}
	
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if($this->is_active()){
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->SpPlan->save($this->data)) {
				$this->Session->setFlash(__('The sp plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}else{
		$this->Session->setFlash(__('plan could not be edited. it`s  submited', true), '');
				$this->render('/elements/failure');
	}
		$this->set('sp_plan', $this->SpPlan->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		
		$array[] = null;
    //
		$sp_items = $this->SpPlan->SpItem->find('all');
		$i=0;
		foreach($sp_items as $item){
		$item['SpItem']['desc']=$item['SpItemGroup']['name'];
			$array[$i] = $item['SpItem'];			
			$i++;
		}

		$sp_items=$array;
		//$branches = $this->SpPlan->Branch->find('list');
		//$sp_items = $this->SpPlan->SpItem->find('list');
		//$budget_years = $this->SpPlan->BudgetYear->find('list');
		//$users = $this->SpPlan->User->find('list');
		$this->set(compact( 'sp_items'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp plan', true), '');
			$this->render('/elements/failure');
		}

if($this->is_active()){
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpPlan->delete($i);
                }
				$this->Session->setFlash(__('Sp plan deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp plan was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpPlan->delete($id)) {
				$this->Session->setFlash(__('Sp plan deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp plan was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
    }else{
    	    $this->Session->setFlash(__('plan could not be deleted, it`s  submited', true), '');
				$this->render('/elements/failure');
    }

	}

	function getBranchType($branch_id=null){
		$this->loadModel('Branche');
   
    
		
		$branch_type=$this->Branche->find('first',array('conditions'=>array('Branche.id'=>$branch_id),'fields'=>array('Branche.branch_category_id')));
		return $branch_type['Branche']['branch_category_id'];

	}

	function getBranchId(){
		$this->loadModel('Employee');
		$this->loadModel('EmployeeDetail');
		$emp_id=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$this->Auth->User('id'))));
			$emp_id=$emp_id[0]['Employee']['id'];
			$emp_dt=$this->EmployeeDetail->find('all',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp_id),'order'=>array('EmployeeDetail.end_date asc LIMIT 1')));
			$branch_dt=$emp_dt[0]['EmployeeDetail']['branch_id'];
			return $branch_dt;
	}
	function getBudgetYear(){
		$this->loadModel('BudgetYear');
			$budget=$this->BudgetYear->find('all',array('order'=>array('BudgetYear.id desc limit 1')));
			$budget=$budget[0]['BudgetYear']['id'];
			return $budget;
	}	
function getPlanHdId($branch=null,$budgetYear=null){
		$this->loadModel('SpPlanHd');
		$dt=$this->SpPlanHd->find('all',array('conditions'=>array('SpPlanHd.branch_id'=>$branch,'SpPlanHd.budget_year_id'=>$budgetYear,'SpPlanHd.status'=>false)));
			if($dt){
		$dt=$dt[0]['SpPlanHd']['id'];
	}else{
		$dt[]=null;
	}
		return $dt;

}

	function getInitPlanHdId($branch=null,$budgetYear=null){

		$this->loadModel('SpPlanHd');
		$dt=$this->SpPlanHd->find('all',array('conditions'=>array('SpPlanHd.branch_id'=>$branch,'SpPlanHd.budget_year_id'=>$budgetYear,'SpPlanHd.status'=>false)));
		
if($dt){
		$dt=$dt[0]['SpPlanHd']['id'];
	   }else{$dt=null;}
		return $dt;
	}

	public  function savePlan($array=null){
		//$this->SpPlan->create();
		$this->autoRender = false;
        return $this->SpPlan->query( "UPDATE sp_plans set july", $array['SpPlan']['id']);

	}

	function getChildItems($parent=null){
       $this->loadModel('SpItem');
       $var[0]=$parent;
       $list= $this->getSubGroups($var);
       $list[]=$var[0];

      
    
       $type=$this->getBranchType($this->getBranchId());

        $b_type[0]=$type==1?2:3;
        //$b_type[0]=2;
        $b_type[1]=1;
        //$b_type[1]=3;
        $sp_items= $this->SpItem->find('all',array('conditions'=>array('SpItem.sp_item_group_id'=>$list,'suspend'=>false,'SpItem.sp_cat_id'=>$b_type)));
       
        if(sizeof($sp_items)==0){
         $sp_items= $this->SpItem->find('all',array('conditions'=>array('SpItem.sp_item_group_id'=>$list,'suspend'=>false,'SpItem.sp_cat_id'=>2)));
       
        }
        //$sp_items= $this->SpPlan->SpItem->find('all',array('conditions'=>array('SpItem.sp_item_group_id'=>$list,'suspend'=>false,'SpItem.sp_cat_id'=>$b_type)));
        //var_dump(sizeof($sp_items));die();
		
		$array[]=null;
		$i=0;
		foreach($sp_items as $item){
			$array[$i] = $item['SpItem'];			
			$i++;
		}
		return $array;
	}

	function getSubGroups($ids=null){
		$this->loadModel('SpItemGroup');

         
		foreach ($ids as $key => $value) {
			
		$groups=$this->SpItemGroup->find('list',array('conditions'=>array('SpItemGroup.parent_id'=>$value)));
      
		if(!empty($groups)){
			

		if(empty($list)){	// only for the first time initialize this variables
         $list[]=null;
          $i=0;
         }
          $list[]=$ids;
		 foreach ($groups as $key => $value) {
			$list[$i]=$key;
			$i++;
		  }
          
		}else{
			
           $this->final_list[]=$value;
          // $k= array_search($value,$list);
          //  var_dump($list);
          //   unset($list[$k]);
          //  var_dump($list);
		}

       }
         
         if(!empty($list)){
          //var_dump($list);
         	$this->getSubGroups($list);
         }

           $final_list[]=$ids;
		return $this->final_list;

	}

	function post_item($parent=null){
		//$this->autoRender = false;
        //echo json_encode($this->getChildItems($this->parent));

        $this->set('sp_items',$this->getChildItems($this->parent));
	}

	function setParent($parent_id=null){
		$this->autoRender = false;
        $this->parent=$parent_id;
        echo json_encode($this->getChildItems($this->parent));
	}

	function comment($branch_id = null){
		$this->autoRender = false;
		$this->loadModel('SpPlanHd');
		$plan_id=$this->getInitPlanHdId($this->getBranchId(),$this->getBudgetYear());

		$comment=$this->SpPlanHd->read('rollback_comment',$plan_id);
        
        echo '<b style="color:darkred">Rollback Comment: </b><br><ul>';

        echo "<li>".$comment['SpPlanHd']['rollback_comment']."</li>";

	}

	function is_active(){

		$this->loadModel('SpPlanHd');
		$plan_id=$this->getPlanHdId($this->getBranchId(),$this->getBudgetYear());
		$plan=$this->SpPlanHd->read('approved',$plan_id);

		if($plan!=null){
             		$plan=$plan['SpPlanHd']['approved'];
             		$is_active=$plan=='init'?true:false;
             	}else{
             		$is_active=true;
             	}
             	return $is_active;	
    }
}
?>