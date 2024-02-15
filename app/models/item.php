<?php

class Item extends AppModel {

    var $name = 'Item';
    var $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'description' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'item_category_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'max_level' => array(
            'range' => array(
                'rule' => array('range', 0, 10000),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'min_level' => array(
            'range' => array(
                'rule' => array('range', 0, 1000),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'ItemCategory' => array(
            'className' => 'ItemCategory',
            'foreignKey' => 'item_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasAndBelongsToMany = array(
        'PurchaseOrder' => array(
            'className' => 'PurchaseOrder',
            'joinTable' => 'purchase_order_items',
            'foreignKey' => 'item_id',
            'associationForeignKey' => 'purchase_order_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    
    var $hasMany = array( 
        'Card' => array(
            'className' => 'Card',
            'foreignKey' => 'item_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'Card.created DESC',
            'limit' => '',
            'offset' => '',
            'dependent'=> true
        )
    );
    
    function getAvailableBalance($id) {
        $item = $this->read(null, $id);
        
        $available = 0;
        foreach($item['Card'] as $card) {
            $available += $card['in_quantity'];
            $available -= $card['out_quantity'];
        }
        
        return $available;
    }

}

?>