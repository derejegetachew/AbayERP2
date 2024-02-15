<?php

class ImsItemCategoriesController extends ImsAppController {

    var $name = 'ImsItemCategories';

    function index() {
    }

    function search() {
        
    }

    function list_data($id = null) {
        $item_categories = $this->ImsItemCategory->find('all', array('order' => 'ImsItemCategory.lft ASC'));
        $tree_data = array();
        if(count($item_categories) > 0) {
            $tree_data = array($this->__getTreeArray($item_categories[0], $item_categories));
        }
        $this->set('item_categories', $tree_data);
    }

    function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array('id' => $node['ImsItemCategory']['id'], 'name' => $node['ImsItemCategory']['name'], 'children' => array());
        $children = $this->__getChildNodes($node['ImsItemCategory']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['ImsItemCategory']['parent_id'] == $p_id) {
                $ret[] = $ad;
            }
        }
        return $ret;
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid item category', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsItemCategory->recursive = 2;
        $this->set('item_category', $this->ImsItemCategory->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ImsItemCategory->create();
            $this->autoRender = false;
            if ($this->ImsItemCategory->save($this->data)) {
                $this->Session->setFlash(__('The item category has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item category could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid item category', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->ImsItemCategory->save($this->data)) {
                $this->Session->setFlash(__('The item category has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item category could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('item_category', $this->ImsItemCategory->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }
    }

    function delete($id = null) {
        $this->autoRender = false;
		$this->loadModel('ImsItem');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for item category', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsItem.ims_item_category_id'] = $i;
					if($this->ImsItemCategory->ImsItem->find('count', array('conditions' => $conditions)) == 0){  
							$this->ImsItemCategory->delete($i);
					} else {
						$itemCat = $this->ImsItemCategory->read(null,$i);
						$msg .= $itemCat['ImsItemCategory']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('Item category deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have Item(s), Following Item categories were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('Item category was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsItem.ims_item_category_id'] = $id;
			if($this->ImsItemCategory->ImsItem->find('count', array('conditions' => $conditions)) == 0){
				if ($this->ImsItemCategory->delete($id)) {
					$this->Session->setFlash(__('Item category deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Item category was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('Item category was not deleted because it has Item(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
    }

}

?>