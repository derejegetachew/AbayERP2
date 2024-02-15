<?php
class BpCumulative extends AppModel {
	var $name = 'BpCumulative';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'BpItem' => array(
			'className' => 'BpItem',
			'foreignKey' => 'bp_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BpMonth' => array(
			'className' => 'BpMonth',
			'foreignKey' => 'bp_month_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BudgetYear' => array(
			'className' => 'BudgetYear',
			'foreignKey' => 'budget_year_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>