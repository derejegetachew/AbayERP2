<?php
class BpMonthsController extends AppController {

	var $name = 'BpMonths';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('bpMonths', $this->BpMonth->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpMonth->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp month', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpMonth->recursive = 2;
		$this->set('bpMonth', $this->BpMonth->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpMonth->create();
			$this->autoRender = false;
			if ($this->BpMonth->save($this->data)) {
				$this->Session->setFlash(__('The bp month has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp month could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp month', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpMonth->save($this->data)) {
				$this->Session->setFlash(__('The bp month has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp month could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__month', $this->BpMonth->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp month', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpMonth->delete($i);
                }
				$this->Session->setFlash(__('Bp month deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp month was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpMonth->delete($id)) {
				$this->Session->setFlash(__('Bp month deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp month was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>