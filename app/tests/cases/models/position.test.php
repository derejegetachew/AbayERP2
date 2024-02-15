<?php
/* Position Test cases generated on: 2013-02-21 16:02:03 : 1361463963*/
App::import('Model', 'Position');

class PositionTestCase extends CakeTestCase {
	var $fixtures = array('app.position', 'app.grade', 'app.scale');

	function startTest() {
		$this->Position =& ClassRegistry::init('Position');
	}

	function endTest() {
		unset($this->Position);
		ClassRegistry::flush();
	}

}
?>