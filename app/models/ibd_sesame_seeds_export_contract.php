<?php
class IbdSesameSeedsExportContract extends AppModel {
	var $name = 'IbdSesameSeedsExportContract';
	var $belongsTo = array(
		'PaymentTerm' => array(
			'className' => 'PaymentTerm',
			'foreignKey' => 'payment_method',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CurrencyType' => array(
			'className' => 'CurrencyType',
			'foreignKey' => 'type_of_currency',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $validate = array(
		'contract_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contract_registry_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shipment_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
?>