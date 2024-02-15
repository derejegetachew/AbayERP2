<?php
/* Employee Fixture generated on: 2013-03-07 11:03:30 : 1362654870 */
class EmployeeFixture extends CakeTestFixture {
	var $name = 'Employee';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'mother_first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 300),
		'mother_last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'location_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'kebele' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'woreda' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'house_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'p_o_box' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'telephone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'marital_status' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'spouse_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'identification_card_number' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'date_of_employment' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'terms_of_employment' => array('type' => 'string', 'null' => false, 'default' => 'P', 'length' => 1),
		'branch_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'contact_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_region' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_kebele' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_house_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_residence_tel' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_office_tel' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_mobile' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'contact_p_o_box' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'mother_first_name' => 'Lorem ipsum dolor sit amet',
			'mother_last_name' => 'Lorem ipsum dolor sit amet',
			'location_id' => 1,
			'city' => 'Lorem ipsum dolor sit amet',
			'kebele' => 'Lorem ipsum dolor sit amet',
			'woreda' => 'Lorem ipsum dolor sit amet',
			'house_no' => 'Lorem ipsum dolor sit amet',
			'p_o_box' => 'Lorem ipsum dolor sit amet',
			'telephone' => 'Lorem ipsum dolor sit amet',
			'marital_status' => 'Lorem ipsum dolor ',
			'spouse_name' => 'Lorem ipsum dolor sit amet',
			'identification_card_number' => 'Lorem ipsum dolor sit amet',
			'date_of_employment' => '2013-03-07',
			'terms_of_employment' => 'Lorem ipsum dolor sit ame',
			'branch_id' => 1,
			'contact_name' => 'Lorem ipsum dolor sit amet',
			'contact_region' => 'Lorem ipsum dolor sit amet',
			'contact_city' => 'Lorem ipsum dolor sit amet',
			'contact_kebele' => 'Lorem ipsum dolor sit amet',
			'contact_house_no' => 'Lorem ipsum dolor sit amet',
			'contact_residence_tel' => 'Lorem ipsum dolor sit amet',
			'contact_office_tel' => 'Lorem ipsum dolor sit amet',
			'contact_mobile' => 'Lorem ipsum dolor sit amet',
			'contact_email' => 'Lorem ipsum dolor sit amet',
			'contact_p_o_box' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>