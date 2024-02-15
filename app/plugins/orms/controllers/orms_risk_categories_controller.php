<?php
class OrmsRiskCategoriesController extends ormsAppController {

	var $name = 'OrmsRiskCategories';
	
	function index() {
		
	}
	
	function search() {
	}
	
	function list_data($id = null) {		
		$risk_categories = $this->OrmsRiskCategory->find('all', array('order' => 'OrmsRiskCategory.lft ASC'));
        $tree_data = array();
        if(count($risk_categories) > 0) {
            $tree_data = array($this->__getTreeArray($risk_categories[0], $risk_categories));
        }
        $this->set('risk_categories', $tree_data);
	}
	
	function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array('id' => $node['OrmsRiskCategory']['id'], 'name' => $node['OrmsRiskCategory']['name'], 'children' => array());
        $children = $this->__getChildNodes($node['OrmsRiskCategory']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['OrmsRiskCategory']['parent_id'] == $p_id) {
                $ret[] = $ad;
            }
        }
        return $ret;
    }

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid orms risk category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->OrmsRiskCategory->recursive = 2;
		$this->set('ormsRiskCategory', $this->OrmsRiskCategory->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->OrmsRiskCategory->create();
			$this->autoRender = false;
			if ($this->OrmsRiskCategory->save($this->data)) {
				$this->Session->setFlash(__('The risk category has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The risk category could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);		
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid risk category', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->OrmsRiskCategory->save($this->data)) {
				$this->Session->setFlash(__('The risk category has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The risk category could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('risk_category', $this->OrmsRiskCategory->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
	}

	function delete($id = null) {
		$this->autoRender = false;
		$this->loadModel('OrmsRisk');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for risk category', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
				$msg = '';
                foreach ($ids as $i) {
                    $conditions['OrmsRisk.orms_risk_category_id'] = $i;
					if($this->OrmsRiskCategory->OrmsRisk->find('count', array('conditions' => $conditions)) == 0){  
							$this->OrmsRiskCategory->delete($i);
					} else {
						$riskCat = $this->OrmsRiskCategory->read(null,$i);
						$msg .= $riskCat['OrmsRiskCategory']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('Risk category deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have Risk(s), Following Risk categories were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('Risk category was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
            $conditions['OrmsRisk.orms_risk_category_id'] = $id;
			if($this->OrmsRiskCategory->OrmsRisk->find('count', array('conditions' => $conditions)) == 0){
				if ($this->OrmsRiskCategory->delete($id)) {
					$this->Session->setFlash(__('Risk category deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Risk category was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('Risk category was not deleted because it has Risk(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
	}
}
?>