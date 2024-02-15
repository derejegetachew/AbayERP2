<?php
class FmsVehiclesController extends AppController {

	var $name = 'FmsVehicles';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$this->FmsVehicle->CreatedUser->unbindModel(array('belongsTo' => array('Branch','Payroll','Employee','Group'),'hasMany' => array()));
		$this->FmsVehicle->recursive = 2;
		$this->set('fms_vehicles', $this->FmsVehicle->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsVehicle->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms vehicle', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsVehicle->recursive = 2;
		$this->set('fmsVehicle', $this->FmsVehicle->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FmsVehicle->create();
			$this->autoRender = false;
			$user = $this->Session->read();
			$this->data['FmsVehicle']['created_by'] = $user['Auth']['User']['id'];
			if ($this->FmsVehicle->save($this->data)) {
				$this->Session->setFlash(__('The vehicle has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid vehicle', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsVehicle->save($this->data)) {
				$this->Session->setFlash(__('The vehicle has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms_vehicle', $this->FmsVehicle->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms vehicle', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsVehicle->delete($i);
                }
				$this->Session->setFlash(__('Fms vehicle deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms vehicle was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsVehicle->delete($id)) {
				$this->Session->setFlash(__('Fms vehicle deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms vehicle was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>