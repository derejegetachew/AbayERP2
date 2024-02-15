<?php
/* CelebrationDays Test cases generated on: 2013-04-05 02:04:27 : 1365127467*/
App::import('Controller', 'CelebrationDays');

class TestCelebrationDaysController extends CelebrationDaysController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CelebrationDaysControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.celebration_day', 'app.budget_year');

	function startTest() {
		$this->CelebrationDays =& new TestCelebrationDaysController();
		$this->CelebrationDays->constructClasses();
	}

	function endTest() {
		unset($this->CelebrationDays);
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