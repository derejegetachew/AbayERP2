<?php
/* Holidays Test cases generated on: 2013-04-03 00:04:36 : 1364947296*/
App::import('Controller', 'Holidays');

class TestHolidaysController extends HolidaysController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HolidaysControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.holiday', 'app.employee', 'app.location', 'app.location_type', 'app.user', 'app.person', 'app.branch', 'app.bank', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language', 'app.offspring', 'app.leave_type', 'app.leave_rule');

	function startTest() {
		$this->Holidays =& new TestHolidaysController();
		$this->Holidays->constructClasses();
	}

	function endTest() {
		unset($this->Holidays);
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