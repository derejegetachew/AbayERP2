<?php
class SpItemGroup extends AppModel {
	var $name = 'SpItemGroup';
	var $actsAs = array('Tree');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	

	var $hasMany = array(
	
		'SpItem' => array(
			'className' => 'SpItem',
			'foreignKey' => 'sp_item_group_id',
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