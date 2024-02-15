<?php
class CompositionsController extends AppController {

	var $name = 'Compositions';
	
	function index() {
		$positions = $this->Composition->Position->find('all');
		$this->set(compact('positions'));
	}
	
	function index3() {
		$this->Composition->Branch->recursive=-1;
		$branches = $this->Composition->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['Composition.branch_id'] = $branch_id;
        }
		
		$compositions= $this->Composition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		$i=0;
		foreach($compositions as $comp){
			
			$cond['EmployeeDetail.position_id']=$comp['Composition']['position_id'];
			$cond['EmployeeDetail.branch_id']=$comp['Composition']['branch_id'];
			$cond['EmployeeDetail.end_date']='0000-00-00';
			$this->loadModel('EmployeeDetail');
			$this->EmployeeDetail->recursive=-1;
			$x=$this->EmployeeDetail->find('count', array('conditions' => $cond));
			$compositions[$i]['Composition']['hired']=$x;
			$i++;
		}
		$this->set('compositions',$compositions);
		$this->set('results', $this->Composition->find('count', array('conditions' => $conditions)));
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['Composition.branch_id'] = $branch_id;
        }
		
		//$compositions= $this->Composition->find('all', array('fields'=>array('DISTINCT Composition.branch_id'),'limit' => $limit, 'offset' => $start));
		$compositions= $this->Composition->find('all', array('conditions' => $conditions,'fields'=>array('*','SUM(Composition.count)'),'group'=>array('Composition.branch_id'),'limit' => $limit, 'offset' => $start));
		//print_r($compositions);
		$this->set('compositions',$compositions);
		$this->set('results', $this->Composition->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid composition', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Composition->recursive = 2;
		$this->set('composition', $this->Composition->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Composition->create();
			$this->autoRender = false;
			if ($this->Composition->save($this->data)) {
				$this->Session->setFlash(__('The job plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The job plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
      $conditions['Position.status'] = "active";
		$positions = $this->Composition->Position->find('list',array('conditions' => $conditions,'order' => 'name'));
		$branches = $this->Composition->Branch->find('list');
		$this->set(compact('positions', 'branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid composition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Composition->save($this->data)) {
				$this->Session->setFlash(__('The job plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The job plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('composition', $this->Composition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$positions = $this->Composition->Position->find('list');
		$branches = $this->Composition->Branch->find('list');
		$this->set(compact('positions', 'branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for composition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Composition->delete($i);
                }
				$this->Session->setFlash(__('job plan deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('job plan was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Composition->delete($id)) {
				$this->Session->setFlash(__('job plan deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('job plan was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>