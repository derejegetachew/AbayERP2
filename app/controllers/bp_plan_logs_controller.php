<?php
class BpPlanLogsController extends AppController {

	var $name = 'BpPlanLogs';
	
	function index() {
		$bp_plans = $this->BpPlanLog->BpPlan->find('all');
		$this->set(compact('bp_plans'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$bpplan_id = (isset($_REQUEST['bpplan_id'])) ? $_REQUEST['bpplan_id'] : -1;
		if($id)
			$bpplan_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($bpplan_id != -1) {
            $conditions['BpPlanLog.bpplan_id'] = $bpplan_id;
        }
		
		$this->set('bpPlanLogs', $this->BpPlanLog->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlanLog->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp plan log', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpPlanLog->recursive = 2;
		$this->set('bpPlanLog', $this->BpPlanLog->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpPlanLog->create();
			$this->autoRender = false;
			if ($this->BpPlanLog->save($this->data)) {
				$this->Session->setFlash(__('The bp plan log has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp plan log could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$bp_plans = $this->BpPlanLog->BpPlan->find('list');
		$users = $this->BpPlanLog->User->find('list');
		$this->set(compact('bp_plans', 'users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp plan log', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpPlanLog->save($this->data)) {
				$this->Session->setFlash(__('The bp plan log has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp plan log could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__plan__log', $this->BpPlanLog->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$bp_plans = $this->BpPlanLog->BpPlan->find('list');
		$users = $this->BpPlanLog->User->find('list');
		$this->set(compact('bp_plans', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp plan log', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpPlanLog->delete($i);
                }
				$this->Session->setFlash(__('Bp plan log deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp plan log was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpPlanLog->delete($id)) {
				$this->Session->setFlash(__('Bp plan log deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp plan log was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>