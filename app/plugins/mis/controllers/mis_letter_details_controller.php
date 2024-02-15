<?php
class MisLetterDetailsController extends AppController {

	var $name = 'MisLetterDetails';
	
	function index() {
		$mis_letters = $this->MisLetterDetail->MisLetter->find('all');
		$this->set(compact('mis_letters'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
		$mis_letter = $this->MisLetterDetail->MisLetter->read(null, $id);
		$this->set(compact('mis_letter'));
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$misletter_id = (isset($_REQUEST['misletter_id'])) ? $_REQUEST['misletter_id'] : -1;
		if($id)
			$misletter_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($misletter_id != -1) {
            $conditions['MisLetterDetail.mis_letter_id'] = $misletter_id;
        }
		
		$this->MisLetterDetail->recursive = 2;
		$this->set('mis_letter_details', $this->MisLetterDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->MisLetterDetail->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$misletter_id = (isset($_REQUEST['misletter_id'])) ? $_REQUEST['misletter_id'] : -1;
		if($id)
			$misletter_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($misletter_id != -1) {
            $conditions['MisLetterDetail.mis_letter_id'] = $misletter_id;
        }
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
		$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		
		$conditions['MisLetterDetail.branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
		$conditions['MisLetterDetail.status'] = 'Sent to Branch';
		
		$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);

		if(in_array($emp_details['EmployeeDetail']['position_id'], $position)){
			$this->MisLetterDetail->recursive = 2;
			$this->set('mis_letter_details', $this->MisLetterDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('results', $this->MisLetterDetail->find('count', array('conditions' => $conditions)));
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mis letter detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->MisLetterDetail->recursive = 2;
		$this->set('misLetterDetail', $this->MisLetterDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->MisLetterDetail->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['MisLetterDetail']['created_by'] = $user['Auth']['User']['id'];			
			$this->data['MisLetterDetail']['status'] = 'created';
			
			
			
			if ($this->MisLetterDetail->save($this->data)) {
				$this->MisLetterDetail->MisLetter->id = $this->data['MisLetterDetail']['mis_letter_id'];
				$this->MisLetterDetail->MisLetter->saveField('status', 'On Process');

				//$this->MisLetterDetail->MisLetter->updateAll(array('MisLetter.status' => '"On Process"'), array('MisLetter.id' => $this->data['MisLetterDetail']['mis_letter_id	']));

				$this->Session->setFlash(__('The letter detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The  letter detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$mis_letters = $this->MisLetterDetail->MisLetter->find('list');		
		$this->MisLetterDetail->Branch->recursive = 0;
		$conditions = array('Branch.branch_category_id' =>1);
		$branches = $this->MisLetterDetail->Branch->find('all', array('conditions' =>$conditions));
		$this->set(compact('mis_letters', 'branches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mis letter detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->MisLetterDetail->save($this->data)) {
				$this->Session->setFlash(__('The mis letter detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The mis letter detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('mis_letter_detail', $this->MisLetterDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$mis_letters = $this->MisLetterDetail->MisLetter->find('list');
		$this->MisLetterDetail->Branch->recursive = 0;
		$conditions = array('Branch.branch_category_id' =>1);
		$branches = $this->MisLetterDetail->Branch->find('all', array('conditions' =>$conditions));
		$this->set(compact('mis_letters', 'branches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mis letter detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->MisLetterDetail->delete($i);
                }
				$this->Session->setFlash(__('Mis letter detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Mis letter detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->MisLetterDetail->delete($id)) {
				$this->Session->setFlash(__('Mis letter detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Mis letter detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function reply($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mis letter detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->layout = 'ajax'; 
			
			$user = $this->Session->read();
			$this->data['MisLetterDetail']['replied_by'] = $user['Auth']['User']['id'];
			$this->data['MisLetterDetail']['status'] = 'replied';
			
			//Attachment
			$file = $this->data['MisLetterDetail']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
			//$fname = time(); old time
			$milliseconds = round(microtime(true) * 1000);
            $fname = $milliseconds; // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

            if (!file_exists(FILES_DIR .DS. 'mis_attachments'))
                mkdir(FILES_DIR .DS. 'mis_attachments', 0777);

            if (!move_uploaded_file($file['tmp_name'], FILES_DIR .DS. 'mis_attachments' . DS . $file_name)) {
                $file_name = 'No file';
            }
            $this->data['MisLetterDetail']['file'] = $file_name;
			
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['MisLetterDetail']['remark']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			
			$this->data['MisLetterDetail']['remark'] = $content;

			if ($this->MisLetterDetail->save($this->data)) {
			
				$conditions =array('MisLetterDetail.mis_letter_id' => $this->data['MisLetterDetail']['mis_letter_id'], 'MisLetterDetail.status' => 'created');
				$letterDetail = $this->MisLetterDetail->find('all', array('conditions' => $conditions));
				
				if(empty($letterDetail)){
					$this->MisLetterDetail->MisLetter->id = $this->data['MisLetterDetail']['mis_letter_id'];
					$this->MisLetterDetail->MisLetter->saveField('status', 'Branch Replied');
				}
				
				$this->Session->setFlash(__('The mis letter detail has been replied', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The mis letter detail could not be replied. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('mis_letter_detail', $this->MisLetterDetail->read(null, $id));
			
		$mis_letters = $this->MisLetterDetail->MisLetter->find('list');
		$branches = $this->MisLetterDetail->Branch->find('list');
		$this->set(compact('mis_letters', 'branches'));
	}
	
	function download($id=null){	
		$this->autoRender = false;	
		$record=$this->MisLetterDetail->read(null, $id);		
		
		$file=FILES_DIR . "mis_attachments" . DS . $record['MisLetterDetail']['file'];
		
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
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
}
?>