<?php
class BpActualDetailsController extends AppController {

	var $name = 'BpActualDetails';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		/*$cmd="SELECT * from bp_actual_details where status=0";
		$bpActualDetail=$this->BpActualDetail->query($cmd);
		$this->set('bpActualDetails',$bpActualDetail);*/
		//var_dump($id);
		//"MONTH(STR_TO_DATE( TDate,  '%d-%b-%y' ))"=>$id
		$this->set('bpActualDetails', $this->BpActualDetail->find('all', array('conditions' => array('status'=>false,"month"=>$id,$conditions) , 'limit' => $limit, 'offset' => $start)));
		//$this->set('results', $this->BpActualDetail->find('count', array('conditions' => $conditions)));
		$this->set('results', $this->BpActualDetail->find('count', array('conditions' => array('status'=>false,"month"=>$id,$conditions))));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp actual detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpActualDetail->recursive = 2;
		$this->set('bpActualDetail', $this->BpActualDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpActualDetail->create();
			$this->autoRender = false;
			if ($this->BpActualDetail->save($this->data)) {
				$this->Session->setFlash(__('The bp actual detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp actual detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp actual detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpActualDetail->save($this->data)) {
				$this->Session->setFlash(__('The bp actual detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp actual detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__actual__detail', $this->BpActualDetail->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp actual detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpActualDetail->delete($i);
                }
				$this->Session->setFlash(__('Bp actual detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp actual detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpActualDetail->delete($id)) {
				$this->Session->setFlash(__('Bp actual detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp actual detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>