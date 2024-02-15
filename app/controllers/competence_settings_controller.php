<?php
class CompetenceSettingsController extends AppController {

	var $name = 'CompetenceSettings';
	
	function index() {
		$grades = $this->CompetenceSetting->Grade->find('all');
		$this->set(compact('grades'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$grade_id = (isset($_REQUEST['grade_id'])) ? $_REQUEST['grade_id'] : -1;
		if($id)
			$grade_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grade_id != -1) {
            $conditions['CompetenceSetting.grade_id'] = $grade_id;
        }
		
		$this->set('competenceSettings', $this->CompetenceSetting->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CompetenceSetting->find('count', array('conditions' => $conditions)));
	
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence setting', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompetenceSetting->recursive = 2;
		$this->set('competenceSetting', $this->CompetenceSetting->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {

			$original_data = $this->data;
			
			$setting_grade_id = $original_data['CompetenceSetting']['grade_id'];
			$setting_competence_id = $original_data['CompetenceSetting']['competence_id'];
			$setting_weight = $original_data['CompetenceSetting']['weight'];

			$weight_row = $this->CompetenceSetting->query('select sum(weight) as sum_weight from competence_settings
			 where grade_id = '.$setting_grade_id );

			$sum_weight = $weight_row[0][0]['sum_weight'];
			$total_weight = $sum_weight + $setting_weight;

			if($total_weight <= 10){

				$settings_row = $this->CompetenceSetting->query("select * from competence_settings where grade_id = ".$setting_grade_id." and competence_id = ".$setting_competence_id."");
			
				if(count($settings_row) == 0) {
					$this->CompetenceSetting->create();
					$this->autoRender = false;
					if ($this->CompetenceSetting->save($this->data)) {
						$this->Session->setFlash(__('The competence setting has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The competence setting could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				} else {
	
					$this->Session->setFlash(__('The setting has already been saved.', true), '');
					$this->render('/elements/failure3');
	
				}
			}
			else{
				$this->Session->setFlash(__('The weight has exceeded 10 for the grade.', true), '');
				$this->render('/elements/failure3');
			}
			
	
			
		}
		if($id)
			$this->set('parent_id', $id);
		$grades = $this->CompetenceSetting->Grade->find('list');
		$competences = $this->CompetenceSetting->Competence->find('list');
		$this->loadModel('CompetenceLevel');
		//$this->CompetenceLevel->recursive=1;
		//$this->User->recursive=0;
		$competence_levels = $this->CompetenceLevel->find('list');
		$this->set(compact('grades', 'competences', 'competence_levels'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence setting', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$setting_id = $original_data['CompetenceSetting']['id'];
			$setting_grade_id = $original_data['CompetenceSetting']['grade_id'];
			$setting_competence_id = $original_data['CompetenceSetting']['competence_id'];
			$setting_weight = $original_data['CompetenceSetting']['weight'];

			$weight_row = $this->CompetenceSetting->query('select sum(weight) as sum_weight from competence_settings
			 where grade_id = '.$setting_grade_id.' and id != '.$setting_id );

			$sum_weight = $weight_row[0][0]['sum_weight'];
			$total_weight = $sum_weight + $setting_weight;

			if($total_weight <= 10){
				$settings_row = $this->CompetenceSetting->query("select * from competence_settings where id != ".$setting_id." and grade_id = ".$setting_grade_id." and competence_id = ".$setting_competence_id."");
			
				if(count($settings_row) == 0) {
					$this->autoRender = false;
					if ($this->CompetenceSetting->save($this->data)) {
						$this->Session->setFlash(__('The competence setting has been saved', true), '');
						$this->render('/elements/success');
					} else {
						$this->Session->setFlash(__('The competence setting could not be saved. Please, try again.', true), '');
						$this->render('/elements/failure');
					}
				}else{
					$this->Session->setFlash(__('The setting has already been saved.', true), '');
					$this->render('/elements/failure3');
	
				}
			}
			else {
				$this->Session->setFlash(__('The total weight has exceeded 10.', true), '');
					$this->render('/elements/failure3');
			}

			
			
		}
		$this->set('competence_setting', $this->CompetenceSetting->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$grades = $this->CompetenceSetting->Grade->find('list');
		$competences = $this->CompetenceSetting->Competence->find('list');
		$this->loadModel('CompetenceLevel');
		//$this->CompetenceLevel->recursive=1;
		//$this->User->recursive=0;
		$competence_levels = $this->CompetenceLevel->find('list');
		$this->set(compact('grades', 'competences', 'competence_levels'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence setting', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CompetenceSetting->delete($i);
                }
				$this->Session->setFlash(__('Competence setting deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence setting was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CompetenceSetting->delete($id)) {
				$this->Session->setFlash(__('Competence setting deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Competence setting was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>