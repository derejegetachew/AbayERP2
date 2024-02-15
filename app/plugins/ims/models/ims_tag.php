<?php
class ImsTag extends ImsAppModel {
	var $name = 'ImsTag';
	var $validate = array(
		'code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ims_sirv_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ims_sirv_item_before_id' => array(
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
		'ImsSirvItem' => array(
			'className' => 'Ims.ImsSirvItem',
			'foreignKey' => 'ims_sirv_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImsSirvItemBefore' => array(
			'className' => 'Ims.ImsSirvItemBefore',
			'foreignKey' => 'ims_sirv_item_before_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>