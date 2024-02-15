<?php
class EmployeeDetailsController extends AppController {

	var $name = 'EmployeeDetails';
	
	function index() {
		$employees = $this->EmployeeDetail->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 10;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['EmployeeDetail.employee_id'] = $employee_id;
        }
		
		$this->set('employee_details', $this->EmployeeDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
   //var_dump($this->EmployeeDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)))die();
		$this->set('results', $this->EmployeeDetail->find('count', array('conditions' => $conditions)));
	}
	
	function empdetailupdate() {
		$this->autoRender = false;
		//1.2.14.3.4.5.15.6.7.8.9.10.11.12.16.13.
		$graderank=array(1=>1,2=>2,14=>3,3=>4,4=>5,5=>6,15=>7,6=>8,7=>9,8=>10,9=>11,10=>12,11=>13,12=>14,16=>15,13=>16,17=>17,18=>18,19=>19);
        
		$this->EmployeeDetail->Employee->recursive=-1;
		//$conditionst['Employee.id'] = 1138;
		//$emps=$this->EmployeeDetail->Employee->find('all',array('conditions' => $conditionst));
		$emps=$this->EmployeeDetail->Employee->find('all');
		//print_r($emps);
	  foreach($emps as $emp){
		
		$conditions['EmployeeDetail.employee_id'] = $emp['Employee']['id'];
		$this->EmployeeDetail->recursive=-1;
		$employee_details=array();
		$employee_details= $this->EmployeeDetail->find('all', array('conditions' => $conditions, 'order' => 'EmployeeDetail.start_date'));
		$old=array();
		$last_position_id='';
		$last_position_end='';
		$numItems=count($employee_details);
		$i=1;
		//if($emp['Employee']['id']=='93')
		foreach($employee_details as $emp_det){
		$new=$emp_det['EmployeeDetail'];
		$data=array();
		$data['EmployeeDetail']['id']=$new['id'];
		$data['EmployeeDetail']['position_change']='0';
		$data['EmployeeDetail']['type']='NO CHANGE';//Recruitment Promotion Demotion Salary Change //Not needed: Company Salary Adjustement
		$data['EmployeeDetail']['transfer']='0';
		$data['EmployeeDetail']['position_end']='0000-00-00';
			if(empty($old)){
				$old=$new;
				$data['EmployeeDetail']['type']='RECRUITMENT';
				$data['EmployeeDetail']['position_change']='1';	
				$last_position_id=$new['id'];				
					//print_r($new);
			}else{
				if($new['step_id']!=$old['step_id'] || $new['salary']!=$old['salary']){
					$data['EmployeeDetail']['type']='SALARY CHANGE';
				}
				if($graderank[$new['grade_id']]>$graderank[$old['grade_id']]){
					$data['EmployeeDetail']['type']='PROMOTION';
				}
				if($graderank[$new['grade_id']]<$graderank[$old['grade_id']]){
					$data['EmployeeDetail']['type']='DEMOTION';
				}
				if($new['position_id']!=$old['position_id']){
					$data['EmployeeDetail']['position_change']='1';
					$datax['EmployeeDetail']=array();
					$datax['EmployeeDetail']['id']=$last_position_id;
					$datax['EmployeeDetail']['position_end']=$last_position_end;
					$this->EmployeeDetail->save($datax);
					$last_position_id=$new['id'];	
				}
				if($new['branch_id']!=$old['branch_id']){
					$data['EmployeeDetail']['transfer']='1';
				}
				if($old['end_date']=='0000-00-00'){
					$datax['EmployeeDetail']=array();
					$datax['EmployeeDetail']['id']=$old['id'];
					$datax['EmployeeDetail']['end_date']=date('Y-m-d',strtotime($new['start_date'].' -1 days'));
					$this->EmployeeDetail->save($datax);
				}
				if($i == $numItems && $emp['Employee']['status']=='active' && $new['end_date']!='0000-00-00'){
					$data['EmployeeDetail']['end_date']='';
				}
				
				    $old=$new;
					//print_r($new);
			}
				$this->EmployeeDetail->save($data);
				$last_position_end=$new['end_date'];
				//print_r($old);
				//print_r($data);
				$i++;
		}
	  }
	}


	function branch_none_remove() {
		$this->autoRender = false;
		//1.2.14.3.4.5.15.6.7.8.9.10.11.12.16.13.
		$graderank=array(1=>1,2=>2,14=>3,3=>4,4=>5,5=>6,15=>7,6=>8,7=>9,8=>10,9=>11,10=>12,11=>13,12=>14,16=>15,13=>16);
        
		$this->EmployeeDetail->Employee->recursive=-1;
		$emps=$this->EmployeeDetail->Employee->find('all');
		//print_r($emps);$
	  foreach($emps as $emp){
		
		$conditions['EmployeeDetail.employee_id'] = $emp['Employee']['id'];
		$this->EmployeeDetail->recursive=-1;
		$employee_details= $this->EmployeeDetail->find('all', array('conditions' => $conditions, 'order' => 'EmployeeDetail.start_date'));
		$old=0;
		$old_id=0;
		foreach($employee_details as $emp_det){
			$new=$emp_det['EmployeeDetail'];
			$data['EmployeeDetail']['id']=$new['id'];
			$data['EmployeeDetail']['branch_id']=$new['branch_id'];

					if($new['branch_id']==0){
						$data['EmployeeDetail']['branch_id']=$old;
						$this->EmployeeDetail->save($data);
					}
					if($old==0 && $old_id!=0){
						$data['EmployeeDetail']['id']=$old_id;
						$data['EmployeeDetail']['branch_id']=$new['branch_id'];
						$this->EmployeeDetail->save($data);
					}		
					if($new['branch_id']!=0)
						$old=$new['branch_id'];
						$old_id=$new['id'];
											
					//print_r($new);
					//print_r($data);				
		}
	  }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid employee detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->EmployeeDetail->recursive = 2;
		$this->set('employeeDetail', $this->EmployeeDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->EmployeeDetail->create();
			$this->autoRender = false;
			if ($this->EmployeeDetail->save($this->data)) {
                            $con['Scale.grade_id'] = $this->data['EmployeeDetail']['grade_id'];
                            $con['Scale.step_id'] = $this->data['EmployeeDetail']['step_id'];
                            $this->loadModel('Scale');
                            $salary = $this->Scale->find('all', array('conditions' => $con));
                            $this->data['EmployeeDetail']['salary'] = $salary[0]['Scale']['salary'];
                            $this->EmployeeDetail->save($this->data);
				$this->Session->setFlash(__('The employee detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->EmployeeDetail->Employee->find('list');
		$grades = $this->EmployeeDetail->Grade->find('list');
		$steps = $this->EmployeeDetail->Step->find('list');
    $conditions['Position.status'] = 'active';
		$positions = $this->EmployeeDetail->Position->find('list',array('conditions' => $conditions,'order' => 'name'));
    $branches = $this->EmployeeDetail->Branch->find('list',array('order' => 'name'));
		$this->set(compact('employees', 'grades', 'steps', 'positions','branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid employee detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) { 
			$this->autoRender = false;
			if ($this->EmployeeDetail->save($this->data)) {
                            $con['Scale.grade_id'] = $this->data['EmployeeDetail']['grade_id'];
                            $con['Scale.step_id'] = $this->data['EmployeeDetail']['step_id'];
                            $this->loadModel('Scale');
                            $salary = $this->Scale->find('all', array('conditions' => $con));
                            $this->data['EmployeeDetail']['salary'] = $salary[0]['Scale']['salary'];
                            $this->EmployeeDetail->save($this->data);
				$this->Session->setFlash(__('The employee detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('employee__detail', $this->EmployeeDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->EmployeeDetail->Employee->find('list');
		$grades = $this->EmployeeDetail->Grade->find('list');
		$steps = $this->EmployeeDetail->Step->find('list');
    $conditions['Position.status'] = 'active';
		$positions = $this->EmployeeDetail->Position->find('list',array('conditions' => $conditions,'order' => 'name'));
        $branches = $this->EmployeeDetail->Branch->find('list',array('order' => 'name'));
		$this->set(compact('employees', 'grades', 'steps', 'positions','branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for employee detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->EmployeeDetail->delete($i);
                }
				$this->Session->setFlash(__('Employee detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Employee detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->EmployeeDetail->delete($id)) {
				$this->Session->setFlash(__('Employee detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Employee detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>