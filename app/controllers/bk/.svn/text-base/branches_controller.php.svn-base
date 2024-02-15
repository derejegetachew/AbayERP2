<?php

class BranchesController extends AppController {

    var $name = 'Branches';

    function index() {
        $banks = $this->Branch->find('all');
        $this->set(compact('banks'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $sort = 'Branch.' . ((isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : 'name');
        $dir = (isset($_REQUEST['dir'])) ? $_REQUEST['dir'] : 'ASC';
        //$bank_id = (isset($_REQUEST['bank_id'])) ? $_REQUEST['bank_id'] : -1;

        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
        
        if($id)
            $conditions=$conditions."'id=".$id."'";
        
        eval("\$conditions = array( " . $conditions . " );");
        /*if ($bank_id != -1) {
            $conditions['Branch.bank_id'] = $bank_id;
        }*/

        $this->set('branches', $this->Branch->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => $sort . ' ' . $dir)));
        $this->set('results', $this->Branch->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid branch', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Branch->recursive = 2;
        $this->set('branch', $this->Branch->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Branch->create();
            $this->autoRender = false;
            if ($this->Branch->save($this->data)) {
                $this->Session->setFlash(__('The branch has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The branch could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        //$banks = $this->Branch->Bank->find('list');
        //$this->set(compact('banks'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid branch', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Branch->save($this->data)) {
                $this->Session->setFlash(__('The branch has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The branch could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('branch', $this->Branch->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }


    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for branch', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Branch->delete($i);
                }
                $this->Session->setFlash(__('Branch deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Branch was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Branch->delete($id)) {
                $this->Session->setFlash(__('Branch deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Branch was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>