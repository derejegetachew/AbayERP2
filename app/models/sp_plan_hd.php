<?php
class SpPlanHd extends AppModel {
	var $name = 'SpPlanHd';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',
			'conditions' => '',
			'fields' => 'name',
			'order' => ''
		),
		'BudgetYear' => array(
			'className' => 'BudgetYear',
			'foreignKey' => 'budget_year_id',
			'conditions' => '',
			'fields' => 'name',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => 'username',
			'order' => ''
		)
	);

	var $hasMany = array(
		'SpPlan' => array(
			'className' => 'SpPlan',
			'foreignKey' => 'sp_plan_hd_id',
			'dependent' => true,
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