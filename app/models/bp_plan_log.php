<?php
class BpPlanLog extends AppModel {
	var $name = 'BpPlanLog';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'BpPlan' => array(
			'className' => 'BpPlan',
			'foreignKey' => 'bp_plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>