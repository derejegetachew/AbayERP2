<?php
class FmsFuelsController extends FmsAppController {

	var $name = 'FmsFuels';
	
	function index() {
		$fms_vehicles = $this->FmsFuel->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}
	
	function index_2() {
		$fms_vehicles = $this->FmsFuel->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_fuel_report(){
		$this->FmsFuel->FmsVehicle->recursive =-1;			
		$vehicles = $this->FmsFuel->FmsVehicle->find('all');
		
	    $this->set(compact('vehicles'));
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
            $conditions['FmsFuel.fms_vehicle_id'] = $fmsvehicle_id;
        }
		$this->FmsFuel->recursive = 2;
		$this->set('fms_fuels', $this->FmsFuel->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsFuel->find('count', array('conditions' => $conditions)));
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
            $conditions['FmsFuel.fms_vehicle_id'] = $fmsvehicle_id;
        }
		//$conditions['FmsFuel.status <>'] = 'created';
		$this->FmsFuel->recursive = 2;
		$this->set('fms_fuels', $this->FmsFuel->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsFuel->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fuel', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsFuel->recursive = 2;
		$this->set('fmsFuel', $this->FmsFuel->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FmsFuel->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['FmsFuel']['created_by'] = $user['Auth']['User']['id'];

			$this->data['FmsFuel']['status'] = 'created';
			if ($this->FmsFuel->save($this->data)) {
				$this->Session->setFlash(__('The fuel has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fuel could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$fms_vehicles = $this->FmsFuel->FmsVehicle->find('all');
		$this->loadModel('FmsDriver');
		$this->FmsDriver->recursive = 0;
		$fms_drivers = $this->FmsDriver->find('all');
		$this->set(compact('fms_vehicles','fms_drivers'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fuel', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsFuel->save($this->data)) {
				$this->Session->setFlash(__('The fuel has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fuel could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_fuel', $this->FmsFuel->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$fms_vehicles = $this->FmsFuel->FmsVehicle->find('all');
		$this->loadModel('FmsDriver');
		$this->FmsDriver->recursive = 0;
		$fms_drivers = $this->FmsDriver->find('all');
		$this->set(compact('fms_vehicles','fms_drivers'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fuel', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsFuel->delete($i);
                }
				$this->Session->setFlash(__('fuel deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('fuel was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsFuel->delete($id)) {
				$this->Session->setFlash(__('fuel deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('fuel was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for fuel data', true), '');
            $this->render('/elements/failure');
        }
		$this->FmsFuel->id = $id;
        if ($this->FmsFuel->saveField('status', 'posted')) {
            $this->Session->setFlash(__('fuel data posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('fuel data was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Fuel data', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();
		$this->FmsFuel->read(null, $id);
		$this->FmsFuel->set('status', 'approved');
		$this->FmsFuel->set('approved_by', $user['Auth']['User']['id']);
        
        if ($this->FmsFuel->save()){
            $this->Session->setFlash(__('Fuel data successfully approved', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Fuel data was not approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for fuel data', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
		$this->FmsFuel->read(null, $id);
		$this->FmsFuel->set('status', 'rejected');
		$this->FmsFuel->set('approved_by', $user['Auth']['User']['id']);
        if ($this->FmsFuel->save()) {
            $this->Session->setFlash(__('Fuel data successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Fuel data was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function fuel_report(){
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
			$vehicle_id = $this->data['FmsFuel']['vehicle'];
            $fromdate = $this->data['FmsFuel']['from'];
			$todate = $this->data['FmsFuel']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));			
			
			$this->FmsFuel->FmsVehicle->recursive = 1;	
			$vehicle = $this->FmsFuel->FmsVehicle->read(null,$vehicle_id);	
			
			$this->FmsFuel->recursive = 1;	
			$conditions =array('FmsFuel.fms_vehicle_id' => $vehicle_id,'FmsFuel.fueled_day >=' => $fromdate,'FmsFuel.fueled_day <=' => $todate, 'FmsFuel.status' => 'approved');
			$fuels = $this->FmsFuel->find('all', array('conditions' => $conditions));
			
			$result = array();
			$count = 0;
			foreach($fuels as $fuel){
				$result[$count][1] = $fuel['FmsFuel']['fueled_day'];
				$result[$count][2] = $fuel['FmsFuel']['price'];
				$result[$count][3] = $fuel['FmsFuel']['litre'];
				$result[$count][4] = $fuel['FmsFuel']['litre'] * $fuel['FmsFuel']['price'];
				$result[$count][5] = $fuel['FmsFuel']['kilometer'];
				$result[$count][6] = '';
				$result[$count][7] = '';
				$result[$count][8] = $fuel['FmsFuel']['driver'];
				$count++;
			}
			$this->set('result',$result);
			$this->set('vehicle',$vehicle);
		}
	}
}
?>