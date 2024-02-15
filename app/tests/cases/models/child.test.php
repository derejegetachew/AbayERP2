<?php
/* Child Test cases generated on: 2013-03-07 11:03:07 : 1362654907*/
App::import('Model', 'Child');

class ChildTestCase extends CakeTestCase {
	var $fixtures = array('app.child', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language');

	function startTest() {
		$this->Child =& ClassRegistry::init('Child');
	}

	function endTest() {
		unset($this->Child);
		ClassRegistry::flush();
	}

}
?>