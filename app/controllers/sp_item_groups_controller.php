<?php
class SpItemGroupsController extends AppController {

	var $name = 'SpItemGroups';
	
	function index() {
		
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		// 
		$spItemGroups = $this->SpItemGroup->find('all');
        $tree_data = array();
        if (count($spItemGroups) > 0) {
            $tree_data = array($this->__getTreeArray($spItemGroups[0], $spItemGroups));
        }

       //var_dump($tree_data);die();
		
		$this->set('spItemGroups', $tree_data);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sp item group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->SpItemGroup->recursive = 2;
		$this->set('spItemGroup', $this->SpItemGroup->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->SpItemGroup->create();
			$this->autoRender = false;
			if ($this->SpItemGroup->save($this->data)) {
				$this->Session->setFlash(__('The sp item group has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp item group could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		//$parent_sp_item_groups = $this->SpItemGroup->ParentSpItemGroup->find('list');
		//$this->set(compact('parent_sp_item_groups'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sp item group', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->SpItemGroup->save($this->data)) {
				$this->Session->setFlash(__('The sp item group has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The sp item group could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('sp_item_group', $this->SpItemGroup->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		//$parent_sp_item_groups = $this->SpItemGroup->ParentSpItemGroup->find('list');
		//$this->set(compact('parent_sp_item_groups'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sp item group', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->SpItemGroup->delete($i);
                }
				$this->Session->setFlash(__('Sp item group deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Sp item group was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->SpItemGroup->delete($id)) {
				$this->Session->setFlash(__('Sp item group deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Sp item group was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array(
            'id' => $node['SpItemGroup']['id'],
            'name' => $node['SpItemGroup']['name'],
            'created' => $node['SpItemGroup']['created'],
            'children' => array());
        $children = $this->__getChildNodes($node['SpItemGroup']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['SpItemGroup']['parent_id'] == $p_id) {
                $ret[] = $ad;
            }
        }
        return $ret;
    }


}
?>