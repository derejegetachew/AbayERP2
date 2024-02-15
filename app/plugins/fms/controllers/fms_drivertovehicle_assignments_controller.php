<?php
class FmsDrivertovehicleAssignmentsController extends AppController {

	var $name = 'FmsDrivertovehicleAssignments';
	
	function index() {
		$this->FmsDrivertovehicleAssignment->FmsDriver->recursive = 0;
		$fms_drivers = $this->FmsDrivertovehicleAssignment->FmsDriver->find('all');
		$this->set(compact('fms_drivers'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$fmsdriver_id = (isset($_REQUEST['fmsdriver_id'])) ? $_REQUEST['fmsdriver_id'] : -1;
		if($id)
			$fmsdriver_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($fmsdriver_id != -1) {
            $conditions['FmsDrivertovehicleAssignment.fms_driver_id'] = $fmsdriver_id;
        }
		$this->FmsDrivertovehicleAssignment->recursive = 2;
		$this->set('fms_drivertovehicle_assignments', $this->FmsDrivertovehicleAssignment->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsDrivertovehicleAssignment->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms drivertovehicle assignment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsDrivertovehicleAssignment->recursive = 2;
		$this->set('fmsDrivertovehicleAssignment', $this->FmsDrivertovehicleAssignment->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) { 
			$conditions =array('FmsDrivertovehicleAssignment.fms_vehicle_id' => $this->data['FmsDrivertovehicleAssignment']['fms_vehicle_id'], 'FmsDrivertovehicleAssignment.end_date' => '0000-00-00');  			
			$assignment = $this->FmsDrivertovehicleAssignment->find('all', array('conditions' => $conditions));
			$conditions1 =array('FmsDrivertovehicleAssignment.fms_driver_id' => $this->data['FmsDrivertovehicleAssignment']['fms_driver_id'], 'FmsDrivertovehicleAssignment.end_date' => '0000-00-00');  			
			$assignment1 = $this->FmsDrivertovehicleAssignment->find('all', array('conditions' => $conditions1));
			$conditions2 =array('FmsDrivertovehicleAssignment.fms_vehicle_id' => $this->data['FmsDrivertovehicleAssignment']['fms_vehicle_id'], 'FmsDrivertovehicleAssignment.end_date <=' => date("Y-m-d"));  			
			$assignment2 = $this->FmsDrivertovehicleAssignment->find('all', array('conditions' => $conditions2));
			$conditions3 =array('FmsDrivertovehicleAssignment.fms_driver_id' => $this->data['FmsDrivertovehicleAssignment']['fms_driver_id'], 'FmsDrivertovehicleAssignment.end_date' => date("Y-m-d"));  			
			$assignment3 = $this->FmsDrivertovehicleAssignment->find('all', array('conditions' => $conditions3));
		    if(count($assignment) > 0 or count($assignment1) > 0 or count($assignment2) > 0 or count($assignment3) > 0){
				$this->Session->setFlash(__('The vehicle was assigned. please end that assignment first.', true), '');
				$this->render('/elements/failure');
			}
			else {
				$this->FmsDrivertovehicleAssignment->create();
				$this->autoRender = false;
				$user = $this->Session->read();
				$this->data['FmsDrivertovehicleAssignment']['created_by'] = $user['Auth']['User']['id'];
				if ($this->FmsDrivertovehicleAssignment->save($this->data)) {
					$this->Session->setFlash(__('The driver to vehicle assignment has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The driver to vehicle assignment could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$this->FmsDrivertovehicleAssignment->FmsDriver->recursive = 0;
		$fms_drivers = $this->FmsDrivertovehicleAssignment->FmsDriver->find('all');
		$fms_vehicles = $this->FmsDrivertovehicleAssignment->FmsVehicle->find('all');
		$this->set(compact('fms_drivers', 'fms_vehicles'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid driver to vehicle assignment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsDrivertovehicleAssignment->save($this->data)) {
				$this->Session->setFlash(__('The driver to vehicle assignment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The driver to vehicle assignment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->FmsDrivertovehicleAssignment->recursive = 2;
		$this->set('fms_drivertovehicle_assignment', $this->FmsDrivertovehicleAssignment->read(null, $id));
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}		
			
		$fms_drivers = $this->FmsDrivertovehicleAssignment->FmsDriver->find('list');
		$fms_vehicles = $this->FmsDrivertovehicleAssignment->FmsVehicle->find('list');
		$this->set(compact('fms_drivers', 'fms_vehicles'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms drivertovehicle assignment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsDrivertovehicleAssignment->delete($i);
                }
				$this->Session->setFlash(__('Fms drivertovehicle assignment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms drivertovehicle assignment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsDrivertovehicleAssignment->delete($id)) {
				$this->Session->setFlash(__('Fms drivertovehicle assignment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms drivertovehicle assignment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>