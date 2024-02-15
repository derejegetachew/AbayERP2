<?php
class TaxRulesController extends AppController {

	var $name = 'TaxRules';
	
	function index() {
		$payrolls = $this->TaxRule->Payroll->find('all');
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
	
            $conditions['TaxRule.payroll_id'] = $this->Session->read('Auth.User.payroll_id');
        $conditions['TaxRule.status'] = 'active';
		
		$this->set('tax_rules', $this->TaxRule->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->TaxRule->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tax rule', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->TaxRule->recursive = 2;
		$this->set('taxRule', $this->TaxRule->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->TaxRule->create();
			$this->autoRender = false;
			if ($this->TaxRule->save($this->data)) {
				$this->Session->setFlash(__('The tax rule has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The tax rule could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payrolls = $this->TaxRule->Payroll->find('list');
		$this->set(compact('payrolls'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tax rule', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->TaxRule->save($this->data)) {
				$this->Session->setFlash(__('The tax rule has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The tax rule could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('tax_rule', $this->TaxRule->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payrolls = $this->TaxRule->Payroll->find('list');
		$this->set(compact('payrolls'));
	}
	function remove($id = null) {
                 $this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid benefit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
                        $this->data['TaxRule']['status']='removed';
                        $this->data['TaxRule']['id']=$id;
			if ($this->TaxRule->save($this->data)) {
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
			$this->Session->setFlash(__('Invalid id for tax rule', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->TaxRule->delete($i);
                }
				$this->Session->setFlash(__('Tax rule deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Tax rule was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->TaxRule->delete($id)) {
				$this->Session->setFlash(__('Tax rule deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Tax rule was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>