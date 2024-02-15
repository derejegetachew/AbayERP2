<?php
class IbdBanksController extends AppController {

	var $name = 'IbdBanks';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_banks', $this->IbdBank->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdBank->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd bank', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdBank->recursive = 2;
		$this->set('ibd_Bank', $this->IbdBank->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->IbdBank->create();
			$this->autoRender = false;
			if ($this->IbdBank->save($this->data)) {
				$this->Session->setFlash(__('The ibd bank has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd bank could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd bank', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->IbdBank->save($this->data)) {
				$this->Session->setFlash(__('The ibd bank has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd bank could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_bank', $this->IbdBank->read(null, $id));
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd bank', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdBank->delete($i);
                }
				$this->Session->setFlash(__('Ibd bank deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd bank was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdBank->delete($id)) {
				$this->Session->setFlash(__('Ibd bank deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd bank was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>