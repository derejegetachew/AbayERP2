<?php

class FieldsController extends AppController {

    var $name = 'Fields';

    function index() {
        
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $this->set('fields', $this->Field->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Field->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid field', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Field->recursive = 2;
        $this->set('field', $this->Field->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Field->create();
            $this->autoRender = false;
            if ($this->Field->save($this->data)) {
                $this->Session->setFlash(__('The field has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The field could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $reports = $this->Field->Report->find('list');
        $this->set(compact('reports'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid field', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Field->save($this->data)) {
                $this->Session->setFlash(__('The field has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The field could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('field', $this->Field->read(null, $id));


        $reports = $this->Field->Report->find('list');
        $this->set(compact('reports'));
    }

    function editphp($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid field', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Field->save($this->data)) {
                $this->Session->setFlash(__('The field has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The field could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('field', $this->Field->read(null, $id));


        $reports = $this->Field->Report->find('list');
        $this->set(compact('reports'));
    }

    function editsql($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid field', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Field->save($this->data)) {
                $this->Session->setFlash(__('The field has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The field could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('field', $this->Field->read(null, $id));


        $reports = $this->Field->Report->find('list');
        $this->set(compact('reports'));
    }

    function editchoices($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid field', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Field->save($this->data)) {
                $this->Session->setFlash(__('The field has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The field could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('field', $this->Field->read(null, $id));


        $reports = $this->Field->Report->find('list');
        $this->set(compact('reports'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for field', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Field->delete($i);
                }
                $this->Session->setFlash(__('Field deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Field was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Field->delete($id)) {
                $this->Session->setFlash(__('Field deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Field was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>