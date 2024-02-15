<?php
class FmsMaintenancesController extends AppController {

	var $name = 'FmsMaintenances';
	
	function index() {
		$fms_vehicles = $this->FmsMaintenance->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}
	
	function index_2() {
		$fms_vehicles = $this->FmsMaintenance->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_maintenance_cost_report($id = null) { 
		$this->FmsMaintenance->FmsVehicle->recursive =-1;		
		$vehicles = $this->FmsMaintenance->FmsVehicle->find('all');
		
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
            $conditions['FmsMaintenance.fmsvehicle_id'] = $fmsvehicle_id;
        }
		$this->FmsMaintenance->recursive = 2;
		$conditions = array('FmsMaintenance.status !=' => 'approved');
		$this->set('fms_maintenances', $this->FmsMaintenance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsMaintenance->find('count', array('conditions' => $conditions)));
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
            $conditions['FmsMaintenance.fmsvehicle_id'] = $fmsvehicle_id;
        }
		$conditions['FmsMaintenance.status'] = 'posted';
		$this->FmsMaintenance->recursive = 2;
		$this->set('fms_maintenances', $this->FmsMaintenance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsMaintenance->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms maintenance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsMaintenance->recursive = 2;
		$this->set('fmsMaintenance', $this->FmsMaintenance->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FmsMaintenance->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['FmsMaintenance']['created_by'] = $user['Auth']['User']['id'];

			$this->data['FmsMaintenance']['status'] = 'created';
			if ($this->FmsMaintenance->save($this->data)) {
				$this->Session->setFlash(__('The maintenance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The maintenance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$fms_vehicles = $this->FmsMaintenance->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms maintenance', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsMaintenance->save($this->data)) {
				$this->Session->setFlash(__('The fms maintenance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms maintenance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_maintenance', $this->FmsMaintenance->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$fms_vehicles = $this->FmsMaintenance->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms maintenance', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsMaintenance->delete($i);
                }
				$this->Session->setFlash(__('Fms maintenance deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms maintenance was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsMaintenance->delete($id)) {
				$this->Session->setFlash(__('Fms maintenance deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms maintenance was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance data', true), '');
            $this->render('/elements/failure');
        }
		$this->FmsMaintenance->id = $id;
        if ($this->FmsMaintenance->saveField('status', 'posted')) {
            $this->Session->setFlash(__('maintenance data posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance data was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance data', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();
		$this->FmsMaintenance->read(null, $id);
		$this->FmsMaintenance->set('status', 'approved');
		$this->FmsMaintenance->set('approved_by', $user['Auth']['User']['id']);
        
        if ($this->FmsMaintenance->save()){
            $this->Session->setFlash(__('maintenance data successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance data was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for maintenance data', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
		$this->FmsMaintenance->read(null, $id);
		$this->FmsMaintenance->set('status', 'rejected');
		$this->FmsMaintenance->set('approved_by', $user['Auth']['User']['id']);
        if ($this->FmsMaintenance->save()) {
            $this->Session->setFlash(__('maintenance data successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('maintenance data was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function maintenance_cost_report($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
		
            $vehicle_id = $this->data['FmsVehicle']['vehicle'];				
			$fromdate = $this->data['FmsVehicle']['from'];
			$todate = $this->data['FmsVehicle']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			//$this->ImsRequisition->recursive =-1;			
			$conditions =array('FmsMaintenance.fms_vehicle_id' => $vehicle_id,'FmsMaintenance.created >=' => $fromdate, 'FmsMaintenance.created <' => $tomorrow);  						 
			$maintenances = $this->FmsMaintenance->find('all', array('conditions' => $conditions));
			
			$result = array();
			$count = 0;
			$totalprice = 0;			
			
			for($j=0; $j<count($maintenances ); $j++){						
				
					$result[$count][0] = $count + 1;
					$result[$count][1] = $maintenances[$j]['FmsMaintenance']['item'];
					$result[$count][2] = $maintenances[$j]['FmsMaintenance']['serial'];
					$result[$count][3] = $maintenances[$j]['FmsMaintenance']['measurement'];
					$result[$count][4] = $maintenances[$j]['FmsMaintenance']['quantity'];					
					$result[$count][5] = $maintenances[$j]['FmsMaintenance']['unit_price'];
					$result[$count][6] = $maintenances[$j]['FmsMaintenance']['quantity'] * $maintenances[$j]['FmsMaintenance']['unit_price'];
					$multiply =  $result[$count][5] * $result[$count][4];
					$totalprice = $totalprice + $multiply;
					$count++;
			}					
				
			if($totalprice != 0)
			{					
				$result[$count][5] = 'Grand Total';
				$result[$count][6] = number_format($totalprice,2,'.',',');
			}
			$vehicle = $this->FmsMaintenance->FmsVehicle->read(null, $vehicle_id);	
			
			$this->set('result',$result);
			$this->set('totalprice',$totalprice);	
			$this->set('vehicle',$vehicle['FmsVehicle']['plate_no']);
        }		
    }
}
?>