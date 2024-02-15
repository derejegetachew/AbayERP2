<?php
/* Position Fixture generated on: 2013-02-21 16:02:03 : 1361463963 */
class PositionFixture extends CakeTestFixture {
	var $name = 'Position';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'position' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 300),
		'grade_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'position' => 'Lorem ipsum dolor sit amet',
			'grade_id' => 1
		),
	);
}
?>