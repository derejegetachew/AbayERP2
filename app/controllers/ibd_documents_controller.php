<?php
class IbdDocumentsController extends AppController {

	var $name = 'IbdDocuments';
	
	function index() {
	}
	
	function index1() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		

        eval("\$conditions = array( " . $conditions . " );");
		$conditions['doc_type']='Import';
		$this->set('ibd_documents', $this->IbdDocument->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdDocument->find('count', array('conditions' => $conditions)));
	}
	
	function list_data1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		

        eval("\$conditions = array( " . $conditions . " );");
		$conditions['doc_type']='Export';
		$this->set('ibd_documents', $this->IbdDocument->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdDocument->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd document', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdDocument->recursive = 2;
		$this->set('ibdDocument', $this->IbdDocument->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->IbdDocument->create();
			$this->autoRender = false;
			if ($this->IbdDocument->save($this->data)) {
				$this->Session->setFlash(__('The ibd document has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd document could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd document', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->IbdDocument->save($this->data)) {
				$this->Session->setFlash(__('The ibd document has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd document could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd_document', $this->IbdDocument->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd document', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdDocument->delete($i);
                }
				$this->Session->setFlash(__('Ibd document deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd document was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdDocument->delete($id)) {
				$this->Session->setFlash(__('Ibd document deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd document was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>