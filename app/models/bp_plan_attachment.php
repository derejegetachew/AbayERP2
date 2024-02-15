<?php
class BpPlanAttachment extends AppModel {
	var $name = 'BpPlanAttachment';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'BpPlan' => array(
			'className' => 'BpPlan',
			'foreignKey' => 'plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>