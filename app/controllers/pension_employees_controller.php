<?php
class PensionEmployeesController extends AppController {

	var $name = 'PensionEmployees';
	


	function edit($id = null, $parent_id = null) {
		if (!empty($this->data)) {
                     if(isset($this->data['PensionEmployee']['id']))
                            $this->PensionEmployee->create();

			$this->autoRender = false;
			if ($this->PensionEmployee->save($this->data)) {
				$this->Session->setFlash(__('The pension employee has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The pension employee could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		//$this->set('pension__employee', $this->PensionEmployee->read(null, $id));

		$this->PensionEmployee->recursive=3;
                $pension_employee=$this->PensionEmployee->findByemployee_id( $id);	
		$pensions = $this->PensionEmployee->Pension->find('list',array('conditions'=>array('Pension.payroll_id'=>$this->Session->read('Auth.User.payroll_id'),'Pension.status'=>'active')));
                $employee=$this->PensionEmployee->Employee->read(null, $id); 
		//$employees = $this->PensionEmployee->Employee->find('list');
		$this->set(compact('pensions','employee','pension_employee'));
	}

	
}
?>