<?php

class ImsGrnsController extends ImsAppController {

    var $name = 'ImsGrns';

    function index() {
    
        $this->ImsGrn->ImsSupplier->recursive=-1;
        $suppliers = $this->ImsGrn->ImsSupplier->find('all');
        $this->set(compact('suppliers'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }
    
    function index_1() {
		$user = $this->Session->read();	
		$this->set('groups',$user['Auth']['Group']);
    }
	
	function index_2() {
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['ims_purchase_order_id'])) ? $_REQUEST['ims_purchase_order_id'] : -1;
		$supplier_id = (isset($_REQUEST['supplier_id'])) ? $_REQUEST['supplier_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
			
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ImsGrn.ims_purchase_order_id'] = $purchase_order_id;
        }
		if($supplier_id != -1){
			 $conditions['ImsGrn.ims_supplier_id'] = $supplier_id;
		}

        $this->set('grns', $this->ImsGrn->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order'=>'ImsGrn.name DESC')));
        $this->set('results', $this->ImsGrn->find('count', array('conditions' => $conditions)));
    }
    
    function list_data_1($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['ims_purchase_order_id'])) ? $_REQUEST['ims_purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ImsPurchaseOrder.ims_purchase_order_id'] = $purchase_order_id;
        }
		$conditions1=array('ImsGrn.status <>' => 'created');    
    
    
        $param="1=1";
       if(isset($_REQUEST['conditions'])){
         $param=  explode("=>",$_REQUEST['conditions']);
         $param= "g.name like " . $param[1];
       }
   
        $cmd="  select g.id,g.name,s.name as supplier,
               o.name as purchase_order, g.date_purchased,g.created,g.modified,g.status
                from ims_grns g left join ims_suppliers s
                on s.id=g.ims_supplier_id left join ims_purchase_orders o
                on o.id=g.ims_purchase_order_id where 1=1 and ".$param." 
                order by id desc limit ".$limit."  offset ".$start.";";
       
       // OLD
       // $this->ImsGrn->recursive = 2;
      //$grn=$this->ImsGrn->find('all', array('conditions' => array($conditions,$conditions1), 'limit' => $limit, 'offset' => $start, 'order'=>'ImsGrn.name DESC'));
      // NEW 
      $grn=$this->ImsGrn->query($cmd);
      $this->set('grns', $grn);
      $this->set('results', $this->ImsGrn->find('count', array('conditions' => $conditions)));
    }
    
    
    
	
	function list_data_2($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
        $purchase_order_id = (isset($_REQUEST['ims_purchase_order_id'])) ? $_REQUEST['ims_purchase_order_id'] : -1;
        if ($id)
            $purchase_order_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($purchase_order_id != -1) {
            $conditions['ImsPurchaseOrder.ims_purchase_order_id'] = $purchase_order_id;
        }
		$conditions1=array('ImsGrn.status' => 'approved');        
        $this->ImsGrn->recursive = 2;
        $this->set('grns', $this->ImsGrn->find('all', array('conditions' => array($conditions,$conditions1), 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->ImsGrn->find('count', array('conditions' => $conditions)));
    }

    function list_data2($id) {
        $this->loadModel('ImsPurchaseOrderItem');
		$this->loadModel('ImsCard');

        //'id','item','ordered_quantity','purchased_quantity','ordered_unit_price','purchased_unit_price'
        $grn = $this->ImsGrn->read(null, $id);
        $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $grn['ImsGrn']['ims_purchase_order_id']);

        $pois = $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions));
        $i = 0;

        foreach ($pois as $poi) {
            $qnt = 0;
            if (!empty($poi['ImsGrnItem'])){
                foreach ($poi['ImsGrnItem'] as $grni)
				{
					 $qnt = $qnt + $grni['quantity'];
					
					$conditionsCard = array('ImsCard.ims_grn_item_id' => $grni['id']);
					$cards = $this->ImsCard->find('all', array('conditions' =>$conditionsCard,'order'=>'ImsCard.id ASC'));
					
					foreach($cards as $card){						
						if($card['ImsCard']['in_quantity'] == 0){
							$qnt = $qnt - $card['ImsCard']['out_quantity'];
						}
					}
					}
               }   

            $pois[$i]['ImsPurchaseOrderItem']['ImsGrnItem']['ims_grn_id'] = $id;
            $pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] = $pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] - $qnt;

            if ($pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] <= 0) {
                array_splice($pois, $i, 1);
                $i--;
            }
            $i++;
        }
        $this->set('purchase_order_items', $pois);

        $this->set('results', count($pois));
    }
	
	function list_data3($id) {
        $this->loadModel('ImsPurchaseOrderItem');
		$this->loadModel('ImsCard');
		
        //'id','item','ordered_quantity','purchased_quantity','ordered_unit_price','purchased_unit_price'
        $grn = $this->ImsGrn->read(null, $id);
        $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $grn['ImsGrn']['ims_purchase_order_id']);

        $pois = $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions));
        $i = 0;
        
        //var_dump($pois);
        foreach ($pois as $poi) {
            $qnt = 0;
			
            if (!empty($poi['ImsGrnItem']))
                foreach ($poi['ImsGrnItem'] as $grni){
					$qnt = $qnt + $grni['quantity'];
					
					$conditionsCard = array('ImsCard.ims_grn_item_id' => $grni['id']);
					$cards = $this->ImsCard->find('all', array('conditions' =>$conditionsCard,'order'=>'ImsCard.id ASC'));
					
					foreach($cards as $card){						
						if($card['ImsCard']['out_quantity'] != 0){
							$qnt = $qnt - $card['ImsCard']['out_quantity'];
						}
					}
				}	
            $pois[$i]['ImsPurchaseOrderItem']['ImsGrnItem']['ims_grn_id'] = $id;
			$pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] = $pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] - $qnt;					

            if ($pois[$i]['ImsPurchaseOrderItem']['ordered_quantity'] <= 0) {
                array_splice($pois, $i, 1);
                $i--;
            }
            $i++;
        }

        $this->set('purchase_order_items', $pois);

        $this->set('results', count($pois));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid grn', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsGrn->recursive = 2;
        $this->set('grn', $this->ImsGrn->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->data['ImsGrn']['status'] = 'created';
            $this->data['ImsGrn']['created_by'] = $this->Session->read('Auth.User.id');
            
              $purchase=$this->ImsGrn->ImsPurchaseOrder->find('all',array('conditions'=>array('ImsPurchaseOrder.id'=>$this->data['ImsGrn']['ims_purchase_order_id']) ));
             $this->data['ImsGrn']['ims_supplier_id']=$purchase[0]['ImsPurchaseOrder']['ims_supplier_id'];
            
            $this->ImsGrn->create();
            $this->autoRender = false;
            if ($this->ImsGrn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true) . '::' . $this->ImsGrn->id, '');
                $this->render('/elements/success_grn');
            } else {
                $this->Session->setFlash(__('The GRN could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
		$this->ImsGrn->ImsPurchaseOrder->recursive = 2;
		$this->ImsGrn->ImsSupplier->recursive = -1;
        $conditions = array('ImsPurchaseOrder.approved' => 1, 'ImsPurchaseOrder.completed' => 0);
        $suppliers = $this->ImsGrn->ImsSupplier->find('all');
		
		$this->ImsGrn->ImsPurchaseOrder->unbindModel(array('belongsTo' => array('User','ApprovedUser', 'ImsSupplier'),'hasMany' => array('ImsGrn')));
        $purchase_orders = $this->ImsGrn->ImsPurchaseOrder->find('all', array('conditions' => $conditions));

        $this->set(compact('suppliers', 'purchase_orders'));
		
		$count = 0;
		$value = $this->ImsGrn->find('first',array('conditions' => array('ImsGrn.name LIKE' => date("Ymd").'%'),'order'=>'ImsGrn.name DESC'));
		if($value != null){
			$value = explode('/',$value['ImsGrn']['name']);		
			$count = $value[1];
		}         

        $this->set('count', $count);
    }
    
    function print_grn($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsGrn->recursive = 3;
        $this->set('grn', $this->ImsGrn->read(null, $id));
    }
	
	function print_grn1($id = null){
        $this->layout = 'print_layout';
        
        if (!$id) {
            $this->autoRender = false;
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        $this->ImsGrn->recursive = 1;
		$grn = $this->ImsGrn->read(null, $id);
        $this->set('grn', $grn);
		
		$grnArray = array();
		$this->loadModel('ImsCard');
		$this->ImsCard->recursive = -1; 
		foreach($grn['ImsGrnItem'] as $grn_item) {
			$conditions = array('ImsCard.ims_grn_item_id' => $grn_item['id'],'ImsCard.ims_sirv_item_id !=' => 0);
			$card = $this->ImsCard->find('all', array('conditions' =>$conditions));
			if($card != null)
			{
				$grnArray[] = $grn_item;
			}
		}
		
		$this->set('grnArray', $grnArray);
    }
	
	function getitem()
	{
		$id = $this->params['itemid'];
		$this->loadModel('ImsItem');
		$this->ImsItem->recursive =-1;
		$item = $this->ImsItem->read(null,$id);
		return $item['ImsItem']; 
	}
	
	function getpoitem()
	{
		$id = $this->params['poitemid'];
		$this->loadModel('ImsPurchaseOrderItem');
		$this->ImsPurchaseOrderItem->recursive =-1;
		$poitem = $this->ImsPurchaseOrderItem->read(null,$id);
		return $poitem['ImsPurchaseOrderItem']; 
	}
	
	function getuser()
	{
		$id = $this->params['userid'];
		$this->loadModel('User');
		$this->User->recursive = 1;
		$user = $this->User->read(null,$id);
		return $user; 
	}
    
    function post($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        $grn = array('ImsGrn' => array('id' => $id, 'status' => 'posted'));
        if ($this->ImsGrn->save($grn)) {
            $this->Session->setFlash(__('grn posted for approval', true), '');
            $this->render('/elements/success');
        } else {
            $this->Session->setFlash(__('grn was not posted for approval', true), '');
            $this->render('/elements/failure');
        }
    }

    function approve($id = null) {
        $this->autoRender = false;
        $this->data['ImsGrn']['id'] = $id;
        $this->data['ImsGrn']['status'] = 'approved';
        $this->data['ImsGrn']['approved_by'] = $this->Session->read('Auth.User.id');
        $this->loadModel('GroupsUser');
        $conditionsg['GroupsUser.group_id'] = '29';
        $conditionsg['GroupsUser.user_id'] = $this->Session->read('Auth.User.id');
        $perm = $this->GroupsUser->find('count', array('conditions' => $conditionsg));
       
        //if ($perm > 0) {
            if ($this->ImsGrn->save($this->data)) {
				$this->loadModel('ImsCard');
				$this->ImsGrn->recursive = 2;
				$grn = $this->ImsGrn->read(null,$id);
				$this->loadModel('ImsStore');
				$this->loadModel('ImsStoresItem');
				$conditionsstore['ImsStore.store_keeper_one'] = $grn['ImsGrn']['created_by'];
				$store=$this->ImsStore->find('first', array('conditions' => array('or' => array(
																					  'ImsStore.store_keeper_one' => $grn['ImsGrn']['created_by'],
																					  'ImsStore.store_keeper_two' => $grn['ImsGrn']['created_by'],
																					  'ImsStore.store_keeper_three' => $grn['ImsGrn']['created_by'],
																					  'ImsStore.store_keeper_four' => $grn['ImsGrn']['created_by'],
                                            'ImsStore.store_keeper_five' => $grn['ImsGrn']['created_by'],
                                            'ImsStore.store_keeper_six' => $grn['ImsGrn']['created_by'] 
																					)
																				  )));
                                                                                                                                                                                                                   
      
				foreach($grn['ImsGrnItem'] as $grnitems){
					$balance = 0;
					$conditionsB = array('ImsCard.ims_item_id' => $grnitems['ImsPurchaseOrderItem']['ims_item_id']);
					$cardB = $this->ImsCard->find('first', array('conditions' =>$conditionsB,'order'=>'ImsCard.id DESC'));
					if($cardB != null){
						$balance = $cardB['ImsCard']['balance'] + $grnitems['quantity'];
					}
					else{
						$balance = $grnitems['quantity'];
					}
                    $this->ImsCard->create();
                    $card = array('ImsCard' => array());
                    
                    $card['ImsCard']['ims_grn_item_id'] = $grnitems['id'];
                    $card['ImsCard']['ims_item_id'] = $grnitems['ImsPurchaseOrderItem']['ims_item_id'];
                    $card['ImsCard']['in_quantity'] = $grnitems['quantity'];
                    $card['ImsCard']['out_quantity'] = 0; $card['ImsCard']['balance'] = $balance;
                    $card['ImsCard']['in_unit_price'] = $grnitems['unit_price'];
                    $card['ImsCard']['out_unit_price'] = 0;$card['ImsCard']['status'] = 'A';
				          	$card['ImsCard']['ims_store_id'] = $store!=null?$store['ImsStore']['id']:4092; // IF new store person crated grn and not in store keeper list, use default store keeper 4092
                    $this->ImsCard->save($card);
					$conditionsstoreitems['ImsStoresItem.ims_store_id'] = $store!=null?$store['ImsStore']['id']:4092;
					$conditionsstoreitems['ImsStoresItem.ims_item_id'] = $grnitems['ImsPurchaseOrderItem']['ims_item_id'];
					$storeitem=$this->ImsStoresItem->find('first', array('conditions' => $conditionsstoreitems));
					if($storeitem == null){
						$this->ImsStoresItem->create();
						$this->datasi['ImsStoresItem']['ims_store_id'] = $store!=null?$store['ImsStore']['id']:4092;
						$this->datasi['ImsStoresItem']['ims_item_id'] = $grnitems['ImsPurchaseOrderItem']['ims_item_id'];
						$this->datasi['ImsStoresItem']['balance'] = $grnitems['quantity'];
						$this->ImsStoresItem->save($this->datasi);
					}
					else if($storeitem != null){
						$balance = $storeitem['ImsStoresItem']['balance'] + $grnitems['quantity'];
						$this->ImsStoresItem->id = $storeitem['ImsStoresItem']['id'];
						$this->ImsStoresItem->saveField('balance', $balance);
					}
				}
                echo 'The GRN has been approved';
                //$this->Session->setFlash(__('The GRN has been approved', true), '');
                //$this->render('/elements/success');
            } else {
                echo 'The grn could not be approved. Please, try again.';
                //$this->Session->setFlash(__('The grn could not be approved. Please, try again.', true), '');
                //$this->render('/elements/failure');
            }
        /*} else {
            echo 'You dont have the required privilage to approve this GRN.';
            //$this->Session->setFlash(__('You dont have the required privilage to approve this GRN.', true), '');
            //$this->render('/elements/failure'); 
        }*/
    }

    function add_grn_items($id = null) {
        $this->set('grn_id', $id);

        if (isset($_POST)) {
            $this->loadModel('ImsGrnItem');
            $this->loadModel('ImsPurchaseOrderItem');
            $this->loadModel('ImsCard');
            $this->loadModel('ImsPurchaseOrder');

            // for each of the items
            $pq;

            foreach ($_POST as $key => $value) {
                $tmpost = explode('^', $key);
                //$poi = '';
                if ($tmpost[1] == 'id') {
                    $poi = $value;
                    $poi = str_replace('"', '', $poi);
                } elseif ($tmpost[1] == 'ims_grn_id') {
                    $grn_id = $value;
                    $grn_id = str_replace('"', '', $grn_id);
                } elseif ($tmpost[1] == 'purchased_quantity') {
                    // this is if we are dealing with the quantity item
                    $po_item = $this->ImsPurchaseOrderItem->read(null, $poi);
                    $pq = $value;

                    // If not, create the GrnItem and the Card
                    $this->ImsGrnItem->create();

                    $this->data['ImsGrnItem']['ims_purchase_order_item_id'] = $poi;
                    $this->data['ImsGrnItem']['ims_grn_id'] = $grn_id;
                    $this->data['ImsGrnItem']['quantity'] = $value;
                    $this->ImsGrnItem->save($this->data);
                    $lastid = $this->ImsGrnItem->getLastInsertId();
					
					
                } elseif ($tmpost[1] == 'purchased_unit_price') {

                    // this is if we are dealing with the unit price item
                    $po_item = $this->ImsPurchaseOrderItem->read(null, $poi);

                    $this->ImsGrnItem->updateAll(array("unit_price" => $value), array('ImsGrnItem.ims_purchase_order_item_id' => $poi, 'ImsGrnItem.ims_grn_id' => $grn_id));
                    //$this->ImsCard->updateAll(array("in_unit_price" => $value), array('ImsCard.ims_item_id' => $po_item['ImsPurchaseOrderItem']['ims_item_id'], 'ImsCard.ims_grn_item_id' => $lastid));

                    $this->ImsPurchaseOrderItem->read(null, $po_item['ImsPurchaseOrderItem']);
                    $this->ImsPurchaseOrderItem->set('purchased_quantity', $pq + $po_item['ImsPurchaseOrderItem']['purchased_quantity']);
                    $this->ImsPurchaseOrderItem->save();
                }elseif ($tmpost[1] == 'remark') {

                    // this is if we are dealing with the remark
                    $this->ImsGrnItem->updateAll(array("remark" => $value), array('ImsGrnItem.ims_purchase_order_item_id' => $poi, 'ImsGrnItem.ims_grn_id' => $grn_id));
                    //$this->ImsCard->updateAll(array("in_unit_price" => $value), array('ImsCard.ims_item_id' => $po_item['ImsPurchaseOrderItem']['ims_item_id'], 'ImsCard.ims_grn_item_id' => $lastid));
                }
            }
            $grn = $this->ImsGrn->read(null, $id);
            $conditions = array('ImsPurchaseOrderItem.ims_purchase_order_id' => $grn['ImsGrn']['ims_purchase_order_id']);
            $pois = $this->ImsPurchaseOrderItem->find('all', array('conditions' => $conditions));
            $found = 0;

            foreach ($pois as $poi) {
                if ($poi['ImsPurchaseOrderItem']['purchased_quantity'] < $poi['ImsPurchaseOrderItem']['ordered_quantity']) {
                    $found = 1;
                    break;
                }
                $found = 2;
            }
            if ($found == 2) {
                $this->ImsPurchaseOrder->read(null, $grn['ImsGrn']['ims_purchase_order_id']);
                $this->ImsPurchaseOrder->set('completed', 1);
                $this->ImsPurchaseOrder->save();
            }
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid grn', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->ImsGrn->save($this->data)) {
                $this->Session->setFlash(__('The GRN has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The grn could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('grn', $this->ImsGrn->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $suppliers = $this->ImsGrn->ImsSupplier->find('list');
        $purchase_orders = $this->ImsGrn->ImsPurchaseOrder->find('list');
        $this->set(compact('suppliers', 'purchase_orders'));
    }

    function delete($id = null) {
        $this->autoRender = false;
		$this->loadModel('ImsGrnItem');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grn', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
				$msg = '';
                foreach ($ids as $i) {	
					$conditions['ImsGrnItem.ims_grn_id'] = $i;
					if($this->ImsGrn->ImsGrnItem->find('count', array('conditions' => $conditions)) == 0){  
							$this->ImsGrn->delete($i);
					} else {
						$grn = $this->ImsGrn->read(null,$i);
						$msg .= $grn['ImsGrn']['name'] . ',';
					}
                }
				if($msg == '') {
					$this->Session->setFlash(__('GRNs deleted', true), '');
					$this->render('/elements/success4');
				} else
					$this->Session->setFlash('since they have GRN Item(s),Following GRNs were not deleted: ' . $msg, '');
					$this->render('/elements/failure3');
				}
            catch (Exception $e) {
                $this->Session->setFlash(__('GRNs was not deleted', true) . ': ' . $e->getMessage(), '');
                $this->render('/elements/failure');
            }
        } else {
			$conditions['ImsGrnItem.ims_grn_id'] = $id;
			if($this->ImsGrn->ImsGrnItem->find('count', array('conditions' => $conditions)) == 0){
				if ($this->ImsGrn->delete($id)) {
					$this->Session->setFlash(__('Grn deleted', true), '');
					$this->render('/elements/success4');
				} else {
					$this->Session->setFlash(__('Grn was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
			else{
				$this->Session->setFlash(__('GRN was not deleted because it has GRN Item(s)', true), '');
				$this->render('/elements/failure3');
			}
        }
    }
	
	function add_sirv_items($id = null){
	
		if (isset($_POST) and $_POST != null) {
			global $value;
			$id;
		    $item_code;
			$measurement;
			$quantity;
			$unit_price;
			
			$this->loadModel('ImsSirv');           
			
			$this->ImsSirv->create();
			date_default_timezone_set("Africa/Addis_Ababa");
			$count = 0;
			$value = $this->ImsSirv->find('first',array('conditions' => array('ImsSirv.name LIKE' => date("Ymd").'%'),'order'=>'ImsSirv.name DESC'));
			if($value != null){
				$value = explode('/',$value['ImsSirv']['name']);		
				$count = $value[1];
			}			
			$this->data['ImsSirv']['name'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
			$this->data['ImsSirv']['status'] = 'completed';
			$this->data['ImsSirv']['ims_requisition_id'] = 0;
			$this->ImsSirv->save($this->data);
			$lastid = $this->ImsSirv->getLastInsertId();
			
			foreach ($_POST as $key => $value) {			
				$tmpost = explode('^', $key);
				if($tmpost[1] == 'id')
				{
					$id = $value;
					$id = explode('"',$id);
				}
				else if($tmpost[1] == 'code')
				{
					$item_code = $value;
					$item_code = explode('"',$item_code);
				}
				else if($tmpost[1] == 'measurement')
				{
					$measurement = $value;
					$measurement = explode('"',$measurement);
				}
				else if($tmpost[1] == 'quantity')
				{
					$quantity = $value;
					$quantity = explode('"',$quantity);
				}
				else if($tmpost[1] == 'unit_price')
				{
					$unit_price = $value;
					$unit_price = explode('"',$unit_price);
					
					$this->create_SIRV($id[1],$item_code[1],$measurement[1],$quantity[1],$unit_price[1],$lastid);
				}							
			}
			if($value == true){
				$this->Session->setFlash(__('GRN Adjusted Successfully', true), '');
				$this->render('/elements/success');
			}
			else{
				$this->Session->setFlash(__('Unable to Adjust GRN', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function create_SIRV($id,$item_code,$measurement,$quantity,$unit_price,$lastid){
		global $value;
		
		$this->loadModel('ImsSirvItem');
		$this->loadModel('ImsCard');
		$this->loadModel('ImsItem');
		$this->loadModel('ImsPurchaseOrderItem');
		$this->loadModel('ImsGrnItem');
		$this->loadModel('ImsPurchaseOrder');
		$this->loadModel('ImsStoresItem');
		
		$item = $this->ImsItem->find('first', array('conditions' => array('ImsItem.description' => $item_code)));
			
		$this->ImsSirvItem->create();
		$this->data['ImsSirvItem']['ims_sirv_id'] = $lastid;
		$this->data['ImsSirvItem']['ims_item_id'] = $item['ImsItem']['id'];
		$this->data['ImsSirvItem']['measurement'] = $measurement;
		$this->data['ImsSirvItem']['quantity'] = $quantity;
		$this->data['ImsSirvItem']['unit_price'] = $unit_price;
		$this->ImsSirvItem->save($this->data);
		$lastidSirvItem = $this->ImsSirvItem->getLastInsertId();
		
		$balance = 0;
		$conditionsB = array('ImsCard.ims_item_id' => $item['ImsItem']['id']);
		$cardB = $this->ImsCard->find('first', array('conditions' =>$conditionsB,'order'=>'ImsCard.id DESC'));
		if($cardB != null){
			$balance = $cardB['ImsCard']['balance'] - $quantity;
		}
		else{
			$balance = $quantity;
		}
		
		$this->ImsCard->create();
		$card = array('ImsCard' => array());
		
		$card['ImsCard']['ims_grn_item_id'] = $id;
		$card['ImsCard']['ims_sirv_item_id'] = $lastidSirvItem;
		$card['ImsCard']['ims_item_id'] = $item['ImsItem']['id'];
		$card['ImsCard']['in_quantity'] = 0;
		$card['ImsCard']['out_quantity'] = $quantity;
		$card['ImsCard']['balance'] = $balance;
		$card['ImsCard']['in_unit_price'] = 0;
		$card['ImsCard']['out_unit_price'] = $unit_price;
		
		$conditionsstore = array('ImsCard.ims_grn_item_id' => $id);
		$cardstore = $this->ImsCard->find('first', array('conditions' =>$conditionsstore,'order'=>'ImsCard.id DESC'));
		$card['ImsCard']['ims_store_id'] = $cardstore['ImsCard']['ims_store_id'];

		if($this->ImsCard->save($card))
		{	
			///////////////////////     Update previous card row status  ////////////////////////////////////////////
			$conditionsGI = array('ImsCard.ims_grn_item_id' => $id,'ImsCard.ims_sirv_item_id' => 0);
			$cardGI = $this->ImsCard->find('first', array('conditions' =>$conditionsGI,'order'=>'ImsCard.id DESC'));
			$this->ImsCard->id = $cardGI['ImsCard']['id'];
			$this->ImsCard->saveField('status', 'D');
			
			$conditions_store = array('ImsStoresItem.ims_item_id' => $item['ImsItem']['id'],'ImsStoresItem.ims_store_id' => $cardGI['ImsCard']['ims_store_id']);
			$storesitem = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store));
			//update store item balance							
			$this->ImsStoresItem->id = $storesitem['ImsStoresItem']['id'];
			$this->ImsStoresItem->saveField('balance', $storesitem['ImsStoresItem']['balance'] - $quantity);
			
			//////////////////////// update purchase order item table purchased quantity field  /////////////////////
			$grnItem = $this->ImsGrnItem->read(null, $id);
			$purchaseOrderItem = $this->ImsPurchaseOrderItem->read(null, $grnItem['ImsGrnItem']['ims_purchase_order_item_id']);
			$purchased_quantity =0;
			$purchased_quantity = $purchaseOrderItem['ImsPurchaseOrderItem']['purchased_quantity'] - $quantity;
			$this->ImsPurchaseOrderItem->saveField('purchased_quantity', $purchased_quantity);
			
			//////////////////////   update purchase order completed field ////////////////////////////////////////////
			$purchaseOrder = $this->ImsPurchaseOrder->read(null, $purchaseOrderItem['ImsPurchaseOrderItem']['ims_purchase_order_id']);
			$this->ImsPurchaseOrder->saveField('completed', 0);
			
			
			
			if($value != false){
				$value = true;
			}
		}
		else{
			$value = false;			
		}
	}

}

?>