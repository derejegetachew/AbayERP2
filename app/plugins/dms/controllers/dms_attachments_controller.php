<?php
class DmsAttachmentsController extends AppController {

	var $name = 'DmsAttachments';
	
	function index() {
		//$dms_messages = $this->DmsAttachment->DmsMessage->find('all');
		//$this->set(compact('dms_messages'));
	}
	
	function index2($id = null) {
		$user = $this->Session->read();
		$this->Session->delete('Person.messatt');
		if($id==0)
		if($this->Session->read('Person.messatt')==null)
			$this->Session->write('Person.messatt', $user['Auth']['User']['id'].'000000');
		
		$id=$this->Session->read('Person.messatt');
	
	
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$dmsmessage_id = (isset($_REQUEST['dmsmessage_id'])) ? $_REQUEST['dmsmessage_id'] : -1;
		if($id)
			$dmsmessage_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($dmsmessage_id != -1) {
            $conditions['DmsAttachment.dms_message_id'] = $dmsmessage_id;
        }
		
		$this->set('dms_attachments', $this->DmsAttachment->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->DmsAttachment->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms attachment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsAttachment->recursive = 2;
		$this->set('dmsAttachment', $this->DmsAttachment->read(null, $id));
	}

	function add($id = null) {
		
		if (!empty($this->data)) {
			$this->DmsAttachment->create();
			$this->autoRender = false;
			$this->layout = 'ajax'; 
			
			//Attachment
			$file = $this->data['DmsAttachment']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
			//$fname = time(); old time
			$milliseconds = round(microtime(true) * 1000);
            $fname = $milliseconds; // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

            if (!file_exists(FILES_DIR .DS. 'message_attachments'))
                mkdir(FILES_DIR .DS. 'message_attachments', 0777);

            if (!move_uploaded_file($file['tmp_name'], FILES_DIR .DS. 'message_attachments' . DS . $file_name)) {
                $file_name = 'No file';
            }
            $this->data['DmsAttachment']['file'] = $file_name;
			$this->data['DmsAttachment']['name'] = $file['name'];
			
			if ($this->DmsAttachment->save($this->data)) {
				$this->Session->setFlash(__('The attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		
		//$dms_messages = $this->DmsAttachment->DmsMessage->find('list');
		//$this->set(compact('dms_messages'));
	}
	function sendupload($parent = null) {

		if (isset($_FILES['Filedata'])){
		if(isset($_FILES['message_id']))
			$_REQUEST['message_id']=$_FILES['message_id'];

			$user_id=$_REQUEST['user_id'];
		$this->autoRender = false;
			//upload file
			$file=$_FILES['Filedata'];
			 if (isset($file)) {
				if (!is_dir(FILES_DIR .DS. "message_attachments"))
                                mkdir(FILES_DIR.DS. "message_attachments", 0777);
							$extension = end(explode(".", $file["name"]));
											
							$this->data['DmsAttachment']['name'] = $file["name"];							
							$this->data['DmsAttachment']['dms_message_id'] = $_REQUEST['message_id'];
							$key = md5(microtime().rand());
							$this->data['DmsAttachment']['file'] = $key.'.'.$extension; 
                            $file["name"] = $key.'.'.$extension;
                            move_uploaded_file($file["tmp_name"], FILES_DIR.DS . "message_attachments" . DS . $file["name"]);
							$this->DmsAttachment->create();
							$this->DmsAttachment->save($this->data);
							echo '{"success":true}';
					
				}
		
			
		}
		$this->set('message_id',$parent);
		$user = $this->Session->read();
		$this->set('user_id',$user['Auth']['User']['id']);
			
	}
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms attachment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DmsAttachment->save($this->data)) {
				$this->Session->setFlash(__('The dms attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('dms__attachment', $this->DmsAttachment->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$dms_messages = $this->DmsAttachment->DmsMessage->find('list');
		$this->set(compact('dms_messages'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms attachment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DmsAttachment->delete($i);
                }
				$this->Session->setFlash(__('Dms attachment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms attachment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DmsAttachment->delete($id)) {
				$this->Session->setFlash(__('Dms attachment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms attachment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function download($id=null){	

		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		$this->autoRender = false;	
		$record=$this->DmsAttachment->read(null, $id);
		
		$this->loadModel('DmsRecipient');
		$this->DmsRecipient->recursive=-1;
		$conditions['DmsRecipient.dms_message_id'] = $record['DmsMessage']['id'];
		$conditions['DmsRecipient.user_id'] = $user_id;      
		$rr= $this->DmsRecipient->find('all', array('conditions' => $conditions));
		if(count($rr)>0 || $record['DmsMessage']['user_id']==$user_id){
		//pr($record);
		/*$file=FILES_DIR.DS . "message_attachments" . DS . $record['DmsAttachment']['file'];
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['DmsAttachment']['name'])));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}*/
		
		$file=FILES_DIR.DS . "message_attachments" . DS . $record['DmsAttachment']['file'];
		$modules = apache_get_modules();
		$record['DmsAttachment']['name'] = str_replace(array('"', "'", ' ', ','), '_', $record['DmsAttachment']['name']);
		if (in_array('mod_xsendfile', $modules)) {
		//header('Location: http://10.1.85.11/erpdownload.php?file='.$file.'&name='.);		
		header ('X-Sendfile: '.$file);
		header('Content-Type: application/octet-stream',true);
		header('Content-Disposition: attachment; filename="'.basename(str_replace(' ','-',$record['DmsAttachment']['name'])).'"');
		exit;			
		}else{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream',true);
			header('Content-Disposition: attachment; filename="'.basename(str_replace(' ','_',$record['DmsAttachment']['name'])).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
		
	}else
		echo "Permisssion Denied!";
	}
	function backup(){
		$this->DmsAttachment->recursive=0;
		$x=$this->DmsAttachment->find('all', array('limit' => 50000, 'offset' => 550000));
		foreach($x as $fils){
			$file=FILES_DIR. DS . "message_attachments" . DS . $fils['DmsAttachment']['file'];
			$cpfile="D:\bc_attachments" . DS . $fils['DmsAttachment']['file'];
			if (!copy($file, $cpfile)) {
				echo "failed to copy $file...\n";
			}else
				unlink($file) or die("Couldn't delete file");
		}
	}
}
?>