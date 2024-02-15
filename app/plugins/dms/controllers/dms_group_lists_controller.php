<?php
class DmsGroupListsController extends AppController {

	var $name = 'DmsGroupLists';
	
	function index() {
		//$users = $this->DmsGroupList->User->find('all');
		//$this->set(compact('users'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	function preview_pos($pos=null){
		$this->autoRender = false;
		if($pos){
			$result=$this->DmsGroupList->query("SELECT * FROM `viewemployee`,(select *
from (select * from `viewemployement`  order by `viewemployement`.`Start Date` DESC) as `xx`
group by `xx`.`Record Id`) AS `viewdet`
WHERE `viewemployee`.`Record Id`=`viewdet`.`Record Id` AND
`viewdet`.`Position`='".$pos."' AND `viewemployee`.`status`='active'");
			echo '<h3>Current Staff with selected Position:'.$pos;
			echo '<table style="border: 1px solid;border-collapse: collapse;"><tr><th>Name</th><th>Branch</th><th>Region</th></tr>';
			foreach($result as $res){
				echo '<tr style="border-top:2px solid #d7d7d8;"><td>'.$res['viewemployee']['First Name'].' '.$res['viewemployee']['Middle Name'].'</td>';
				echo '<td>'.$res['viewdet']['Branch'].'</td>';
				echo '<td>'.$res['viewdet']['Branch_REGION'].'</td></tr>';
			}
		}
	}
	function list_data($id = null) {
	
		if($id)
			$group_id = ($id) ? $id : -1;
     
            $conditions['DmsGroupList.dms_group_id'] = $group_id;
			$this->DmsGroupList->recursive=2;

		$this->set('dms_group_lists', $this->DmsGroupList->find('all', array('conditions' => $conditions,'order'=>'type')));
		$this->set('results', $this->DmsGroupList->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms group list', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsGroupList->recursive = 2;
		$this->set('dmsGroupList', $this->DmsGroupList->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		$grp=$this->DmsGroupList->DmsGroup->read(null, $this->data['DmsGroupList']['dms_group_id']);
		if($grp['DmsGroup']['user_id']==$user_id || $user_id ==  4766 || $user_id ==  1941 ){
			$this->DmsGroupList->create();
			$this->autoRender = false;
			if ($this->DmsGroupList->save($this->data)) {
				$this->Session->setFlash(__('The dms group list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms group list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}else{
			$this->Session->setFlash(__('Access Denied.', true), '');
			$this->render('/elements/failure');
		}
		}
		if($id)
			$this->set('parent_id', $id);
		$users = $this->DmsGroupList->User->find('list');
		$dms_groups = $this->DmsGroupList->DmsGroup->find('list');
		$this->set(compact('users', 'dms_groups'));
	}
	
	function add_position($id = null) {
		if (!empty($this->data)) {
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		$grp=$this->DmsGroupList->DmsGroup->read(null, $this->data['DmsGroupList']['dms_group_id']);
		if($grp['DmsGroup']['user_id']==$user_id || $user_id ==  4766 || $user_id ==  1941 ){
			$this->data['DmsGroupList']['type']='position';
			$this->DmsGroupList->create();
			$this->autoRender = false;
			if ($this->DmsGroupList->save($this->data)) {
				$this->Session->setFlash(__('The list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}else{
			$this->Session->setFlash(__('Access Denied.', true), '');
			$this->render('/elements/failure');
		}
		}
		if($id)
			$this->set('parent_id', $id);
		$positions = $this->DmsGroupList->Position->find('list');
		$dms_groups = $this->DmsGroupList->DmsGroup->find('list');
		$this->set(compact('positions', 'dms_groups'));
	}
	function add_branch($id = null) {
		if (!empty($this->data)) {
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		$grp=$this->DmsGroupList->DmsGroup->read(null, $this->data['DmsGroupList']['dms_group_id']);
		if($grp['DmsGroup']['user_id']==$user_id || $user_id ==  4766 || $user_id ==  1941 ){
			$this->data['DmsGroupList']['type']='branch';
			$this->DmsGroupList->create();
			$this->autoRender = false;
			if ($this->DmsGroupList->save($this->data)) {
				$this->Session->setFlash(__('The list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}else{
			$this->Session->setFlash(__('Access Denied.', true), '');
			$this->render('/elements/failure');
		}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->DmsGroupList->Branch->find('list');
		$dms_groups = $this->DmsGroupList->DmsGroup->find('list');
		$this->set(compact('branches', 'dms_groups'));
	}
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms group list', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DmsGroupList->save($this->data)) {
				$this->Session->setFlash(__('The dms group list has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms group list could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('dms__group__list', $this->DmsGroupList->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->DmsGroupList->User->find('list');
		$dms_groups = $this->DmsGroupList->DmsGroup->find('list');
		$this->set(compact('users', 'dms_groups'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms group list', true), '');
			$this->render('/elements/failure');
		}
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
					$grplst=$this->DmsGroupList->read(null,$i);
					$grp=$this->DmsGroupList->DmsGroup->read(null, $grplst['DmsGroupList']['dms_group_id']);
					//if($grp['DmsGroup']['user_id']==$user_id)
						$this->DmsGroupList->delete($i);
                }
				$this->Session->setFlash(__('Dms group list deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms group list was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
			$grplst=$this->DmsGroupList->read(null,$i);
			$grp=$this->DmsGroupList->DmsGroup->read(null, $grplst['DmsGroupList']['dms_group_id']);
			//if($grp['DmsGroup']['user_id']==$user_id)
            if ($this->DmsGroupList->delete($id)) {
				$this->Session->setFlash(__('Dms group list deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms group list was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>