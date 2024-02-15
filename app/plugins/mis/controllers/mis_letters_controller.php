<?php
class MisLettersController extends MisAppController {

	var $name = 'MisLetters';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->MisLetter->recursive = 2;
		$conditions['MisLetter.status <>'] = 'Completed';
		$this->set('mis_letters', $this->MisLetter->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->MisLetter->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mis letter', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->MisLetter->recursive = 2;
		$this->set('misLetter', $this->MisLetter->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->MisLetter->create();
			$this->autoRender = false;
			$this->layout = 'ajax'; 
			
			//Attachment
			$file = $this->data['MisLetter']['file'];
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
            $this->data['MisLetter']['file'] = $file_name;
			
			$user = $this->Session->read();
			$this->data['MisLetter']['created_by'] = $user['Auth']['User']['id'];
			
			$this->data['MisLetter']['status'] = 'created';
			
			if ($this->MisLetter->save($this->data)) {
				$this->Session->setFlash(__('The letter has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The letter could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		
		$count = 0;
		$value = $this->MisLetter->find('first',array('conditions' => array('MisLetter.ref_no LIKE' => date("Ymd").'%'),'order'=>'MisLetter.ref_no DESC'));
		if($value != null){
			$value = explode('/',$value['MisLetter']['ref_no']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mis letter', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			$this->layout = 'ajax'; 
			
			//Attachment
			$file = $this->data['MisLetter']['file'];
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
            $this->data['MisLetter']['file'] = $file_name;
			
			$user = $this->Session->read();
			$this->data['MisLetter']['created_by'] = $user['Auth']['User']['id'];			
			
			if ($this->MisLetter->save($this->data)) {
				$this->Session->setFlash(__('The mis letter has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The mis letter could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('mis_letter', $this->MisLetter->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mis letter', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->MisLetter->delete($i);
                }
				$this->Session->setFlash(__('Mis letter deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Mis letter was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->MisLetter->delete($id)) {
				$this->Session->setFlash(__('Mis letter deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Mis letter was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function download($id=null){	
		$this->autoRender = false;	
		$record=$this->MisLetter->read(null, $id);		
		
		$file=FILES_DIR . "mis_attachments" . DS . $record['MisLetter']['file'];
		
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
	
	function send($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for letter', true), '');
            $this->render('/elements/failure');
        }
        $letter = array('MisLetter' => array('id' => $id, 'status' => 'Branch Working'));
        if ($this->MisLetter->save($letter)) {
			
			$this->loadModel('MisLetterDetail');
			$conditionsMisLetterDetail = array('MisLetterDetail.mis_letter_id' => $id);
			$misLetterDetail = $this->MisLetterDetail->find('all', array('conditions' =>$conditionsMisLetterDetail));
			foreach ($misLetterDetail as $detail){
				$this->MisLetterDetail->read(null, $detail['MisLetterDetail']['id']);
				$this->MisLetterDetail->set('status', 'Sent to Branch');
				$this->MisLetterDetail->save();
			}
			
			
			$conditionsMisLetterDetail = array('MisLetterDetail.mis_letter_id' => $id);
			$misLetterDetail = $this->MisLetterDetail->find('all', array('fields' => array('DISTINCT MisLetterDetail.branch_id'),'conditions' =>$conditionsMisLetterDetail));
			
			foreach ($misLetterDetail as $detail){
				$this->loadModel('EmployeeDetail');
				//$this->EmployeeDetail->recursive = -1;
				$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);
				$conditionsEmpDetail = array('EmployeeDetail.branch_id' => $detail['MisLetterDetail']['branch_id'], 'EmployeeDetail.position_id' => $position, 'EmployeeDetail.end_date' => '0000-00-00');
				$employeeDetail = $this->EmployeeDetail->find('all', array('conditions' =>$conditionsEmpDetail));
				foreach($employeeDetail as $empDetail){
					if($empDetail['Employee']['status'] == 'active'){
						$sup_tel=$empDetail['Employee']['telephone'];
						$message=urlencode('Branch Operation and Resource Mobilization department has sent you a letter. Please respond on Abay ERP BORM letters form. for detail please call 0911254477 / 0913951663 / 0933527803 / 0934187447');
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					}
				}
			}
			
            $this->Session->setFlash(__('letter sent to branch', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('letter was not sent to branch', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function letterPrepared($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for letter', true), '');
            $this->render('/elements/failure');
        }
        $letter = array('MisLetter' => array('id' => $id, 'status' => 'Letter Prepared'));
        if ($this->MisLetter->save($letter)) {
			$user = $this->Session->read();
			$this->loadModel('MisLetterDetail');
			$this->MisLetterDetail->updateAll(array('MisLetterDetail.letter_prepared_by' => $user['Auth']['User']['id']), array('MisLetterDetail.mis_letter_id' => $id));
							
            $this->Session->setFlash(__('letter prepared successfully', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('letter was not prepared', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function completed($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for letter', true), '');
            $this->render('/elements/failure');
        }
        $letter = array('MisLetter' => array('id' => $id, 'status' => 'Completed'));
        if ($this->MisLetter->save($letter)) {
			$user = $this->Session->read();
			$this->loadModel('MisLetterDetail');
			$this->MisLetterDetail->updateAll(array('MisLetterDetail.completed_by' => $user['Auth']['User']['id']), array('MisLetterDetail.mis_letter_id' => $id));
		
            $this->Session->setFlash(__('letter completed successfully', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('letter was not completed', true), '');
            $this->render('/elements/failure');
        }
    }
}
?>