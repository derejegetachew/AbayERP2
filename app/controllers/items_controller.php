<?php

class ItemsController extends AppController {

    var $name = 'Items';

    function index() {
        //$item_categories = $this->Item->ItemCategory->find('all');
        $item_categories = $this->Item->ItemCategory->generatetreelist(null, null, null, '---');
        $this->set(compact('item_categories'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $item_category_id = (isset($_REQUEST['item_category_id'])) ? $_REQUEST['item_category_id'] : -1;
        if ($id)
            $item_category_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
        
        eval("\$conditions = array( " . $conditions . " );");
        if ($item_category_id != -1) {
            $conditions['Item.item_category_id'] = $item_category_id;
        }

        $this->set('items', $this->Item->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Item->find('count', array('conditions' => $conditions)));
    }
    
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Item->recursive = 2;
        $this->set('item', $this->Item->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Item->create();
            $this->autoRender = false;
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $item_categories = $this->Item->ItemCategory->generatetreelist(null, null, null, '---');
        $this->set(compact('item_categories'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid item', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The item has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('item', $this->Item->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $item_categories = $this->Item->ItemCategory->find('list');
        $this->set(compact('item_categories'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for item', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Item->delete($i);
                }
                $this->Session->setFlash(__('Item deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Item was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Item->delete($id)) {
                $this->Session->setFlash(__('Item deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Item was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>