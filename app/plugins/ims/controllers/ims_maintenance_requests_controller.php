<?php
class ImsMaintenanceRequestsController extends AppController {

	var $name = 'ImsMaintenanceRequests';
	
	function index() {
		//$branches = $this->ImsMaintenanceRequest->Branch->find('all');
		//$this->set(compact('branches'));
	}
	
	function index_1() {
		
	}
	
	function index_2() {
		
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();
		if ($branch_id != -1) {
            $conditions['ImsMaintenanceRequest.branch_id'] = $branch_id;
        }
		$conditions['ImsMaintenanceRequest.requested_by'] = $user['Auth']['User']['id'];
		$this->set('ims_maintenance_requests', $this->ImsMaintenanceRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsMaintenanceRequest->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$user = $this->Session->read();		
		if ($branch_id != -1) {
            $conditions['ImsMaintenanceRequest.branch_id'] = $branch_id;
        }
		$conditions['ImsMaintenanceRequest.requested_by <>'] = $user['Auth']['User']['id'];
		$conditions['ImsMaintenanceRequest.status'] = 'created';
		
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		foreach($employees as $employee){
			$emp = $this->Employee->read(null,$employee);
			$users[] = $emp['Employee']['user_id'];
		}
		$empcond=array("OR "=>array("ImsMaintenanceRequest.requested_by" => $users));
		$conditions = array_merge($empcond , $conditions);
		
		$test=$this->set('ims_maintenance_requests', $this->ImsMaintenanceRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsMaintenanceRequest->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['ImsMaintenanceRequest.branch_id'] = $branch_id;
        }
		$conditions['ImsMaintenanceRequest.status'] = array('approved', 'accepted', 'spare-part needed');
		
		$user = $this->Session->read();
		$list_of_users=array(1377,1661,434,1561,2904,2902);
		// $user['Auth']['User']['id'] == 2037 or $user['Auth']['User']['id'] == 1377 or $user['Auth']['User']['id'] == 1661 or $user['Auth']['User']['id'] == 434 or $user['Auth']['User']['id'] == 1561
		if(in_array($user['Auth']['User']['id'],$list_of_users)){
			$conditions['ImsMaintenanceRequest.ims_item_id'] = array(63, 667, 889, 42, 310, 321, 322, 57, 326, 887);
		}
		else $conditions['ImsMaintenanceRequest.ims_item_id NOT'] = array(63, 667, 889, 42, 310, 321, 322, 57, 326);
		
		$test=$this->set('ims_maintenance_requests', $this->ImsMaintenanceRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));		
		$this->set('results', $this->ImsMaintenanceRequest->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims maintenance request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsMaintenanceRequest->recursive = 2;
		$this->set('imsMaintenanceRequest', $this->ImsMaintenanceRequest->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['description']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsMaintenanceRequest']['description'] = $content;
			
			// Strip out carriage returns
            $content1 = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['technician_recommendation']);
            // Handle paragraphs
            $content1 = ereg_replace("\n\n",'<br /><br />',$content1);
            // Handle line breaks
            $content1 = ereg_replace("\n",'<br />',$content1);
            // Handle apostrophes
            $content1 = ereg_replace("'",'&#8217;',$content1);
			$this->data['ImsMaintenanceRequest']['technician_recommendation'] = $content1;
			
			// Strip out carriage returns
            $content2 = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['branch_recommendation']);
            // Handle paragraphs
            $content2 = ereg_replace("\n\n",'<br /><br />',$content2);
            // Handle line breaks
            $content2 = ereg_replace("\n",'<br />',$content2);
            // Handle apostrophes
            $content2 = ereg_replace("'",'&#8217;',$content2);
			$this->data['ImsMaintenanceRequest']['branch_recommendation'] = $content2;
			
			$this->ImsMaintenanceRequest->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['ImsMaintenanceRequest']['requested_by'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['ImsMaintenanceRequest']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			
			$this->data['ImsMaintenanceRequest']['status'] = 'created';
			
			if ($this->ImsMaintenanceRequest->save($this->data)) {
				$this->Session->setFlash(__('The maintenance request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The maintenance request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->ImsMaintenanceRequest->Branch->find('list');
		$this->set(compact('branches'));
		
		$count = 0;
		$value = $this->ImsMaintenanceRequest->find('first',array('conditions' => array('ImsMaintenanceRequest.name LIKE' => date("Ymd").'%'),'order'=>'ImsMaintenanceRequest.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsMaintenanceRequest']['name']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
		
		$this->ImsMaintenanceRequest->ImsItem->recursive = 0;
		$items = $this->ImsMaintenanceRequest->ImsItem->find('all');
		$this->set(compact('items'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid maintenance request', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['description']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$this->data['ImsMaintenanceRequest']['description'] = $content;
			
			// Strip out carriage returns
            $content1 = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['technician_recommendation']);
            // Handle paragraphs
            $content1 = ereg_replace("\n\n",'<br /><br />',$content1);
            // Handle line breaks
            $content1 = ereg_replace("\n",'<br />',$content1);
            // Handle apostrophes
            $content1 = ereg_replace("'",'&#8217;',$content1);
			$this->data['ImsMaintenanceRequest']['technician_recommendation'] = $content1;
			
			// Strip out carriage returns
            $content2 = ereg_replace("\r",'',$this->data['ImsMaintenanceRequest']['branch_recommendation']);
            // Handle paragraphs
            $content2 = ereg_replace("\n\n",'<br /><br />',$content2);
            // Handle line breaks
            $content2 = ereg_replace("\n",'<br />',$content2);
            // Handle apostrophes
            $content2 = ereg_replace("'",'&#8217;',$content2);
			$this->data['ImsMaintenanceRequest']['branch_recommendation'] = $content2;
			
			if ($this->ImsMaintenanceRequest->save($this->data)) {
				$this->Session->setFlash(__('The maintenance request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The maintenance request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_maintenance_request', $this->ImsMaintenanceRequest->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$this->ImsMaintenanceRequest->ImsItem->recursive = 0;
		$items = $this->ImsMaintenanceRequest->ImsItem->find('all');
		$this->set(compact('items'));
	}
	
	function edit_1($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid maintenance request', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->data['ImsMaintenanceRequest']['status'] = 'spare-part needed';
			if ($this->ImsMaintenanceRequest->save($this->data)) {
				$this->Session->setFlash(__('The maintenance request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The maintenance request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_maintenance_request', $this->ImsMaintenanceRequest->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
		
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for maintenance request', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsMaintenanceRequest->delete($i);
                }
				$this->Session->setFlash(__('maintenance request deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('maintenance request was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsMaintenanceRequest->delete($id)) {
				$this->Session->setFlash(__('maintenance request deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('maintenance request was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function getUser(){
		$userid = $this->params['userid'];	
		$this->loadModel('User');
		$conditions = array('User.id' => $userid);
		$this->User->recursive = 0;
		$user = $this->User->find('first',array('conditions' => $conditions));	
		return $user;
	}
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();		
        $requisition = array('ImsMaintenanceRequest' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'approved'));
        if ($this->ImsMaintenanceRequest->save($requisition)) {
            $this->Session->setFlash(__('maintenance request successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $requisition = array('ImsMaintenanceRequest' => array('id' => $id, 'approved_rejected_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->ImsMaintenanceRequest->save($requisition)) {
            $this->Session->setFlash(__('maintenance request successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function accept($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $requisition = array('ImsMaintenanceRequest' => array('id' => $id, 'received_by' => $user['Auth']['User']['id'],'status' => 'accepted'));
        if ($this->ImsMaintenanceRequest->save($requisition)) {
            $this->Session->setFlash(__('maintenance request successfully accepted', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not successfully accepted', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function complete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $requisition = array('ImsMaintenanceRequest' => array('id' => $id, 'status' => 'completed'));
        if ($this->ImsMaintenanceRequest->save($requisition)) {
            $this->Session->setFlash(__('maintenance request successfully completed', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not successfully completed', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>