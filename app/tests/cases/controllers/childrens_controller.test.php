<?php
/* Childrens Test cases generated on: 2013-03-06 18:03:14 : 1362593774*/
App::import('Controller', 'Childrens');

class TestChildrensController extends ChildrensController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ChildrensControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.children', 'app.employee', 'app.location', 'app.location_type', 'app.branch', 'app.bank', 'app.user', 'app.person', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.education', 'app.employee_detail', 'app.grade', 'app.position', 'app.scale', 'app.step', 'app.experience', 'app.language');

	function startTest() {
		$this->Childrens =& new TestChildrensController();
		$this->Childrens->constructClasses();
	}

	function endTest() {
		unset($this->Childrens);
		ClassRegistry::flush();
	}

	function testIndex() {

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