<?php
class StafftooktrainingsController extends AppController {

	var $name = 'Stafftooktrainings';
	
	function index() {
		$takentrainings = $this->Stafftooktraining->Takentraining->find('all');
		$this->set(compact('takentrainings'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 100;
		$takentraining_id = (isset($_REQUEST['takentraining_id'])) ? $_REQUEST['takentraining_id'] : -1;
		if($id)
			$takentraining_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($takentraining_id != -1) {
            $conditions['Stafftooktraining.takentraining_id'] = $takentraining_id;
        }
		$this->Stafftooktraining->recursive=3;
		$this->Stafftooktraining->unbindModel(array('belongsTo' => array('Takentraining')));
		$this->Stafftooktraining->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','EmployeeDetail','Experience','Language','Offspring','Termination','Loan')));
		$this->Stafftooktraining->Position->unbindModel(array('belongsTo' => array('Grade')));
		$this->Stafftooktraining->Branch->unbindModel(array('belongsTo' => array('Bank','BranchCategory'),'hasMany'=>array('CmsCase','DmsShare','EmployeeDetail','ImsBudget','ImsRequisition','User')));
		$this->set('stafftooktrainings', $this->Stafftooktraining->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Stafftooktraining->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid stafftooktraining', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Stafftooktraining->recursive = 2;
		$this->set('stafftooktraining', $this->Stafftooktraining->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$takentraining=$this->Stafftooktraining->Takentraining->read(null, $this->data['Stafftooktraining']['takentraining_id']);
			$pdate=$takentraining['Takentraining']['from'];
			$conditions['Stafftooktraining.takentraining_id'] =  $this->data['Stafftooktraining']['takentraining_id'];
			$alreadylist=$this->Stafftooktraining->find('list', array('conditions' => $conditions, 'fields' => array('Stafftooktraining.employee_id')));
			
			if(!in_array($this->data['Stafftooktraining']['employee_id'],$alreadylist)){
			$this->Stafftooktraining->create();
			$this->autoRender = false;
			$emp_id=$this->data['Stafftooktraining']['employee_id'];
			$this->loadModel('Employee');
			$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','Experience','Language','Offspring','Loan')));
		$this->Employee->recursive=1;
		$emp=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));

		$mess['EmployeeDetail']=$emp['EmployeeDetail'];
			if(isset($mess['EmployeeDetail'])){
				foreach($mess['EmployeeDetail'] as $empdt){
					if($empdt['end_date']=='0000-00-00'){
						if($emp['Employee']['status']=='deactivated')
							$empdt['end_date']=$emp['Termination'][0]['date'];
						else
						  $empdt['end_date']='9999-99-99';
					}
					if($empdt['start_date']<=$pdate && $empdt['end_date']>=$pdate){
					$this->data['Stafftooktraining']['position_id']=$empdt['position_id'];
					$this->data['Stafftooktraining']['branch_id']=$empdt['branch_id'];
					$this->Stafftooktraining->create();
					$this->Stafftooktraining->save($this->data);
					break;
					}
				}
			}

				/*if ($this->Stafftooktraining->save($this->data)) {
					$this->Session->setFlash(__('The stafftooktraining has been saved', true), '');
					$this->render('/elements/success');
				} else {*/
					$this->Session->setFlash(__('The stafftooktraining could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				//}
			}else {
				$this->Session->setFlash(__('Record Alread Exist on the list.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$takentrainings = $this->Stafftooktraining->Takentraining->find('list');
		$this->set(compact('takentrainings'));
	}
	
	function add2($id = null) {
		if (!empty($this->data)) {
			$takentraining=$this->Stafftooktraining->Takentraining->read(null, $this->data['Stafftooktraining']['takentraining_id']);
			$pdate=$takentraining['Takentraining']['from'];
			$conditions['Stafftooktraining.takentraining_id'] =  $this->data['Stafftooktraining']['takentraining_id'];
			$alreadylist=$this->Stafftooktraining->find('list', array('conditions' => $conditions, 'fields' => array('Stafftooktraining.employee_id')));
			$this->loadModel('Employee');
			$this->Employee->recursive=1;
			$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','Experience','Language','Offspring','Loan')));
			foreach($this->data['Stafftooktraining']['employees'] as $emp){
				if (is_numeric($emp)){
				   if(!in_array($emp,$alreadylist)){	
				   $this->data['Stafftooktraining']['employee_id']=$emp;
				   $emp_id=$this->data['Stafftooktraining']['employee_id'];
				   $empx=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));
				   $mess['EmployeeDetail']=$empx['EmployeeDetail'];

					if(isset($mess['EmployeeDetail'])){
						foreach($mess['EmployeeDetail'] as $empdt){
						if($empdt['end_date']=='0000-00-00'){
							if($empx['Employee']['status']=='deactivated')
								$empdt['end_date']=$empx['Termination'][0]['date'];
							else
							  $empdt['end_date']='9999-99-99';
						}

							if($empdt['start_date']<=$pdate && $empdt['end_date']>=$pdate){
							$this->data['Stafftooktraining']['position_id']=$empdt['position_id'];
							$this->data['Stafftooktraining']['branch_id']=$empdt['branch_id'];
							$this->Stafftooktraining->create();
							$this->Stafftooktraining->save($this->data);
							break;
							}
						}
						
					}
				   }
				}
			}
			$this->Session->setFlash(__('The stafftooktraining has been saved', true), '');
			$this->render('/elements/success');		
		}
		if($id)
			$this->set('parent_id', $id);
		$takentrainings = $this->Stafftooktraining->Takentraining->find('list');
		$this->set(compact('takentrainings'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid stafftooktraining', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Stafftooktraining->save($this->data)) {
				$this->Session->setFlash(__('The stafftooktraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The stafftooktraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('stafftooktraining', $this->Stafftooktraining->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$takentrainings = $this->Stafftooktraining->Takentraining->find('list');
		$employees = $this->Stafftooktraining->Employee->find('list');
		$positions = $this->Stafftooktraining->Position->find('list');
		$branches = $this->Stafftooktraining->Branch->find('list');
		$this->set(compact('takentrainings', 'employees', 'positions', 'branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for stafftooktraining', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Stafftooktraining->delete($i);
                }
				$this->Session->setFlash(__('Stafftooktraining deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Stafftooktraining was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Stafftooktraining->delete($id)) {
				$this->Session->setFlash(__('Stafftooktraining deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Stafftooktraining was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>