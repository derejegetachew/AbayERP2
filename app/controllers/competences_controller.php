<?php
class CompetencesController extends AppController {

	var $name = 'Competences';
	
	function index() {
		$competence_categories = $this->Competence->CompetenceCategory->find('all');
		$this->set(compact('competence_categories'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$competencecategory_id = (isset($_REQUEST['competencecategory_id'])) ? $_REQUEST['competencecategory_id'] : -1;
		if($id)
			$competencecategory_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($competencecategory_id != -1) {
            $conditions['Competence.competencecategory_id'] = $competencecategory_id;
        }
		
		$this->set('competences', $this->Competence->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Competence->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid competence', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Competence->recursive = 2;
		$this->set('competence', $this->Competence->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {

			$original_data = $this->data;
			$competence_name = str_replace("'", "`", $original_data['Competence']['name']);
      $competence_name = str_replace('"', "`", $competence_name);
      $competence_name = str_replace(',', " ", $competence_name);
			$competence_definition = str_replace("'", "`", $original_data['Competence']['definition']);
      $competence_definition = str_replace('"', "`", $competence_definition);
      $competence_definition = str_replace(',', " ", $competence_definition);
			$original_data['Competence']['name'] = $competence_name;
			$original_data['Competence']['definition'] = $competence_definition;

			$conditions = array('Competence.name' => $competence_name );
			$competence = $this->Competence->find('all', array('conditions' => $conditions )); 
			if(count($competence) == 0) {
				$this->Competence->create();
				$this->autoRender = false;
	
				
			//	if ($this->Competence->save($this->data)) {
				if ($this->Competence->save($original_data)) {
					$this->Session->setFlash(__('The competence has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('The competence has already been saved.', true), '');
					$this->render('/elements/failure3');
			}

			
		}
		if($id)
			$this->set('parent_id', $id);
		$competence_categories = $this->Competence->CompetenceCategory->find('list');
		$this->set(compact('competence_categories'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid competence', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$competence_id = $original_data['Competence']['id'];
			$competence_name = str_replace("'", "`", $original_data['Competence']['name']);
      $competence_name = str_replace('"', "`", $competence_name);
      $competence_name = str_replace(',', " ", $competence_name);
			$competence_definition = str_replace("'", "`", $original_data['Competence']['definition']);
      $competence_definition = str_replace('"', "`", $competence_definition);
      $competence_definition = str_replace(',', " ", $competence_definition);

			$original_data['Competence']['name'] = $competence_name;
			$original_data['Competence']['definition'] = $competence_definition;

			$competence_row = $this->Competence->query("select * from competences where id != ". $competence_id ." and name = '".$competence_name."'");
			
			if(count($competence_row) == 0) {
				$this->autoRender = false;
			//	if ($this->Competence->save($this->data)) {
				if ($this->Competence->save($original_data)) {
					
					$this->Session->setFlash(__('The competence has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The competence could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			} else{
				$this->Session->setFlash(__('The competence has already been saved.', true), '');
				$this->render('/elements/failure3');
			}

			
		}
		$this->set('competence', $this->Competence->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$competence_categories = $this->Competence->CompetenceCategory->find('list');
		$this->set(compact('competence_categories'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for competence', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Competence->delete($i);
                }
				$this->Session->setFlash(__('Competence deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Competence was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Competence->delete($id)) {
				$this->Session->setFlash(__('Competence deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Competence was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>