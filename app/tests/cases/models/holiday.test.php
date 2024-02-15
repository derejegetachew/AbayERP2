<?php
/* Holiday Test cases generated on: 2013-03-28 07:03:55 : 1364457115*/
App::import('Model', 'Holiday');

class HolidayTestCase extends CakeTestCase {
	var $fixtures = array('app.holiday', 'app.employee', 'app.location', 'app.location_type', 'app.user', 'app.person', 'app.branch', 'app.bank', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language', 'app.offspring');

	function startTest() {
		$this->Holiday =& ClassRegistry::init('Holiday');
	}

	function endTest() {
		unset($this->Holiday);
		ClassRegistry::flush();
	}

}
?>