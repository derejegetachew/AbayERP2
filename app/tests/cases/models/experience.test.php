<?php
/* Experience Test cases generated on: 2013-03-06 17:03:26 : 1362592106*/
App::import('Model', 'Experience');

class ExperienceTestCase extends CakeTestCase {
	var $fixtures = array('app.experience', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.education', 'app.employee_detail', 'app.language');

	function startTest() {
		$this->Experience =& ClassRegistry::init('Experience');
	}

	function endTest() {
		unset($this->Experience);
		ClassRegistry::flush();
	}

}
?>