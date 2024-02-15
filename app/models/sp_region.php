<?php
class SpRegion extends AppModel {
	var $name = 'SpRegion';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'sp_region_id',
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