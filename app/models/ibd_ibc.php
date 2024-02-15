<?php
class IbdIbc extends AppModel {
	var $name = 'IbdIbc';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $validate = array(
		'ISSUE_DATE' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'SETT_Date' => array(
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
		'IbdPurchaseOrder' => array(
			'className' => 'IbdPurchaseOrder',
			'foreignKey' => 'PURCHASE_ORDER_NO',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
?>