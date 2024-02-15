<?php

require "sp_plans_controller.php";

class SpPlanHdsController extends AppController {

	var $name = 'SpPlanHds';
	
	function index() {
		$this->SpPlanHd->Branch->recursive=0;
		$branches = $this->SpPlanHd->Branch->find('all');
		$region_name=$this->getBranchName();
   

		$this->set(compact('branches','region_name'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function index3($id = null) {
		$this->SpPlanHd->Branch->recursive=0;
		$branches = $this->SpPlanHd->Branch->find('all');
		$this->set(compact('branches'));
	}

	function index4($id = null) {
		$this->SpPlanHd->Branch->recursive=0;
		$branches = $this->SpPlanHd->Branch->find('all');
    $this->Session->delete('reg');
     $regions = $this->SpPlanHd->Branch->find('all',array('conditions'=>array('Branch.name like'=>'%district%')));

     $region_name=$this->getBranchName();
		$this->set(compact('branches','region_name','regions'));
	}

	function index5($id = null) {
		$this->SpPlanHd->Branch->recursive=0;
		$branches = $this->SpPlanHd->Branch->find('all');

     $region_name=$this->getBranchName();
		$this->set(compact('branches','region_name'));
	}

	function search() {
	}
	
	function list_data($id = null) {

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

		 $cond=-1;
		 $ids[]=null;
        foreach ($this->getBranches() as $key => $value){
        	//$cond = $cond.",".$key;
           $ids[]=$key;
        } 

       //var_dump($cond);die();


		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1  && in_array($branch_id, $ids)) { 
            $conditions['SpPlanHd.branch_id'] = $branch_id;
        }else{
        	$conditions['SpPlanHd.branch_id']= $ids;
        }

        $conditions['SpPlanHd.approved']='created';
         $conditions['SpPlanHd.status']=false;

//var_dump(str_replace("'", "`", $conditions['SpPlanHd.branch_id in']));die();
    
 
       

        $this->SpPlanHd->recursive=0;

       $dts[]=null;
        foreach ($this->SpPlanHd->find('list', array('conditions' => $conditions)) as $key => $value){
        	//$cond = $cond.",".$key;
           $dts[]=$key;
        } 


		

	$sp_plans_hds=$this->SpPlanHd->find('all', array('conditions' => array('SpPlanHd.id'=>$dts),'limit' => $limit, 'offset' => $start));

	
      

		$this->set('sp_plan_hds',$sp_plans_hds);

		$this->set('results', $this->SpPlanHd->find('count', array('conditions' => array('SpPlanHd.id'=>$dts))));
        


		//var_dump($this->SpPlanHd->SpPlan->find('count', array('conditions' => array('SpPlan.sp_plan_hd_id'=>$dts))));die();
	}

	function list_data1($id = null) {

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

		 $cond=-1;
		 $ids[]=null;
        foreach ($this->getBranches() as $key => $value){
        	//$cond = $cond.",".$key;
           $ids[]=$key;
        } 

		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) { 
			//var_dump($branch_id);die();
            $conditions['SpPlanHd.branch_id'] = $branch_id;
        }else{
        	//$conditions['SpPlanHd.branch_id']=$ids;
        }

        $conditions['SpPlanHd.approved']='bo_approved';
        $conditions['SpPlanHd.status']=false;


     $this->SpPlanHd->recursive=0;
		
	 $this->set('sp_plan_hds', $this->SpPlanHd->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));


     $dts[]=null;
        foreach ($this->SpPlanHd->find('list', array('conditions' => $conditions)) as $key => $value){
        	//$cond = $cond.",".$key;
           $dts[]=$key;
        } 


		$this->set('results', $this->SpPlanHd->find('count', array('conditions' => array('SpPlanHd.id'=>$dts))));


		//var_dump($this->SpPlanHd->SpPlan->find('count', array('conditions' => array('SpPlan.sp_plan_hd_id'=>$dts))));die();
	}

	function list_data2($id = null) {
   $this->loadModel('Branch');
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

		 $cond=-1;
		 $ids[]=null;
        foreach ($this->getBranchesForBo() as $key => $value){
        	//$cond = $cond.",".$key;
           $ids[]=$key;
        } 

		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
	  	if ($branch_id != -1 && in_array($branch_id, $ids)) { 
            $conditions['SpPlanHd.branch_id'] = $branch_id;
        }else{
        	$conditions['SpPlanHd.branch_id']=$ids;
        }
     
        
     if(isset($_REQUEST['region_id'])){
     $this->Session->write('reg', $_REQUEST['region_id']);
     }else{
      if(!$this->Session->check('reg')){
        $this->Session->write('reg', 'All');
      }
      
     }
        
      $region_id = (isset($_REQUEST['region_id'])) ? $_REQUEST['region_id'] : $this->Session->read('reg');
      
      
    
      if ($region_id != 'All'){
      $this->Branch->recursive=0;
        $b_list=$this->Branch->find('all',array('conditions'=>array('Branch.region'=>$region_id),'fields'=>array('Branch.id')));
        //var_dump($b_list);die();
        $b_lists[]=null;
        foreach ($b_list as $key => $value){
        	//$cond = $cond.",".$key;
           $b_lists[]=$value['Branch']['id'];
        }
        //var_dump($b_lists);die();
        $conditions['SpPlanHd.branch_id'] = $b_lists;
      }
    
    
    
          $conditions['SpPlanHd.approved']='r_approved';
          $conditions['SpPlanHd.status']=false;


        $this->SpPlanHd->recursive=0;

       $dts[]=null;
        foreach ($this->SpPlanHd->find('list', array('conditions' => $conditions)) as $key => $value){
        	//$cond = $cond.",".$key;
           $dts[]=$key;
        } 
		

	$sp_plans_hds=$this->SpPlanHd->find('all', array('conditions' => array('SpPlanHd.id'=>$dts),'limit' => $limit, 'offset' => $start));
      //print_r($sp_plans_hds);exit();

		$this->set('sp_plan_hds',$sp_plans_hds);
          

      


		$this->set('results', $this->SpPlanHd->find('count', array('conditions' => array('SpPlanHd.id'=>$dts))));
	}

	function list_data5($id = null) {

		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

		 $cond=-1;
		 $ids[]=null;
		
        foreach ($this->getBranchesForNewBranch() as $key => $value){
        	//$cond = $cond.",".$key;
           $ids[]=$key;
        } 

		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1 && in_array($branch_id, $ids)) { 
            $conditions['SpPlanHd.branch_id'] = $branch_id;
        }else{
        	$conditions['SpPlanHd.branch_id']=$ids;
        }

        $conditions['SpPlanHd.approved']='init';


        $this->SpPlanHd->recursive=0;

       $dts[]=null;
        foreach ($this->SpPlanHd->find('list', array('conditions' => $conditions)) as $key => $value){
        	//$cond = $cond.",".$key;
           $dts[]=$key;
        } 
		

	$sp_plans_hds=$this->SpPlanHd->find('all', array('conditions' => array('SpPlanHd.id'=>$dts),'limit' => $limit, 'offset' => $start));
      //print_r($sp_plans_hds);exit();

		$this->set('sp_plan_hds',$sp_plans_hds);
          

      


		$this->set('results', $this->SpPlanHd->find('count', array('conditions' => array('SpPlanHd.id'=>$dts))));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp plan hd', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpPlanHd->recursive = 2;
		$this->set('spPlanHd', $this->SpPlanHd->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->SpPlanHd->create();
			$this->autoRender = false;

			$this->data['SpPlanHd']['budget_year_id']=$this->getBudgetYear();
			$this->data['SpPlanHd']['user_id']=$this->Auth->User('id');
			$this->data['SpPlanHd']['approved']="init";
			$this->data['SpPlanHd']['rollback_comment']="Plan Created";
			//var_dump($this->data);die();

			if ($this->SpPlanHd->save($this->data)) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->getNewBranches(); // $this->SpPlanHd->Branch->find('list');
		//$budget_years = $this->SpPlanHd->BudgetYear->find('list');
		//$users = $this->SpPlanHd->User->find('list');
		$this->set(compact('branches', 'budget_years', 'users'));
	}

	function edit($id = null, $parent_id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->SpPlanHd->save($this->data)) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp_plan_hd', $this->SpPlanHd->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->SpPlanHd->Branch->find('list');
		$budget_years = $this->SpPlanHd->BudgetYear->find('list');
		$users = $this->SpPlanHd->User->find('list');
		$this->set(compact('branches', 'budget_years', 'users'));
	}
	function edit1($id = null, $parent_id = null) {
		$this->loadModel('SpPlan');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$sp=new SpPlansController();
			//if ($sp->savePlan($this->data)){
			if ($this->SpPlanHd->SpPlan->save($this->data)){
				$this->Session->setFlash(__('The plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
        //var_dump($this->SpPlanHd->SpPlan->read(null, $id));die();
		$this->set('sp_plan', $this->SpPlanHd->SpPlan->read(null, $id));

		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		$array[] = null;
   	$sp_items = $this->SpPlan->SpItem->find('all');
		//$sp_items = $this->SpPlanHd->SpPlan->SpItem->find('all', array('conditions' => array('SpItem.suspend'=>false,'SpPlan.id'=>$id)));
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

		function edit2($id = null, $parent_id = null) {
		//$this->loadModel('SpPlan');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$sp=new SpPlansController();
			//if ($sp->savePlan($this->data)){
			if ($this->SpPlanHd->SpPlan->save($this->data)){
				$this->Session->setFlash(__('The plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp_plan', $this->SpPlanHd->SpPlan->read(null, $id));

		//var_dump($this->SpPlanHd->SpPlan->read(null, $id));die();
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		$array[] = null;
		$sp_items = $this->SpPlanHd->SpPlan->SpItem->find('all', array('conditions' => array('SpItem.suspend'=>false,'SpPlan->id'=>$id)));
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
		function edit3($id = null, $parent_id = null) {
		//$this->loadModel('SpPlan');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$sp=new SpPlansController();
			//if ($sp->savePlan($this->data)){
			if ($this->SpPlanHd->SpPlan->save($this->data)){
				$this->Session->setFlash(__('The plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp_plan', $this->SpPlanHd->SpPlan->read(null, $id));

		//var_dump($this->SpPlanHd->SpPlan->read(null, $id));die();
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		$array[] = null;
		$sp_items = $this->SpPlanHd->SpPlan->SpItem->find('all' ,array('conditions' => array('SpItem.suspend'=>false)));
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

	function boapprove($id = null, $parent_id = null) {
   
		$this->autoRender = false;
		if (!$id || $id == null) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}

		else  {

			
  			$this->SpPlanHd->read(null,$id);
  			$this->SpPlanHd->set(array('approved'=>'bo_approved','rollback_comment'=>'Plan Approved'));

			if ($this->SpPlanHd->save()) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}


		}
			
	}

	function approve($id = null, $parent_id = null) {
   
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}

		else  {

  			$this->SpPlanHd->read(null,$id);
  			$this->SpPlanHd->set(array('approved'=>'r_approved','rollback_comment'=>'Plan Approved'));

			if ($this->SpPlanHd->save()) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
			
	}

	function ret($id = null, $parent_id = null) {
      //var_dump($id);die();
		//$this->autoRender = false;
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if( !empty($this->data)) {
			$this->autoRender = false;
			$this->SpPlanHd->read(null,$id);
  			$this->SpPlanHd->set(array('approved'=>'init','rollback_comment'=>$this->data['SpPlanHd']['rollback_comment']));
//"UPDATE SpPlanHd set approved='init', rollback_comment='".$this->data['SpPlanHd']['rollback_comment']."' where id=".$id)
			if ($this->SpPlanHd->save()) {
				$message="Your Proposed budget plan is returned, please review it!";
file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$this->getPhone($id).'&msg='.urlencode($message));

				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}




		$this->set('plan',$id);
		$this->set('sp_plan_hd', $this->SpPlanHd->read(null, $id));
	
	}

		function boret($id = null, $parent_id = null) {
      //var_dump($id);die();
		//$this->autoRender = false;
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if( !empty($this->data)) {
			$this->autoRender = false;
			$this->SpPlanHd->read(null,$id);
  			$this->SpPlanHd->set(array('approved'=>'created','rollback_comment'=>$this->data['SpPlanHd']['rollback_comment']));
//"UPDATE SpPlanHd set approved='init', rollback_comment='".$this->data['SpPlanHd']['rollback_comment']."' where id=".$id)
			if ($this->SpPlanHd->save()) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}




		$this->set('plan',$id);
		$this->set('sp_plan_hd', $this->SpPlanHd->read(null, $id));
	
	}

function finalret($id = null, $parent_id = null) {
   		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp plan hd', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if( !empty($this->data)) {
			$this->autoRender = false;
			$this->SpPlanHd->read(null,$id);
  			$this->SpPlanHd->set(array('approved'=>'r_approved','rollback_comment'=>$this->data['SpPlanHd']['rollback_comment']));
//"UPDATE SpPlanHd set approved='init', rollback_comment='".$this->data['SpPlanHd']['rollback_comment']."' where id=".$id)
			if ($this->SpPlanHd->save()) {
				$this->Session->setFlash(__('The sp plan hd has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp plan hd could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}




		$this->set('plan',$id);
		$this->set('sp_plan_hd', $this->SpPlanHd->read(null, $id));
	
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp plan hd', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpPlanHd->delete($i);
                }
				$this->Session->setFlash(__('Sp plan hd deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp plan hd was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpPlanHd->delete($id)) {
				$this->Session->setFlash(__('Sp plan hd deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp plan hd was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	function close() {
		$this->autoRender = false;
		$this->SpPlanHd->query("UPDATE sp_plan_hds set status=true where status=false and id<>0");
		$this->Session->setFlash(__('Closed', true), '');
		$this->render('/elements/success');

	}

	function getPlanUser($plan_id=null){
		$this->loadModel('SpPlanHd');
		$dt=$this->SpPlanHd->find('all',array('conditions'=>array('SpPlanHd.id'=>$plan_id)));
			if($dt){
		$dt=$dt[0]['SpPlanHd']['user_id'];
	}else{
		$dt[]=null;
	}
		return $dt;

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
	function getBranchName(){
		$this->loadModel('Branch');
		
			$branch_dt=$this->getBranchId();
			$name=$this->Branch->find('all',array('conditions'=>array('Branch.id'=>$branch_dt)));
			return $name[0]['Branch']['name'];
	}

	function getBranches(){
		$this->loadModel('Branch');
		$region_name=$this->getBranchName();
		if($region_name=='H/Office Strategy and Innovation Department')
			$branches=$this->Branch->find('list',array('conditions'=>array('Branch.region'=>'Head Office')));
		else
			$branches=$this->Branch->find('list',array('conditions'=>array('Branch.region'=>$region_name)));
		return $branches;
	}

function getBranchesForNewBranch(){
		$this->loadModel('Branch');
		$this->loadModel('BudgetYear');
		$user_id=$this->Auth->User('id');
		$branch_ids=$this->SpPlanHd->find('all',
			array(
				'conditions'=>array('SpPlanHd.user_id'=>$user_id),
				'fields'=>array('SpPlanHd.branch_id'),
				'recursive'=>-1
			)
		);

		$from_date=$this->BudgetYear->find('all',
			array('order'=>array('BudgetYear.id desc limit 1'),
				'fields'=>array('year(BudgetYear.from_date) as year')
			)
		);
        
        $b_id[]=null;
        $i=0;
        foreach ($branch_ids as $key) {
        	$b_id[$i]=$key['SpPlanHd']['branch_id'];
        	$i++;
        }
        

		$branch=$this->Branch->find('list',
			array('conditions'=>array('Branch.id'=>$b_id,'year(Branch.created) >='=>$from_date[0][0]['year']))
		 );

  return $branch;

	}

	function getNewBranches(){
		$this->loadModel('Branch');
		$this->loadModel('BudgetYear');
		
		$branch_name=$this->getBranchName();
		$user_id=$this->Auth->User('id');
		$branch_ids=$this->SpPlanHd->find('all',
			array(
				//'conditions'=>array('SpPlanHd.user_id'=>$user_id),
				'fields'=>array('SpPlanHd.branch_id'),
				'recursive'=>-1
			)
		);

		$from_date=$this->BudgetYear->find('all',
			array('order'=>array('BudgetYear.id desc limit 1'),
				'fields'=>array('year(BudgetYear.from_date) as year')
			)
		);
        
        $b_id[]=null;
        $i=0;
        foreach ($branch_ids as $key) {
        	$b_id[$i]=$key['SpPlanHd']['branch_id'];
        	$i++;
        }
        

		$branch=$this->Branch->find('list',
			array('conditions'=>array('year(Branch.created) >='=>$from_date[0][0]['year'],'NOT'=>array('Branch.id'=>$b_id),'Branch.region'=>$branch_name)
		           )
		 );
		//var_dump($b_id);die();

		return $branch;

	}

	function getBranchesForBo(){
		$this->loadModel('Branch');
		$region_name=$this->getBranchName();
		if($region_name=='H/Office Strategy and Innovation Department')
			$branches=$this->Branch->find('list',array('conditions'=>array('Branch.region'=>'Head Office')));
		else
			$branches=$this->Branch->find('list',array('conditions'=>array('Branch.region !='=>'Head Office')));
		return $branches;
	}


	function getBudgetYear(){
		$this->loadModel('BudgetYear');
			$budget=$this->BudgetYear->find('all',array('order'=>array('BudgetYear.id desc limit 1')));
			$budget=$budget[0]['BudgetYear']['id'];
			return $budget;
	}
	function getPhone($plan_id=null){

		$this->loadModel('Employee');

		$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$this->getPlanUser($plan_id))));
               
		return $emp[0]['Employee']['telephone'];

	}
}
?>