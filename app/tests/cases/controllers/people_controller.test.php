<?php
/* People Test cases generated on: 2013-03-07 13:03:44 : 1362663944*/
App::import('Controller', 'People');

class TestPeopleController extends PeopleController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PeopleControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.person', 'app.location', 'app.location_type', 'app.user', 'app.branch', 'app.bank', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user');

	function startTest() {
		$this->People =& new TestPeopleController();
		$this->People->constructClasses();
	}

	function endTest() {
		unset($this->People);
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