<?php
class SpRegionsController extends AppController {

	var $name = 'SpRegions';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('spRegions', $this->SpRegion->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->SpRegion->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp region', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpRegion->recursive = 2;
		$this->set('spRegion', $this->SpRegion->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->SpRegion->create();
			$this->autoRender = false;
			if ($this->SpRegion->save($this->data)) {
				$this->Session->setFlash(__('The sp region has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp region could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp region', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->SpRegion->save($this->data)) {
				$this->Session->setFlash(__('The sp region has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp region could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp__region', $this->SpRegion->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp region', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpRegion->delete($i);
                }
				$this->Session->setFlash(__('Sp region deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp region was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpRegion->delete($id)) {
				$this->Session->setFlash(__('Sp region deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp region was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>