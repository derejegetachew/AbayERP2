<?php
/* Educations Test cases generated on: 2013-03-06 17:03:42 : 1362592062*/
App::import('Controller', 'Educations');

class TestEducationsController extends EducationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EducationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.education', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.employee_detail', 'app.experience', 'app.language');

	function startTest() {
		$this->Educations =& new TestEducationsController();
		$this->Educations->constructClasses();
	}

	function endTest() {
		unset($this->Educations);
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