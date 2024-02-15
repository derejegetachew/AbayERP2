<?php

class LoansController extends AppController {

    var $name = 'Loans';

    function index() {
        $employees = $this->Loan->Employee->find('all');
        $this->set(compact('employees'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
        $this->Loan->Employee->recursive = 3;
        $this->set('employee', $this->Loan->Employee->read(null, $id));
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Loan.employee_id'] = $employee_id;
        }

        $this->set('loans', $this->Loan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Loan->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid loan', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Loan->recursive = 2;
        $this->set('loan', $this->Loan->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Loan->create();
            $this->autoRender = false;
            if ($this->Loan->save($this->data)) {
                $this->Session->setFlash(__('The loan has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The loan could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $employees = $this->Loan->Employee->find('list');
        $this->set(compact('employees'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid loan', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Loan->save($this->data)) {
                $this->Session->setFlash(__('The loan has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The loan could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('loan', $this->Loan->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $employees = $this->Loan->Employee->find('list');
        $this->set(compact('employees'));
    }

    function skip($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid loan', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $loan = $this->Loan->read(null, $this->data['Loan']['id']);
            $this->data['Loan']['start'] = $this->data['Loan']['startt'];
            //pr($this->data);

            if ($loan['Loan']['skipped_months'] != '')
                $this->data['Loan']['skipped_months'] = $this->data['Loan']['skipped_months'] . ',' . $loan['Loan']['skipped_months'];
            $this->autoRender = false;
            if ($this->Loan->save($this->data)) {
                $this->Session->setFlash(__('The loan has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The loan could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('loan', $this->Loan->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $employees = $this->Loan->Employee->find('list');
        $this->set(compact('employees'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for loan', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Loan->delete($i);
                }
                $this->Session->setFlash(__('Loan deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Loan was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Loan->delete($id)) {
                $this->Session->setFlash(__('Loan deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Loan was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function close($id = null, $parent_id = null) {
        
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid loan', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Loan->save($this->data)) {
                $this->Session->setFlash(__('The loan has been Closed', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The loan could not be Closed. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('loan', $this->Loan->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $employees = $this->Loan->Employee->find('list');
        $this->set(compact('employees'));        
        
        
  
    }

}

?>