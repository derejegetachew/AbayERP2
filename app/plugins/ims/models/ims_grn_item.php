<?php

class ImsGrnItem extends ImsAppModel {

    var $name = 'ImsGrnItem';
    var $validate = array(
        'ims_grn_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ims_purchase_order_item_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
        'ImsGrn' => array(
            'className' => 'Ims.ImsGrn',
            'foreignKey' => 'ims_grn_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ImsPurchaseOrderItem' => array(
            'className' => 'Ims.ImsPurchaseOrderItem',
            'foreignKey' => 'ims_purchase_order_item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasAndBelongsToMany = array(
        'ImsStore' => array(
            'className' => 'Ims.ImsStore',
            'joinTable' => 'ims_stores_grn_items',
            'foreignKey' => 'ims_grn_item_id',
            'associationForeignKey' => 'ims_store_id',
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