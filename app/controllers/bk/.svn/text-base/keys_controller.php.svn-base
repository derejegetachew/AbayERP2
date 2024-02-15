<?php

class KeysController extends AppController {

    var $name = 'Keys';

    function index() {
        
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
        
        if (isset($_REQUEST['from_branch_id']))
            $conditions.="'from_branch_id = " . $_REQUEST['from_branch_id'] . "'";
        if (isset($_REQUEST['to_branch_id']))
            $conditions.="'to_branch_id = " . $_REQUEST['to_branch_id'] . "'";
        
        eval("\$conditions = array( " . $conditions . " );");

        $this->set('keys', $this->Key->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Key->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid key', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Key->recursive = 2;
        $this->set('key', $this->Key->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Key->create();
            $this->autoRender = false;
            if ($this->Key->save($this->data)) {
                $this->Session->setFlash(__('The key has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The key could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $this->loadModel('Branch');
        $this->set('branchlist', $this->Branch->find('list'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid key', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Key->save($this->data)) {
                $this->Session->setFlash(__('The key has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The key could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('key', $this->Key->read(null, $id));
        $this->set('parent_id', $id);
        $this->loadModel('Branch');
        $this->set('branchlist', $this->Branch->find('list'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for key', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Key->delete($i);
                }
                $this->Session->setFlash(__('Key deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Key was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Key->delete($id)) {
                $this->Session->setFlash(__('Key deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Key was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>