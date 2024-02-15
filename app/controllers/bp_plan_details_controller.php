<?php
class BpPlanDetailsController extends AppController {

	var $name = 'BpPlanDetails';
	
	function index() {
		$bp_items = $this->BpPlanDetail->BpItem->find('all');
		$this->set(compact('bp_items'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 1000;
		$bpitem_id = (isset($_REQUEST['bpitem_id'])) ? $_REQUEST['bpitem_id'] : -1;
		if($id)
			$bpitem_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($bpitem_id != -1) {
            $conditions['BpPlanDetail.bp_plan_id'] = $bpitem_id;
        }
		
		//var_dump($id);
		$this->set('bp_plan_details', $this->BpPlanDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlanDetail->find('count', array('conditions' => $conditions)));
	}
	function list_data1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 1000;
		$bpitem_id = (isset($_REQUEST['bpitem_id'])) ? $_REQUEST['bpitem_id'] : -1;
		if($id)
			$bpitem_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($bpitem_id != -1) {
            $conditions['BpPlanDetail.bp_plan_id'] = $bpitem_id;
        }
		
		$cmd=" select  pd.month,it.name,pd.bp_item_id as bp_item_id,pd.amount as planAmount,ac.bp_item_id as actualItem,round(sum(ac.amount),4) as ".       " actualAmount,".
				" (select round(sum(amount),4)  from bp_plan_details ".
				" where bp_plan_id in( select id from bp_plans".
				" where branch_id=(select branch_id from  bp_plans".
				" where id=$id )" .
				" and id<=$id and status=0) and bp_item_id=pd.bp_item_id  group by bp_item_id) as cumulativePlan,".
				" (select round(sum(amount),4) from bp_actuals".
				" where bp_plan_id in(".
				" select id from bp_plans".
				" where branch_id=(select branch_id from  bp_plans".
				" where id=$id )" .
				" and id<=$id and status=0) and bp_item_id=pd.bp_item_id group by bp_item_id) as cumilativeActual".
				" from bp_plan_details pd left".
				" join bp_actuals ac".
				" on pd.bp_plan_id=ac.bp_plan_id and pd.bp_item_id=ac.bp_item_id inner join bp_items it on pd.bp_item_id=it.id".
				" where  pd.bp_plan_id=$id".
				" group by ac.bp_item_id,pd.bp_item_id".
				" union distinct ".
				" select pd.month,it.name,ac.bp_item_id as bp_item_id,pd.amount planAmount,ac.bp_item_id,round(sum(ac.amount),4) as actualAmount,".
				" (select round(sum(amount),4)  from bp_plan_details ".
				" where bp_plan_id in( select id from bp_plans".
				" where branch_id=(select branch_id from  bp_plans".
				" where id=$id )" .
				" and id<=$id and status=0) and bp_item_id=pd.bp_item_id  group by bp_item_id) as cumulativePlan,".
				" (select round(sum(amount),4) from bp_actuals".
				" where bp_plan_id in(".
				" select id from bp_plans".
				" where branch_id=(select branch_id from  bp_plans".
				" where id=$id 
				
				) ".
				" and id<=$id and status=0) and bp_item_id=ac.bp_item_id group by bp_item_id) as cumilativeActual".
				" from bp_plan_details pd right join bp_actuals ac".
				" on pd.bp_plan_id=ac.bp_plan_id and pd.bp_item_id=ac.bp_item_id inner join bp_items it on ac.bp_item_id=it.id".
				" where  ac.bp_plan_id=$id".
				" group by ac.bp_item_id,pd.bp_item_id".
				" union distinct ".

				" select distinct  bp_month_id,it.name,bp_item_id,0 as planAmount,null as actualItem,0 as actualAmount,".
				" 0 as cumulativePlan,sum(amount) as cumulativeActual from bp_actuals inner join bp_items it on bp_item_id=it.id ".
				" where bp_plan_id in(".
				" select id from bp_plans".
				" where branch_id=(select branch_id from  bp_plans".
				" where id=$id ) and id<=$id and status=0)".
				" and bp_item_id not in(".
				" select distinct pd.bp_item_id".
				" from bp_plan_details pd left".
				" join bp_actuals ac".
				" on pd.bp_plan_id=ac.bp_plan_id and pd.bp_item_id=ac.bp_item_id".
				" where  pd.bp_plan_id=$id  and pd.bp_item_id is not null)".
				//-- group by pd.bp_item_id"
				//"-- union distinct ".
				" and bp_item_id not in(".
				" select distinct  ac.bp_item_id".
				" from bp_plan_details pd right join bp_actuals ac".
				" on pd.bp_plan_id=ac.bp_plan_id and pd.bp_item_id=ac.bp_item_id".
				" where  ac.bp_plan_id=$id and ac.bp_item_id is not null".
			//	-- group by ac.bp_item_id*/
				" ) group by bp_item_id;";
		
		
	    $bp_plan_details=$this->BpPlanDetail->query($cmd);
		//var_dump($bp_plan_details);
		$this->set('bp_plan_details',$bp_plan_details);
		$this->set('results', $this->BpPlanDetail->find('count', array('conditions' => $conditions)));
		//var_dump($this->BpPlanDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp plan detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpPlanDetail->recursive = 2;
		$this->set('bpPlanDetail', $this->BpPlanDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BpPlanDetail->create();
			$this->autoRender = false;
			if ($this->BpPlanDetail->save($this->data)) {
				$this->Session->setFlash(__('The bp plan detail has been saved', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('The bp plan detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$bp_items = $this->BpPlanDetail->BpItem->find('list');
		$bp_plans = $this->BpPlanDetail->BpPlan->find('list');
		$this->set(compact('bp_items', 'bp_plans'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp plan detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpPlanDetail->save($this->data)) {
				$this->Session->setFlash(__('The bp plan detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp plan detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__plan__detail', $this->BpPlanDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$bp_items = $this->BpPlanDetail->BpItem->find('list');
		$bp_plans = $this->BpPlanDetail->BpPlan->find('list');
		$this->set(compact('bp_items', 'bp_plans'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp plan detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpPlanDetail->delete($i);
                }
				$this->Session->setFlash(__('Bp plan detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp plan detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpPlanDetail->delete($id)) {
				$this->Session->setFlash(__('Bp plan detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp plan detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>