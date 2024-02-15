<?php
class LeaseTransaction extends AppModel {
	var $name = 'LeaseTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Lease' => array(
			'className' => 'Lease',
			'foreignKey' => 'lease_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>