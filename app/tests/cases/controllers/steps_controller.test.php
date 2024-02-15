<?php
/* Steps Test cases generated on: 2013-02-21 16:02:30 : 1361464890*/
App::import('Controller', 'Steps');

class TestStepsController extends StepsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StepsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.step', 'app.scale', 'app.grade', 'app.position');

	function startTest() {
		$this->Steps =& new TestStepsController();
		$this->Steps->constructClasses();
	}

	function endTest() {
		unset($this->Steps);
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