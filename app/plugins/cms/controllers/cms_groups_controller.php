<?php
class CmsGroupsController extends AppController {

	var $name = 'CmsGroups';
	
	function index() {
		$users = $this->CmsGroup->User->find('all');
		$this->set(compact('users'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
		if($id)
			$user_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		$this->CmsGroup->recursive = 2;
		$this->set('cms_groups', $this->CmsGroup->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CmsGroup->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cms group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CmsGroup->recursive = 2;
		$this->set('cmsGroup', $this->CmsGroup->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
		
			// Strip out carriage returns
            $name = ereg_replace("\r",'',$this->data['CmsGroup']['name']);
            // Handle paragraphs
            $name = ereg_replace("\n\n",'<br /><br />',$name);
            // Handle line breaks
            $name = ereg_replace("\n",'<br />',$name);
            // Handle apostrophes
            $name = ereg_replace("'",'&#8217;',$name);
			$this->data['CmsGroup']['name'] = $name;
			
			$this->CmsGroup->create();
			$this->autoRender = false;
			if ($this->CmsGroup->save($this->data)) {
				$this->Session->setFlash(__('The group has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$users = $this->CmsGroup->User->find('list');
		$branches = $this->CmsGroup->Branch->find('all');
		$this->set(compact('users','branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cms group', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CmsGroup->save($this->data)) {
				$this->Session->setFlash(__('The cms group has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cms group could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cms_group', $this->CmsGroup->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->CmsGroup->User->find('list');
		$branches = $this->CmsGroup->Branch->find('all');
		$this->set(compact('users','branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cms group', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CmsGroup->delete($i);
                }
				$this->Session->setFlash(__('Cms group deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cms group was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CmsGroup->delete($id)) {
				$this->Session->setFlash(__('Cms group deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cms group was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>