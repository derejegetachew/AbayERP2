<?php
class CelebrationDaysController extends AppController {

	var $name = 'CelebrationDays';
	
	function index() {
		$budget_years = $this->CelebrationDay->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($budgetyear_id != -1) {
            $conditions['CelebrationDay.budget_year_id'] = $budgetyear_id;
        }
		
		$this->set('celebration_days', $this->CelebrationDay->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CelebrationDay->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid celebration day', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CelebrationDay->recursive = 2;
		$this->set('celebrationDay', $this->CelebrationDay->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->CelebrationDay->create();
			$this->autoRender = false;
			if ($this->CelebrationDay->save($this->data)) {
				$this->Session->setFlash(__('The celebration day has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The celebration day could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$budget_years = $this->CelebrationDay->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid celebration day', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CelebrationDay->save($this->data)) {
				$this->Session->setFlash(__('The celebration day has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The celebration day could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('celebration__day', $this->CelebrationDay->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->CelebrationDay->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for celebration day', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CelebrationDay->delete($i);
                }
				$this->Session->setFlash(__('Celebration day deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Celebration day was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CelebrationDay->delete($id)) {
				$this->Session->setFlash(__('Celebration day deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Celebration day was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>