<?php
/* Employee Test cases generated on: 2013-03-07 11:03:33 : 1362654873*/
App::import('Model', 'Employee');

class EmployeeTestCase extends CakeTestCase {
	var $fixtures = array('app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.child', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language');

	function startTest() {
		$this->Employee =& ClassRegistry::init('Employee');
	}

	function endTest() {
		unset($this->Employee);
		ClassRegistry::flush();
	}

}
?>