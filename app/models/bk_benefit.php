<?php
class BkBenefit extends AppModel {
	var $name = 'BkBenefit';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Benefit' => array(
			'className' => 'Benefit',
			'foreignKey' => 'benefit_id',
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
		),
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>