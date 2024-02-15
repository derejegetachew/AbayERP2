<?php

class CardsController extends AppController {

    var $name = 'Cards';

    function index() {
        $items = $this->Card->Item->find('all');
        $this->set(compact('items'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function index_stock_card($id = null) {
        $this->set('parent_id', $id);
    }

    function index_bin_card($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $conditions['Card.item_id'] = $item_id;
        }

        $this->set('cards', $this->Card->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'Card.created ASC')));
        $this->set('results', $this->Card->find('count', array('conditions' => $conditions)));
    }

    function list_data_stock_cards($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $conditions['Card.item_id'] = $item_id;
        }

        $this->set('cards', $this->Card->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'Card.created ASC')));
        $this->set('results', $this->Card->find('count', array('conditions' => $conditions)));
    }

    function list_data_bin_cards($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $conditions['Card.item_id'] = $item_id;
        }
        $cards = $this->Card->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));

        $cs = array();
        $balance = 0;
        foreach ($cards as $card) {
            $balance += ($card['Card']['in_quantity'] - $card['Card']['out_quantity']);

            $cs[] = array(
                'Card' => array(
                    'id' => $card['Card']['id'],
                    'in_quantity' => $card['Card']['in_quantity'],
                    'out_quantity' => $card['Card']['out_quantity'],
                    'balance' => $balance,
                    'created' => $card['Card']['created'],
                    'modified' => $card['Card']['modified']
                ),
                'Item' => $card['Item'],
                'Grn' => $card['Grn']
            );
        }

        $this->set('cards', $cs);
        $this->set('results', $this->Card->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Card->recursive = 2;
        $this->set('card', $this->Card->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Card->create();
            $this->autoRender = false;
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $items = $this->Card->Item->find('list');
        $grns = $this->Card->Grn->find('list');
        $this->set(compact('items', 'grns'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid card', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('card', $this->Card->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $items = $this->Card->Item->find('list');
        $grns = $this->Card->Grn->find('list');
        $this->set(compact('items', 'grns'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for card', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Card->delete($i);
                }
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Card->delete($id)) {
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>