<?php
class PerformanceListChoice extends AppModel {
	var $name = 'PerformanceListChoice';
	var $validate = array(
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
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'PerformanceList' => array(
			'className' => 'PerformanceList',
			'foreignKey' => 'performance_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'EmployeePerformanceResult' => array(
			'className' => 'EmployeePerformanceResult',
			'foreignKey' => 'performance_list_choice_id',
			'dependent' => false,
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