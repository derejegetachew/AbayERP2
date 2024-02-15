<?php
class PerformancesController extends AppController {

	var $name = 'Performances';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('performances', $this->Performance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Performance->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Performance->recursive = 2;
		$this->set('performance', $this->Performance->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Performance->create();
			$this->autoRender = false;
			if ($this->Performance->save($this->data)) {
				$this->Session->setFlash(__('The performance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$employees = $this->Performance->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Performance->save($this->data)) {
				$this->Session->setFlash(__('The performance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('performance', $this->Performance->read(null, $id));
		
			
		$employees = $this->Performance->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Performance->delete($i);
                }
				$this->Session->setFlash(__('Performance deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Performance->delete($id)) {
				$this->Session->setFlash(__('Performance deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>