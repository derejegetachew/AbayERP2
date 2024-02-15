<?php
/* Language Fixture generated on: 2013-03-06 17:03:07 : 1362592087 */
class LanguageFixture extends CakeTestFixture {
	var $name = 'Language';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'speak' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'read' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'write' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'listen' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'speak' => 'Lorem ipsum dolor sit amet',
			'read' => 'Lorem ipsum dolor sit amet',
			'write' => 'Lorem ipsum dolor sit amet',
			'listen' => 'Lorem ipsum dolor sit amet',
			'employee_id' => 1
		),
	);
}
?>