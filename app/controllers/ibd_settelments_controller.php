<?php
class IbdSettelmentsController extends AppController {

	var $name = 'IbdSettelments';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
	
		$id=str_replace(")","/", $id);
	
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('ibd_Settelments', $this->IbdSettelment->find('all', array('conditions' => array('reference'=>$id,'ibc_no'=>null), 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->IbdSettelment->find('count', array('conditions' => $conditions)));
	}
	function list_data_po($id = null) {
	
		$this->LoadModel('IbdIbcs');
		$id=str_replace(")","/", $id);
	//	var_dump($id);die();
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdIbcs->recursive = 0;
		$ibdibcs=$this->IbdIbcs->find('all',array('conditions'=>array('PURCHASE_ORDER_NO' => $id)));
		//var_dump($id);die();
		$this->set('ibdSettelments',$ibdibcs );
		$this->set('results', $this->IbdIbcs->find('count', array('conditions' => array('PURCHASE_ORDER_NO' => $id))));
	}
	
	function list_data_c($id = null) {
	
		$this->LoadModel('IbdIbcs');
		$id=str_replace(")","/", $id);
	//	var_dump($id);die();
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdSettelment->recursive = 0;
		$ibdibcs=$this->IbdSettelment->find('all',array('conditions'=>array('reference' => $id)));
		//var_dump($id);die();
		$this->set('ibdSettelments',$ibdibcs );
		$this->set('results', $this->IbdSettelment->find('count', array('conditions' => array('reference' => $id))));
	}


	function view($id = null) {
		$this->LoadModel('IbdIbcs');
		$id=str_replace("<","/", $id);
	//	var_dump($id);die();
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdIbcs->recursive = 0;
		$ibdibcs=$this->IbdIbcs->find('all',array('conditions'=>array('PURCHASE_ORDER_NO' => $id)));
		//var_dump($ibdibcs);die();
		$this->set('ibdSettelments',$ibdibcs );
	     
	}
	
	function view_c($id = null) {
		$this->LoadModel('IbdIbcs');
		$id=str_replace("<","/", $id);
	//	var_dump($id);die();
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdSettelment->recursive = 0;
		$ibdibcs=$this->IbdSettelment->find('all',array('conditions'=>array('reference' => $id)));
		//var_dump($ibdibcs);die();
		$this->set('ibdSettelments',$ibdibcs );
	     
	}

	function view_lc($id = null) {
		$id=str_replace("<","/", $id);
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdSettelment->recursive = 0;
		$this->set('ibdSettelment', $this->IbdSettelment->find('all',array('conditions'=>array('reference'=>$id,'ibc_no'=>Null))));
	
	}
	function view_ibcs($id = null) {
		$id=str_replace("<","/", $id);
	//	var_dump($id);die();
		if (!$id) {
			$this->Session->setFlash(__('Invalid ibd settelment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->IbdSettelment->recursive = 0;
		$this->set('ibdSettelment', $this->IbdSettelment->find('all',array('conditions'=>array('reference' => $id))));
	
	}

	function add($id = null) {
		$this->LoadModel('IbdPurchaseOrder');
		if (!empty($this->data)){
			
			$this->IbdSettelment->create();
			$this->autoRender = false;
			
			if ($this->IbdSettelment->save($this->data)) {
				$last=$this->IbdSettelment->query("SELECT LAST_INSERT_ID()");
				
				$this->UpdateRemaining($this->data['IbdSettelment']['reference'],$this->data['IbdSettelment']['fcy_amount'],$this->data['IbdSettelment']['lcy_amount'],$last[0][0]['LAST_INSERT_ID()']);
				$this->Session->setFlash(__('The ibd settelment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd settelment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id){
			$this->set('parent_id',$id);
		}
		$val=str_replace("<","/", $id);
		$rate=$this->IbdPurchaseOrder->query("SELECT RATE from ibd_purchase_orders WHERE PURCHASE_ORDER_NO='$val' limit 1");
	
		$rate=$rate[0]['ibd_purchase_orders']['RATE'];
		$this->set('rate',$rate);
	}
	function add_ibcs($id = null) {
		$this->LoadModel('IbdIbcs');
		$this->LoadModel('IbdPurchaseOrder');
		if (!empty($this->data)){
			
			$this->IbdSettelment->create();
			$this->autoRender = false;
			
			if ($this->IbdSettelment->save($this->data)) {
				$last=$this->IbdSettelment->query("SELECT LAST_INSERT_ID()");
				$last=$last[0][0]['LAST_INSERT_ID()'];
				$reference=$this->data['IbdSettelment']['reference'];
				$fcy_amount=$this->data['IbdSettelment']['fcy_amount'];
				$lcy_amount=$this->data['IbdSettelment']['lcy_amount'];

				$this->UpdateRemaining($reference,$fcy_amount,$lcy_amount,$last);
				$this->UpdateRemainingIbcs($reference,$fcy_amount,$lcy_amount,$last);

				$this->Session->setFlash(__('The ibd settelment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd settelment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id){
			$this->set('parent_id',$id);
		
		$val=str_replace("<","/", $id);

		$po=$this->IbdIbcs->query("SELECT PURCHASE_ORDER_NO from ibd_ibcs WHERE IBC_REFERENCE='$val' limit 1");
		$po=$po[0]['ibd_ibcs']['PURCHASE_ORDER_NO'];

		$rate=$this->IbdPurchaseOrder->query("SELECT RATE from ibd_purchase_orders WHERE PURCHASE_ORDER_NO='$po' limit 1");
		$rate=$rate[0]['ibd_purchase_orders']['RATE'];
		$this->set('rate',$rate);
		}
	}
	function add_lc($id = null) {
		$this->loadModel('IbdLc');
	  
		if (!empty($this->data)){
			
			$this->IbdSettelment->create();
			$this->autoRender = false;
			
			if ($this->IbdSettelment->save($this->data)) {
			
				$last=$this->IbdSettelment->query("SELECT LAST_INSERT_ID()");
				$last=$last[0][0]['LAST_INSERT_ID()'];
				
				$this->UpdateOutstanding($this->data['IbdSettelment']['reference'],$this->data['IbdSettelment']['fcy_amount'],$this->data['IbdSettelment']['lcy_amount'],$this->data['IbdSettelment']['margin_amount'],$last);
				$this->Session->setFlash(__('The ibd settelment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd settelment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id){
			$id=str_replace("<","/",$id);
			$this->set('parent_id',$id);

			$first_lc=$this->IbdLc->find('first',array('conditions'=>array('LC_REF_NO'=>$id)));

			$this->set('lc_rate',$first_lc['IbdLc']['OPENING_RATE']);
		}





	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ibd settelment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->IbdSettelment->save($this->data)) {
				$this->Session->setFlash(__('The ibd settelment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The ibd settelment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('ibd__settelment', $this->IbdSettelment->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ibd settelment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->IbdSettelment->delete($i);
                }
				$this->Session->setFlash(__('Ibd settelment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Ibd settelment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->IbdSettelment->delete($id)) {
				$this->Session->setFlash(__('Ibd settelment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Ibd settelment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	

	function UpdateRemaining($ref,$fcy,$lcy,$last){
		$this->loadModel('IbdPurchaseOrder');
		$this->loadModel('IbdIbcs');

		$po=$this->IbdIbcs->query("SELECT PURCHASE_ORDER_NO from ibd_ibcs WHERE IBC_REFERENCE='$ref' limit 1");
		$po=$po[0]['ibd_ibcs']['PURCHASE_ORDER_NO'];

		$data1=$this->IbdPurchaseOrder->find('first',array('conditions'=>array('PURCHASE_ORDER_NO'=>$po)));
		$id=$data1['IbdPurchaseOrder']['id'];

		$this->data=$this->IbdPurchaseOrder->findById($id);
		$REM_FCY_AMOUNT=$this->data['IbdPurchaseOrder']['REM_FCY_AMOUNT']-$fcy;
		$REM_CAD_PAYABLE_IN_BIRR=$this->data['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR']-$lcy;
		if($REM_FCY_AMOUNT>=0 && $REM_CAD_PAYABLE_IN_BIRR>=0){
		$this->IbdPurchaseOrder->query("UPDATE ibd_purchase_orders set REM_FCY_AMOUNT=$REM_FCY_AMOUNT,REM_CAD_PAYABLE_IN_BIRR=$REM_CAD_PAYABLE_IN_BIRR where id=$id");
		}else{
			$this->IbdPurchaseOrder->query("DELETE FROM ibd_settelments where id=$last");
		}
	}
	function UpdateRemainingIbcs($ref,$fcy,$lcy,$last){
		$this->loadModel('IbdIbcs');

		$data1=$this->IbdIbcs->find('first',array('conditions'=>array('IBC_REFERENCE'=>$ref)));
		$id=$data1['IbdIbcs']['id'];

		$this->data=$this->IbdIbcs->findById($id);
		$REM_FCY_AMOUNT=$this->data['IbdIbcs']['REM_FCY_AMOUNT']-$fcy;
		$REM_CAD_PAYABLE_IN_BIRR=$this->data['IbdIbcs']['REM_CAD_PAYABLE_IN_BIRR']-$lcy;

		if($REM_FCY_AMOUNT>=0 && $REM_CAD_PAYABLE_IN_BIRR>=0){
		$this->IbdIbcs->query("UPDATE ibd_ibcs set REM_FCY_AMOUNT=$REM_FCY_AMOUNT,REM_CAD_PAYABLE_IN_BIRR=$REM_CAD_PAYABLE_IN_BIRR where id=$id");
		}else{
			$this->IbdIbcs->query("DELETE FROM ibd_settelments where id=$last");
		}
	}
	
	function UpdateOutstanding($ref,$fcy,$lcy,$margin,$last){
		$this->loadModel('IbdLc');

		$data1=$this->IbdLc->find('first',array('conditions'=>array('LC_REF_NO'=>$ref)));
		$id=$data1['IbdLc']['id'];
		
		$this->data=$this->IbdLc->findById($id);
		$OUT_FCY_AMOUNT=round($this->data['IbdLc']['OUT_FCY_AMOUNT'],4)- round($fcy,4);
		$OUT_BIRR_VALUE=round($this->data['IbdLc']['OUT_BIRR_VALUE'],4)- round($lcy,4);
		$OUT_Margin_Amt=round($this->data['IbdLc']['OUT_Margin_Amt'],4)- round($margin,4);
		if($OUT_FCY_AMOUNT>=0 && $OUT_BIRR_VALUE>=0){
		$this->IbdLc->query("UPDATE ibd_lcs set OUT_FCY_AMOUNT=$OUT_FCY_AMOUNT,OUT_BIRR_VALUE=$OUT_BIRR_VALUE,OUT_Margin_Amt=$OUT_Margin_Amt  where id=$id");
		}else{
		  $this->IbdLc->query("DELETE FROM ibd_settelments where id=$last");
		}
		
	}
}
?>