<?php
class PensionsController extends AppController {

	var $name = 'Pensions';
	
	function index() {
		$payrolls = $this->Pension->Payroll->find('all');
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
	
            $conditions['Pension.payroll_id'] = $this->Session->read('Auth.User.payroll_id');
        $conditions['Pension.status'] = 'active';
		
		$this->set('pensions', $this->Pension->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Pension->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pension', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Pension->recursive = 2;
		$this->set('pension', $this->Pension->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Pension->create();
			$this->autoRender = false;
			if ($this->Pension->save($this->data)) {
				$this->Session->setFlash(__('The pension has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The pension could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$payrolls = $this->Pension->Payroll->find('list');
		$this->set(compact('payrolls'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pension', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Pension->save($this->data)) {
				$this->Session->setFlash(__('The pension has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The pension could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('pension', $this->Pension->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$payrolls = $this->Pension->Payroll->find('list');
		$this->set(compact('payrolls'));
	}
	function remove($id = null) {
                 $this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid benefit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		
                        $this->data['Pension']['status']='removed';
                        $this->data['Pension']['id']=$id;
			if ($this->Pension->save($this->data)) {
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
			$this->Session->setFlash(__('Invalid id for pension', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Pension->delete($i);
                }
				$this->Session->setFlash(__('Pension deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Pension was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Pension->delete($id)) {
				$this->Session->setFlash(__('Pension deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Pension was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>