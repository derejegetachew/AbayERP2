<?php

class ImsItem extends ImsAppModel {

    var $name = 'ImsItem';
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
        'ims_item_category_id' => array(
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
                'rule' => array('range', 0, 7000000),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'min_level' => array(
            'range' => array(
                'rule' => array('range', 0, 2000000),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'booked' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fixed_asset' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
        'ImsItemCategory' => array(
            'className' => 'Ims.ImsItemCategory',
            'foreignKey' => 'ims_item_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasAndBelongsToMany = array(
        'ImsPurchaseOrder' => array(
            'className' => 'Ims.ImsPurchaseOrder',
            'joinTable' => 'ims_purchase_order_items',
            'foreignKey' => 'ims_item_id',
            'associationForeignKey' => 'ims_purchase_order_id',
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
		'ImsCard' => array(
			'className' => 'Ims.ImsCard',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ImsStoresItem' => array(
			'className' => 'Ims.ImsStoresItem',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ImsTransferItem' => array(
			'className' => 'Ims.ImsTransferItem',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ImsSirvItemBefore' => array(
			'className' => 'Ims.ImsSirvItemBefore',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ImsMaintenanceRequest' => array(
			'className' => 'Ims.ImsMaintenanceRequest',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    
    function getAvailableBalance($id) {
        $item = $this->read(null, $id);
        
        $available = 0;
        foreach($item['ImsCard'] as $card) {
            $available += $card['in_quantity'];
            $available -= $card['out_quantity'];
        }
        
        return $available;
    }

}

?>