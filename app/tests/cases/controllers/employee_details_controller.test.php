<?php
/* EmployeeDetails Test cases generated on: 2013-03-06 17:03:39 : 1362592119*/
App::import('Controller', 'EmployeeDetails');

class TestEmployeeDetailsController extends EmployeeDetailsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EmployeeDetailsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.employee_detail', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.children', 'app.education', 'app.experience', 'app.language', 'app.grade', 'app.position', 'app.scale', 'app.step');

	function startTest() {
		$this->EmployeeDetails =& new TestEmployeeDetailsController();
		$this->EmployeeDetails->constructClasses();
	}

	function endTest() {
		unset($this->EmployeeDetails);
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