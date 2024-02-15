<?php
class BudgetYearsController extends AppController {

	var $name = 'BudgetYears';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('budget_years', $this->BudgetYear->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BudgetYear->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid budget year', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BudgetYear->recursive = 2;
		$this->set('budgetYear', $this->BudgetYear->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BudgetYear->create();
			$this->autoRender = false;
			if ($this->BudgetYear->save($this->data)) {
				$this->Session->setFlash(__('The budget year has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The budget year could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid budget year', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BudgetYear->save($this->data)) {
				$this->Session->setFlash(__('The budget year has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The budget year could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('budget__year', $this->BudgetYear->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for budget year', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BudgetYear->delete($i);
                }
				$this->Session->setFlash(__('Budget year deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Budget year was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BudgetYear->delete($id)) {
				$this->Session->setFlash(__('Budget year deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Budget year was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>