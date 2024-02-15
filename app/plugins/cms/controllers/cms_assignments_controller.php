<?php
class CmsAssignmentsController extends CmsAppController {

	var $name = 'CmsAssignments';
	
	function index() {
		$cms_cases = $this->CmsAssignment->CmsCase->find('all');
		$this->set(compact('cms_cases'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$cmscase_id = (isset($_REQUEST['cmscase_id'])) ? $_REQUEST['cmscase_id'] : -1;
		if($id)
			$cmscase_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($cmscase_id != -1) {
            $conditions['CmsAssignment.cmscase_id'] = $cmscase_id;
        }
		
		$this->set('cmsAssignments', $this->CmsAssignment->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CmsAssignment->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cms assignment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CmsAssignment->recursive = 2;
		$this->set('cmsAssignment', $this->CmsAssignment->read(null, $id));
	}

	function add($id = null) {
		$user = $this->Session->read();
		if (!empty($this->data)) {
			$this->data['CmsAssignment']['assigned_by'] = $user['Auth']['User']['id'];
			$this->CmsAssignment->create();
			$this->autoRender = false;
			$this->CmsAssignment->updateAll(array('status' => 0),array('cms_case_id' => $this->data['CmsAssignment']['cms_case_id']));
			$this->data['CmsAssignment']['status'] = 1;
			
			$this->loadModel('CmsCase');
			$case = $this->CmsCase->read(null, $this->data['CmsAssignment']['cms_case_id']);
			if($case['CmsCase']['status'] == 'created' or $case['CmsCase']['status'] == 'Work On Progress' or $this->data['CmsAssignment']['assigned_to'] != $user['Auth']['User']['id']){
				if ($this->CmsAssignment->save($this->data)) {
					$this->loadModel('CmsCase');
					$this->CmsCase->id = $this->data['CmsAssignment']['cms_case_id'];
					$this->CmsCase->saveField('status', 'Work On Progress');
					if(!empty($this->data['CmsAssignment']['searchable']))
					$this->CmsCase->saveField('searchable', $this->data['CmsAssignment']['searchable']);
				
					if($this->data['CmsAssignment']['assigned_by'] != $this->data['CmsAssignment']['assigned_to']){
						$this->loadModel('Employee');
						$this->Employee->recursive = -1;
						$conditionsEmp = array('Employee.user_id' => $this->data['CmsAssignment']['assigned_to']);
						$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
						$sup_tel=$employee['Employee']['telephone'];
						$message=urlencode('a new case is assigned to you. Please reply on Case Management System');
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					}
					
					$this->Session->setFlash(__('The assignment has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The cms assignment could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else {
					$this->Session->setFlash(__('the case is already assigned to another person.', true), '');
					$this->render('/elements/failure');
			}
		}
		if($id)	
		$this->set('parent_id', $id);
		
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		$users[$user['Auth']['User']['id']]='SELF ASSIGN';
		foreach($employees as $employee){
			$this->Employee->recursive=2;
			$emp = $this->Employee->read(null,$employee);			
			$count = $this->CmsAssignment->find('count', array('conditions' => array('CmsAssignment.assigned_to'=>$emp['Employee']['user_id'],"NOT" => array('CmsCase.status'=>array('Closed','Solution Offered')))));
			$users[$emp['Employee']['user_id']] = $emp['User']['Person']['first_name'].' '.$emp['User']['Person']['middle_name'].' ('.$count.' Active Cases)';
		}
		$this->set('users',$users);
		
		$cms_cases = $this->CmsAssignment->CmsCase->find('list');
		$this->set(compact('cms_cases'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cms assignment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CmsAssignment->save($this->data)) {
				$this->Session->setFlash(__('The cms assignment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cms assignment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cms__assignment', $this->CmsAssignment->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$cms_cases = $this->CmsAssignment->CmsCase->find('list');
		$this->set(compact('cms_cases'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cms assignment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CmsAssignment->delete($i);
                }
				$this->Session->setFlash(__('Cms assignment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cms assignment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CmsAssignment->delete($id)) {
				$this->Session->setFlash(__('Cms assignment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cms assignment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>