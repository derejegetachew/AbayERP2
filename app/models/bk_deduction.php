<?php
class BkDeduction extends AppModel {
	var $name = 'BkDeduction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Deduction' => array(
			'className' => 'Deduction',
			'foreignKey' => 'deduction_id',
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