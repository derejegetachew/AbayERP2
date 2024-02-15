<?php

class ImsPurchaseOrder extends ImsAppModel {

    var $name = 'ImsPurchaseOrder';
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
		'ims_supplier_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Your should select a Supplier. If the supplier is not in the list, please close this form and maintain the supplier first.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'notempty' => array(  
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'approved_by' => array(
            'notempty' => array(  
                'rule' => array('notempty'),
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
		'ApprovedUser' => array(
			'className' => 'User',
			'foreignKey' => 'approved_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsSupplier' => array(
            'className' => 'Ims.ImsSupplier',
            'foreignKey' => 'ims_supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'ImsGrn' => array(
            'className' => 'Ims.ImsGrn',
            'foreignKey' => 'ims_purchase_order_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ImsPurchaseOrderItem' => array(
            'className' => 'Ims.ImsPurchaseOrderItem',
            'foreignKey' => 'ims_purchase_order_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}

?>