<?php
/* Grades Test cases generated on: 2013-02-21 16:02:17 : 1361464877*/
App::import('Controller', 'Grades');

class TestGradesController extends GradesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class GradesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.grade', 'app.position', 'app.scale', 'app.step');

	function startTest() {
		$this->Grades =& new TestGradesController();
		$this->Grades->constructClasses();
	}

	function endTest() {
		unset($this->Grades);
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