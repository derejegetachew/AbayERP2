<?php
class CmsAttachmentsController extends CmsAppController {

	var $name = 'CmsAttachments';
	
	function index() {
		$cms_replies = $this->CmsAttachment->CmsReply->find('all');
		$this->set(compact('cms_replies'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$cmsreply_id = (isset($_REQUEST['cmsreply_id'])) ? $_REQUEST['cmsreply_id'] : -1;
		if($id)
			$cmsreply_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($cmsreply_id != -1) {
            $conditions['CmsAttachment.cms_reply_id'] = $cmsreply_id;
        }
		
		$this->set('cms_attachments', $this->CmsAttachment->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CmsAttachment->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cms attachment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CmsAttachment->recursive = 2;
		$this->set('cmsAttachment', $this->CmsAttachment->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->CmsAttachment->create();
			$this->autoRender = false;
			$this->layout = 'ajax';  
			
			//Attachment
			$file = $this->data['CmsAttachment']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
            $fname = time(); // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

            if (!file_exists(FILES_DIR .DS. 'case_attachments'))
                mkdir(FILES_DIR .DS. 'case_attachments', 0777);

            if (!move_uploaded_file($file['tmp_name'], FILES_DIR .DS. 'case_attachments' . DS . $file_name)) {
                $file_name = 'No file';
            }
            $this->data['CmsAttachment']['file'] = $file_name;
			$this->data['CmsAttachment']['name'] = $file['name'];
			
			if ($this->CmsAttachment->save($this->data)) {
				$this->Session->setFlash(__('The attachment has been Uploaded', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The attachment could not be Uploaded. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$cms_replies = $this->CmsAttachment->CmsReply->find('list');
		$this->set(compact('cms_replies'));
	}
	
	function download($id=null){
 
		$record=$this->CmsAttachment->read(null, $id);
		$file=FILES_DIR.DS .  "case_attachments" . DS . $record['CmsAttachment']['file'];
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['CmsAttachment']['name'])));
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
	
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cms attachment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CmsAttachment->save($this->data)) {
				$this->Session->setFlash(__('The cms attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cms attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cms__attachment', $this->CmsAttachment->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$cms_replies = $this->CmsAttachment->CmsReply->find('list');
		$this->set(compact('cms_replies'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cms attachment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CmsAttachment->delete($i);
                }
				$this->Session->setFlash(__('Cms attachment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cms attachment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CmsAttachment->delete($id)) {
				$this->Session->setFlash(__('Cms attachment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cms attachment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>