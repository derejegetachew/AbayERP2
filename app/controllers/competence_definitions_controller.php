<?php
class CompetenceDefinitionsController extends AppController {

	var $name = 'CompetenceDefinitions';
	
	function index() {
		$competences = $this->CompetenceDefinition->Competence->find('all');
		$this->set(compact('competences'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$competence_id = (isset($_REQUEST['competence_id'])) ? $_REQUEST['competence_id'] : -1;
		if($id)
			$competence_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($competence_id != -1) {
            $conditions['CompetenceDefinition.competence_id'] = $competence_id;
        }
		
		$this->set('competenceDefinitions', $this->CompetenceDefinition->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CompetenceDefinition->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence definition', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompetenceDefinition->recursive = 2;
		$this->set('competenceDefinition', $this->CompetenceDefinition->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			
			$definition_competence_id = $original_data['CompetenceDefinition']['competence_id'];
			$definition_level_id = $original_data['CompetenceDefinition']['competence_level_id'];
			$definition = str_replace("'", "`", $original_data['CompetenceDefinition']['definition']);
      $definition = str_replace('"', "`", $definition);
      $definition = str_replace(',', " ", $definition);
			$original_data['CompetenceDefinition']['definition'] = $definition;
			
			$definitions_row = $this->CompetenceDefinition->query("select * from competence_definitions where competence_level_id = ".$definition_level_id." and competence_id = ".$definition_competence_id."");
			
			if(count($definitions_row) == 0) { 
				$this->CompetenceDefinition->create();
				$this->autoRender = false;
			//	if ($this->CompetenceDefinition->save($this->data)) {
				if ($this->CompetenceDefinition->save($original_data)) {
					$this->Session->setFlash(__('The competence definition has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence definition could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			} else {
				$this->Session->setFlash(__('The definition has already been saved.', true), '');
				$this->render('/elements/failure3');
				
			}
			
		}
		if($id)
			$this->set('parent_id', $id);
		$competences = $this->CompetenceDefinition->Competence->find('list');
		$competence_levels = $this->CompetenceDefinition->CompetenceLevel->find('list');
		$this->set(compact('competences', 'competence_levels'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence definition', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$definition_id = $original_data['CompetenceDefinition']['id'];
			$definition_competence_id = $original_data['CompetenceDefinition']['competence_id'];
			$definition_level_id = $original_data['CompetenceDefinition']['competence_level_id'];
			$definition = str_replace("'", "`", $original_data['CompetenceDefinition']['definition']);
      $definition = str_replace('"', "`", $definition);
      $definition = str_replace(',', " ", $definition);
			$original_data['CompetenceDefinition']['definition'] = $definition;
			
			$definitions_row = $this->CompetenceDefinition->query("select * from competence_definitions where id != ".$definition_id." and competence_level_id = ".$definition_level_id." and competence_id = ".$definition_competence_id."");
			
			if(count($definitions_row) == 0) {
				$this->autoRender = false;
				if ($this->CompetenceDefinition->save($this->data)) {
					$this->Session->setFlash(__('The competence definition has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence definition could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			 } else {
				$this->Session->setFlash(__('The definition has already been saved.', true), '');
				$this->render('/elements/failure3');
			}
			
		}
		$this->set('competence_definition', $this->CompetenceDefinition->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$competences = $this->CompetenceDefinition->Competence->find('list');
		$competence_levels = $this->CompetenceDefinition->CompetenceLevel->find('list');
		$this->set(compact('competences', 'competence_levels'));
		
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence definition', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CompetenceDefinition->delete($i);
                }
				$this->Session->setFlash(__('Competence definition deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence definition was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CompetenceDefinition->delete($id)) {
				$this->Session->setFlash(__('Competence definition deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Competence definition was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>