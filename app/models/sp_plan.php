<?php
class SpPlan extends AppModel {
	var $name = 'SpPlan';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
				'SpItem' => array(
			'className' => 'SpItem',
			'foreignKey' => 'sp_item_id',
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
		),'SpPlanHd' => array(
			'className' => 'SpPlanHd',
			'foreignKey' => 'sp_plan_hd_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)

	);
}
?>