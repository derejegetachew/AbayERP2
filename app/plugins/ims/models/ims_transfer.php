<?php
class ImsTransfer extends AppModel {
	var $name = 'ImsTransfer';
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
		'ims_sirv_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from_user' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'to_user' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from_branch' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'to_branch' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'approved_by' => array(
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
		'ImsSirv' => array(
			'className' => 'Ims.ImsSirv',
			'foreignKey' => 'ims_sirv_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TransfferingUser' => array(
			'className' => 'User',
			'foreignKey' => 'from_user',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReceivingUser' => array(
			'className' => 'User',
			'foreignKey' => 'to_user',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TransfferingBranch' => array(
			'className' => 'Branch',
			'foreignKey' => 'from_branch',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReceivingBranch' => array(
			'className' => 'Branch',
			'foreignKey' => 'to_branch',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ApprovingUser' => array(
			'className' => 'User',
			'foreignKey' => 'approved_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ImsTransferItem' => array(
			'className' => 'Ims.ImsTransferItem',
			'foreignKey' => 'ims_transfer_id',
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