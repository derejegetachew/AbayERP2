<?php
class IbdInvisiblePermit extends AppModel {
	var $name = 'IbdInvisiblePermit';
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
		)
	);

	var $belongsTo = array(
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