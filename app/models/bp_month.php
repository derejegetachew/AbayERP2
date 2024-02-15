<?php
class BpMonth extends AppModel {
	var $name = 'BpMonth';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'BpActual' => array(
			'className' => 'BpActual',
			'foreignKey' => 'bp_month_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BpPlan' => array(
			'className' => 'BpPlan',
			'foreignKey' => 'bp_month_id',
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