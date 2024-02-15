<?php
class ImsSirvBeforesController extends AppController {

	var $name = 'ImsSirvBefores';
	
	function index() {
		$this->ImsSirvBefore->Branch->recursive = -1;
		$branches = $this->ImsSirvBefore->Branch->find('all');
		$this->set(compact('branches'));
		
		$user = $this->Session->read();	
		$this->set('groups',$user['Auth']['Group']);
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
            $conditions['ImsSirvBefore.branch_id'] = $branch_id;
        }
		
		$this->set('ims_sirv_befores', $this->ImsSirvBefore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsSirvBefore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims sirv before', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsSirvBefore->recursive = 2;
		$this->set('imsSirvBefore', $this->ImsSirvBefore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsSirvBefore->create();
			$this->autoRender = false;
			if ($this->ImsSirvBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
			
		$this->ImsSirvBefore->Branch->recursive = -1;
		$branches = $this->ImsSirvBefore->Branch->find('all');
		$this->set(compact('branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims sirv before', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsSirvBefore->save($this->data)) {
				$this->Session->setFlash(__('The ims sirv before has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims sirv before could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims_sirv_before', $this->ImsSirvBefore->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->ImsSirvBefore->Branch->find('list');
		$this->set(compact('branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims sirv before', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsSirvBefore->delete($i);
                }
				$this->Session->setFlash(__('Ims sirv before deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims sirv before was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsSirvBefore->delete($id)) {
				$this->Session->setFlash(__('Ims sirv before deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims sirv before was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function print_sirv($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for sirv', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsSirvBefore->recursive = 1;
        $this->set('sirv', $this->ImsSirvBefore->read(null, $id));
    }
	
	function getcategories()
	{		
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
		for($j=0;$j<count($itemcategory );$j++){
			$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
			$itemcategory [$j]['child'][] = $itemcategory[$j];
		}
		return $itemcategory; 
	}
	
	function getChild($parentId=null){
		$this->loadModel('ImsItemCategory'); 
		$conditions =array('ImsItemCategory.parent_id' =>$parentId);
		$this->ImsItemCategory->recursive = -1;
		$children = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){				
				$children[$i]['child'] = $this->getChild($children[$i]['ImsItemCategory']['id']);
			}
			return $children;
		}
	}
	
	function getitem()
	{
		$id = $this->params['itemid'];
		$this->loadModel('ImsItem');
		$item = $this->ImsItem->read(null,$id);
		return $item['ImsItem']; 
	}
}
?>