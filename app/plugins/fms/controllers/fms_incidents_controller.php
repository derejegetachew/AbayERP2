<?php
class FmsIncidentsController extends AppController {

	var $name = 'FmsIncidents';
	
	function index() {
		$fms_vehicles = $this->FmsIncident->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
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
            $conditions['FmsIncident.fmsvehicle_id'] = $fmsvehicle_id;
        }
		$this->FmsIncident->recursive = 2;
		
		$this->set('fms_incidents', $this->FmsIncident->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FmsIncident->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fms incident', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FmsIncident->recursive = 2;
		$this->set('fmsIncident', $this->FmsIncident->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['FmsIncident']['occurrence_place']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			// double quotes
            $content = ereg_replace('"','&quot;',$content);
			// slash
            $content = ereg_replace("/", '&#47;',$content);
			// back slash
            $content = ereg_replace('\\\\', '&#92;',$content);
			$this->data['FmsIncident']['occurrence_place'] = $content;
			
			// Strip out carriage returns
            $details = ereg_replace("\r",'',$this->data['FmsIncident']['details']);
            // Handle paragraphs
            $details = ereg_replace("\n\n",'<br /><br />',$details);
            // Handle line breaks
            $details = ereg_replace("\n",'<br />',$details);
            // Handle apostrophes
            $details = ereg_replace("'",'&apos;',$details);
			// double quotes
            $details = ereg_replace('"','&quot;',$details);
			// slash
            $details = ereg_replace("/", '&#47;',$details);
			// back slash
            $details = ereg_replace('\\\\', '&#92;',$details);
			$this->data['FmsIncident']['details'] = $details;
			
			// Strip out carriage returns
            $action_taken = ereg_replace("\r",'',$this->data['FmsIncident']['action_taken']);
            // Handle paragraphs
            $action_taken = ereg_replace("\n\n",'<br /><br />',$action_taken);
            // Handle line breaks
            $action_taken = ereg_replace("\n",'<br />',$action_taken);
            // Handle apostrophes
            $action_taken = ereg_replace("'",'&apos;',$action_taken);
			// double quotes
            $action_taken = ereg_replace('"','&quot;',$action_taken);
			// slash
            $action_taken = ereg_replace("/", '&#47;',$action_taken);
			// back slash
            $action_taken = ereg_replace('\\\\', '&#92;',$action_taken);
			$this->data['FmsIncident']['action_taken'] = $action_taken;
			
			$this->FmsIncident->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['FmsIncident']['created_by'] = $user['Auth']['User']['id'];
			if ($this->FmsIncident->save($this->data)) {
				$this->Session->setFlash(__('The fms incident has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms incident could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$fms_vehicles = $this->FmsIncident->FmsVehicle->find('all');
		$this->set(compact('fms_vehicles'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fms incident', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FmsIncident->save($this->data)) {
				$this->Session->setFlash(__('The fms incident has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fms incident could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fms__incident', $this->FmsIncident->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$fms_vehicles = $this->FmsIncident->FmsVehicle->find('list');
		$this->set(compact('fms_vehicles'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fms incident', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FmsIncident->delete($i);
                }
				$this->Session->setFlash(__('Fms incident deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fms incident was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FmsIncident->delete($id)) {
				$this->Session->setFlash(__('Fms incident deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fms incident was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>