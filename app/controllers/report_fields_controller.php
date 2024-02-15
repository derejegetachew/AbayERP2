<?php
class ReportFieldsController extends AppController {

	var $name = 'ReportFields';
	
	function index() {
		$reports = $this->ReportField->Report->find('all');
		$this->set(compact('reports'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$report_id = (isset($_REQUEST['report_id'])) ? $_REQUEST['report_id'] : -1;
		if($id)
			$report_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($report_id != -1) {
            $conditions['ReportField.report_id'] = $report_id;
        }
		
		$this->set('report_fields', $this->ReportField->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ReportField->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid report field', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ReportField->recursive = 2;
		$this->set('reportField', $this->ReportField->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ReportField->create();
			$this->autoRender = false;
			if ($this->ReportField->save($this->data)) {
				$this->Session->setFlash(__('The report field has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The report field could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$reports = $this->ReportField->Report->find('list');
		$fields = $this->ReportField->Field->find('list');
		$this->set(compact('reports', 'fields'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid report field', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ReportField->save($this->data)) {
				$this->Session->setFlash(__('The report field has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The report field could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('report_field', $this->ReportField->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$reports = $this->ReportField->Report->find('list');
		$fields = $this->ReportField->Field->find('list');
		$this->set(compact('reports', 'fields'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for report field', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ReportField->delete($i);
                }
				$this->Session->setFlash(__('Report field deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Report field was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ReportField->delete($id)) {
				$this->Session->setFlash(__('Report field deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Report field was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>