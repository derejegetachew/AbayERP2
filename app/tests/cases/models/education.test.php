<?php
/* Education Test cases generated on: 2013-03-06 17:03:41 : 1362592061*/
App::import('Model', 'Education');

class EducationTestCase extends CakeTestCase {
	var $fixtures = array('app.education', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.employee_detail', 'app.experience', 'app.language');

	function startTest() {
		$this->Education =& ClassRegistry::init('Education');
	}

	function endTest() {
		unset($this->Education);
		ClassRegistry::flush();
	}

}
?>