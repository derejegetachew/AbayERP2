<?php
class OrmsLossDatasController extends OrmsAppController {

	var $name = 'OrmsLossDatas';
	
	function index() {
		$this->OrmsLossData->Branch->recursive = -1;
		$branches = $this->OrmsLossData->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index_1() {
		$this->OrmsLossData->Branch->recursive = -1;
		$branches = $this->OrmsLossData->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index_2() {
		$this->OrmsLossData->Branch->recursive = -1;
		$branches = $this->OrmsLossData->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	
	function index_risk_incident($id = null) {
		
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['OrmsLossData.branch_id'] = $branch_id;
        }
		$conditions['OrmsLossData.status'] = 'approved';
		$this->OrmsLossData->recursive = 2;
		$this->set('ormsLossDatas', $this->OrmsLossData->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OrmsLossData->find('count', array('conditions' => $conditions)));
	}
	
	function list_data1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['OrmsLossData.branch_id'] = $branch_id;
        }
		$user = $this->Session->read();
		$conditions['OrmsLossData.created_by'] = $user['Auth']['User']['id'];
		//$this->OrmsLossData->unbindModel(array('belongsTo' => array('Branch')), true);
		$this->OrmsLossData->recursive = 2;
		$this->set('ormsLossDatas', $this->OrmsLossData->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OrmsLossData->find('count', array('conditions' => $conditions)));
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['OrmsLossData.branch_id'] = $branch_id;
        }
		
		$user = $this->Session->read();
		$conditions['OrmsLossData.created_by <>'] = $user['Auth']['User']['id'];
		$conditions['OrmsLossData.status <>'] = 'created';		
		
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));		
		$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
			
		$users=array();
		foreach($employees as $employee){
			$emp = $this->Employee->read(null,$employee);
			$users[] = $emp['Employee']['user_id'];
		}
		$empcond=array("OR "=>array("OrmsLossData.created_by" => $users));
		$conditions = array_merge($empcond , $conditions);
		
		$this->OrmsLossData->recursive = 2;
		$this->set('ormsLossDatas', $this->OrmsLossData->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OrmsLossData->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid orms loss data', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->OrmsLossData->recursive = 2;
		$this->set('ormsLossData', $this->OrmsLossData->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->OrmsLossData->create();
			$this->autoRender = false;
			
			$user = $this->Session->read();
			$this->data['OrmsLossData']['created_by'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['OrmsLossData']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			
			$this->data['OrmsLossData']['status'] = 'created';
			
			if(empty($this->data['OrmsLossData']['occured_to'])){
				$this->data['OrmsLossData']['occured_to'] = Null;
			}
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['OrmsLossData']['description']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			// double quotes
            $content = ereg_replace('"','&quot;',$content);
			// slash
            $content = ereg_replace("/",'&#47;',$content);
			
			$this->data['OrmsLossData']['description'] = $content;
			
			if ($this->OrmsLossData->save($this->data)) {
				$this->Session->setFlash(__('The loss data has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The loss data could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->OrmsLossData->Branch->find('list');
		
		$orms_risk_categories = $this->OrmsLossData->OrmsRiskCategory->find('all',array('conditions'=>array('OrmsRiskCategory.parent_id' => 1)));
		$this->set(compact('branches', 'orms_risk_categories'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid orms loss data', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->OrmsLossData->save($this->data)) {
				$this->Session->setFlash(__('The loss data has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The loss data could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('orms_loss_data', $this->OrmsLossData->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->OrmsLossData->Branch->find('list');
		$orms_risk_categories = $this->OrmsLossData->OrmsRiskCategory->find('all',array('conditions'=>array('OrmsRiskCategory.parent_id' => 1)));
		
		$this->set(compact('branches', 'orms_risk_categories'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for loss data', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->OrmsLossData->delete($i);
                }
				$this->Session->setFlash(__('loss data deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('loss data was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->OrmsLossData->delete($id)) {
				$this->Session->setFlash(__('loss data deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('loss data was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function search_subcategory($id = null){
		
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		$category_id = (isset($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : -1;
		if($id)
			$category_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($category_id != -1) {
            $conditions['OrmsRiskCategory.parent_id'] = $category_id;
        }
		
		$this->set('subcategories', $this->OrmsLossData->OrmsRiskCategory->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OrmsLossData->OrmsRiskCategory->find('count', array('conditions' => $conditions)));
	}
	
	function search_risk($id = null){
		
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		$subcategory_id = (isset($_REQUEST['subcategory_id'])) ? $_REQUEST['subcategory_id'] : -1;
		if($id)
			$subcategory_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($subcategory_id != -1) {
            $conditions['OrmsRiskCategory.parent_id'] = $subcategory_id;
        }
		
		$this->set('risks', $this->OrmsLossData->OrmsRiskCategory->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OrmsLossData->OrmsRiskCategory->find('count', array('conditions' => $conditions)));
	}
	
	function getparent($childid = null){
		
		$childid = $this->params['childid'];
		
		$this->loadModel('OrmsRiskCategory'); 
		$conditions =array('OrmsRiskCategory.id' =>$childid);
		$this->OrmsRiskCategory->recursive = -1;
		$child = $this->OrmsRiskCategory->find('first', array('conditions' => $conditions));
		$parent = $this->OrmsRiskCategory->find('first', array('conditions' => array('OrmsRiskCategory.id' =>$child['OrmsRiskCategory']['parent_id'])));
		$parentmain = $this->OrmsRiskCategory->find('first', array('conditions' => array('OrmsRiskCategory.id' =>$parent['OrmsRiskCategory']['parent_id'])));
		return $parent['OrmsRiskCategory']['name'].'~'.$parentmain['OrmsRiskCategory']['name'].'~'.$parent['OrmsRiskCategory']['factor'];
	}
	
	function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for risk', true), '');
            $this->render('/elements/failure');
        }
        $risk = array('OrmsLossData' => array('id' => $id, 'status' => 'posted'));
        if ($this->OrmsLossData->save($risk)) {
            $this->Session->setFlash(__('Risk posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Risk was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approve($id = null) {
        $this->autoRender = false;
        if (!$this->data['OrmsLossData']['id']) {
            $this->Session->setFlash(__('Invalid id for risk', true), '');
            $this->render('/elements/failure');
        }
		
		$user = $this->Session->read();		
		
        $risk = array('OrmsLossData' => array('id' => $this->data['OrmsLossData']['id'], 'approved_by' => $user['Auth']['User']['id'],'status' => 'approved',
												'action_tobe_taken' =>$this->data['OrmsLossData']['action_tobe_taken'],'action_taken_date' =>$this->data['OrmsLossData']['action_taken_date']));
						
        if ($this->OrmsLossData->save($risk)) {
            $this->Session->setFlash(__('Risk successfully approved', true), '');
            $this->render('/elements/success');
        } else {

            $this->Session->setFlash(__('Risk was not successfully approved', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function reject($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for risk', true), '');
            $this->render('/elements/failure');
        }
		$user = $this->Session->read();	
        $risk = array('OrmsLossData' => array('id' => $id, 'approved_by' => $user['Auth']['User']['id'],'status' => 'rejected'));
        if ($this->OrmsLossData->save($risk)) {
            $this->Session->setFlash(__('Risk successfully rejected', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('Risk was not successfully rejected', true), '');
            $this->render('/elements/failure');
        }
    }
	
	function approverisk($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid orms loss data', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->OrmsLossData->recursive = 2;
		$this->set('orms_loss_data', $this->OrmsLossData->read(null, $id));
	}
	
	function risk_incident($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
			$fromdate=$this->data['OrmsLossData']['from'];
			$todate =$this->data['OrmsLossData']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			$date2 = str_replace('-', '/', $fromdate);
			$yesterday = date('Y-m-d',strtotime($date2 . "+1 days"));
			
			$this->loadModel('Branch'); 
			$this->Branch->recursive =-1;						 
			$branches = $this->Branch->find('all');
			$result = array();
			$brancharray = array();
			$count = 0;
			$branchName = '';
			for($j=0;$j<count($branches );$j++){
				$countbranchName = 0;
				$conditionsLossData =array('OrmsLossData.branch_id' => $branches[$j]['Branch']['id'],'OrmsLossData.status' => 'approved',
				'OrmsLossData.created >=' => $fromdate,'OrmsLossData.created <' => $tomorrow);
				$lossDatas = $this->OrmsLossData->find('all', array('conditions' => $conditionsLossData));
				foreach($lossDatas as $lossData){
					if($branches[$j]['Branch']['name'] != $branchName)
					{
						$result[$count][0] = $branches[$j]['Branch']['name'];
						$branchName = $branches[$j]['Branch']['name'];
					}
					else $result[$count][0] = '';
					$result[$count][1] = $lossData['OrmsLossData']['occured_from'].' - '.$lossData['OrmsLossData']['occured_to'];
					
					$risk = $this->requestAction(
							array(
								'controller' => 'orms_loss_datas', 
								'action' => 'getparent'), 
							array('childid' => $lossData['OrmsLossData']['orms_risk_category_id'])
						);
					$category = explode('~',$risk,3);
					$result[$count][2] = $category[1];
					$result[$count][3] = $category[0];
					$result[$count][4] = $lossData['OrmsRiskCategory']['name'];
					$result[$count][5] = $lossData['OrmsLossData']['description'];
					$result[$count][6] = $lossData['OrmsLossData']['severity'] * $lossData['OrmsLossData']['frequency'];
					$result[$count][7] = $category[2];
					$result[$count][8] = '';
					$result[$count][9] = $lossData['OrmsLossData']['insured_amount'];
					$result[$count][10] = $lossData['OrmsLossData']['action_tobe_taken'];
					$result[$count][11] = $lossData['OrmsLossData']['action_taken_date'];
					$date = date_create($lossData['OrmsLossData']['created']);
					$date = date_format($date,"M d, Y");
					$result[$count][12] = $date;
					
					$countbranchName++;
					$count++;
				}
				$brancharray[$branches[$j]['Branch']['name']] = $countbranchName;
			}
			
			$this->set('result',$result);			
			$this->set('brancharray',$brancharray);
		}
	}
}
?>