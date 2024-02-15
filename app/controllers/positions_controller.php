<?php
class PositionsController extends AppController {

	var $name = 'Positions';
	
	function index() {
		$grades = $this->Position->Grade->find('all');
		$this->set(compact('grades'));
	}
	function index3() {
		$grades = $this->Position->Grade->find('all');
		$this->set(compact('grades'));
	}
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		$grade_id = (isset($_REQUEST['grade_id'])) ? $_REQUEST['grade_id'] : -1;
		if($id)
			$grade_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grade_id != -1) {
            $conditions['Position.grade_id'] = $grade_id;
        }
		$positions=$this->Position->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		$this->loadModel('User');
		$this->User->recursive=-1;
		$this->loadModel('Person');
		$this->Person->recursive=-1;
		$i=0;
		foreach($positions as $pos){	
			//echo $pos['Position']['updated_by'].'xx';			
			$upby=(int)$pos['Position']['updated_by'];
			if($upby==0)
				$upby='xx';
			
			unset($xx);unset($yy);$xx=array();$yy=array();
			$xx = $this->User->read(null, $upby);
			if(!empty($xx)){
			$yy= $this->Person->read(null, $xx['User']['person_id']);
			$positions[$i]['Position']['updated_by']=$yy['Person']['first_name'].' '.$yy['Person']['middle_name'];
			}
			
			$apby=(int)$pos['Position']['approved_by'];
			if($apby==0)
				$apby='xx';
			unset($xx);unset($yy);$xx=array();$yy=array();
			$xx= $this->User->read(null, $apby);
			if(!empty($xx)){
			$yy= $this->Person->read(null, $xx['User']['person_id']);
			$positions[$i]['Position']['approved_by']=$yy['Person']['first_name'].' '.$yy['Person']['middle_name'];
			}
			$i++;
		}
		//print_r($positions);
		$this->set('positions', $positions);
		$this->set('results', $this->Position->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid position', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Position->recursive = 2;
		$this->set('position', $this->Position->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Position->create();
			$this->autoRender = false;
			$this->data['Position']['updated_by']=$this->Session->read('Auth.User.id');
      $this->data['Position']['status']='active';
			if ($this->Position->save($this->data)) {
				$this->Session->setFlash(__('The position has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$grades = $this->Position->Grade->find('list');
		$this->set(compact('grades'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid position', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if($this->data['Position']['status']=='approved'){
				$this->Session->setFlash(__('The position could not be saved. its already approved.', true), '');
				$this->render('/elements/failure');
			}else{
			$this->data['Position']['updated_by']=$this->Session->read('Auth.User.id');
			if ($this->Position->save($this->data)) {
				$this->Session->setFlash(__('The position has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			}
		}
		$this->set('position', $this->Position->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$grades = $this->Position->Grade->find('list');
		$this->set(compact('grades'));
	}

	function approve($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for position', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
				$this->data['Position']['id']=$i;
				$this->data['Position']['approved_by']=$this->Session->read('Auth.User.id');
				$this->data['Position']['status']="approved";
                 $this->Position->save($this->data);
                }
				$this->Session->setFlash(__('Position approved', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Position was not approved', true), '');
				$this->render('/elements/failure');
            }
        } else {
				$this->data['Position']['id']=$id;
				$this->data['Position']['approved_by']=$this->Session->read('Auth.User.id');
				$this->data['Position']['status']="approved";
            if ($this->Position->save($this->data)) {
				$this->Session->setFlash(__('Position approved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Position was not approved', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	function unlock($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for position', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
				$this->data['Position']['id']=$i;
				$this->data['Position']['approved_by']=$this->Session->read('Auth.User.id');
				$this->data['Position']['status']="";
                 $this->Position->save($this->data);
                }
				$this->Session->setFlash(__('Position unlocked', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Position was not unlocked', true), '');
				$this->render('/elements/failure');
            }
        } else {
				$this->data['Position']['id']=$id;
				$this->data['Position']['approved_by']=$this->Session->read('Auth.User.id');
				$this->data['Position']['status']="";
            if ($this->Position->save($this->data)) {
				$this->Session->setFlash(__('Position unlocked', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Position was not unlocked', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	function delete($id = null) {
	$this->Position->recursive = 0;
	
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for position', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
				$xx= $this->Position->read(null, $id);
				if($xx['Position']['status']!='approved')
                    $this->Position->delete($i);
                }
				$this->Session->setFlash(__('Position deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Position was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$xx= $this->Position->read(null, $id);
			if($xx['Position']['status']=='approved'){
				$this->Session->setFlash(__('Position can not be deleted', true), '');
				$this->render('/elements/failure');
			}else{
            if ($this->Position->delete($id)) {
				$this->Session->setFlash(__('Position deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Position was not deleted', true), '');
				$this->render('/elements/failure');
			}
			}
        }
	}
}
?>