<?php
class SpCatsController extends AppController {

	var $name = 'SpCats';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('spCats', $this->SpCat->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->SpCat->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp cat', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpCat->recursive = 2;
		$this->set('spCat', $this->SpCat->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->SpCat->create();
			$this->autoRender = false;
			if ($this->SpCat->save($this->data)) {
				$this->Session->setFlash(__('The sp cat has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp cat could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp cat', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->SpCat->save($this->data)) {
				$this->Session->setFlash(__('The sp cat has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp cat could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp__cat', $this->SpCat->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp cat', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpCat->delete($i);
                }
				$this->Session->setFlash(__('Sp cat deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp cat was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpCat->delete($id)) {
				$this->Session->setFlash(__('Sp cat deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp cat was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>