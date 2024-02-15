<?php
class DisciplinaryRecordsController extends AppController {

	var $name = 'DisciplinaryRecords';
	
	function index() {
		$employees = $this->DisciplinaryRecord->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['DisciplinaryRecord.employee_id'] = $employee_id;
        }
		
		$this->set('disciplinary_records', $this->DisciplinaryRecord->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->DisciplinaryRecord->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid disciplinary record', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DisciplinaryRecord->recursive = 2;
		$this->set('disciplinaryRecord', $this->DisciplinaryRecord->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->DisciplinaryRecord->create();
			$this->autoRender = false;
			if ($this->DisciplinaryRecord->save($this->data)) {
				$this->Session->setFlash(__('The disciplinary record has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The disciplinary record could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->DisciplinaryRecord->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid disciplinary record', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DisciplinaryRecord->save($this->data)) {
				$this->Session->setFlash(__('The disciplinary record has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The disciplinary record could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('disciplinary_record', $this->DisciplinaryRecord->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->DisciplinaryRecord->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for disciplinary record', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DisciplinaryRecord->delete($i);
                }
				$this->Session->setFlash(__('Disciplinary record deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Disciplinary record was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DisciplinaryRecord->delete($id)) {
				$this->Session->setFlash(__('Disciplinary record deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Disciplinary record was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>