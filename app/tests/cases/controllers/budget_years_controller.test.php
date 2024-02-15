<?php
/* BudgetYears Test cases generated on: 2013-04-05 02:04:19 : 1365127459*/
App::import('Controller', 'BudgetYears');

class TestBudgetYearsController extends BudgetYearsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BudgetYearsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.budget_year', 'app.celebration_day');

	function startTest() {
		$this->BudgetYears =& new TestBudgetYearsController();
		$this->BudgetYears->constructClasses();
	}

	function endTest() {
		unset($this->BudgetYears);
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