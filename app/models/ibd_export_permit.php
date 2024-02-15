<?php
class IbdExportPermit extends AppModel {
	var $name = 'IbdExportPermit';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $validate = array(
		'PERMIT_ISSUE_DATE' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
		
	);


	var $belongsTo = array(
		'PaymentTerm' => array(
			'className' => 'PaymentTerm',
			'foreignKey' => 'payment_term_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CurrencyType' => array(
			'className' => 'CurrencyType',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>