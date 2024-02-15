<?php
class BkTaxrule extends AppModel {
	var $name = 'BkTaxrule';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'TaxRule' => array(
			'className' => 'TaxRule',
			'foreignKey' => 'tax_rule_id',
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