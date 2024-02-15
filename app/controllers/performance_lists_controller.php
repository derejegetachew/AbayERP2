<?php
class PerformanceListsController extends AppController {

	var $name = 'PerformanceLists';
	
	function index() {
		$performances = $this->PerformanceList->Performance->find('all');
		$this->set(compact('performances'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$performance_id = (isset($_REQUEST['performance_id'])) ? $_REQUEST['performance_id'] : -1;
		if($id)
			$performance_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($performance_id != -1) {
            $conditions['PerformanceList.performance_id'] = $performance_id;
        }
		
		$this->set('performance_lists', $this->PerformanceList->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PerformanceList->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance list', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PerformanceList->recursive = 2;
		$this->set('performanceList', $this->PerformanceList->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->PerformanceList->create();
			$this->autoRender = false;
			if ($this->PerformanceList->save($this->data)) {
				$this->Session->setFlash(__('The performance list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$performances = $this->PerformanceList->Performance->find('list');
		$this->set(compact('performances'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance list', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->PerformanceList->save($this->data)) {
				$this->Session->setFlash(__('The performance list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('performance__list', $this->PerformanceList->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$performances = $this->PerformanceList->Performance->find('list');
		$this->set(compact('performances'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance list', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PerformanceList->delete($i);
                }
				$this->Session->setFlash(__('Performance list deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance list was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PerformanceList->delete($id)) {
				$this->Session->setFlash(__('Performance list deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance list was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>