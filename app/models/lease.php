<?php
class Lease extends AppModel {
	var $name = 'Lease';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'LeaseTransaction' => array(
			'className' => 'LeaseTransaction',
			'foreignKey' => 'lease_id',
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