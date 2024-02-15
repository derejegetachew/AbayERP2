<?php
/* LeaveRule Test cases generated on: 2013-04-03 00:04:20 : 1364947280*/
App::import('Model', 'LeaveRule');

class LeaveRuleTestCase extends CakeTestCase {
	var $fixtures = array('app.leave_rule', 'app.leave_type', 'app.holiday', 'app.employee', 'app.location', 'app.location_type', 'app.user', 'app.person', 'app.branch', 'app.bank', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language', 'app.offspring');

	function startTest() {
		$this->LeaveRule =& ClassRegistry::init('LeaveRule');
	}

	function endTest() {
		unset($this->LeaveRule);
		ClassRegistry::flush();
	}

}
?>