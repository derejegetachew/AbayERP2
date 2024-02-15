<?php
class DmsSharesController extends AppController {

	var $name = 'DmsShares';
	
	function index() {
		//$dms_documents = $this->DmsShare->DmsDocument->find('all');
		//$this->set(compact('dms_documents'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$dmsdocument_id = (isset($_REQUEST['dmsdocument_id'])) ? $_REQUEST['dmsdocument_id'] : -1;
		if($id)
			$dmsdocument_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($dmsdocument_id != -1) {
            $conditions['DmsShare.dmsdocument_id'] = $dmsdocument_id;
        }
		
		$this->set('dmsShares', $this->DmsShare->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->DmsShare->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms share', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsShare->recursive = 2;
		$this->set('dmsShare', $this->DmsShare->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->DmsShare->create();
			$this->autoRender = false;
			if ($this->DmsShare->save($this->data)) {
				$this->Session->setFlash(__('The dms share has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms share could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$dms_documents = $this->DmsShare->DmsDocument->find('list');
		$branches = $this->DmsShare->Branch->find('list');
		$users = $this->DmsShare->User->find('list');
		$this->set(compact('dms_documents', 'branches', 'users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms share', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DmsShare->save($this->data)) {
				$this->Session->setFlash(__('The dms share has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms share could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('dms__share', $this->DmsShare->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$dms_documents = $this->DmsShare->DmsDocument->find('list');
		$branches = $this->DmsShare->Branch->find('list');
		$users = $this->DmsShare->User->find('list');
		$this->set(compact('dms_documents', 'branches', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms share', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DmsShare->delete($i);
                }
				$this->Session->setFlash(__('Dms share deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms share was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DmsShare->delete($id)) {
				$this->Session->setFlash(__('Dms share deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms share was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>