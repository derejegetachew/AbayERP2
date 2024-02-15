<?php
/* Experiences Test cases generated on: 2013-03-06 17:03:27 : 1362592107*/
App::import('Controller', 'Experiences');

class TestExperiencesController extends ExperiencesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExperiencesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.experience', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.education', 'app.employee_detail', 'app.language');

	function startTest() {
		$this->Experiences =& new TestExperiencesController();
		$this->Experiences->constructClasses();
	}

	function endTest() {
		unset($this->Experiences);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testIndex2() {

	}

	function testSearch() {

	}

	function testListDatum() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>