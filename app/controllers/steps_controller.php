<?php
class StepsController extends AppController {

	var $name = 'Steps';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('steps', $this->Step->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Step->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid step', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Step->recursive = 2;
		$this->set('step', $this->Step->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Step->create();
			$this->autoRender = false;
			if ($this->Step->save($this->data)) {
				$this->Session->setFlash(__('The step has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The step could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid step', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Step->save($this->data)) {
				$this->Session->setFlash(__('The step has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The step could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('step', $this->Step->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for step', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Step->delete($i);
                }
				$this->Session->setFlash(__('Step deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Step was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Step->delete($id)) {
				$this->Session->setFlash(__('Step deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Step was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>