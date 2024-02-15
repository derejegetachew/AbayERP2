<?php
/* CelebrationDay Test cases generated on: 2013-04-05 02:04:26 : 1365127466*/
App::import('Model', 'CelebrationDay');

class CelebrationDayTestCase extends CakeTestCase {
	var $fixtures = array('app.celebration_day', 'app.budget_year');

	function startTest() {
		$this->CelebrationDay =& ClassRegistry::init('CelebrationDay');
	}

	function endTest() {
		unset($this->CelebrationDay);
		ClassRegistry::flush();
	}

}
?>