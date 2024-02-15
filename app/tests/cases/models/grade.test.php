<?php
/* Grade Test cases generated on: 2013-02-21 16:02:48 : 1361463948*/
App::import('Model', 'Grade');

class GradeTestCase extends CakeTestCase {
	var $fixtures = array('app.grade', 'app.position', 'app.scale');

	function startTest() {
		$this->Grade =& ClassRegistry::init('Grade');
	}

	function endTest() {
		unset($this->Grade);
		ClassRegistry::flush();
	}

}
?>