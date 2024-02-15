<?php
class DmsRecipient extends AppModel {
	var $name = 'DmsRecipient';
	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DmsMessage' => array(
			'className' => 'DmsMessage',
			'foreignKey' => 'dms_message_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	

}
?>