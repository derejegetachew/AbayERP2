<?php
class FrwfmDocumentsController extends AppController {

	var $name = 'FrwfmDocuments';
	
	function index() {
		$frwfm_applications = $this->FrwfmDocument->FrwfmApplication->find('all');
		$this->set(compact('frwfm_applications'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$frwfmapplication_id = (isset($_REQUEST['frwfmapplication_id'])) ? $_REQUEST['frwfmapplication_id'] : -1;
		if($id)
			$frwfmapplication_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($frwfmapplication_id != -1) {
            $conditions['FrwfmDocument.frwfm_application_id'] = $frwfmapplication_id;
        }
		
		$this->set('frwfm_documents', $this->FrwfmDocument->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FrwfmDocument->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid frwfm document', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FrwfmDocument->recursive = 2;
		$this->set('frwfmDocument', $this->FrwfmDocument->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FrwfmDocument->create();
			$this->autoRender = false;
			$this->layout = 'ajax'; 
			
			//Attachment
			$file = $this->data['FrwfmDocument']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
            $fname = time(); // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

            if (!file_exists(FILES_DIR .DS. 'frwfm_attachments'))
                mkdir(FILES_DIR .DS. 'frwfm_attachments', 0777);

            if (!move_uploaded_file($file['tmp_name'], FILES_DIR .DS. 'frwfm_attachments' . DS . $file_name)) {
                $file_name = 'No file';
            }
            $this->data['FrwfmDocument']['file_path'] = $file_name;
			$this->data['FrwfmDocument']['name'] = $file['name'];
			
			if ($this->FrwfmDocument->save($this->data)) {
				$this->Session->setFlash(__('The attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$frwfm_applications = $this->FrwfmDocument->FrwfmApplication->find('list');
		$this->set(compact('frwfm_applications'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid frwfm document', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FrwfmDocument->save($this->data)) {
				$this->Session->setFlash(__('The frwfm document has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The frwfm document could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('frwfm__document', $this->FrwfmDocument->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$frwfm_applications = $this->FrwfmDocument->FrwfmApplication->find('list');
		$this->set(compact('frwfm_applications'));
	}
	function download($id=null){		
		$record=$this->FrwfmDocument->read(null, $id);
		pr($record);
		$file=FILES_DIR .DS. 'frwfm_attachments'. DS . $record['FrwfmDocument']['file_path'];
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['FrwfmDocument']['name'])));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
	
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for frwfm document', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FrwfmDocument->delete($i);
                }
				$this->Session->setFlash(__('Frwfm document deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Frwfm document was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FrwfmDocument->delete($id)) {
				$this->Session->setFlash(__('Frwfm document deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Frwfm document was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>