<?php
class EmployeePerformancesController extends AppController {

	var $name = 'EmployeePerformances';
	
	function index() {
		$employees = $this->EmployeePerformance->Employee->find('all');
		$this->set(compact('employees'));
	}
        function index3() {
		$employees = $this->EmployeePerformance->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['EmployeePerformance.employee_id'] = $employee_id;
        }
		
		$this->set('employee_performances', $this->EmployeePerformance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->EmployeePerformance->find('count', array('conditions' => $conditions)));
	}
        
        function list_data3($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        $this->loadModel('Employee');
        $emp=$this->Employee->find('all', array('conditions' => array('user_id'=>$this->Session->read('Auth.User.id'))));
        if(!empty($emp))
            $conditions['EmployeePerformance.employee_id'] = $emp[0]['Employee']['id'];
                $this->loadModel('EmployeePerformance');
		$this->set('employee_performances', $this->EmployeePerformance->find('all', array('conditions' => $conditions)));
		$this->set('results', $this->EmployeePerformance->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid employee performance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->EmployeePerformance->recursive = 2;
		$this->set('employeePerformance', $this->EmployeePerformance->read(null, $id));
	}
        
        
	function result($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid employee performance', true));
			$this->redirect(array('action' => 'index'));
		}
                //$this->autoRender = false;
                $this->loadModel('EmployeePerformanceResult');
                $conditions['EmployeePerformanceResult.employee_performance_id']=$id;
		$this->EmployeePerformanceResult->recursive = 2;
		$emp= $this->EmployeePerformanceResult->find('all', array('conditions' => $conditions));
                //print_r($emp);
                $this->set('employeePerformance',$emp);
	}
        
        function grade($id = null) {
                if (!empty($this->data)) {
                    $this->autoRender = false;
                    $this->loadModel('EmployeePerformanceResult');
                    $this->data['EmployeePerformanceResult']['employee_id']=$this->data['EmployeePerformance']['employee_id'];
                    $this->data['EmployeePerformanceResult']['employee_performance_id']=$this->data['EmployeePerformance']['employee_performance_id'];
                    while ($empper = current($this->data['EmployeePerformance'])) {
                            
                            $arrname=key($this->data['EmployeePerformance']);
                            
                            $this->data['EmployeePerformanceResult']['performance_list_id']=$arrname;
                            $this->data['EmployeePerformanceResult']['value']=$empper;
                            
                            $this->EmployeePerformanceResult->create();
                            $this->EmployeePerformanceResult->save($this->data);
                            next($this->data['EmployeePerformance']);
                        }
                 $this->data['EmployeePerformance']['id']=$this->data['EmployeePerformance']['employee_performance_id'];
                 $this->data['EmployeePerformance']['status']='Pending Approval';
                 $this->loadModel('EmployeePerformance');
                 $this->EmployeePerformance->save($this->data);
                 $this->Session->setFlash(__('The employee performance report has been sent', true), '');
		 $this->render('/elements/success');
                }else{
                
                $dt= $this->EmployeePerformance->read(null, $id);
                if($dt['EmployeePerformance']['status']!='created'){
                    $this->autoRender = false;
                    echo 'graded';
                }else{
                $this->set('employee_id',$dt['EmployeePerformance']['employee_id']);
                $this->set('employee_performance_id',$dt['EmployeePerformance']['id']);
                $conditions['PerformanceList.performance_id'] = $dt['EmployeePerformance']['performance_id'];
                $this->loadModel('PerformanceList');
                $perspectives=$this->PerformanceList->find('all', array('conditions' => $conditions, 'group'=>'perspective'));
                $performance_lists=$this->PerformanceList->find('all', array('conditions' => $conditions));
		$this->set('perspectives', $perspectives);
                $this->set('performance_lists', $performance_lists);
                }
                
            }
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->EmployeePerformance->create();
			$this->autoRender = false;
			if ($this->EmployeePerformance->save($this->data)) {
				$this->Session->setFlash(__('The employee performance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee performance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->EmployeePerformance->Employee->find('list');
                $conditions['Performance.status']='active';
		$performances = $this->EmployeePerformance->Performance->find('list',array('conditions' => $conditions));
		$this->set(compact('employees', 'performances'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid employee performance', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->EmployeePerformance->save($this->data)) {
				$this->Session->setFlash(__('The employee performance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The employee performance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('employee__performance', $this->EmployeePerformance->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->EmployeePerformance->Employee->find('list');
		$performances = $this->EmployeePerformance->Performance->find('list');
		$this->set(compact('employees', 'performances'));
	}
        function accept($id = null) {
            $this->autoRender = false;
            $this->data['EmployeePerformance']['status']='Accepted';
            $this->data['EmployeePerformance']['id']=$id;
            if($this->EmployeePerformance->save($this->data)){
                $this->Session->setFlash(__('Performance Report Accepted', true), '');
                $this->render('/elements/success');
            }else{
                $this->Session->setFlash(__('Could not process request', true), '');
		$this->render('/elements/failure');
            }
            
        }
        
        function oppose($id = null) {
            $this->autoRender = false;
            $this->data['EmployeePerformance']['status']='Opposed';
            $this->data['EmployeePerformance']['id']=$id;
            if($this->EmployeePerformance->save($this->data)){
                $this->Session->setFlash(__('Performance Report Rejected', true), '');
                $this->render('/elements/success');
            }else{
                $this->Session->setFlash(__('Could not process request', true), '');
		$this->render('/elements/failure');
            }
            
        }

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for employee performance', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->EmployeePerformance->delete($i);
                }
				$this->Session->setFlash(__('Employee performance deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Employee performance was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->EmployeePerformance->delete($id)) {
				$this->Session->setFlash(__('Employee performance deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Employee performance was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>