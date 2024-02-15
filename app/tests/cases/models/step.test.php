<?php
/* Step Test cases generated on: 2013-02-21 16:02:21 : 1361463921*/
App::import('Model', 'Step');

class StepTestCase extends CakeTestCase {
	var $fixtures = array('app.step', 'app.scale');

	function startTest() {
		$this->Step =& ClassRegistry::init('Step');
	}

	function endTest() {
		unset($this->Step);
		ClassRegistry::flush();
	}

}
?>