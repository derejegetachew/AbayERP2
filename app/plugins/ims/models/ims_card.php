<?php
class ImsCard extends ImsAppModel {
	var $name = 'ImsCard';
	var $validate = array(
		'ims_grn_item_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ims_item_id' => array(
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
		'ims_store_id' => array(
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
		'ImsItem' => array(
			'className' => 'Ims.ImsItem',
			'foreignKey' => 'ims_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsGrnItem' => array(
			'className' => 'Ims.ImsGrnItem',
			'foreignKey' => 'ims_grn_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsSirvItem' => array(
			'className' => 'Ims.ImsSirvItem',
			'foreignKey' => 'ims_sirv_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsStore' => array(
			'className' => 'Ims.ImsStore',
			'foreignKey' => 'ims_store_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsDisposalItem' => array(
			'className' => 'Ims.ImsDisposalItem',
			'foreignKey' => 'ims_disposal_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>