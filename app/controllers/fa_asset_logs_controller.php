<?php
class FaAssetLogsController extends AppController {

	var $name = 'FaAssetLogs';
	
	function index() {
		$fa_assets = $this->FaAssetLog->FaAsset->find('all');
		$this->set(compact('fa_assets'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$faasset_id = (isset($_REQUEST['faasset_id'])) ? $_REQUEST['faasset_id'] : -1;
		if($id)
			$faasset_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($faasset_id != -1) {
            $conditions['FaAssetLog.faasset_id'] = $faasset_id;
        }
		
		$this->set('faAssetLogs', $this->FaAssetLog->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FaAssetLog->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fa asset log', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FaAssetLog->recursive = 2;
		$this->set('faAssetLog', $this->FaAssetLog->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FaAssetLog->create();
			$this->autoRender = false;
			if ($this->FaAssetLog->save($this->data)) {
				$this->Session->setFlash(__('The fa asset log has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset log could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$fa_assets = $this->FaAssetLog->FaAsset->find('list');
		$this->set(compact('fa_assets'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fa asset log', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FaAssetLog->save($this->data)) {
				$this->Session->setFlash(__('The fa asset log has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset log could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fa__asset__log', $this->FaAssetLog->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$fa_assets = $this->FaAssetLog->FaAsset->find('list');
		$this->set(compact('fa_assets'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fa asset log', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FaAssetLog->delete($i);
                }
				$this->Session->setFlash(__('Fa asset log deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fa asset log was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FaAssetLog->delete($id)) {
				$this->Session->setFlash(__('Fa asset log deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fa asset log was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>