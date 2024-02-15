<?php
class ImsTagsController extends AppController {

	var $name = 'ImsTags';
	
	function index() {
		$ims_sirv_items = $this->ImsTag->ImsSirvItem->find('all');
		$this->set(compact('ims_sirv_items'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$imssirvitem_id = (isset($_REQUEST['imssirvitem_id'])) ? $_REQUEST['imssirvitem_id'] : -1;
		if($id)
			$imssirvitem_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($imssirvitem_id != -1) {
            $conditions['ImsTag.ims_sirv_item_id'] = $imssirvitem_id;
        }
		
		$this->set('ims_tags', $this->ImsTag->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->ImsTag->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ims tag', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->ImsTag->recursive = 2;
		$this->set('imsTag', $this->ImsTag->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->ImsTag->create();
			$this->autoRender = false;
			if ($this->ImsTag->save($this->data)) {
				$this->Session->setFlash(__('The ims tag has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims tag could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$ims_sirv_items = $this->ImsTag->ImsSirvItem->find('list');
		$ims_sirv_item_befores = $this->ImsTag->ImsSirvItemBefore->find('list');
		$this->set(compact('ims_sirv_items', 'ims_sirv_item_befores'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ims tag', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->ImsTag->save($this->data)) {
				$this->Session->setFlash(__('The ims tag has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ims tag could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ims__tag', $this->ImsTag->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$ims_sirv_items = $this->ImsTag->ImsSirvItem->find('list');
		$ims_sirv_item_befores = $this->ImsTag->ImsSirvItemBefore->find('list');
		$this->set(compact('ims_sirv_items', 'ims_sirv_item_befores'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ims tag', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->ImsTag->delete($i);
                }
				$this->Session->setFlash(__('Ims tag deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ims tag was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->ImsTag->delete($id)) {
				$this->Session->setFlash(__('Ims tag deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ims tag was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function add_code($id = null){
	
		if (isset($_POST) and $_POST != null) {
			global $value;
			$id;		    
			$tag;
			
			foreach ($_POST as $key => $value) {			
				$tmpost = explode('^', $key);
				if($tmpost[1] == 'id')
				{
					$id = $value;
					$id = explode('"',$id);
				}
				else if($tmpost[1] == 'tag')
				{
					$tag = $value;
					$tag = explode('"',$tag);
					$this->create_Tag($id[1],$tag[1]);
				}				
			}
			if($value == true){
				$this->Session->setFlash(__('Tag created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Tag', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function create_Tag($id,$tags){
		global $value;
		
		$this->loadModel('ImsTag');		
		$this->ImsTag->deleteAll(array('ImsTag.ims_sirv_item_id' => $id));
		
		$tags = preg_replace('/[\n\r\t]/','',$tags);
		$tags = explode(',',preg_replace('/\s+/','',$tags));
		foreach($tags as $tag){		
			$this->ImsTag->create();
			$this->data['ImsTag']['code'] = $tag;
			$this->data['ImsTag']['ims_sirv_item_id'] = $id;		
			
			if($this->ImsTag->save($this->data))
			{
				if($value != false){
					$value = true;
				}
			}		
			else{
				$value = false;			
			}
		}
	}
	
	function add_code_before($id = null){
	
		if (isset($_POST) and $_POST != null) {
			global $value;
			$id;		    
			$tag;
			
			foreach ($_POST as $key => $value) {			
				$tmpost = explode('^', $key);
				if($tmpost[1] == 'id')
				{
					$id = $value;
					$id = explode('"',$id);
				}
				else if($tmpost[1] == 'tag')
				{
					$tag = $value;
					$tag = explode('"',$tag);
					$this->create_Tag_before($id[1],$tag[1]);
				}				
			}
			if($value == true){
				$this->Session->setFlash(__('Tag created Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to create Tag', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function create_Tag_before($id,$tags){
		global $value;
		
		$this->loadModel('ImsTag');		
		$this->ImsTag->deleteAll(array('ImsTag.ims_sirv_item_before_id' => $id));
		
		$tags = preg_replace('/[\n\r\t]/','',$tags);
		$tags = explode(',',preg_replace('/\s+/','',$tags));
		foreach($tags as $tag){		
			$this->ImsTag->create();
			$this->data['ImsTag']['code'] = $tag;
			$this->data['ImsTag']['ims_sirv_item_before_id'] = $id;		
			
			if($this->ImsTag->save($this->data))
			{
				if($value != false){
					$value = true;
				}
			}		
			else{
				$value = false;			
			}
		}
	}
}
?>