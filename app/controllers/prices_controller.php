<?php
class PricesController extends AppController {

	var $name = 'Prices';
	
	function index() {
		$payrolls = $this->Price->Payroll->find('all');
		$this->set(compact('payrolls'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$payroll_id = (isset($_REQUEST['payroll_id'])) ? $_REQUEST['payroll_id'] : -1;
		if($id)
			$payroll_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($payroll_id != -1) {
            $conditions['Price.payroll_id'] = $payroll_id;
        }
		$conditions['Price.status'] = 'active';
		$this->set('prices', $this->Price->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Price->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid price', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Price->recursive = 2;
		$this->set('price', $this->Price->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Price->create();
			$this->autoRender = false;
			if ($this->Price->save($this->data)) {
				$this->Session->setFlash(__('The price has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payrolls = $this->Price->Payroll->find('list');
		$this->set(compact('payrolls'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid price', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Price->save($this->data)) {
				$this->Session->setFlash(__('The price has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('price', $this->Price->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payrolls = $this->Price->Payroll->find('list');
		$this->set(compact('payrolls'));
	}
	function remove($id = null) {
                 $this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid benefit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
                        $this->data['Price']['status']='removed';
                        $this->data['Price']['id']=$id;
			if ($this->Price->save($this->data)) {
				$this->Session->setFlash(__('The benefit has been removed', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The benefit could not be removed. Please, try again.', true), '');
				$this->render('/elements/failure');
			}

	}
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for price', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Price->delete($i);
                }
				$this->Session->setFlash(__('Price deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Price was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Price->delete($id)) {
				$this->Session->setFlash(__('Price deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Price was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>