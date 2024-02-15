<?php
/* Children Test cases generated on: 2013-03-07 12:03:48 : 1362659568*/
App::import('Controller', 'Children');

class TestChildrenController extends ChildrenController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ChildrenControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.child', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language');

	function startTest() {
		$this->Children =& new TestChildrenController();
		$this->Children->constructClasses();
	}

	function endTest() {
		unset($this->Children);
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