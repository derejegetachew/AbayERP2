<?php
/* LeaveType Test cases generated on: 2013-04-03 00:04:42 : 1364947242*/
App::import('Model', 'LeaveType');

class LeaveTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.leave_type', 'app.holiday', 'app.employee', 'app.location', 'app.location_type', 'app.user', 'app.person', 'app.branch', 'app.bank', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language', 'app.offspring', 'app.leave_rule');

	function startTest() {
		$this->LeaveType =& ClassRegistry::init('LeaveType');
	}

	function endTest() {
		unset($this->LeaveType);
		ClassRegistry::flush();
	}

}
?>