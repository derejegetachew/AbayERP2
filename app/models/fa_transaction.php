<?php
class FaTransaction extends AppModel {
	var $name = 'FaTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'FaAsset' => array(
			'className' => 'FaAsset',
			'foreignKey' => 'fa_asset_id',
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