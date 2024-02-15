<?php
class EmployeePerformanceResult extends AppModel {
	var $name = 'EmployeePerformanceResult';
	var $validate = array(
		'employee_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'employee_performance_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'performance_list_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'performance_list_choice_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EmployeePerformance' => array(
			'className' => 'EmployeePerformance',
			'foreignKey' => 'employee_performance_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PerformanceList' => array(
			'className' => 'PerformanceList',
			'foreignKey' => 'performance_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PerformanceListChoice' => array(
			'className' => 'PerformanceListChoice',
			'foreignKey' => 'performance_list_choice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>