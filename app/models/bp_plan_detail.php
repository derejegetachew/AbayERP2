<?php
class BpPlanDetail extends AppModel {
	var $name = 'BpPlanDetail';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'BpItem' => array(
			'className' => 'BpItem',
			'foreignKey' => 'bp_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BpPlan' => array(
			'className' => 'BpPlan',
			'foreignKey' => 'bp_plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>