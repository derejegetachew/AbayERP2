<?php

class GrnItem extends AppModel {

    var $name = 'GrnItem';
    var $validate = array(
        'grn_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'purchase_order_item_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'quantity' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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
        'Grn' => array(
            'className' => 'Grn',
            'foreignKey' => 'grn_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PurchaseOrderItem' => array(
            'className' => 'PurchaseOrderItem',
            'foreignKey' => 'purchase_order_item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasAndBelongsToMany = array(
        'Store' => array(
            'className' => 'Store',
            'joinTable' => 'stores_grn_items',
            'foreignKey' => 'grn_item_id',
            'associationForeignKey' => 'store_id',
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

}

?>