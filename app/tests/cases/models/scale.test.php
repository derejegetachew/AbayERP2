<?php
/* Scale Test cases generated on: 2013-02-21 16:02:11 : 1361463971*/
App::import('Model', 'Scale');

class ScaleTestCase extends CakeTestCase {
	var $fixtures = array('app.scale', 'app.grade', 'app.position', 'app.step');

	function startTest() {
		$this->Scale =& ClassRegistry::init('Scale');
	}

	function endTest() {
		unset($this->Scale);
		ClassRegistry::flush();
	}

}
?>