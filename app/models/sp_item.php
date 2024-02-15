<?php
class SpItem extends AppModel {
	var $name = 'SpItem';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'SpItemGroup' => array(
			'className' => 'SpItemGroup',
			'foreignKey' => 'sp_item_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
			'SpCat' => array(
			'className' => 'SpCat',
			'foreignKey' => 'sp_cat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>