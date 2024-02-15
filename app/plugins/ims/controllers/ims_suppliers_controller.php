<?php
class ImsSuppliersController extends ImsAppController {

	var $name = 'ImsSuppliers';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('suppliers', $this->ImsSupplier->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSupplier->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid supplier', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsSupplier->recursive = 2;
		$this->set('supplier', $this->ImsSupplier->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsSupplier->create();
			$this->autoRender = false;
			if ($this->ImsSupplier->save($this->data)) {
				$this->Session->setFlash(__('The supplier has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The supplier could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid supplier', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsSupplier->save($this->data)) {
				$this->Session->setFlash(__('The supplier has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The supplier could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('supplier', $this->ImsSupplier->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		$this->loadModel('ImsGrn');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for supplier', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsGrn.ims_supplier_id'] = $i;
					if($this->ImsSupplier->ImsGrn->find('count', array('conditions' => $conditions)) == 0){  
							$this->ImsSupplier->delete($i);
					} else {
						$supplier = $this->ImsSupplier->read(null,$i);
						$msg .= $supplier['ImsSupplier']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('Suppliers deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have GRN(s), Following Suppliers were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('Suppliers was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsGrn.ims_supplier_id'] = $id;
			if($this->ImsSupplier->ImsGrn->find('count', array('conditions' => $conditions)) == 0){
				if ($this->ImsSupplier->delete($id)) {
					$this->Session->setFlash(__('Supplier deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Supplier was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('Supplier was not deleted because it has GRN(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
	}
}
?>