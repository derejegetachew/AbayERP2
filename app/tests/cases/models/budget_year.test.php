<?php
/* BudgetYear Test cases generated on: 2013-04-05 02:04:06 : 1365127446*/
App::import('Model', 'BudgetYear');

class BudgetYearTestCase extends CakeTestCase {
	var $fixtures = array('app.budget_year', 'app.celebration_day');

	function startTest() {
		$this->BudgetYear =& ClassRegistry::init('BudgetYear');
	}

	function endTest() {
		unset($this->BudgetYear);
		ClassRegistry::flush();
	}

}
?>