<?php
/* EmployeeDetail Test cases generated on: 2013-03-06 17:03:37 : 1362592117*/
App::import('Model', 'EmployeeDetail');

class EmployeeDetailTestCase extends CakeTestCase {
	var $fixtures = array('app.employee_detail', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.education', 'app.experience', 'app.language', 'app.grade', 'app.position', 'app.scale', 'app.step');

	function startTest() {
		$this->EmployeeDetail =& ClassRegistry::init('EmployeeDetail');
	}

	function endTest() {
		unset($this->EmployeeDetail);
		ClassRegistry::flush();
	}

}
?>