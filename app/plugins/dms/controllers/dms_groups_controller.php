<?php
class DmsGroupsController extends AppController {

	var $name = 'DmsGroups';
	
	function index() {
		//$users = $this->DmsGroup->User->find('all');
		//$this->set(compact('users'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
			$conditions=array('OR'=>array(
					'DmsGroup.user_id' => $user_id,
					'DmsGroup.public' => '1'));
		//$this->set('dms_groups', $this->DmsGroup->find('all', array('conditions' => $conditions)));
		$this->DmsGroup->recursive=2;
		$groups=$this->DmsGroup->find('all', array('conditions' => $conditions,'order'=>'DmsGroup.public'));
		/*print_r($groups);
		$i=0;
		foreach($groups as $group){
		$groups[$i]['DmsGroup']['name']=$groups[$i]['DmsGroup']['name'].' ('.count($group['DmsGroupList']).')';
		$i++;
		}*/
		$this->set('dms_groups',$groups);
		$this->set('results', $this->DmsGroup->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsGroup->recursive = 2;
		$this->set('dmsGroup', $this->DmsGroup->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->DmsGroup->create();
			$this->autoRender = false;
			$user = $this->Session->read();	
			$user_id = $user['Auth']['User']['id'];
			if($user_id!='3566' && $user_id!='408' && $user_id!='105' && $user_id!='287' && $user_id!='1177')
				$this->data['DmsGroup']['public']=false;
			if ($this->DmsGroup->save($this->data)) {
				$this->Session->setFlash(__('The dms group has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms group could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$users = $this->DmsGroup->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms group', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$user = $this->Session->read();	
			$user_id = $user['Auth']['User']['id'];
			$grp=$this->DmsGroup->read(null, $this->data['DmsGroup']['id']);
			//if(!isset($this->data['DmsGroup']['public']))
			if($user_id!='3566' && $user_id!='408' && $user_id!='105' && $user_id!='287' && $user_id!='3873' && $user_id!='1177')
				$this->data['DmsGroup']['public']=false;
			if($grp['DmsGroup']['user_id']==$user_id ){
				if ($this->DmsGroup->save($this->data)) {
					$this->Session->setFlash(__('The dms group has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The dms group could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}else{
			$this->Session->setFlash(__('Access Denied.', true), '');
			$this->render('/elements/failure');
		}
		}
		$this->set('dms_group', $this->DmsGroup->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->DmsGroup->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms group', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DmsGroup->delete($i);
                }
				$this->Session->setFlash(__('Dms group deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms group was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DmsGroup->delete($id)) {
				$this->Session->setFlash(__('Dms group deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms group was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>