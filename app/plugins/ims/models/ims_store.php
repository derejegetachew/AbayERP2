<?php

class ImsStore extends ImsAppModel {

    var $name = 'ImsStore';
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
        'address' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'store_keeper_one' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'store_keeper_two' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'store_keeper_three' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'store_keeper_four' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
   'store_keeper_five' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
   'store_keeper_six' => array(
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
		'StoreKeeperOne' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_one',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StoreKeeperTwo' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_two',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StoreKeeperThree' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_three',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StoreKeeperFour' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_four',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StoreKeeperFive' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_five',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StoreKeeperSix' => array(
			'className' => 'User',
			'foreignKey' => 'store_keeper_six',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
    var $hasAndBelongsToMany = array(
        'ImsGrnItem' => array(
            'className' => 'Ims.ImsGrnItem',
            'joinTable' => 'ims_stores_grn_items',
            'foreignKey' => 'ims_store_id',
            'associationForeignKey' => 'ims_grn_item_id',
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
		'ImsStoresItem' => array(
			'className' => 'Ims.ImsStoresItem',
			'foreignKey' => 'ims_store_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ImsRequisition' => array(
			'className' => 'Ims.ImsRequisition',
			'foreignKey' => 'ims_store_id',
			'dependent' => false,
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