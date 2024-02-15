<?php
class IbdTt extends AppModel {
	var $name = 'IbdTt';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $validate = array(
		'DATE_OF_ISSUE' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'FCY_APPROVAL_DATE' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	var $belongsTo = array(
		'CurrencyType' => array(
			'className' => 'CurrencyType',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'IbdBank' => array(
			'className' => 'IbdBank',
			'foreignKey' => 'REIBURSING_BANK',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>