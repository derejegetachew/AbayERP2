<?php

class ImsGrn extends ImsAppModel {

    var $name = 'ImsGrn';
    var $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please give a name for your GRN. It can be any thing that identifies the GRN.',
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
        'ims_purchase_order_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Your should select a PO',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'date_purchased' => array(
            'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'created_by' => array(
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
		'CreatedUser' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
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
        ),
        'ImsPurchaseOrder' => array(
            'className' => 'Ims.ImsPurchaseOrder',
            'foreignKey' => 'ims_purchase_order_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'ImsGrnItem' => array(
            'className' => 'Ims.ImsGrnItem',
            'foreignKey' => 'ims_grn_id',
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