<?php
class MinerRulesController extends AppController {

	var $name = 'MinerRules';
	
	function index() {
		$mines = $this->MinerRule->Mine->find('all');
		$this->set(compact('mines'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$mine_id = (isset($_REQUEST['mine_id'])) ? $_REQUEST['mine_id'] : -1;
		if($id)
			$mine_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($mine_id != -1) {
            $conditions['MinerRule.mine_id'] = $mine_id;
        }
		
		$this->set('minerRules', $this->MinerRule->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->MinerRule->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid miner rule', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->MinerRule->recursive = 2;
		$this->set('minerRule', $this->MinerRule->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->MinerRule->create();
			$this->autoRender = false;
			if ($this->MinerRule->save($this->data)) {
				$this->Session->setFlash(__('The miner rule has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The miner rule could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$mines = $this->MinerRule->Mine->find('list');
		$this->set(compact('mines'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid miner rule', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->MinerRule->save($this->data)) {
				$this->Session->setFlash(__('The miner rule has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The miner rule could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('miner__rule', $this->MinerRule->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$mines = $this->MinerRule->Mine->find('list');
		$this->set(compact('mines'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for miner rule', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->MinerRule->delete($i);
                }
				$this->Session->setFlash(__('Miner rule deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Miner rule was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->MinerRule->delete($id)) {
				$this->Session->setFlash(__('Miner rule deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Miner rule was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>