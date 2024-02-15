<?php
class BkPrice extends AppModel {
	var $name = 'BkPrice';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Price' => array(
			'className' => 'Price',
			'foreignKey' => 'price_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PayrollReport' => array(
			'className' => 'PayrollReport',
			'foreignKey' => 'payroll_report_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>