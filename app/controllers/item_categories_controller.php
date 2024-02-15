<?php

class ItemCategoriesController extends AppController {

    var $name = 'ItemCategories';

    function index() {
    }

    function search() {
        
    }

    function list_data($id = null) {
        $item_categories = $this->ItemCategory->find('all', array('order' => 'ItemCategory.lft ASC'));
        $tree_data = array();
        if(count($item_categories) > 0) {
            $tree_data = array($this->__getTreeArray($item_categories[0], $item_categories));
        }
        $this->set('item_categories', $tree_data);
    }

    function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array('id' => $node['ItemCategory']['id'], 'name' => $node['ItemCategory']['name'], 'children' => array());
        $children = $this->__getChildNodes($node['ItemCategory']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['ItemCategory']['parent_id'] == $p_id) {
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
        $this->ItemCategory->recursive = 2;
        $this->set('itemCategory', $this->ItemCategory->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ItemCategory->create();
            $this->autoRender = false;
            if ($this->ItemCategory->save($this->data)) {
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
            if ($this->ItemCategory->save($this->data)) {
                $this->Session->setFlash(__('The item category has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item category could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('item__category', $this->ItemCategory->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for item category', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->ItemCategory->delete($i);
                }
                $this->Session->setFlash(__('Item category deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Item category was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->ItemCategory->delete($id)) {
                $this->Session->setFlash(__('Item category deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Item category was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>