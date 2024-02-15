<?php
class PerformanceListChoicesController extends AppController {

	var $name = 'PerformanceListChoices';
	
	function index() {
		$performance_lists = $this->PerformanceListChoice->PerformanceList->find('all');
		$this->set(compact('performance_lists'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$performancelist_id = (isset($_REQUEST['performancelist_id'])) ? $_REQUEST['performancelist_id'] : -1;
		if($id)
			$performancelist_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($performancelist_id != -1) {
            $conditions['PerformanceListChoice.performance_list_id'] = $performancelist_id;
        }
		
		$this->set('performance_list_choices', $this->PerformanceListChoice->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->PerformanceListChoice->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid performance list choice', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->PerformanceListChoice->recursive = 2;
		$this->set('performanceListChoice', $this->PerformanceListChoice->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->PerformanceListChoice->create();
			$this->autoRender = false;
			if ($this->PerformanceListChoice->save($this->data)) {
				$this->Session->setFlash(__('The performance list choice has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance list choice could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$performance_lists = $this->PerformanceListChoice->PerformanceList->find('list');
		$this->set(compact('performance_lists'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid performance list choice', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->PerformanceListChoice->save($this->data)) {
				$this->Session->setFlash(__('The performance list choice has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The performance list choice could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('performance__list__choice', $this->PerformanceListChoice->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$performance_lists = $this->PerformanceListChoice->PerformanceList->find('list');
		$this->set(compact('performance_lists'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for performance list choice', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->PerformanceListChoice->delete($i);
                }
				$this->Session->setFlash(__('Performance list choice deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Performance list choice was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->PerformanceListChoice->delete($id)) {
				$this->Session->setFlash(__('Performance list choice deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Performance list choice was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>