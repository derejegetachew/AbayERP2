<?php
class ImsStoresCard extends AppModel {
	var $name = 'ImsStoresCard';
	var $validate = array(
		'ims_store_id' => array(
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
		'ImsStore' => array(
			'className' => 'Ims.ImsStore',
			'foreignKey' => 'ims_store_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsRequisition' => array(
			'className' => 'Ims.ImsRequisition',
			'foreignKey' => 'ims_requisition_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsCard' => array(
			'className' => 'Ims.ImsCard',
			'foreignKey' => 'ims_card_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>