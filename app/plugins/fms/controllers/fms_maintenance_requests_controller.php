<?php
class FmsMaintenanceRequestsController extends AppController {

	var $name = 'FmsMaintenanceRequests';
	
	function index() {
		$fmsvehicles = $this->FmsMaintenanceRequest->FmsVehicle->find('all', array('order' => 'FmsVehicle.plate_no ASC'));
		$this->set(compact('fmsvehicles'));
	}
	
	function index_2() {
		$fmsvehicles = $this->FmsMaintenanceRequest->FmsVehicle->find('all', array('order' => 'FmsVehicle.plate_no ASC'));
		$this->set(compact('fmsvehicles'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_maintenance_request_report($id = null) { 
		$this->FmsMaintenanceRequest->FmsVehicle->recursive =-1;		
		$vehicles = $this->FmsMaintenanceRequest->FmsVehicle->find('all');
		
	    $this->set('vehicles',$vehicles);
    }

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$fmsvehicle_id = (isset($_REQUEST['fmsvehicle_id'])) ? $_REQUEST['fmsvehicle_id'] : -1;
		if($id)
			$fmsvehicle_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($fmsvehicle_id != -1) {
            $conditions['FmsMaintenanceRequest.fms_vehicle_id'] = $fmsvehicle_id;
        }
		$conditions['FmsMaintenanceRequest.status !='] = 'approved';
		$this->set('fms_maintenance_requests', $this->FmsMaintenanceRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsMaintenanceRequest->find('count', array('conditions' => $conditions)));
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$fmsvehicle_id = (isset($_REQUEST['fmsvehicle_id'])) ? $_REQUEST['fmsvehicle_id'] : -1;
		if($id)
			$fmsvehicle_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($fmsvehicle_id != -1) {
            $conditions['FmsMaintenanceRequest.fms_vehicle_id'] = $fmsvehicle_id;
        }
		$conditions['FmsMaintenanceRequest.status'] = 'posted';
		$this->set('fms_maintenance_requests', $this->FmsMaintenanceRequest->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsMaintenanceRequest->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms maintenance request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsMaintenanceRequest->recursive = 2;
		$this->set('fmsMaintenanceRequest', $this->FmsMaintenanceRequest->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
		
			// Strip out carriage returns
            $damage_type = ereg_replace("\r",'',$this->data['FmsMaintenanceRequest']['damage_type']);
            // Handle paragraphs
            $damage_type = ereg_replace("\n\n",'<br /><br />',$damage_type);
            // Handle line breaks
            $damage_type = ereg_replace("\n",'<br />',$damage_type);
            // Handle apostrophes
            $damage_type = ereg_replace("'",'&apos;',$damage_type);
			// double quotes
            $damage_type = ereg_replace('"','&quot;',$damage_type);
			// slash
            $damage_type = ereg_replace("/", '&#47;',$damage_type);
			// back slash
            $damage_type = ereg_replace('\\\\', '&#92;',$damage_type);
			$this->data['FmsMaintenanceRequest']['damage_type'] = $damage_type;
			
			// Strip out carriage returns
            $examination = ereg_replace("\r",'',$this->data['FmsMaintenanceRequest']['examination']);
            // Handle paragraphs
            $examination = ereg_replace("\n\n",'<br /><br />',$examination);
            // Handle line breaks
            $examination = ereg_replace("\n",'<br />',$examination);
            // Handle apostrophes
            $examination = ereg_replace("'",'&apos;',$examination);
			// double quotes
            $examination = ereg_replace('"','&quot;',$examination);
			// slash
            $examination = ereg_replace("/", '&#47;',$examination);
			// back slash
            $examination = ereg_replace('\\\\', '&#92;',$examination);
			$this->data['FmsMaintenanceRequest']['examination'] = $examination;
			
			$this->FmsMaintenanceRequest->create();
			$this->autoRender = false;
			$this->data['FmsMaintenanceRequest']['status'] = 'created';
			if ($this->FmsMaintenanceRequest->save($this->data)) {
				$this->Session->setFlash(__('The fms maintenance request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms maintenance request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$fms_vehicles = $this->FmsMaintenanceRequest->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
		
		$this->loadModel('People');
		$people = $this->People->find('all', array('order' => 'People.first_name ASC'));
		$this->set(compact('people'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms maintenance request', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			// Strip out carriage returns
            $damage_type = ereg_replace("\r",'',$this->data['FmsMaintenanceRequest']['damage_type']);
            // Handle paragraphs
            $damage_type = ereg_replace("\n\n",'<br /><br />',$damage_type);
            // Handle line breaks
            $damage_type = ereg_replace("\n",'<br />',$damage_type);
            // Handle apostrophes
            $damage_type = ereg_replace("'",'&apos;',$damage_type);
			// double quotes
            $damage_type = ereg_replace('"','&quot;',$damage_type);
			// slash
            $damage_type = ereg_replace("/", '&#47;',$damage_type);
			// back slash
            $damage_type = ereg_replace('\\\\', '&#92;',$damage_type);
			$this->data['FmsMaintenanceRequest']['damage_type'] = $damage_type;
			
			// Strip out carriage returns
            $examination = ereg_replace("\r",'',$this->data['FmsMaintenanceRequest']['examination']);
            // Handle paragraphs
            $examination = ereg_replace("\n\n",'<br /><br />',$examination);
            // Handle line breaks
            $examination = ereg_replace("\n",'<br />',$examination);
            // Handle apostrophes
            $examination = ereg_replace("'",'&apos;',$examination);
			// double quotes
            $examination = ereg_replace('"','&quot;',$examination);
			// slash
            $examination = ereg_replace("/", '&#47;',$examination);
			// back slash
            $examination = ereg_replace('\\\\', '&#92;',$examination);
			$this->data['FmsMaintenanceRequest']['examination'] = $examination;
			
			
			if ($this->FmsMaintenanceRequest->save($this->data)) {
				$this->Session->setFlash(__('The fms maintenance request has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms maintenance request could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_maintenance_request', $this->FmsMaintenanceRequest->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$fms_vehicles = $this->FmsMaintenanceRequest->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
		
		$this->loadModel('People');
		$people = $this->People->find('all', array('order' => 'People.first_name ASC'));
		$this->set(compact('people'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms maintenance request', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsMaintenanceRequest->delete($i);
                }
				$this->Session->setFlash(__('Fms maintenance request deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms maintenance request was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsMaintenanceRequest->delete($id)) {
				$this->Session->setFlash(__('Fms maintenance request deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms maintenance request was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$this->FmsMaintenanceRequest->id = $id;
        if ($this->FmsMaintenanceRequest->saveField('status', 'posted')) {
            $this->Session->setFlash(__('maintenance request posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance request', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();
		$this->FmsMaintenanceRequest->read(null, $id);
		$this->FmsMaintenanceRequest->set('status', 'approved');
		//$this->FmsMaintenanceRequest->set('approved_by', $user['Auth']['User']['id']);
        
        if ($this->FmsMaintenanceRequest->save()){
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
		$this->FmsMaintenanceRequest->read(null, $id);
		$this->FmsMaintenanceRequest->set('status', 'rejected');
		//$this->FmsMaintenanceRequest->set('approved_by', $user['Auth']['User']['id']);
		
        if ($this->FmsMaintenanceRequest->save()) {
            $this->Session->setFlash(__('maintenance request successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance request was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function maintenance_request_report($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
		
            //$vehicle_id = $this->data['FmsVehicle']['vehicle'];				
			$fromdate = $this->data['FmsVehicle']['from'];
			$todate = $this->data['FmsVehicle']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			//$this->ImsRequisition->recursive =-1;			
			$conditions =array('FmsMaintenanceRequest.created >=' => $fromdate, 'FmsMaintenanceRequest.created <' => $tomorrow, 'FmsMaintenanceRequest.status' => 'approved');  						 
			$maintenances = $this->FmsMaintenanceRequest->find('all', array('conditions' => $conditions));
			
			$result = array();
			$count = 0;
			$totalprice = 0;			
			
			for($j=0; $j<count($maintenances ); $j++){						
				
					$vehicle = $this->FmsMaintenanceRequest->FmsVehicle->read(null, $maintenances[$j]['FmsMaintenanceRequest']['fms_vehicle_id']);
					$result[$count][0] = $count + 1;
					$result[$count][1] = $maintenances[$j]['FmsMaintenanceRequest']['company'];
					$result[$count][2] = $vehicle['FmsVehicle']['plate_no'];
					$result[$count][3] = $maintenances[$j]['FmsMaintenanceRequest']['km'];
					$result[$count][4] = $maintenances[$j]['FmsMaintenanceRequest']['damage_type'];					
					$result[$count][5] = $maintenances[$j]['FmsMaintenanceRequest']['examination'];
					$result[$count][6] = $maintenances[$j]['FmsMaintenanceRequest']['notifier'];
					$result[$count][7] = $maintenances[$j]['FmsMaintenanceRequest']['confirmer'];
					$result[$count][8] = $maintenances[$j]['FmsMaintenanceRequest']['approver'];					
					$count++;
			}			
			
			$this->set('result',$result);
        }		
    }
}
?>