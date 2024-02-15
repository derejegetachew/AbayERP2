<?php
/* Scales Test cases generated on: 2013-02-21 16:02:16 : 1361464996*/
App::import('Controller', 'Scales');

class TestScalesController extends ScalesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ScalesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.scale', 'app.grade', 'app.position', 'app.step');

	function startTest() {
		$this->Scales =& new TestScalesController();
		$this->Scales->constructClasses();
	}

	function endTest() {
		unset($this->Scales);
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