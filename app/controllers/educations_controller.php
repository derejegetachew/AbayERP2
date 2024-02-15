<?php

class EducationsController extends AppController {

    var $name = 'Educations';

    function index() {
        $employees = $this->Education->Employee->find('all');
        $this->set(compact('employees'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 10;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Education.employee_id'] = $employee_id;
        }

        $this->set('educations', $this->Education->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Education->find('count', array('conditions' => $conditions)));
    }

    function level_of_attainment($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Education.employee_id'] = $employee_id;
        }

        $this->set('educations', $this->Education->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'group' => 'level_of_attainment')));
        $this->set('results', $this->Education->find('count', array('conditions' => $conditions)));
    }

    function field_of_study($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Education.employee_id'] = $employee_id;
        }

        $this->set('educations', $this->Education->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'group' => 'field_of_study')));
        $this->set('results', $this->Education->find('count', array('conditions' => $conditions)));
    }
	
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
            $sort_col = array();
            foreach ($arr as $key => $row) {
                $sort_col[$key] = $row[$col];
            }

            array_multisort($sort_col, $dir, $arr);
    }
	function highlist(){
			$this->Education->updateAll(array('highest' => "0"));
            $this->autoRender = false;
			$this->loadModel('Employee');
            $this->Employee->recursive = 2;
            $employees = $this->Employee->find('all');
		$edulevel=array('10'=>1,'12'=>2,'Certificate'=>3,'101'=>3,'102'=>3,'103'=>6,'level1'=>3,'level2'=>3,'level3'=>3,'level4'=>10,'Diploma'=>11,'BA'=>12,'BSC'=>12,'LLB'=>12,'BED'=>12,'MA'=>13,'MSC'=>13,'MBA'=>13,'LLM'=>13,'PhD'=>14);
		
        foreach($employees as $employee){			
			 if(!empty($employee['Education'])){
			 $this->array_sort_by_column($employee['Education'], "date");
			 $edid=$employee['Education'][0]['id'];
			 $edhigh=0;
				foreach($employee['Education'] as $edus){
					if($edulevel[$edus['level_of_attainment']]>=$edhigh){
						$edhigh=$edulevel[$edus['level_of_attainment']];
						$edid=$edus['id'];
					}
				}
				$this->data['Education']['id']=$edid;
				$this->data['Education']['highest']=1;
				$this->Education->save($this->data);
			 }
		}
	}

    function institution($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
        if ($id)
            $employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($employee_id != -1) {
            $conditions['Education.employee_id'] = $employee_id;
        }

        $this->set('educations', $this->Education->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'group' => 'institution')));
        $this->set('results', $this->Education->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid education', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Education->recursive = 2;
        $this->set('education', $this->Education->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Education->create();
            $this->autoRender = false;
            if ($this->Education->save($this->data)) {
                $this->Session->setFlash(__('The education has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The education could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $employees = $this->Education->Employee->find('list');
        $this->set(compact('employees'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid education', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Education->save($this->data)) {
                $this->Session->setFlash(__('The education has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The education could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('education', $this->Education->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $employees = $this->Education->Employee->find('list');
        $this->set(compact('employees'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for education', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Education->delete($i);
                }
                $this->Session->setFlash(__('Education deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Education was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Education->delete($id)) {
                $this->Session->setFlash(__('Education deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Education was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>