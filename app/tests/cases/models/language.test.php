<?php
/* Language Test cases generated on: 2013-03-06 17:03:07 : 1362592087*/
App::import('Model', 'Language');

class LanguageTestCase extends CakeTestCase {
	var $fixtures = array('app.language', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.education', 'app.employee_detail', 'app.experience');

	function startTest() {
		$this->Language =& ClassRegistry::init('Language');
	}

	function endTest() {
		unset($this->Language);
		ClassRegistry::flush();
	}

}
?>