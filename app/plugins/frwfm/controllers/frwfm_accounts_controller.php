<?php
class FrwfmAccountsController extends AppController {

	var $name = 'FrwfmAccounts';
	
	function index() {
		$frwfm_applications = $this->FrwfmAccount->FrwfmApplication->find('all');
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
            $conditions['FrwfmAccount.frwfm_application_id'] = $frwfmapplication_id;
        }
		
		$this->set('frwfm_accounts', $this->FrwfmAccount->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FrwfmAccount->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid frwfm account', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FrwfmAccount->recursive = 2;
		$this->set('frwfmAccount', $this->FrwfmAccount->read(null, $id));
	}

	function updatebalance(){
			$this->autoRender = false;
			$allaccounts=$this->FrwfmAccount->find('all');
			$this->loadModel('FrwfmFlexcube');
			foreach($allaccounts as $account){
			$query = "SELECT ACY_AVL_BAL
							FROM ABYFCLIVE.ABY_VW_STTM_CUST_ACCOUNT 
						WHERE CUST_AC_NO = '".$account['FrwfmAccount']['acc_no']."' ";
		
				$customer = $this->FrwfmFlexcube->query($query);
				if(!empty($customer)){
					$this->data['FrwfmAccount']['id']=$account['FrwfmAccount']['id'];
					$this->data['FrwfmAccount']['amount']=$customer[0][0]['ACY_AVL_BAL'];
					$this->FrwfmAccount->save($this->data);
				}
			}
			$query = "SELECT `frwfm_application_id` , SUM( `amount` )
							FROM `frwfm_accounts`
							WHERE 1
							GROUP BY `frwfm_application_id`";
		
			$summary = $this->FrwfmAccount->query($query);
			$this->loadModel('FrwfmApplication');
			foreach($summary as $summ){
			        $applica=$this->FrwfmApplication->read(null, $summ['frwfm_accounts']['frwfm_application_id']);
					if($applica['FrwfmApplication']['status']=='Accepted' || $applica['FrwfmApplication']['status']=='Posted'){
					$this->data2['FrwfmApplication']['id']=$summ['frwfm_accounts']['frwfm_application_id'];
					$this->data2['FrwfmApplication']['deposit_amount']=$summ[0]['SUM( `amount` )'];
					$this->FrwfmApplication->save($this->data2);
					}
			}
			
			
	}
	function add($id = null) {
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->loadModel('FrwfmFlexcube');
			
			$query = "SELECT BRANCH_CODE, AC_DESC, CUST_NO, CCY, ACCOUNT_CLASS, ACY_AVL_BAL
							FROM ABYFCLIVE.ABY_VW_STTM_CUST_ACCOUNT 
						WHERE CUST_AC_NO = '".$this->data['FrwfmAccount']['acc_no']."' ";
		
			$customer = $this->FrwfmFlexcube->query($query);
			if(!empty($customer)){
			
			$query = "SELECT BRANCH_NAME FROM ABYFCLIVE.ABY_VW_STTM_BRANCH WHERE BRANCH_CODE = '".$customer[0][0]['BRANCH_CODE']."' ";		
			$branch = $this->FrwfmFlexcube->query($query);
			
			$query = "SELECT ACCOUNT_CLASS, DESCRIPTION FROM ABYFCLIVE.ABY_VW_STTM_ACCOUNT_CLASS WHERE ACCOUNT_CLASS = '".$customer[0][0]['ACCOUNT_CLASS']."' ";		
			$acc_desc = $this->FrwfmFlexcube->query($query);
				//$this->data['FrwfmAccount']['id']=$this->FrwfmAccount->getLastInsertId();
				$this->data['FrwfmAccount']['cif']=$customer[0][0]['CUST_NO'];
				$this->data['FrwfmAccount']['name']=$customer[0][0]['AC_DESC'];
				$this->data['FrwfmAccount']['branch']=$branch[0][0]['BRANCH_NAME'];
				$this->data['FrwfmAccount']['amount']=$customer[0][0]['ACY_AVL_BAL'];
				$this->data['FrwfmAccount']['currency']=$customer[0][0]['CCY'];
				$this->data['FrwfmAccount']['type']=$customer[0][0]['ACCOUNT_CLASS'];
				$this->data['FrwfmAccount']['type_desc']=$acc_desc[0][0]['DESCRIPTION'];
							
				 $conditions['FrwfmAccount.frwfm_application_id'] = $this->data['FrwfmAccount']['frwfm_application_id'];
				 $conditions['FrwfmAccount.acc_no'] = $this->data['FrwfmAccount']['acc_no'];
				 $acc=$this->FrwfmAccount->find('count', array('conditions' => $conditions));
				 
			if($acc<=0)	{			 
				$this->FrwfmAccount->create();
				$this->FrwfmAccount->save($this->data);
				
				$query = "SELECT CUST_AC_NO, BRANCH_CODE, AC_DESC, CUST_NO, CCY, ACCOUNT_CLASS, ACY_AVL_BAL
						FROM ABYFCLIVE.ABY_VW_STTM_CUST_ACCOUNT 
					WHERE CUST_NO = '".$customer[0][0]['CUST_NO']."' AND CUST_AC_NO <> '".$this->data['FrwfmAccount']['acc_no']."'";
		
				$allaccounts = $this->FrwfmFlexcube->query($query);
				
				if(!empty($allaccounts)){
					foreach($allaccounts as $account){
					
					$query = "SELECT BRANCH_NAME FROM ABYFCLIVE.ABY_VW_STTM_BRANCH WHERE BRANCH_CODE = '".$account[0]['BRANCH_CODE']."' ";
					$branch = $this->FrwfmFlexcube->query($query);
					
					$query = "SELECT ACCOUNT_CLASS, DESCRIPTION FROM ABYFCLIVE.ABY_VW_STTM_ACCOUNT_CLASS WHERE ACCOUNT_CLASS = '".$account[0]['ACCOUNT_CLASS']."' ";		
					$acc_desc = $this->FrwfmFlexcube->query($query);
							$this->data['FrwfmAccount']['acc_no']=$account[0]['CUST_AC_NO'];
							$this->data['FrwfmAccount']['cif']=$account[0]['CUST_NO'];
							$this->data['FrwfmAccount']['name']=$account[0]['AC_DESC'];
							$this->data['FrwfmAccount']['branch']=$branch[0][0]['BRANCH_NAME'];
							$this->data['FrwfmAccount']['amount']=$account[0]['ACY_AVL_BAL'];
							$this->data['FrwfmAccount']['currency']=$account[0]['CCY'];
							$this->data['FrwfmAccount']['type']=$account[0]['ACCOUNT_CLASS'];
							$this->data['FrwfmAccount']['type_desc']=$acc_desc[0][0]['DESCRIPTION'];
							
							$conditions['FrwfmAccount.frwfm_application_id'] = $this->data['FrwfmAccount']['frwfm_application_id'];
							$conditions['FrwfmAccount.acc_no'] = $this->data['FrwfmAccount']['acc_no'];
							$acc=$this->FrwfmAccount->find('count', array('conditions' => $conditions));
							 
							if($acc<=0)	{	
							$this->FrwfmAccount->create();
							$this->FrwfmAccount->save($this->data);
							}
				 }
				}
				
				$this->Session->setFlash(__('The account has been saved', true), '');
				$this->render('/elements/success');
				}
				else {
				$this->Session->setFlash(__('The account could not be saved. Duplicate exist.', true), '');
				$this->render('/elements/failure');
				}
			}			
			else {
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$frwfm_applications = $this->FrwfmAccount->FrwfmApplication->find('list');
		$this->set(compact('frwfm_applications'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid frwfm account', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FrwfmAccount->save($this->data)) {
				$this->Session->setFlash(__('The frwfm account has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The frwfm account could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('frwfm__account', $this->FrwfmAccount->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$frwfm_applications = $this->FrwfmAccount->FrwfmApplication->find('list');
		$this->set(compact('frwfm_applications'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for frwfm account', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FrwfmAccount->delete($i);
                }
				$this->Session->setFlash(__('Frwfm account deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Frwfm account was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FrwfmAccount->delete($id)) {
				$this->Session->setFlash(__('Frwfm account deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Frwfm account was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>