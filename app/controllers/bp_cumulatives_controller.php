<?php
class BpCumulativesController extends AppController {

	var $name = 'BpCumulatives';
	
	function index() {
		$bp_items = $this->BpCumulative->BpItem->find('all');
		$this->set(compact('bp_items'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$bpitem_id = (isset($_REQUEST['bpitem_id'])) ? $_REQUEST['bpitem_id'] : -1;
		if($id)
			$bpitem_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($bpitem_id != -1) {
            $conditions['BpCumulative.bpitem_id'] = $bpitem_id;
        }
		
		$this->set('bpCumulatives', $this->BpCumulative->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpCumulative->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp cumulative', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpCumulative->recursive = 2;
		$this->set('bpCumulative', $this->BpCumulative->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpCumulative->create();
			$this->autoRender = false;
			if ($this->BpCumulative->save($this->data)) {
				$this->Session->setFlash(__('The bp cumulative has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp cumulative could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$bp_items = $this->BpCumulative->BpItem->find('list');
		$bp_months = $this->BpCumulative->BpMonth->find('list');
		$budget_years = $this->BpCumulative->BudgetYear->find('list');
		$this->set(compact('bp_items', 'bp_months', 'budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp cumulative', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpCumulative->save($this->data)) {
				$this->Session->setFlash(__('The bp cumulative has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp cumulative could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__cumulative', $this->BpCumulative->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$bp_items = $this->BpCumulative->BpItem->find('list');
		$bp_months = $this->BpCumulative->BpMonth->find('list');
		$budget_years = $this->BpCumulative->BudgetYear->find('list');
		$this->set(compact('bp_items', 'bp_months', 'budget_years'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp cumulative', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpCumulative->delete($i);
                }
				$this->Session->setFlash(__('Bp cumulative deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp cumulative was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpCumulative->delete($id)) {
				$this->Session->setFlash(__('Bp cumulative deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp cumulative was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>