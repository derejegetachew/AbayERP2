<?php
/* Positions Test cases generated on: 2013-02-21 16:02:04 : 1361464984*/
App::import('Controller', 'Positions');

class TestPositionsController extends PositionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PositionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.position', 'app.grade', 'app.scale', 'app.step');

	function startTest() {
		$this->Positions =& new TestPositionsController();
		$this->Positions->constructClasses();
	}

	function endTest() {
		unset($this->Positions);
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