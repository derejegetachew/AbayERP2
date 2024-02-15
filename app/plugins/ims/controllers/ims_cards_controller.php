<?php

class ImsCardsController extends ImsAppController {

    var $name = 'ImsCards';

    function index() {
        $items = $this->ImsCard->ImsItem->find('all');
        $this->set(compact('items'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function index_stock_card($id = null) {
        $this->set('parent_id', $id);
		
		$item = $this->ImsCard->ImsItem->find('first', array(
        'conditions' => array('ImsItem.id' => $id)
        ));
		
		$this->set('item',$item['ImsItem']['name']);	
    }

    function index_bin_card($id = null,$store_id = null) {
        $this->set('parent_id', $id);
		$this->set('store_id', $store_id);
		$this->loadModel('ImsStore');
		$store = $this->ImsStore->read(null,$store_id);
		$this->set('store_name', $store['ImsStore']['name']);
		
		//$total_balance = $this->ImsCard->find('all', array(
		  //'fields' => array(
			//'SUM(ImsCard.balance) AS total_balance'
		  //),
		  //'conditions' => array('ImsCard.ims_item_id' => $id)
		//));
		
		$total_balance = $this->ImsCard->find('first', array(
        'conditions' => array('ImsCard.ims_item_id' => $id),'order' => 'ImsCard.id DESC'));
		
		//	pr($total_balance);
		$this->set('total_balance', $total_balance['ImsCard']['balance']);
		
		$item = $this->ImsCard->ImsItem->find('first', array(
        'conditions' => array('ImsItem.id' => $id)
        ));
		
		$this->set('item',$item['ImsItem']['name']);		
    }
	
	function index_ending_balance($id = null) {
      
    }
	
	function index_sirv_by_branch($id = null) {		
	    $this->loadModel('Branch');
		$this->Branch->recursive =-1;
	    $branches = $this->Branch->find('all');
	  
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set(compact('branches','itemcategory'));
    }
	
	function index_sirv_grn_by_category($id = null) { 
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set('itemcategory',$itemcategory);
    }
	
	function index_sirv_all_category($id = null) { 
		
    }
	
	function index_balance_by_category($id = null) { 
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set('itemcategory',$itemcategory);
    }
	
	function index_min_max_by_category($id = null) { 
	  	$this->loadModel('ImsItemCategory'); 
	  	$this->ImsItemCategory->recursive =-1;			
	  	$conditions =array('ImsItemCategory.parent_id' => 1);  			
	  	$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	  	$this->loadModel('ImsStore'); 
	  	$this->ImsStore->recursive =-1;			
	  	$imsStore = $this->ImsStore->find('all', array());
		
	    $this->set('itemcategory',$itemcategory);
	  	$this->set('imsStore',$imsStore);
		
    }
	
	function index_emp_card($id = null) {
	    $this->loadModel('People');
	    $employees = $this->People->find('all',array('order' => 'People.first_name ASC')); 		
		
	    $this->set(compact('employees'));
    }
	
	function index_branch_card($id = null) {
	    $this->loadModel('Branch');
		  $this->Branch->recursive = -1;
	    $branches = $this->Branch->find('all',array('order' => 'Branch.name ASC')); 		
		
	    $this->set(compact('branches'));
    }
	
	function index_category_card($id = null) {
	    $this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set(compact('itemcategory'));
    }
	
	function index_disposal_by_category($id = null) {
	    
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set(compact('itemcategory'));
    }
	
	function index_returned_disposal_by_category($id = null) {
	    
		$this->loadModel('ImsItemCategory'); 
		$this->ImsItemCategory->recursive =-1;			
		$conditions =array('ImsItemCategory.parent_id' => 1);  			
		$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		
	    $this->set(compact('itemcategory'));
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $conditions['ImsCard.ims_item_id'] = $item_id;
        }

        $this->set('cards', $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'ImsCard.created ASC')));
        $this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }

    function list_data_stock_cards($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $cond[0]['ImsCard.ims_item_id'] = $item_id;
			$cond[0]['ImsCard.ims_grn_item_id'] = 0;
			
			$cond[1]['ImsCard.status !='] = '';
			$cond[1]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[1]['ImsCard.ims_item_id'] = $item_id;
			
			$cond[2]['ImsCard.ims_item_id'] = $item_id;
			$cond[2]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[2]['ImsCard.ims_sirv_item_id !='] = 0;
			
			$cond[3]['ImsCard.ims_item_id'] = $item_id;
			$cond[3]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[3]['ImsCard.ims_disposal_item_id !='] = 0;			
			
			$conditions = array("OR" => $cond);
        }
		$this->ImsCard->unbindModel(array('belongsTo' => array('ImsStore','ImsItem'),'hasMany' => array()));
		$this->ImsCard->ImsSirvItem->unbindModel(array('belongsTo' => array('ImsItem'),'hasMany' => array()));
		$this->ImsCard->ImsGrnItem->unbindModel(array('belongsTo' => array('ImsItem'),'hasAndBelongsToMany' => array('ImsStore')));
		$this->ImsCard->recursive = 2;
		$cards = $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start, 'order' => 'ImsCard.id ASC'));
		$mcards = array();
		$last_sum = 0;
		$sums = array();
		$cur_page = 1;
		if($this->Session->check('sums')) {
			$sums = $this->Session->read('sums');
			$cur_page = ($start + $limit) / $limit;
			$last_sum = isset($sums[$cur_page - 1])? $sums[$cur_page - 1]: 0;
		}
		
		$balance = $last_sum;
		$count = 0;
		foreach($cards as $card) {
			$total_price = '';
			if($card['ImsCard']['in_quantity'] != 0){
				$total_price = number_format($card['ImsCard']['in_quantity'] * $card['ImsCard']['in_unit_price'] , 4 , '.' , ',' ); 
			} else {
				if($card['ImsCard']['out_quantity'] != 0){
					$total_price = number_format($card['ImsCard']['out_quantity'] * $card['ImsCard']['out_unit_price'] , 4 , '.' , ',' );
				}
				else{
					$total_price = number_format($card['ImsCard']['disp_quantity'] * $card['ImsCard']['disp_unit_price'] , 4 , '.' , ',' );
				}
			}
			// balance in birr
			$balance_in_birr = '';
			if($card['ImsCard']['in_quantity'] != 0){			
				$balance = $balance + ($cards[$count]['ImsCard']['in_quantity'] * $cards[$count]['ImsCard']['in_unit_price']);				
				$balance_in_birr = number_format($balance, 4 , '.' , ',');				
				$count++;
			} else {
				if($card['ImsCard']['out_quantity'] != 0){
					$balance = $balance - ($cards[$count]['ImsCard']['out_quantity'] * $cards[$count]['ImsCard']['out_unit_price']);
					$balance_in_birr = number_format($balance, 4 , '.' , ',');		
					$count++;
				}
				else{
					$balance = $balance - ($cards[$count]['ImsCard']['disp_quantity'] * $cards[$count]['ImsCard']['disp_unit_price']);
					$balance_in_birr = number_format($balance, 4 , '.' , ',');		
					$count++;
				}
			}
			// end of balance in birr
			
			//purchase order
			$purchase_order_id = '';
			if($card['ImsCard']['ims_grn_item_id'] != 0){
				if($card['ImsGrnItem']['ImsGrn']['ims_purchase_order_id'] == 0){
					$purchase_order_id = '<font color=red>Adjustment</font>'; 
				}
				else if($card['ImsCard']['ims_grn_item_id'] != 0 and $card['ImsCard']['ims_sirv_item_id'] != 0){
					$purchase_order_id = '<font color=red>Adjustment</font>'; 
				}
			}
			else if($card['ImsCard']['ims_disposal_item_id'] != 0){
				$purchase_order_id = '<font color=red>Disposal</font>';
			}
			//end of purchase order
			//grn sirv
			$grn_sirv = '';
			if($card['ImsCard']['ims_grn_item_id'] != 0 and $card['ImsCard']['ims_sirv_item_id'] != 0){
				if($card['ImsCard']['out_quantity'] != 0){
					$grn_sirv = '<font color=red>'.$card['ImsGrnItem']['ImsGrn']['name'].'</font>';
				}
				else if($card['ImsCard']['in_quantity'] != 0){
					$grn_sirv = '<font color=red>'.$card['ImsSirvItem']['ImsSirv']['name'].'</font>';
				}
			}
			else if($card['ImsCard']['ims_grn_item_id'] != 0){
			  $grn_sirv = $card['ImsGrnItem']['ImsGrn']['name'];
			}
			else if($card['ImsCard']['ims_disposal_item_id'] != 0){				
				$grn_sirv = $card['ImsDisposalItem']['ImsDisposal']['name'];
			}
			else {
				$grn_sirv = $card['ImsSirvItem']['ImsSirv']['name'];
			}
			//end of grn sirv
			
			$out_quantity = null;
			if($card['ImsCard']['out_quantity'] != 0){
				$out_quantity = $card['ImsCard']['out_quantity'];
			}else if($card['ImsCard']['disp_quantity'] != 0){
				$out_quantity = $card['ImsCard']['disp_quantity'];
			} else $out_quantity = '';
			
			$unit_price = null;
			if($card['ImsCard']['in_unit_price'] != 0.00){
				$unit_price = $card['ImsCard']['in_unit_price'];
			}else if($card['ImsCard']['out_unit_price'] != 0){
				$unit_price = $card['ImsCard']['out_unit_price'];
			} else $unit_price = $card['ImsCard']['disp_unit_price'];
			
			$mcards[] = array(
				'ImsCard' => array(
					'id' => $card['ImsCard']['id'],
					'item' => $card['ImsItem']['name'] . ' - ' . $card['ImsItem']['description'],
					'grn_sirv_no' => $grn_sirv,
					'in_quantity' => $card['ImsCard']['in_quantity'] != 0? $card['ImsCard']['in_quantity']: '',
					'out_quantity' => $out_quantity,
					'unit_price' => $unit_price,
					'balance' => $card['ImsCard']['balance'],					
					'total_price' => $total_price,
					'out_unit_price' => $card['ImsCard']['out_unit_price'],
					'balance_in_birr' => $balance_in_birr,
					'created' => $card['ImsCard']['created'],
					'modified' => $card['ImsCard']['modified'],
					'purchase_order_id' => $purchase_order_id
				)
			);
		}
		$sums[$cur_page] = $balance;
		$this->Session->write('sums', $sums);
		
        $this->set('cards', $mcards);
		$this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }


  
   function list_data_bin_cards($id = null,$store_id = null){
   
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        
        
        $cmd="
            select null as id,td.ims_item_id,t.name as ims_sirv_item_id,null as ims_grn_item_id,
            (case when ".$store_id."<>t.from_store and t.to_store=".$store_id."  then td.issued else 0 end) as in_quantity,'null' as in_unit_price,
            (case when ".$store_id."=t.from_store then td.issued else 0 end) as out_quantity,0 as out_unit_price,0 as disp_quantity,
  0 as disp_unit_price ,'null' as status,
            0 as balance,".$store_id." as ims_store_id,td.created as created,td.modified as modified,i.name as item_name,i.description as item_description,
             'name' as full_name,st.name as supplier,'null' as ims_purchase_order_id,null as grn_name,'null' as srv_name,NULL AS ims_disposal_item_id,
             null as disp_name
            from ims_transfer_store_items t join ims_transfer_store_item_details td
            on t.id=td.ims_transfer_store_item_id join ims_items i
            on i.id=td.ims_item_id join ims_stores st 
            on st.id=t.to_store
            and td.ims_item_id=".$id." 
            and t.status='accepted'
            
            union 
            
            select c.id as id,c.ims_item_id,ims_sirv_item_id,ims_grn_item_id,in_quantity,in_unit_price,
              out_quantity,out_unit_price,c.disp_quantity,c.disp_unit_price,c.status ,balance,c.ims_store_id,c.created,c.modified,i.name as item_name,i.description as item_description,
              CONCAT(getbranch_card(c.ims_sirv_item_id),' (',CONCAT(getfullname_card(c.ims_sirv_item_id),')')) as full_name,getsupplier_card(c.ims_grn_item_id) as supplier,
             g.ims_purchase_order_id as ims_purchase_order_id,g.name as grn_name,ss.name as srv_name,c.ims_disposal_item_id,g.name as disp_name
              from ims_cards c join ims_items i
              on i.id=c.ims_item_id left join ims_grn_items gi
              on gi.id=c.ims_grn_item_id left join ims_grns g
              on g.id=gi.ims_grn_id  left join ims_sirv_items si
              on si.id=c.ims_sirv_item_id left  join ims_sirvs ss
              on ss.id=si.ims_sirv_id  left join ims_disposal_items di
              on di.id=c.ims_disposal_item_id left join ims_disposals d
              on d.id=di.ims_disposal_id
              where c.ims_item_id=".$id." 
              and c.ims_store_id=".$store_id."
            order by created;";
              
     
        $cards=$this->ImsCard->query($cmd);
       //var_dump($cards);die();
        $this->set('cards', $cards);
        $conditions['ImsCard.ims_item_id']=$id;
        $conditions['ImsCard.ims_store_id']=$store_id;
        $this->set('results', count($cards));
       // $this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
       
   }
   
   
   
   
    //  Commented due to performance issue 
    
    function list_data_bin_cards_o($id = null,$store_id = null) {		
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;
        $item_id = (isset($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : -1;
        if ($id)
            $item_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($item_id != -1) {
            $cond[0]['ImsCard.ims_item_id'] = $item_id;
			$cond[0]['ImsCard.ims_grn_item_id'] = 0;
			$cond[0]['ImsCard.ims_store_id'] = $store_id;
			
			$cond[1]['ImsCard.status !='] = '';
			$cond[1]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[1]['ImsCard.ims_item_id'] = $item_id;
			$cond[1]['ImsCard.ims_store_id'] = $store_id;
			
			$cond[2]['ImsCard.ims_item_id'] = $item_id;
			$cond[2]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[2]['ImsCard.ims_sirv_item_id !='] = 0;
			$cond[2]['ImsCard.ims_store_id'] = $store_id;
			
			$cond[3]['ImsCard.ims_item_id'] = $item_id;
			$cond[3]['ImsCard.ims_grn_item_id !='] = 0;
			$cond[3]['ImsCard.ims_disposal_item_id !='] = 0;
			$cond[3]['ImsCard.ims_store_id'] = $store_id;
			
			$conditions = array("OR" => $cond);
        }
		$this->ImsCard->unbindModel(array('belongsTo' => array('ImsStore','ImsItem'),'hasMany' => array()));
		$this->ImsCard->ImsSirvItem->unbindModel(array('belongsTo' => array('ImsItem'),'hasMany' => array()));
		$this->ImsCard->ImsGrnItem->unbindModel(array('belongsTo' => array('ImsItem'),'hasAndBelongsToMany' => array('ImsStore')));
		$this->ImsCard->recursive = 2;
    $card = $this->ImsCard->find('all', array('conditions' => $conditions, 'limit' => 6000, 'offset' => $start));
		
   
   
		$this->loadModel('ImsTransferStoreItem');
		//$this->ImsTransferStoreItem->recursive = 0;
		$condTrans[0]['ImsTransferStoreItem.from_store'] = $store_id;
		$condTrans[0]['ImsTransferStoreItem.status'] = 'accepted';
		$condTrans[1]['ImsTransferStoreItem.to_store'] = $store_id;
		$condTrans[1]['ImsTransferStoreItem.status'] = 'accepted';
		$conditionsTrans = array("OR" => $condTrans);
    $this->ImsTransferStoreItem->recursive=1;
		$transferstoreitems = $this->ImsTransferStoreItem->find('all', array('conditions' => $conditionsTrans, 'limit' => 3000, 'offset' => $start));
		$mcards = array();
		
		
		foreach($transferstoreitems as $tsi){
			foreach($tsi['ImsTransferStoreItemDetail'] as $tsid){
				if($tsid['ims_item_id'] == $item_id){
					$in_quantity = null;
					$out_quantity = null;
					$storename = null;
					if($tsi['ImsTransferStoreItem']['from_store'] == $store_id){
						$out_quantity = $tsid['issued'];
						$storename = 'To '.$tsi['ToStore']['name'].' Store';
					}
					else if($tsi['ImsTransferStoreItem']['to_store'] == $store_id){
						$in_quantity = $tsid['issued'];
						$storename = 'From '.$tsi['FromStore']['name'].' Store';
					}
					
					$mcards[] = array(
						'ImsCard' => array(
							'id' => null,
							'ims_item_id' => $tsid['ims_item_id'],
							'ims_grn_item_id' => null,
							'ims_sirv_item_id' => $tsi['ImsTransferStoreItem']['name'],
							'in_quantity' => $in_quantity,
							'out_quantity' => $out_quantity,
							'in_unit_price' => null,					
							'out_unit_price' => $storename,
							'status' => null,
							'balance' => null,
							'ims_store_id' => $store_id,
							'created' => $tsid['created'],
							'modified' => $tsid['modified']
						)
					);
				}
			}
		}		
		$cards = array_merge($card, $mcards);
		$dates;
		foreach ($cards as $key => $row) {					
			$dates[$key]  = $row['ImsCard']['created'];			
		}
		array_multisort($dates, SORT_ASC, $cards);
  // var_dump($cards);die();
        $this->set('cards', $cards);
        $this->set('results', $this->ImsCard->find('count', array('conditions' => $conditions)));
    }
    
    
    
    
    

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ImsCard->recursive = 2;
        $this->set('card', $this->ImsCard->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ImsCard->create();
            $this->autoRender = false;
            if ($this->ImsCard->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $items = $this->ImsCard->ImsItem->find('list');
        $grns = $this->ImsCard->ImsGrn->find('list');
        $this->set(compact('items', 'grns'));
    }
	
	function display($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
			$fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			$date2 = str_replace('-', '/', $fromdate);
			$yesterday = date('Y-m-d',strtotime($date2 . "+1 days"));			

			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;
			
			$conditions =array('ImsItemCategory.parent_id' => 1);  
		//	$conditions =array('ImsItemCategory.id' => 16);  			 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	      /////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$previousMonthEndingBalanceTotalCost = 0;
				$currentMonthGRNTotalCost = 0;
				$currentMonthSIRVTotalCost = 0;				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$this->ImsItem->recursive =-1;
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
					foreach ($items as $item)
					{
						$conditions =array('ImsCard.created <' => $fromdate,'ImsCard.ims_item_id' => $item['ImsItem']['id']);
						$previousMonthEndingBalance = $this->ImsCard->find('all', array('conditions' => $conditions,'order' => 'ImsCard.created ASC'));
						
						$totalprice =0;
						for($i =0; $i<count($previousMonthEndingBalance); $i++){
						
							if($previousMonthEndingBalance[$i]['ImsCard']['ims_grn_item_id'] != 0 ){//and !empty($previousMonthEndingBalance[$i]['ImsCard']['status'])								
								if($previousMonthEndingBalance[$i]['ImsCard']['in_quantity'] != 0){
									$totalprice = $totalprice + ($previousMonthEndingBalance[$i]['ImsCard']['in_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['in_unit_price']);
								}
								else $totalprice = $totalprice - ($previousMonthEndingBalance[$i]['ImsCard']['out_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['out_unit_price']);
							}
							/*else if($cards[$i]['ImsCard']['ims_sirv_item_id'] != 0 and $previousMonthEndingBalance[$i]['ImsCard']['ims_grn_item_id'] == 0){	
								$totalprice = $totalprice - ($previousMonthEndingBalance[$i]['ImsCard']['out_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['out_unit_price']);
							}*/
							else if($previousMonthEndingBalance[$i]['ImsCard']['ims_disposal_item_id'] != 0){
								$totalprice = $totalprice - ($previousMonthEndingBalance[$i]['ImsCard']['disp_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['disp_unit_price']);
							}
							else if($previousMonthEndingBalance[$i]['ImsCard']['ims_grn_item_id'] == 0 ){//and $cards[$i]['ImsCard']['out_quantity'] != 0
								$totalprice = $totalprice - ($previousMonthEndingBalance[$i]['ImsCard']['out_quantity'] * $previousMonthEndingBalance[$i]['ImsCard']['out_unit_price']);
							}
						}						
						
						$previousMonthEndingBalanceTotalCost = $previousMonthEndingBalanceTotalCost + $totalprice;
						
						$conditionsGRN =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id'],
						'ImsCard.ims_grn_item_id !=' => 0,'ImsCard.status !=' => '');
						$currentMonthGRN = $this->ImsCard->find('all', array('conditions' => $conditionsGRN));
              //var_dump($currentMonthGRN);die();
							foreach($currentMonthGRN as $cMGRN){
								$GRNcost = $cMGRN['ImsCard']['in_quantity'] * $cMGRN['ImsCard']['in_unit_price'];
                //var_dump($GRNcost);
								$currentMonthGRNTotalCost = $currentMonthGRNTotalCost + $GRNcost;
							}
                                        //  die();
					/////////////////////////////////////  grn that are adjusted because of the system errors  //////////////////////////////////////////////////////////////
						$conditionsGRN =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id'],
						'ImsCard.ims_grn_item_id !=' => 0,'ImsCard.in_quantity <' => 0);
						$currentMonthGRN = $this->ImsCard->find('all', array('conditions' => $conditionsGRN));
							foreach($currentMonthGRN as $cMGRN){
								$GRNcost = $cMGRN['ImsCard']['in_quantity'] * $cMGRN['ImsCard']['in_unit_price'];
								$currentMonthGRNTotalCost = $currentMonthGRNTotalCost + $GRNcost;
							}
					///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$conditionsSIRV =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id'],
						'ImsCard.ims_grn_item_id' => 0);
						$condsirv[0]['ImsCard.created >='] = $fromdate;
						$condsirv[0]['ImsCard.created <'] = $tomorrow;
						$condsirv[0]['ImsCard.ims_item_id'] = $item['ImsItem']['id'];
						$condsirv[0]['ImsCard.ims_grn_item_id'] = 0;
						
						$condsirv[1]['ImsCard.created >='] = $fromdate;
						$condsirv[1]['ImsCard.created <'] = $tomorrow;
						$condsirv[1]['ImsCard.ims_item_id'] = $item['ImsItem']['id'];
						$condsirv[1]['ImsCard.ims_grn_item_id !='] = 0;
						$condsirv[1]['ImsCard.out_quantity !='] = 0;
						
						$conditionsSIRV2 = array("OR" => $condsirv);
		
						$currentMonthSIRV = $this->ImsCard->find('all', array('conditions' => $conditionsSIRV2));
						foreach($currentMonthSIRV as $cMSIRV){
                                        // var_dump($cMSIRV['ImsItem']);die();
							if($cMSIRV['ImsCard']['ims_sirv_item_id'] != 0){
                    
                    $SIRVcost = $cMSIRV['ImsCard']['out_quantity'] * $cMSIRV['ImsCard']['out_unit_price'];
                    
							}
							else if($cMSIRV['ImsCard']['ims_disposal_item_id'] != 0 ){
								$SIRVcost = $cMSIRV['ImsCard']['disp_quantity'] * $cMSIRV['ImsCard']['disp_unit_price'];
							}
							$currentMonthSIRVTotalCost = $currentMonthSIRVTotalCost + $SIRVcost;
						}
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$result[0][$j+1] = $itemcategory [$j]['ImsItemCategory']['name'];
				$result[1][$j+1] = $previousMonthEndingBalanceTotalCost;
				$result[2][$j+1] = $currentMonthGRNTotalCost;
				$result[3][$j+1] = $currentMonthSIRVTotalCost;
				$result[4][$j+1] = $previousMonthEndingBalanceTotalCost + $currentMonthGRNTotalCost - $currentMonthSIRVTotalCost;
			}
				$date1 = str_replace('-', '/', $fromdate);
				$yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));
				$this->set('date',$yesterday);
				$this->set('from',$fromdate);
				$this->set('to',$todate);
				$this->set('result',$result);
        }			
    }
	
	function getChild($parentId=null){
		$this->loadModel('ImsItemCategory'); 
		$conditions =array('ImsItemCategory.parent_id' =>$parentId);
		$this->ImsItemCategory->recursive = -1;
		$children = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){				
			$children[$i]['child'] = $this->getChild($children[$i]['ImsItemCategory']['id']);
			}
			return $children;
		}
	}

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid card', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->ImsCard->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('card', $this->ImsCard->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $items = $this->ImsCard->ImsItem->find('list');
        $grns = $this->ImsCard->ImsGrn->find('list');
        $this->set(compact('items', 'grns'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for card', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->ImsCard->delete($i);
                }
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->ImsCard->delete($id)) {
                $this->Session->setFlash(__('Card deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Card was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }
	
	function getSupplier(){
		$grnitemid = $this->params['grnitemid'];
		
		$this->loadModel('ImsGrnItem');
		$conditions = array('ImsGrnItem.id' => $grnitemid);
		$this->ImsGrnItem->recursive =2;
		$grnitem = $this->ImsGrnItem->find('first',array('conditions' => $conditions));
		
		return $grnitem;
	}
	
	function getUser(){
		$sirvitemid = $this->params['sirvitemid'];
		
		$this->loadModel('ImsSirvItem');
		$conditions = array('ImsSirvItem.id' => $sirvitemid);
		$this->ImsGrnItem->recursive = 1;
		$sirvitem = $this->ImsSirvItem->find('first',array('conditions' => $conditions));
		
		$this->loadModel('ImsRequisition');
		$conditions = array('ImsRequisition.id' => $sirvitem['ImsSirv']['ims_requisition_id']);
		$this->ImsRequisition->recursive = 1;
		$requisition = $this->ImsRequisition->find('first',array('conditions' => $conditions));
		
		$this->loadModel('User');
		$conditions = array('User.id' => $requisition['ImsRequisition']['requested_by']);
		$this->User->recursive = 1;
		$user = $this->User->find('first',array('conditions' => $conditions));		
		return $user;
	}
	
	function getbranch(){
		$sirvitemid = $this->params['sirvitemid'];
		
		$this->loadModel('ImsSirvItem');
		$conditions = array('ImsSirvItem.id' => $sirvitemid);
		$this->ImsGrnItem->recursive = 1;
		$sirvitem = $this->ImsSirvItem->find('first',array('conditions' => $conditions));
		
		$this->loadModel('ImsRequisition');
		$conditions = array('ImsRequisition.id' => $sirvitem['ImsSirv']['ims_requisition_id']);
		$this->ImsRequisition->recursive = 1;
		$requisition = $this->ImsRequisition->find('first',array('conditions' => $conditions));
		
		$this->loadModel('Branch');
		$conditions = array('Branch.id' => $requisition['ImsRequisition']['branch_id']);
		$this->Branch->recursive = -1;
		$branch = $this->Branch->find('first',array('conditions' => $conditions));			
		return $branch;
	}
	
	function sirv_by_branch($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));			
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsSirv');
			$this->ImsSirv->recursive = 1;	
			$conditionssirv =array('ImsSirv.created >=' => $fromdate,'ImsSirv.created <' => $tomorrow);
			$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
			
			$this->loadModel('Branch');	
			$this->Branch->recursive =-1;
			$branches = $this->Branch->find('all',array('order' => 'Branch.name ASC'));	
			
			$result = array();
			$count = 0;
			$totalprice;
			$overallcost =0;
			$branchName = '';
			
			$brancharray = array();
			$sirvarray = array();
			$datevalue = '';
			$sirvnumber = '';
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
			foreach($branches as $branch){
			$countbranchName = 0;
			$totalprice = 0;			
				for($i=0;$i<count($sirvs);$i++)
				{	
					$countsirv=0;
					if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id'])
					{
						foreach ($itemcategory [$j]['child'] as $child)
						{
							$this->loadModel('ImsItem');
							$this->ImsItem->recursive =-1;
							$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
							$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
							
							foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
								foreach ($items as $item)
								{			
									if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){								
										$this->loadModel('ImsRequisition');
										//$this->ImsRequisition->unbindModel(array('belongsTo' => array('BudgetYear','Branch','ApprovedUser','ImsStore'),'hasMany' => array('ImsRequisitionItem','ImsStoresCard')));
										$this->ImsRequisition->recursive =2;
										$conditions =array('ImsRequisition.id' => $sirvs[$i]['ImsRequisition']['id']);
										$requisition = $this->ImsRequisition->find('all', array('conditions' => $conditions));
										$this->loadModel('User');
										$this->User->recursive =1;
										$conditionsUser =array('User.id' => $requisition[0]['ImsRequisition']['requested_by']);
										$user = $this->User->find('all', array('conditions' => $conditionsUser));
										
										if($item['ImsItem']['booked'] == 1){
											if($branch['Branch']['name'] != $branchName)
											{
												$result[$count][0] = $branch['Branch']['name'];
												$branchName = $branch['Branch']['name'];
											}											
											if($sirvs[$i]['ImsSirv']['created'] != $datevalue)
											{
												$result[$count][1] = date('d-M-Y', strtotime($sirvs[$i]['ImsSirv']['created']));
												$datevalue = $sirvs[$i]['ImsSirv']['created'];
											}
											
											if($sirvs[$i]['ImsSirv']['name'] != $sirvnumber)
											{
												$result[$count][2] = $sirvs[$i]['ImsSirv']['name'];
												$sirvnumber = $sirvs[$i]['ImsSirv']['name'];
											}
											
											$result[$count][3] = $item['ImsItem']['description'];
											$result[$count][4] = $item['ImsItem']['name'];
											$result[$count][5] = $sirvItem['quantity'];
											$result[$count][6] = $sirvItem['unit_price'];
											$result[$count][7] = number_format($sirvItem['quantity'] * $sirvItem['unit_price'],2,'.',',');
											$result[$count][8] = $sirvs[$i]['ImsSirv']['status'];											
											$result[$count][9] = $user[0]['Person']['first_name'].' '.$user[0]['Person']['middle_name'].' '.$user[0]['Person']['last_name'];
											$result[$count][10] = array($branch['Branch']['name'],$count);
											
											$this->loadModel('ImsTag');
											$this->ImsTag->recursive =-1;
											$conditionsTag =array('ImsTag.ims_sirv_item_id' => $sirvItem['id']);
											$tag = $this->ImsTag->find('all', array('conditions' => $conditionsTag));
											$result[$count][11] = $tag[0]['ImsTag']['code'];
											
											if($sirvItem['grn_date'] != '0000-00-00'){
												$result[$count][12] = date('d-M-Y', strtotime( $sirvItem['grn_date']));
											}
											
											$totalprice = $totalprice + ($sirvItem['quantity'] * $sirvItem['unit_price']);
											$count++;
											$countbranchName++;
											$countsirv++;
										}								
									}
								}						
							}						
						}
					}
					$sirvarray[$branch['Branch']['name']][$sirvs[$i]['ImsSirv']['name']] = $countsirv;				
				}
				$brancharray[$branch['Branch']['name']] = $countbranchName;	
				
				if($totalprice != 0)
				{					
					$result[$count][3] = 'Grand Total';
					$result[$count][4] = number_format($totalprice,2,'.',',');
					$overallcost = $overallcost + $totalprice;
					$count++;
				}
			}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
				if($overallcost != 0){
					$result[$count][3] = 'Over All Total';
					$result[$count][4] = number_format($overallcost,2,'.',',');
				}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('brancharray',$brancharray);
				$this->set('sirvarray',$sirvarray);				
        }		
    }
	
	function sirv_grn_by_category($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsSirv');
			$this->ImsSirv->recursive = 1;	
			$conditionssirv =array('ImsSirv.created >=' => $fromdate,'ImsSirv.created <' => $tomorrow);
			$sirvs =$this->ImsSirv->find('all', array('conditions' => $conditionssirv));	
      
      //var_dump($sirvs);die();		
			
			$this->loadModel('ImsGrn');
			$this->ImsGrn->unbindModel(array('belongsTo' => array('ImsSupplier','ImsPurchaseOrder')));
			$this->ImsGrn->recursive =3;	
			$conditions =array('ImsGrn.created >=' => $fromdate,'ImsGrn.created <' => $tomorrow,'ImsGrn.status' => 'approved');
			$grns = $this->ImsGrn->find('all', array('conditions' => $conditions));
		
			$resultSIRV = array();
			$resultGRN = array();
			$this->loadModel('Branch');	
			$this->Branch->recursive =-1;
			$branches = $this->Branch->find('all',array('order' => 'Branch.name ASC'));	

			$branchName = '';
			$brancharray = array();
			$branchNameHOffice = '';
			$brancharrayHOffice = array();
			
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
			$this->loadModel('ImsItem');
			$this->ImsItem->recursive =-1;
			$this->loadModel('ImsCard');
			$this->loadModel('User');
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////	
				$countsirv=0;
				$countsirvHeadOffice=0;
				$countbranchsirv =0;
				$countbranchsirvHeadOffice =0;
				$HeadOfficeOverAllCost =0;
				$BranchOverAllCost =0;
				$totalExpense = 0;
				$totalgrn = 0;
				foreach($branches as $branch){
					$countbranchName = 0;
					$countbranchNameHOffice = 0;
					if($branch['Branch']['branch_category_id'] == 1)
					{
						$totalpricebranch =0;
						for($i=0;$i<count($sirvs);$i++)
						{	
							if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
								$totalprice =0;
								foreach ($itemcategory [$j]['child'] as $child)
								{	
									
									$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
									$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
									foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
										foreach($items as $item){								
											if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
												if($item['ImsItem']['booked'] == 0){
													$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
													$totalprice = $totalprice + $price;	
												}
											}
										}
									}						
								}
								
								$this->Branch->recursive =-1;
								$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
								$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
								
								$myvalue = $sirvs[$i]['ImsSirv']['created'];
								$datetime = new DateTime($myvalue);
								$date = $datetime->format('Y-m-d');
								
								if($totalprice != 0){
									$resultSIRV[$countsirv][0] = $date;
									$resultSIRV[$countsirv][1] = $sirvs[$i]['ImsSirv']['name'];
									if($branch['Branch']['name'] != $branchName)
									{
										$resultSIRV[$countsirv][2] = $branch['Branch']['name'];
										$branchName = $branch['Branch']['name'];
									}									
									$resultSIRV[$countsirv][3] = number_format($totalprice,4,'.',',');
									$countsirv++;
									$countbranchsirv = $countsirv; 
									$totalpricebranch = $totalpricebranch + $totalprice;
									$countbranchName++;
								}
							}
						}
						$brancharray[$branch['Branch']['name']] = $countbranchName;
						if($totalpricebranch != 0 && $countsirv > ($countbranchsirv -1)){
							$resultSIRV[$countsirv][0] = '';
							$resultSIRV[$countsirv][1] = '';
							$resultSIRV[$countsirv][2] = 'Grand Total';
							$resultSIRV[$countsirv][3] = number_format($totalpricebranch,2,'.',',');
							$countsirv++;
							$countbranchsirv = $countsirv;
							$BranchOverAllCost = $BranchOverAllCost + $totalpricebranch;
						}
					}
					else if($branch['Branch']['branch_category_id'] == 2)
					{
						$totalpriceheadoffice =0;
						for($i=0;$i<count($sirvs);$i++)
						{	
							if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
								$totalprice =0;
								foreach ($itemcategory [$j]['child'] as $child)
								{	
									//$this->loadModel('ImsItem');
									$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
									$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
									foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
										foreach($items as $item){								
											if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
												if($item['ImsItem']['booked'] == 0){
													$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
													$totalprice = $totalprice + $price;
												}
											}
										}
									}						
								}
								
								$this->Branch->recursive =-1;
								$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
								$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
								
								$myvalue = $sirvs[$i]['ImsSirv']['created'];
								$datetime = new DateTime($myvalue);
								$date = $datetime->format('Y-m-d');
								
								if($totalprice != 0){
									$resultSIRVHeadOffice[$countsirvHeadOffice][0] = $date;
									$resultSIRVHeadOffice[$countsirvHeadOffice][1] = $sirvs[$i]['ImsSirv']['name'];
									
									if($branch['Branch']['name'] != $branchNameHOffice)
									{
										$resultSIRVHeadOffice[$countsirvHeadOffice][2] = $branch['Branch']['name'];
										$branchNameHOffice = $branch['Branch']['name'];
									}									
									$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($totalprice,4,'.',',');
									$countsirvHeadOffice++;
									$countbranchsirvHeadOffice = $countsirvHeadOffice; 
									$totalpriceheadoffice = $totalpriceheadoffice + $totalprice;
									$countbranchNameHOffice++;
								}
							}
						}
						$brancharrayHOffice[$branch['Branch']['name']] = $countbranchNameHOffice;
						if($totalpriceheadoffice != 0 && $countsirvHeadOffice > ($countbranchsirvHeadOffice -1)){
							$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
							$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
							$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Grand Total';
							$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($totalpriceheadoffice,2,'.',',');
							$countsirvHeadOffice++;
							$countbranchsirvHeadOffice = $countsirvHeadOffice; 							
							$HeadOfficeOverAllCost = $HeadOfficeOverAllCost + $totalpriceheadoffice;
						}
					}
				}
				
				   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			

	/////////////////////  GRN  ///////////////////////////////////////////////////////////////////////////////////////////////////	
				$countgrn=0;
				$adjustment;
				$grn ='';
				for($i=0;$i<count($grns);$i++)
				{						
					$totalprice =0;					
					if($grns[$i]['ImsGrn']['ims_supplier_id'] != 0){
						$adjustment='';
						$grn = $grns[$i]['ImsGrn']['name'];
						foreach($grns[$i]['ImsGrnItem'] as $grnItem){
							foreach ($itemcategory [$j]['child'] as $child)
							{
								//$this->loadModel('ImsItem');
								$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
								$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
														
								foreach($items as $item){								
									if($item['ImsItem']['id'] == $grnItem['ImsPurchaseOrderItem']['ims_item_id']){
									$price = $grnItem['quantity'] * $grnItem['unit_price'];
										$totalprice = $totalprice + $price;
									}
								}
							}						
						}
					}
					else if($grns[$i]['ImsGrn']['ims_supplier_id'] == 0){
						$adjustment = 'Adjustment';							 
						foreach($grns[$i]['ImsGrnItem'] as $grnItem){
							
							$this->ImsCard->recursive =2;
							$this->ImsCard->unbindModel(array('belongsTo' => array('ImsItem','ImsGrnItem','ImsStore')));
							$conditionsCard =array('ImsCard.ims_grn_item_id' => $grnItem['id']);
							$card = $this->ImsCard->find('first', array('conditions' => $conditionsCard));
							$grn = $card['ImsSirvItem']['ImsSirv']['name'];							
							foreach ($itemcategory [$j]['child'] as $child)
							{
								//$this->loadModel('ImsItem');
								$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
								$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
														
								foreach($items as $item){	
									if($item['ImsItem']['id'] == $card['ImsCard']['ims_item_id']){
									$price = $grnItem['quantity'] * $grnItem['unit_price'];
										$totalprice = $totalprice + $price;
									}
								}
							}						
						}
					}
					$myvalue = $grns[$i]['ImsGrn']['created'];
					$datetime = new DateTime($myvalue);
					$date = $datetime->format('Y-m-d');
					
					if($totalprice != 0){
						$resultGRN[$countgrn][0] = $date;
						$resultGRN[$countgrn][1] = $grn;
						$resultGRN[$countgrn][2] = number_format($totalprice,2,'.',',');
						$resultGRN[$countgrn][3] = $adjustment;
						//////////////////////////////////////////////////////////////users //////////////////////////////////
						
						$this->User->recursive =0;
						
						$conditionsUsercreated =array('User.id' => $grns[$i]['ImsGrn']['created_by']);
						$usercreated = $this->User->find('first', array('conditions' => $conditionsUsercreated));
						$resultGRN[$countgrn][4] = $usercreated['Person']['first_name'].' '.$usercreated['Person']['middle_name'].' '.$usercreated['Person']['last_name'];
						
						$conditionsUserapproved =array('User.id' => $grns[$i]['ImsGrn']['approved_by']);
						$userapproved = $this->User->find('first', array('conditions' => $conditionsUserapproved));
						$resultGRN[$countgrn][5] = $userapproved['Person']['first_name'].' '.$userapproved['Person']['middle_name'].' '.$userapproved['Person']['last_name'];
			//////////////////////////////////////////////////////////////////////////////////////////////////////
						$countgrn++;
						$totalgrn = $totalgrn + $totalprice;
					}					
				}				
				$resultGRN[$countgrn][0] = '';
				$resultGRN[$countgrn][1] = 'Total Cost';
				$resultGRN[$countgrn][2] = number_format($totalgrn,2,'.',',');
				$resultGRN[$countgrn][3] = '';
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Over All Total';
			$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($HeadOfficeOverAllCost,2,'.',',');
			
			$resultSIRV[$countsirv][0] = '';
			$resultSIRV[$countsirv][1] = '';
			$resultSIRV[$countsirv][2] = 'Over All Total';
			$resultSIRV[$countsirv][3] = number_format($BranchOverAllCost,2,'.',',');
			}				
				$this->set('resultSIRV',$resultSIRV);
				$this->set('resultSIRVHeadOffice',$resultSIRVHeadOffice);
				$this->set('resultGRN',$resultGRN);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('brancharray',$brancharray);
				$this->set('brancharrayHOffice',$brancharrayHOffice);
				$totalExpense = $HeadOfficeOverAllCost + $BranchOverAllCost;
				$this->set('totalExpense',$totalExpense);
        }		
    }

	function sirv_all_category($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.parent_id' => 1);
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsSirv');
			$this->ImsSirv->recursive = 1;	
			$conditionssirv =array('ImsSirv.created >=' => $fromdate,'ImsSirv.created <' => $tomorrow);
			$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));	
			
			$resultSIRV = array();			
			$this->loadModel('Branch');	
			$this->Branch->recursive =-1;
			$branches = $this->Branch->find('all',array('order' => 'Branch.name ASC'));	

			$branchName = '';
			$brancharray = array();
			$branchNameHOffice = '';
			$brancharrayHOffice = array();	
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////	
				$countsirv=0;
				$countsirvHeadOffice=0;
				$countbranchsirv =0;
				$countbranchsirvHeadOffice =0;
				$HeadOfficeOverAllCost =0;
				$BranchOverAllCost =0;
				$totalExpense = 0;
				$totalgrn = 0;
				foreach($branches as $branch){
					$countbranchName = 0;
					$countbranchNameHOffice = 0;
					$grandtotalbranch =0;
					$grandtotalHeadOffice =0;
					
					for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
						$itemcategory [$j]['child'][] = $itemcategory[$j];						
			
						if($branch['Branch']['branch_category_id'] == 1)
						{
							$totalpricebranch =0;							
							for($i=0;$i<count($sirvs);$i++)
							{	
								if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
									$totalprice =0;
									foreach ($itemcategory [$j]['child'] as $child)
									{	
										$this->loadModel('ImsItem');
										$this->ImsItem->recursive =-1;
										$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
										$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
										foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
											foreach($items as $item){								
												if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
													if($item['ImsItem']['booked'] == 0){
														$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
														$totalprice = $totalprice + $price;	
													}
												}
											}
										}						
									}
									
									$this->Branch->recursive =-1;
									$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
									$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
									
									$myvalue = $sirvs[$i]['ImsSirv']['created'];
									$datetime = new DateTime($myvalue);
									$date = $datetime->format('Y-m-d');
									
									if($totalprice != 0){
										$resultSIRV[$countsirv][0] = $date;
										$resultSIRV[$countsirv][1] = $sirvs[$i]['ImsSirv']['name'];
										if($branch['Branch']['name'] != $branchName)
										{
											$resultSIRV[$countsirv][2] = $branch['Branch']['name'];
											$branchName = $branch['Branch']['name'];
										}									
										$resultSIRV[$countsirv][3] = number_format($totalprice,4,'.',',');
										$countsirv++;
										$countbranchsirv = $countsirv; 
										$totalpricebranch = $totalpricebranch + $totalprice;
										$countbranchName++;
									}
								}
							}
							
							if($totalpricebranch != 0 && $countsirv > ($countbranchsirv -1)){
								$resultSIRV[$countsirv][0] = '';
								$resultSIRV[$countsirv][1] = '';
								$resultSIRV[$countsirv][2] = '';
								$resultSIRV[$countsirv][3] = $itemcategory[$j]['ImsItemCategory']['name'].' '.number_format($totalpricebranch,2,'.',',');
								$countsirv++;
								$countbranchsirv = $countsirv;
								$BranchOverAllCost = $BranchOverAllCost + $totalpricebranch;
								$grandtotalbranch = $grandtotalbranch + $totalpricebranch;
								$countbranchName++;
							}
						}
						else if($branch['Branch']['branch_category_id'] == 2)
						{
							$totalpriceheadoffice =0;
							for($i=0;$i<count($sirvs);$i++)
							{	
								if($branch['Branch']['id'] ==$sirvs[$i]['ImsRequisition']['branch_id']){
									$totalprice =0;
									foreach ($itemcategory [$j]['child'] as $child)
									{	
										$this->loadModel('ImsItem');
										$this->ImsItem->recursive =-1;
										$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
										$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
										foreach($sirvs[$i]['ImsSirvItem'] as $sirvItem){
											foreach($items as $item){								
												if($item['ImsItem']['id'] == $sirvItem['ims_item_id']){
													if($item['ImsItem']['booked'] == 0){
														$price = $sirvItem['quantity'] * $sirvItem['unit_price'];
														$totalprice = $totalprice + $price;
													}
												}
											}
										}						
									}
									
									$this->Branch->recursive =-1;
									$conditionsBranch =array('Branch.id' => $sirvs[$i]['ImsRequisition']['branch_id']);
									$branch = $this->Branch->find('first', array('conditions' => $conditionsBranch));
									
									$myvalue = $sirvs[$i]['ImsSirv']['created'];
									$datetime = new DateTime($myvalue);
									$date = $datetime->format('Y-m-d');
									
									if($totalprice != 0){
										$resultSIRVHeadOffice[$countsirvHeadOffice][0] = $date;
										$resultSIRVHeadOffice[$countsirvHeadOffice][1] = $sirvs[$i]['ImsSirv']['name'];
										
										if($branch['Branch']['name'] != $branchNameHOffice)
										{
											$resultSIRVHeadOffice[$countsirvHeadOffice][2] = $branch['Branch']['name'];
											$branchNameHOffice = $branch['Branch']['name'];
										}									
										$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($totalprice,4,'.',',');
										$countsirvHeadOffice++;
										$countbranchsirvHeadOffice = $countsirvHeadOffice; 
										$totalpriceheadoffice = $totalpriceheadoffice + $totalprice;
										$countbranchNameHOffice++;
									}
								}
							}							
							if($totalpriceheadoffice != 0 && $countsirvHeadOffice > ($countbranchsirvHeadOffice -1)){
								$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
								$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
								$resultSIRVHeadOffice[$countsirvHeadOffice][2] = '';
								$resultSIRVHeadOffice[$countsirvHeadOffice][3] = $itemcategory[$j]['ImsItemCategory']['name'].' '.number_format($totalpriceheadoffice,2,'.',',');
								$countsirvHeadOffice++;
								$countbranchsirvHeadOffice = $countsirvHeadOffice; 							
								$HeadOfficeOverAllCost = $HeadOfficeOverAllCost + $totalpriceheadoffice;
								$grandtotalHeadOffice = $grandtotalHeadOffice + $totalpriceheadoffice;
								$countbranchNameHOffice++;
							}
						}
					}
					$brancharray[$branch['Branch']['name']] = $countbranchName;					
					$brancharrayHOffice[$branch['Branch']['name']] = $countbranchNameHOffice;
					
					if($grandtotalbranch > 0){
						$resultSIRV[$countsirv][0] = '';
						$resultSIRV[$countsirv][1] = '';
						$resultSIRV[$countsirv][2] = 'Grand Total';
						$resultSIRV[$countsirv][3] = number_format($grandtotalbranch,2,'.',',');
						$countsirv++;
						$countbranchsirv = $countsirv;	
					}
					if($grandtotalHeadOffice > 0){
						$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
						$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
						$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Grand Total';
						$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($grandtotalHeadOffice,2,'.',',');
						$countsirvHeadOffice++;
						$countbranchsirvHeadOffice = $countsirvHeadOffice;
					}
				}				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$resultSIRVHeadOffice[$countsirvHeadOffice][0] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][1] = '';
			$resultSIRVHeadOffice[$countsirvHeadOffice][2] = 'Over All Total';
			$resultSIRVHeadOffice[$countsirvHeadOffice][3] = number_format($HeadOfficeOverAllCost,2,'.',',');
			
			$resultSIRV[$countsirv][0] = '';
			$resultSIRV[$countsirv][1] = '';
			$resultSIRV[$countsirv][2] = 'Over All Total';
			$resultSIRV[$countsirv][3] = number_format($BranchOverAllCost,2,'.',',');
							
				$this->set('resultSIRV',$resultSIRV);
				$this->set('resultSIRVHeadOffice',$resultSIRVHeadOffice);
				$this->set('brancharray',$brancharray);
				$this->set('brancharrayHOffice',$brancharrayHOffice);
				$totalExpense = $HeadOfficeOverAllCost + $BranchOverAllCost;
				$this->set('totalExpense',$totalExpense);
				
				
				/////////////////   SIRV Adjustement    ////////////////////////////////////////////////////////////////////////
				$this->ImsCard->recursive = 2;
				$conditionssirvcard =array('ImsCard.out_quantity !=' => 0,'ImsCard.ims_grn_item_id !=' => 0,'ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow);
				$cardssirvadj = $this->ImsCard->find('all', array('conditions' => $conditionssirvcard, 'order' => 'ImsCard.id ASC'));
				$resultSIRVAdj = array();
				for($sirvadj=0;$sirvadj<count($cardssirvadj);$sirvadj++){
					$resultSIRVAdj[$sirvadj][0] = $cardssirvadj[$sirvadj]['ImsCard']['created'];
					$resultSIRVAdj[$sirvadj][1] = $cardssirvadj[$sirvadj]['ImsGrnItem']['ImsGrn']['name'];
					$resultSIRVAdj[$sirvadj][2] = $cardssirvadj[$sirvadj]['ImsSirvItem']['ImsSirv']['name'];
					$totalsirvadj = number_format($cardssirvadj[$sirvadj]['ImsCard']['out_quantity'] * $cardssirvadj[$sirvadj]['ImsCard']['out_unit_price'] , 4 , '.' , ',' );
					$resultSIRVAdj[$sirvadj][3] = $totalsirvadj;					
				}				
				$this->set('resultSIRVAdj',$resultSIRVAdj);				
        }		
    }
		
	function balance_by_category($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
            $date=$this->data['ImsCard']['date'];
			$date1 = str_replace('-', '/', $date);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('ImsItemCategory'); 
			$this->loadModel('ImsStoresItem'); 
			$this->ImsItemCategory->recursive =-1;
			$this->loadModel('ImsItem');
			$this->loadModel('ImsGrn');
			$this->ImsItem->recursive = -1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']); 						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			$totalprice = 0;
			$grn_date = null;
			$grn_number = null;
			$price = null;
			$quan_indiv = null;
			$balance =0;
			$grandTotalPrice =0;
			$meas = null;
			$count = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem,'order' => 'ImsItem.description ASC'));
					foreach ($items as $item)
					{	
					  
						$this->ImsCard->recursive =1;
						$this->ImsCard->unbindModel(array('belongsTo' => array('ImsItem','ImsStore')));
						$conditions =array('ImsCard.created <' => $tomorrow,'ImsCard.ims_item_id' => $item['ImsItem']['id']);
						$cards = $this->ImsCard->find('all', array('conditions' => $conditions,'order' => 'ImsCard.created ASC'));	

						$addisababaBalance = 0;
						$bahirdarBalance = 0;
						$desseBalance = 0;
						
						for($i =0; $i<count($cards); $i++){
							if($cards[$i]['ImsCard']['ims_grn_item_id'] != 0 and $cards[$i]['ImsCard']['status'] != ''){
								if($cards[$i]['ImsCard']['status'] != 'D'){									
									$price = $price .' ' . $cards[$i]['ImsCard']['in_unit_price'].',';									
									$grn_date = $grn_date .'   '. date("m/d/Y", strtotime($cards[$i]['ImsCard']['created']));
									$this->ImsGrn->recursive = -1;
									$grn = $this->ImsGrn->read(null, $cards[$i]['ImsGrnItem']['ims_grn_id']);									
									$grn_number = $grn_number .' '. $grn['ImsGrn']['name'].',';
								}
								if(!empty($cards[$i]['ImsGrnItem']['ImsPurchaseOrderItem']['measurement'])){
									$meas = $cards[$i]['ImsGrnItem']['ImsPurchaseOrderItem']['measurement'];
								}
								$totalprice = $totalprice + ($cards[$i]['ImsCard']['in_quantity'] * $cards[$i]['ImsCard']['in_unit_price']);
								$balance = sprintf("%.2f",$balance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								
								if($cards[$i]['ImsCard']['status'] == 'A'){
									$quan_indiv = $quan_indiv . ' ' . $cards[$i]['ImsCard']['in_quantity'].',';
								}
								else if($cards[$i]['ImsCard']['status'] == 'S'){
									$quan_indiv = $quan_indiv . ' <' . $cards[$i]['ImsCard']['in_quantity'].',';
								}
								
								if($cards[$i]['ImsCard']['ims_store_id'] == 1){
									$addisababaBalance = sprintf("%.2f",$addisababaBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 2){
									$bahirdarBalance = sprintf("%.2f",$bahirdarBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 3){
									$desseBalance = sprintf("%.2f",$desseBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
							}
							else if($cards[$i]['ImsCard']['ims_grn_item_id'] != 0 and $cards[$i]['ImsCard']['in_quantity'] < 0){
								if($cards[$i]['ImsCard']['status'] != 'D'){
									$price = $price .' ' .$cards[$i]['ImsCard']['in_unit_price'].',';
									$grn_date = $grn_date .'  '.date("M d, Y", strtotime($cards[$i]['ImsCard']['created']));
									$this->ImsGrn->recursive = -1;
									$grn = $this->ImsGrn->read(null, $cards[$i]['ImsGrnItem']['ims_grn_id']);									
									$grn_number = $grn_number .' '. $grn['ImsGrn']['name'].',';
								}
								if(!empty($cards[$i]['ImsGrnItem']['ImsPurchaseOrderItem']['measurement'])){
									$meas = $cards[$i]['ImsGrnItem']['ImsPurchaseOrderItem']['measurement'];
								}
								$totalprice = $totalprice + ($cards[$i]['ImsCard']['in_quantity'] * $cards[$i]['ImsCard']['in_unit_price']);
								$balance = sprintf("%.2f",$balance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								
								if($cards[$i]['ImsCard']['status'] == 'A'){
									$quan_indiv = $quan_indiv . ' ' . $cards[$i]['ImsCard']['in_quantity'].',';
								}
								else if($cards[$i]['ImsCard']['status'] == 'S'){
									$quan_indiv = $quan_indiv . ' <' . $cards[$i]['ImsCard']['in_quantity'].',';
								}
								
								if($cards[$i]['ImsCard']['ims_store_id'] == 1){
									$addisababaBalance = sprintf("%.2f", $addisababaBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 2){
									$bahirdarBalance = sprintf("%.2f", $bahirdarBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 3){
									$desseBalance = sprintf("%.2f", $desseBalance) + sprintf("%.2f", $cards[$i]['ImsCard']['in_quantity']);
								}
							}
							else if($cards[$i]['ImsCard']['ims_grn_item_id'] == 0 and $cards[$i]['ImsCard']['ims_sirv_item_id'] != 0){
								/*if($cards[$i]['ImsCard']['balance'] !=0){
									$price = $cards[$i]['ImsCard']['out_unit_price'];
								}*/
								$meas = $cards[$i]['ImsSirvItem']['measurement'];
								$totalprice = $totalprice - ($cards[$i]['ImsCard']['out_quantity'] * $cards[$i]['ImsCard']['out_unit_price']);
								$balance = sprintf("%.2f",$balance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								
								if($cards[$i]['ImsCard']['ims_store_id'] == 1){
									$addisababaBalance = sprintf("%.2f",$addisababaBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 2){
									$bahirdarBalance = sprintf("%.2f", $bahirdarBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 3){
									$desseBalance = sprintf("%.2f",$desseBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
							}
							else if($cards[$i]['ImsCard']['ims_disposal_item_id'] != 0){
								/*if($cards[$i]['ImsCard']['balance'] !=0){
									$price = $cards[$i]['ImsCard']['disp_unit_price'];
								}*/
								$meas = $cards[$i]['ImsDisposalItem']['measurement'];
								$totalprice = $totalprice - ($cards[$i]['ImsCard']['disp_quantity'] * $cards[$i]['ImsCard']['disp_unit_price']);
								$balance = sprintf("%.2f",$balance) - sprintf("%.2f",$cards[$i]['ImsCard']['disp_quantity']);
								
								if($cards[$i]['ImsCard']['ims_store_id'] == 1){
									$addisababaBalance = sprintf("%.2f",$addisababaBalance) - sprintf("%.2f",$cards[$i]['ImsCard']['disp_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 2){
									$bahirdarBalance = sprintf("%.2f",$bahirdarBalance) - sprintf("%.2f",$cards[$i]['ImsCard']['disp_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 3){
									$desseBalance = sprintf("%.2f",$desseBalance) - sprintf("%.2f",$cards[$i]['ImsCard']['disp_quantity']);
								}
							}
							else if($cards[$i]['ImsCard']['ims_grn_item_id'] != 0 and $cards[$i]['ImsCard']['out_quantity'] != 0){
								/*if($cards[$i]['ImsCard']['balance'] !=0){
									$price = $cards[$i]['ImsCard']['out_unit_price'];
								}*/
								$meas = $cards[$i]['ImsSirvItem']['measurement'];
								$totalprice = $totalprice - ($cards[$i]['ImsCard']['out_quantity'] * $cards[$i]['ImsCard']['out_unit_price']);
								$balance = sprintf("%.2f",$balance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								
								if($cards[$i]['ImsCard']['ims_store_id'] == 1){
									$addisababaBalance = sprintf("%.2f",$addisababaBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 2){
									$bahirdarBalance = sprintf("%.2f",$bahirdarBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
								else if($cards[$i]['ImsCard']['ims_store_id'] == 3){
									$desseBalance = sprintf("%.2f",$desseBalance) - sprintf("%.2f", $cards[$i]['ImsCard']['out_quantity']);
								}
							}
							
						}
						if($balance == 0){
							$price =0;
							$grn_date = null;
							$grn_number = null;
							$quan_indiv = null;
						}
						/*$conditionsAAS =array('ImsStoresItem.ims_store_id' => '1','ImsStoresItem.ims_item_id' => $item['ImsItem']['id']);
						$storeitemAA = $this->ImsStoresItem->find('first', array('conditions' => $conditionsAAS));
						
						$conditionsBDS =array('ImsStoresItem.ims_store_id' => '2','ImsStoresItem.ims_item_id' => $item['ImsItem']['id']);
						$storeitemBD = $this->ImsStoresItem->find('first', array('conditions' => $conditionsBDS));
						
						$conditionsDS =array('ImsStoresItem.ims_store_id' => '3','ImsStoresItem.ims_item_id' => $item['ImsItem']['id']);
						$storeitemD = $this->ImsStoresItem->find('first', array('conditions' => $conditionsDS));*/
						
						
						$this->loadModel('ImsTransferStoreItem');
						//$this->ImsTransferStoreItem->recursive = 0;
						$this->ImsTransferStoreItem->unbindModel(array('belongsTo' => array('FromStoreKeeper','ToStoreKeeper','','')));
						$conditionsTrans = array('ImsTransferStoreItem.status' => 'accepted','ImsTransferStoreItem.created <' => $tomorrow);
						$transferstoreitems = $this->ImsTransferStoreItem->find('all', array('conditions' => $conditionsTrans));
						
						foreach($transferstoreitems as $tsi){
							foreach($tsi['ImsTransferStoreItemDetail'] as $tsid){
								if($tsid['ims_item_id'] == $item['ImsItem']['id']){
									
									if($tsi['ImsTransferStoreItem']['from_store'] == 1){
										$addisababaBalance -= $tsid['issued'];
									}
									else if($tsi['ImsTransferStoreItem']['from_store'] == 2){
										$bahirdarBalance -= $tsid['issued'];
									}
									else if($tsi['ImsTransferStoreItem']['from_store'] == 3){
										$desseBalance -= $tsid['issued'];
									}
									
									if($tsi['ImsTransferStoreItem']['to_store'] == 1){
										$addisababaBalance += $tsid['issued'];
									}
									else if($tsi['ImsTransferStoreItem']['to_store'] == 2){
										$bahirdarBalance += $tsid['issued'];
									}
									else if($tsi['ImsTransferStoreItem']['to_store'] == 3){
										$desseBalance += $tsid['issued'];
									}
								}
							}
						}
						
						$result[$count][0] = $count+1;
						$result[$count][1] = $item['ImsItem']['description'];
						$result[$count][2] = $item['ImsItem']['name'];
						$result[$count][3] = $meas;
						$result[$count][4] = $balance;
						$result[$count][5] = $addisababaBalance;
						$result[$count][6] = $bahirdarBalance;
						$result[$count][7] = $desseBalance;
						$result[$count][8] = $price;
						$result[$count][9] = number_format($totalprice,4,'.',',');
						$result[$count][10] = $grn_date;
						$result[$count][11] = $grn_number;
						$result[$count][12] = $quan_indiv;
						
						
						$grandTotalPrice += $totalprice;
						$count++;
						$meas = null;
						$price = null;
						$grn_date = null;
						$grn_number = null;
						$quan_indiv = null;
						$totalprice =0;
						$balance = 0;
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('grandTotalPrice',number_format($grandTotalPrice,4,'.',','));
        }			
    }
	
	function min_max_by_category($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
            $minmax=$this->data['ImsCard']['minmax'];
			$store=$this->data['ImsCard']['store'];

			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']); 						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$result = array();
			$count = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  CARD  ///////////////////////////////////////////////////////////////////////////////////////////////////				
				
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));					
					foreach ($items as $item)
					{	
						$this->loadModel('ImsStoresItem');
						$this->ImsStoresItem->recursive =-1;
						$conditions =array('ImsStoresItem.ims_item_id' => $item['ImsItem']['id'], 'ImsStoresItem.ims_store_id' => $store);
						$storeItem = $this->ImsStoresItem->find('first', array('conditions' => $conditions,'order' => 'ImsStoresItem.id DESC'));
						
						if($minmax == 'Min'){
							if($storeItem['ImsStoresItem']['balance'] <= $item['ImsItem']['min_level']){
								$result[$count][0] = $count+1;
								$result[$count][1] = $item['ImsItem']['description'];
								$result[$count][2] = $item['ImsItem']['name'];
								$result[$count][3] = $item['ImsItem']['min_level'];
								$result[$count][4] = $storeItem['ImsStoresItem']['balance'];
								$count++;
							}
						}
						else if($minmax == 'Max'){
							if($storeItem['ImsStoresItem']['balance'] >= $item['ImsItem']['max_level']){
								$result[$count][0] = $count+1;
								$result[$count][1] = $item['ImsItem']['description'];
								$result[$count][2] = $item['ImsItem']['name'];
								$result[$count][3] = $item['ImsItem']['max_level'];
								$result[$count][4] = $storeItem['ImsStoresItem']['balance'];
								$count++;
							}
						}						
					}						
				}	
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			}
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
        }			
    }
	
	function emp_card($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $personId=$this->data['ImsCard']['employee'];				
			$this->loadModel('User'); 
			$this->User->recursive =-1;			
			$conditions =array('User.person_id' => $personId);  						 
			$user = $this->User->find('first', array('conditions' => $conditions));
			
			$this->loadModel('ImsRequisition'); 
			$this->ImsRequisition->recursive =-1;			
			$conditionsreq =array('ImsRequisition.requested_by' => $user['User']['id'],'ImsRequisition.status' => 'completed');  						 
			$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
			
			$result = array();
			$count = 0;
			$totalprice = 0;
			$sirvarray = array();
			$sirvname = '';
			
			
			$this->loadModel('ImsSirv');				
			$this->ImsSirv->recursive =2;	
			
			for($j=0;$j<count($requisitions );$j++){						
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsCard'); 		
				$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
				$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
				
				for($i=0;$i<count($sirvs);$i++)
				{	
					$countsirv = 0;
					if($sirvname = '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
						$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];
					}
					foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){
						if($sirvitems['ImsItem']['booked'] == 1){
							
							$this->ImsCard->recursive =-1;							
							$conditionscard =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity >' => 0);  						 
							$card = $this->ImsCard->find('all', array('conditions' => $conditionscard));
							if(empty($card)){
								$transferedQuantity = 0;
								$quantity = 0;
								foreach($sirvs[$i]['ImsTransfer'] as $transferItems){ 
									foreach($transferItems['ImsTransferItem'] as $transferItem){ 
										if($transferItem['ims_item_id'] == $sirvitems['ImsItem']['id'] and $transferItems['from_user'] == $user['User']['id']){
											$transferedQuantity = $transferedQuantity + $transferItem['quantity'];
										}
									}
								}
								$quantity = $sirvitems['quantity'] - $transferedQuantity;
								
								$returnedQuantity = 0;
								foreach($sirvs[$i]['ImsSirvItem'] as $returnedItems){ 
									foreach($returnedItems['ImsReturnItem'] as $returnedItem){ 
										if($returnedItem['ims_item_id'] == $sirvitems['ImsItem']['id']){
											$returnedQuantity = $returnedItem['quantity'];
										}
									}
								}
								$quantity = $quantity - $returnedQuantity;
								
								if($quantity > 0){							
									$result[$count][1] = $sirvitems['ImsItem']['description'];
									$result[$count][2] = $sirvitems['ImsItem']['name'];
									$result[$count][3] = $quantity;
									$result[$count][4] = $sirvitems['unit_price'];
									$tags = null;
									foreach($sirvitems['ImsTag'] as $tag){
										if(!empty($tags)){
											$tags = $tags.', '.$tag['code'];
										}
										else $tags = $tag['code'];									
									}
									$result[$count][5] = $tags;
									$totalprice = $totalprice + ($quantity * $sirvitems['unit_price']);
									$count++;
									$countsirv++;
								}
							}
						}
					}
					$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
				}
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
			
			
			
/////////////////////////////////////////////////    Transfer   ///////////////////////////////////////////////////////////////////////////////////
			$this->loadModel('ImsTransfer');
			$this->loadModel('ImsTag');
			$this->ImsTransfer->recursive = 2;
			$this->ImsTransfer->unbindModel(array('belongsTo' => array('ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
			$conditionstra =array('ImsTransfer.to_user' => $user['User']['id']);  						 
			$transfers = $this->ImsTransfer->find('all', array('conditions' => $conditionstra)); 
			for($i=0;$i<count($transfers);$i++)
			{
				$countsirv = 0;
				if($sirvname = '' or $sirvname != $transfers[$i]['ImsSirv']['name']){
					$result[$count][0] = $transfers[$i]['ImsSirv']['name'] . ' <font color="red">(Transfered from '. $transfers[$i]['TransfferingUser']['Person']['first_name'].' '. $transfers[$i]['TransfferingUser']['Person']['middle_name'].')</font>';
				}
				foreach($transfers[$i]['ImsTransferItem'] as $sirvitems){
					if($sirvitems['ImsItem']['booked'] == 1){
						$conditionsecondstransfer =array('ImsTransferItem.transfer_id' => $transfers[$i]['ImsTransfer']['id']);  						 
						$secondtransfers = $this->ImsTransfer->ImsTransferItem->find('all', array('conditions' => $conditionsecondstransfer));
						if(empty($secondtransfers)){
							$result[$count][1] = $sirvitems['ImsItem']['description'];
							$result[$count][2] = $sirvitems['ImsItem']['name'];
							$result[$count][3] = $sirvitems['quantity'];
							$result[$count][4] = $sirvitems['unit_price'];						
							$result[$count][5] = $sirvitems['tag'];
							$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
							$count++;
							$countsirv++;
						}
					}
				}
				$sirvarray[$transfers[$i]['ImsSirv']['name']. ' <font color="red">(Transfer)</font>'] = $countsirv;
			}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			if($totalprice != 0)
			{					
				$result[$count][3] = 'Grand Total';
				$result[$count][4] = number_format($totalprice,2,'.',',');
				$count++;
			}
			$this->loadModel('People');
			$person = $this->People->read(null,$personId);	
			
			$this->set('result',$result);
			$this->set('sirvarray',$sirvarray);	
			$this->set('person',$person['People']['first_name'].' '.$person['People']['middle_name'].' '.$person['People']['last_name']);
        }		
    }
	
	function branch_card($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
		
			$this->loadModel('ImsItem');
			$this->loadModel('ImsTag');
            $branchId=$this->data['ImsCard']['branch'];
			
			if($branchId == 'All'){
				$this->loadModel('Branch');
				$this->Branch->recursive =-1;                			
				$branches = $this->Branch->find('all');
				
				$outputAll = '						
					<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
					<h4>&nbsp;</h4>
					<h2 align="center">Fixed Asset of All Branches</h2>	
					<p align="left"> Date:<b>'. date("F j, Y").' </b></p>';	
				
				foreach($branches as $branch)
				{
					if($branch['Branch']['id'] != 0){
						$resultAll = $this->branch_card_all($branch['Branch']['id']);
						$outputAll = $outputAll . $resultAll;
					}
				}
				$this->set('outputAll',$outputAll);
				$this->set('type','All');
			}
			
			else {			
				$this->loadModel('ImsRequisition'); 
				$this->ImsRequisition->recursive =-1;			
				$conditionsreq =array('ImsRequisition.branch_id' => $branchId,'ImsRequisition.status' => 'completed');  						 
				$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
				
				$result = array();
				$resultbefore = array();
				$resulttransfer = array();
				$count = 0;
				$countbefore = 0;
				$counttransfer = 0;
				$totalprice = 0;
				$totalpricebefore = 0;
				$totalpricetransfer = 0;
				$sirvarray = array();
				$sirvarraybefore = array();
				$transferarray = array();
				$sirvname = '';
				$sirvnamebefore = '';
				$transfername = '';
        
        
        //var_dump($this->data);die();
        
        if(empty($this->data['ImsCard']['from']) || $this->data['ImsCard']['from']==null || $this->data['ImsCard']['from']=='From Date'){$this->data['ImsCard']['from']='1900/01/01';}
        if(empty($this->data['ImsCard']['to']) || $this->data['ImsCard']['to']==null || $this->data['ImsCard']['from']=='To Date'){$this->data['ImsCard']['to']='2099/01/01';}
				
				for($j=0;$j<count($requisitions );$j++){						
							
                                                        
		/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsSirv'); 
					$this->ImsSirv->unbindModel(array('belongsTo' => array('ImsRequisition'),'hasMany' => array()));
					$this->ImsSirv->recursive =1;			
					//$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
				$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed','ImsSirv.created >='=>$this->data['ImsCard']['from'],'ImsSirv.created <'=>$this->data['ImsCard']['to']);
          $sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
							
					for($i=0;$i<count($sirvs);$i++)
					{	
						$countsirv = 0;
						if($sirvname == '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
							$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];	
							$sirvname = $sirvs[$i]['ImsSirv']['name'];
						}
						foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){
							$item_detail = $this->ImsItem->read(null, $sirvitems['ims_item_id']);
							if($item_detail['ImsItem']['fixed_asset'] == 1){
								$this->loadModel('ImsCard'); 
								$this->ImsCard->recursive =-1;							
								$conditionscard =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity >' => 0);  						 
								$card = $this->ImsCard->find('all', array('conditions' => $conditionscard));
								if(empty($card)){
								
									$conditionscardcheck =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity' => 0);  						 
									$cardcheck = $this->ImsCard->find('first', array('conditions' => $conditionscardcheck));
									$this->loadModel('ImsTransferItem'); 
									$this->ImsTransferItem->recursive =0;
									$conditionstransferitem =array('ImsTransferItem.ims_card_id' => $cardcheck['ImsCard']['id']);  						 
									$transferitem = $this->ImsTransferItem->find('first', array('conditions' => $conditionstransferitem));
									
									if(empty($transferitem) or $transferitem['ImsTransfer']['to_branch'] == $branchId){
									
										$this->loadModel('ImsReturnItem'); 
										$this->ImsReturnItem->recursive =0;
										$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
										$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
										if(empty($returnitem)){ 
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $sirvitems['quantity'];
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
											$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;
										}
										else if (!empty($returnitem)){										
											$rtnqntsub =0;
											foreach($returnitem as $ret){
												if($ret['ImsReturn']['status'] == 'approved' || $ret['ImsReturn']['status'] == 'disposed'){
													$rtnqntsub = $rtnqntsub + $ret['ImsReturnItem']['quantity'];
												}
											}
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $sirvitems['quantity'] - $rtnqntsub;
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];	
											$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;									
										}
									}
									else if($transferitem['ImsTransferItem']['quantity'] < $sirvitems['quantity']){
										$this->loadModel('ImsReturnItem'); 
										$this->ImsReturnItem->recursive =-1;
										$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
										$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
										if(empty($returnitem)){ 
											$quantity = $sirvitems['quantity'] - $transferitem['ImsTransferItem']['quantity'];
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $quantity . ' <font color = "red">(Transferred = ' . $transferitem['ImsTransferItem']['quantity'].')</font>';
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
											$totalprice = $totalprice + ($result[$count][3] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;
										}
									}
								}
							}
						}
						$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
					}
					
					
	   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				}
				if($totalprice != 0)
				{					
					$result[$count][3] = 'Grand Total';
					$result[$count][4] = number_format($totalprice,2,'.',',');
					$count++;
				}
				//pr($result);
				/////////////////////  SIRV  Before  ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsSirvBefore'); 
					$this->ImsSirvBefore->unbindModel(array('belongsTo' => array('Branch'),'hasMany' => array()));
					$this->ImsSirvBefore->recursive =1;		
          // ,'ImsSirvBefore.created >='=>$this->data['ImsCard']['from']		
					$conditionssirvbefore =array('ImsSirvBefore.branch_id' => $branchId,'ImsSirvBefore.created <'=>$this->data['ImsCard']['to']);  						 
					$sirvsbefore = $this->ImsSirvBefore->find('all', array('conditions' => $conditionssirvbefore));
							
					for($i=0;$i<count($sirvsbefore);$i++)
					{	
						$countsirvbefore = 0;
						if($sirvnamebefore = '' or $sirvnamebefore != $sirvsbefore[$i]['ImsSirvBefore']['name']){
							$resultbefore[$countbefore][0] = $sirvsbefore[$i]['ImsSirvBefore']['name'];
						}
						foreach($sirvsbefore[$i]['ImsSirvItemBefore'] as $sirvitemsbefore){
							$item_detail = $this->ImsItem->read(null, $sirvitemsbefore['ims_item_id']);
							if($item_detail['ImsItem']['fixed_asset'] == 1){

								$this->loadModel('ImsTransferItemBefore'); 
								$this->ImsTransferItemBefore->recursive =0;
								$conditionstransferitembefore =array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
								$transferitembefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionstransferitembefore));
								
								if(empty($transferitembefore) or $transferitembefore['ImsTransferBefore']['to_branch'] == $branchId){
									$this->loadModel('ImsReturnItem'); 
									$this->ImsReturnItem->recursive =-1;
									$conditionsreturnitembefore =array('ImsReturnItem.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
									$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitembefore));
									if(empty($returnitem)){
										$resultbefore[$countbefore][1] = $item_detail['ImsItem']['description'];
										$resultbefore[$countbefore][2] = $item_detail['ImsItem']['name'];
										$resultbefore[$countbefore][3] = $sirvitemsbefore['quantity'];
										$resultbefore[$countbefore][4] = $sirvitemsbefore['unit_price'];
										$tag_code = null;
										$this->ImsTag->recursive = -1;			
										$conditionstag =array('ImsTag.ims_sirv_item_before_id	' => $sirvitemsbefore['id']);  						 
										$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
										foreach($tags_detail as $tag){
											if(!empty($tag_code))
											{
												$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
											}
											else $tag_code = $tag['ImsTag']['code'];
										}
										$resultbefore[$countbefore][5] = $tag_code;
										$resultbefore[$countbefore][6] = $sirvsbefore[$i]['ImsSirvBefore']['created'];
										$totalpricebefore = $totalpricebefore + ($sirvitemsbefore['quantity'] * $sirvitemsbefore['unit_price']);
										$countbefore++;
										$countsirvbefore++;
									}
								}
							}
						}
						$sirvarraybefore[$sirvsbefore[$i]['ImsSirvBefore']['name']] = $countsirvbefore;
					}
					if($totalpricebefore != 0)
					{					
						$resultbefore[$countbefore][3] = 'Grand Total';
						$resultbefore[$countbefore][4] = number_format($totalpricebefore,2,'.',',');
						$countbefore++;
					}
				
	   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
				
				/////////////////////  Transfered  ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsTransfer'); 
          $this->loadModel('Branche'); 
					$this->ImsTransfer->unbindModel(array('belongsTo' => array('ImsSirv', 'TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
					$this->ImsTransfer->recursive =2;			
					$conditionstransfer =array('ImsTransfer.to_branch' => $branchId,'ImsTransfer.from_branch <>' => $branchId,'ImsTransfer.created >='=>$this->data['ImsCard']['from'],'ImsTransfer.created <'=>$this->data['ImsCard']['to']);  						 
					$transfer = $this->ImsTransfer->find('all', array('conditions' => $conditionstransfer));
                    
                    
					
      //var_dump($transfer);die();
									
					for($i=0;$i<count($transfer);$i++)
					{	
						$counttransferinner = 0;
						if($transfername = '' or $transfername != $transfer[$i]['ImsTransfer']['name']){
							$resulttransfer[$counttransfer][0] = $transfer[$i]['ImsTransfer']['name'];
							$transfername = $transfer[$i]['ImsTransfer']['name'];
             $to_branch= $this->Branche->find('all',array('conditions'=>array('Branche.id'=>$transfer[$i]['ImsTransfer']['from_branch'] ) ) );                                       //    var_dump($to_branch);die();
						}
						foreach($transfer[$i]['ImsTransferItem'] as $transferitems){
							if($transferitems['ImsItem']['fixed_asset'] == 1){
                                    
                // check if the transfer is also tranfered to other branch and the full quantity is transfered 
								$conditionsecondstransfer =array('ImsTransferItem.transfer_id' => $transfer[$i]['ImsTransfer']['id'],'ImsTransferItem.quantity >'=>0 ); 
                 						 
								$secondtransfers = $this->ImsTransfer->ImsTransferItem->find('all', array('conditions' => $conditionsecondstransfer));
          // || $secondtransfers[0]['ImsTransfer']['from_branch'] == $secondtransfers[0]['ImsTransfer']['to_branch']
								if(empty($secondtransfers) ||  $secondtransfers[0]['ImsTransferItem']['quantity']<$transferitems['quantity']   ){
									$resulttransfer[$counttransfer][1] = $transferitems['ImsItem']['description'];
									$resulttransfer[$counttransfer][2] = $transferitems['ImsItem']['name'];
									$resulttransfer[$counttransfer][3] = $transferitems['quantity']-$secondtransfers[0]['ImsTransferItem']['quantity'];
									$resulttransfer[$counttransfer][4] = $transferitems['unit_price'];
									$tag_code = null;
									/*foreach($transferitems['ImsTag'] as $tag){
										if(!empty($tag_code))
										{
											$tag_code = $tag_code . ', ' . $tag['code'];
										}
										else $tag_code = $tag['code'];
									}*/
									$resulttransfer[$counttransfer][5] = $transferitems['tag'];
									$resulttransfer[$counttransfer][6] = $transfer[$i]['ImsTransfer']['created'];
									$resulttransfer[$counttransfer][7] =$to_branch[0]['Branche']['name'];  //$transfer[$i]['TransfferingBranch']['name'];
									$totalpricetransfer = $totalpricetransfer + ($transferitems['quantity'] * $transferitems['unit_price']);
									$counttransfer++;
									$counttransferinner++;
								}else{
               // var_dump($secondtransfers); die();
                }
							}
						}
						$transferarray[$transfer[$i]['ImsTransfer']['name']] = $counttransferinner;
					}
				
					
					
					/////////////////////  Transfered Before ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsTransferBefore'); 
					$this->ImsTransferBefore->unbindModel(array('belongsTo' => array('ImsSirvBefore', 'TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
					$this->ImsTransferBefore->recursive =2;			
					$conditionstransferbefore =array('ImsTransferBefore.to_branch' => $branchId,'ImsTransferBefore.from_branch <>' => $branchId);  						 
					$transferbefore = $this->ImsTransferBefore->find('all', array('conditions' => $conditionstransferbefore));
							
					for($i=0;$i<count($transferbefore);$i++)
					{	
						$counttransferinner = 0;
						if($transfername = '' or $transfername != $transferbefore[$i]['ImsTransferBefore']['name']){
							$resulttransfer[$counttransfer][0] = $transferbefore[$i]['ImsTransferBefore']['name'];
							$transfername = $transferbefore[$i]['ImsTransferBefore']['name'];
              $to_branch= $this->Branche->find('all',array('conditions'=>array('Branche.id'=>$transferbefore[$i]['ImsTransferBefore']['from_branch'] ) ) );                         
						}
						foreach($transferbefore[$i]['ImsTransferItemBefore'] as $transferitems){
							if($transferitems['ImsItem']['fixed_asset'] == 1){							
								$resulttransfer[$counttransfer][1] = $transferitems['ImsItem']['description'];
								$resulttransfer[$counttransfer][2] = $transferitems['ImsItem']['name'];
								$resulttransfer[$counttransfer][3] = $transferitems['quantity'];
								$resulttransfer[$counttransfer][4] = $transferitems['unit_price'];
								$tag_code = null;
								/*foreach($transferitems['ImsTag'] as $tag){
									if(!empty($tag_code))
									{
										$tag_code = $tag_code . ', ' . $tag['code'];
									}
									else $tag_code = $tag['code'];
								}*/
								$resulttransfer[$counttransfer][5] = $transferitems['tag'];
								$resulttransfer[$counttransfer][6] = $transferbefore[$i]['ImsTransferBefore']['created'];
								$resulttransfer[$counttransfer][7] =$to_branch[0]['Branche']['name'];  //$transferbefore[$i]['TransfferingBranch']['name'];
								$totalpricetransfer = $totalpricetransfer + ($transferitems['quantity'] * $transferitems['unit_price']);
								$counttransfer++;
								$counttransferinner++;
							}
						}
						$transferarray[$transferbefore[$i]['ImsTransferBefore']['name']] = $counttransferinner;
					}
					
					
					if($totalpricetransfer != 0)
					{					
						$resulttransfer[$counttransfer][3] = 'Grand Total';
						$resulttransfer[$counttransfer][4] = number_format($totalpricetransfer,2,'.',',');
						$counttransfer++;
					}
					
	   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
				
				
				$this->loadModel('Branch');
				$this->Branch->recursive =-1;	
				$branch = $this->Branch->read(null,$branchId);	
				
				$this->set('result',$result);
				$this->set('resultbefore',$resultbefore);
				$this->set('resulttransfer',$resulttransfer);
				$this->set('sirvarray',$sirvarray);
				$this->set('sirvarraybefore',$sirvarraybefore);
				$this->set('transferarray',$transferarray);
				$this->set('branch',$branch['Branch']['name']);
				$this->set('type','Branch');
			}
        }			
    }
	
	function branch_card_all($branchId) {		
		
			$this->loadModel('ImsItem');
			$this->loadModel('ImsTag');			
						
			$this->loadModel('ImsRequisition'); 
			$this->ImsRequisition->recursive =-1;			
			$conditionsreq =array('ImsRequisition.branch_id' => $branchId,'ImsRequisition.status' => 'completed');  						 
			$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
			
			$result = array();
			$resultbefore = array();
			$resulttransfer = array();
			$count = 0;
			$countbefore = 0;
			$counttransfer = 0;
			$totalprice = 0;
			$totalpricebefore = 0;
			$totalpricetransfer = 0;
			$sirvarray = array();
			$sirvarraybefore = array();
			$transferarray = array();
			$sirvname = '';
			$sirvnamebefore = '';
			$transfername = '';
			
			for($j=0;$j<count($requisitions );$j++){						
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsSirv'); 
				$this->ImsSirv->unbindModel(array('belongsTo' => array('ImsRequisition'),'hasMany' => array()));
				$this->ImsSirv->recursive =1;			
				$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
				$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
						
				for($i=0;$i<count($sirvs);$i++)
				{	
					$countsirv = 0;
					if($sirvname = '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
						$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];
					}
					foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){
						$item_detail = $this->ImsItem->read(null, $sirvitems['ims_item_id']);
						if($item_detail['ImsItem']['fixed_asset'] == 1){
							$this->loadModel('ImsCard'); 
							$this->ImsCard->recursive =-1;							
							$conditionscard =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity >' => 0);  						 
							$card = $this->ImsCard->find('all', array('conditions' => $conditionscard));
							if(empty($card)){
							
								$conditionscardcheck =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity' => 0);  						 
								$cardcheck = $this->ImsCard->find('first', array('conditions' => $conditionscardcheck));
								$this->loadModel('ImsTransferItem'); 
								$this->ImsTransferItem->recursive =0;
								$conditionstransferitem =array('ImsTransferItem.ims_card_id' => $cardcheck['ImsCard']['id']);  						 
								$transferitem = $this->ImsTransferItem->find('first', array('conditions' => $conditionstransferitem));
								
								if(empty($transferitem) or $transferitem['ImsTransfer']['to_branch'] == $branchId){
								
									$this->loadModel('ImsReturnItem'); 
									$this->ImsReturnItem->recursive =0;
									$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
									$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
									if(empty($returnitem)){
										$result[$count][1] = $item_detail['ImsItem']['description'];
										$result[$count][2] = $item_detail['ImsItem']['name'];
										$result[$count][3] = $sirvitems['quantity'];
										$result[$count][4] = $sirvitems['unit_price'];
										$tag_code = null;
										$this->ImsTag->recursive = -1;			
										$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
										$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
										foreach($tags_detail as $tag){
											if(!empty($tag_code))
											{
												$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
											}
											else $tag_code = $tag['ImsTag']['code'];
										}
										$result[$count][5] = $tag_code;
										$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
										$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
										$count++;
										$countsirv++;
									}
									else if (!empty($returnitem)){										
										$rtnqntsub =0;
										foreach($returnitem as $ret){
											if($ret['ImsReturn']['status'] == 'approved'){
												$rtnqntsub = $rtnqntsub + $ret['ImsReturnItem']['quantity'];
											}
										}
										$result[$count][1] = $item_detail['ImsItem']['description'];
										$result[$count][2] = $item_detail['ImsItem']['name'];
										$result[$count][3] = $sirvitems['quantity'] - $rtnqntsub;
										$result[$count][4] = $sirvitems['unit_price'];
										$tag_code = null;
										$this->ImsTag->recursive = -1;			
										$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
										$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
										foreach($tags_detail as $tag){
											if(!empty($tag_code))
											{
												$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
											}
											else $tag_code = $tag['ImsTag']['code'];
										}
										$result[$count][5] = $tag_code;
										$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
										$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
										$count++;
										$countsirv++;										
									}
								}
								else if($transferitem['ImsTransferItem']['quantity'] < $sirvitems['quantity']){
									$this->loadModel('ImsReturnItem'); 
									$this->ImsReturnItem->recursive =-1;
									$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
									$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
									if(empty($returnitem)){ 
										$quantity = $sirvitems['quantity'] - $transferitem['ImsTransferItem']['quantity'];
										$result[$count][1] = $item_detail['ImsItem']['description'];
										$result[$count][2] = $item_detail['ImsItem']['name'];
										$result[$count][3] = $quantity . ' <font color = "red">(Transferred = ' . $transferitem['ImsTransferItem']['quantity'].')</font>';
										$result[$count][4] = $sirvitems['unit_price'];
										$tag_code = null;
										$this->ImsTag->recursive = -1;			
										$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
										$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
										foreach($tags_detail as $tag){
											if(!empty($tag_code))
											{
												$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
											}
											else $tag_code = $tag['ImsTag']['code'];
										}
										$result[$count][5] = $tag_code;
										$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
										$totalprice = $totalprice + ($result[$count][3] * $sirvitems['unit_price']);
										$count++;
										$countsirv++;
									}
								}
							}
						}
					}
					$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
				}
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
			if($totalprice != 0)
			{					
				$result[$count][3] = 'Grand Total';
				$result[$count][4] = number_format($totalprice,2,'.',',');
				$count++;
			}
			
			/////////////////////  SIRV  Before  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsSirvBefore'); 
				$this->ImsSirvBefore->unbindModel(array('belongsTo' => array('Branch'),'hasMany' => array()));
				$this->ImsSirvBefore->recursive =1;				
				$conditionssirvbefore =array('ImsSirvBefore.branch_id' => $branchId);  						 
				$sirvsbefore = $this->ImsSirvBefore->find('all', array('conditions' => $conditionssirvbefore));
						
				for($i=0;$i<count($sirvsbefore);$i++)
				{	
					$countsirvbefore = 0;
					if($sirvnamebefore = '' or $sirvnamebefore != $sirvsbefore[$i]['ImsSirvBefore']['name']){
						$resultbefore[$countbefore][0] = $sirvsbefore[$i]['ImsSirvBefore']['name'];
					}
					foreach($sirvsbefore[$i]['ImsSirvItemBefore'] as $sirvitemsbefore){
						$item_detail = $this->ImsItem->read(null, $sirvitemsbefore['ims_item_id']);
						if($item_detail['ImsItem']['fixed_asset'] == 1){

							$this->loadModel('ImsTransferItemBefore'); 
							$this->ImsTransferItemBefore->recursive =0;
							$conditionstransferitembefore =array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
							$transferitembefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionstransferitembefore));
							
							if(empty($transferitembefore) or $transferitembefore['ImsTransferBefore']['to_branch'] == $branchId){
								$this->loadModel('ImsReturnItem'); 
								$this->ImsReturnItem->recursive =-1;
								$conditionsreturnitembefore =array('ImsReturnItem.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
								$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitembefore));
								if(empty($returnitem)){
									$resultbefore[$countbefore][1] = $item_detail['ImsItem']['description'];
									$resultbefore[$countbefore][2] = $item_detail['ImsItem']['name'];
									$resultbefore[$countbefore][3] = $sirvitemsbefore['quantity'];
									$resultbefore[$countbefore][4] = $sirvitemsbefore['unit_price'];
									$tag_code = null;
									$this->ImsTag->recursive = -1;			
									$conditionstag =array('ImsTag.ims_sirv_item_before_id	' => $sirvitemsbefore['id']);  						 
									$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
									foreach($tags_detail as $tag){
										if(!empty($tag_code))
										{
											$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
										}
										else $tag_code = $tag['ImsTag']['code'];
									}
									$resultbefore[$countbefore][5] = $tag_code;
									$resultbefore[$countbefore][6] = $sirvsbefore[$i]['ImsSirvBefore']['created'];
									$totalpricebefore = $totalpricebefore + ($sirvitemsbefore['quantity'] * $sirvitemsbefore['unit_price']);
									$countbefore++;
									$countsirvbefore++;
								}
							}
						}
					}
					$sirvarraybefore[$sirvsbefore[$i]['ImsSirvBefore']['name']] = $countsirvbefore;
				}
				if($totalpricebefore != 0)
				{					
					$resultbefore[$countbefore][3] = 'Grand Total';
					$resultbefore[$countbefore][4] = number_format($totalpricebefore,2,'.',',');
					$countbefore++;
				}
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
			/////////////////////  Transfered  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsTransfer'); 
				$this->ImsTransfer->unbindModel(array('belongsTo' => array('ImsSirv', 'TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
				$this->ImsTransfer->recursive =2;			
				$conditionstransfer =array('ImsTransfer.to_branch' => $branchId);  						 
				$transfer = $this->ImsTransfer->find('all', array('conditions' => $conditionstransfer));
				
								
				for($i=0;$i<count($transfer);$i++)
				{	
					$counttransferinner = 0;
					if($transfername = '' or $transfername != $transfer[$i]['ImsTransfer']['name']){
						$resulttransfer[$counttransfer][0] = $transfer[$i]['ImsTransfer']['name'];
						$transfername = $transfer[$i]['ImsTransfer']['name'];
					}
					foreach($transfer[$i]['ImsTransferItem'] as $transferitems){
						if($transferitems['ImsItem']['fixed_asset'] == 1){
							$conditionsecondstransfer =array('ImsTransferItem.transfer_id' => $transfer[$i]['ImsTransfer']['id']);  						 
							$secondtransfers = $this->ImsTransfer->ImsTransferItem->find('all', array('conditions' => $conditionsecondstransfer));
							if(empty($secondtransfers)){
								$resulttransfer[$counttransfer][1] = $transferitems['ImsItem']['description'];
								$resulttransfer[$counttransfer][2] = $transferitems['ImsItem']['name'];
								$resulttransfer[$counttransfer][3] = $transferitems['quantity'];
								$resulttransfer[$counttransfer][4] = $transferitems['unit_price'];
								$tag_code = null;
								/*foreach($transferitems['ImsTag'] as $tag){
									if(!empty($tag_code))
									{
										$tag_code = $tag_code . ', ' . $tag['code'];
									}
									else $tag_code = $tag['code'];
								}*/
								$resulttransfer[$counttransfer][5] = $transferitems['tag'];
								$resulttransfer[$counttransfer][6] = $transfer[$i]['ImsTransfer']['created'];
								$resulttransfer[$counttransfer][7] = $transfer[$i]['TransfferingBranch']['name'];
								$totalpricetransfer = $totalpricetransfer + ($transferitems['quantity'] * $transferitems['unit_price']);
								$counttransfer++;
								$counttransferinner++;
							}
						}
					}
					$transferarray[$transfer[$i]['ImsTransfer']['name']] = $counttransferinner;
				}
				
				
				
				/////////////////////  Transfered Before ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsTransferBefore'); 
				$this->ImsTransferBefore->unbindModel(array('belongsTo' => array('ImsSirvBefore', 'TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
				$this->ImsTransferBefore->recursive =2;			
				$conditionstransferbefore =array('ImsTransferBefore.to_branch' => $branchId);  						 
				$transferbefore = $this->ImsTransferBefore->find('all', array('conditions' => $conditionstransferbefore));
						
				for($i=0;$i<count($transferbefore);$i++)
				{	
					$counttransferinner = 0;
					if($transfername = '' or $transfername != $transferbefore[$i]['ImsTransferBefore']['name']){
						$resulttransfer[$counttransfer][0] = $transferbefore[$i]['ImsTransferBefore']['name'];
						$transfername = $transferbefore[$i]['ImsTransferBefore']['name'];
					}
					foreach($transferbefore[$i]['ImsTransferItemBefore'] as $transferitems){
						if($transferitems['ImsItem']['fixed_asset'] == 1){							
							$resulttransfer[$counttransfer][1] = $transferitems['ImsItem']['description'];
							$resulttransfer[$counttransfer][2] = $transferitems['ImsItem']['name'];
							$resulttransfer[$counttransfer][3] = $transferitems['quantity'];
							$resulttransfer[$counttransfer][4] = $transferitems['unit_price'];
							$tag_code = null;
							/*foreach($transferitems['ImsTag'] as $tag){
								if(!empty($tag_code))
								{
									$tag_code = $tag_code . ', ' . $tag['code'];
								}
								else $tag_code = $tag['code'];
							}*/
							$resulttransfer[$counttransfer][5] = $transferitems['tag'];
							$resulttransfer[$counttransfer][6] = $transferbefore[$i]['ImsTransferBefore']['created'];
							$resulttransfer[$counttransfer][7] = $transferbefore[$i]['TransfferingBranch']['name'];
							$totalpricetransfer = $totalpricetransfer + ($transferitems['quantity'] * $transferitems['unit_price']);
							$counttransfer++;
							$counttransferinner++;
						}
					}
					$transferarray[$transferbefore[$i]['ImsTransferBefore']['name']] = $counttransferinner;
				}
				
				
				if($totalpricetransfer != 0)
				{					
					$resulttransfer[$counttransfer][3] = 'Grand Total';
					$resulttransfer[$counttransfer][4] = number_format($totalpricetransfer,2,'.',',');
					$counttransfer++;
				}
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
			$this->loadModel('Branch');
			$this->Branch->recursive =-1;	
			$branch = $this->Branch->read(null,$branchId);	
			
			$result = $result;
			$resultbefore = $resultbefore;
			$resulttransfer = $resulttransfer;
			$sirvarray = $sirvarray;
			$sirvarraybefore = $sirvarraybefore;
			$transferarray = $transferarray;
			$branch = $branch['Branch']['name'];
			
			 $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<p align="left"> Branch Name:<b>'.$branch.'</b></p>
	
	<font  align="left" color="red"><b>Transferred to</b></font >
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>Transfer n<u>o</u></th>
        <th>Item Code</th>
		<th>Item Name</th>		
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Tag</th>
		<th>Date</th>
		<th>From Branch</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($resulttransfer);$i++)
		{
			if($resulttransfer[$i][3] == 'Grand Total')
			{
				$output.='<tr bgcolor="lightblue">
				<td colspan =4 align="right">'.$resulttransfer[$i][3].'</td>
				<td align="right">'.$resulttransfer[$i][4].'</td>';							
			}
			
			else if($resulttransfer[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';	
				if($resulttransfer[$i][0] != ''){
					$output.='<td rowspan ='.$transferarray[$resulttransfer[$i][0]].'>'.$resulttransfer[$i][0].'</td>';
				}
				$output.='<td align="left">'.$resulttransfer[$i][1].'</td>
				<td align="right">'.$resulttransfer[$i][2].'</td>
				<td align="right">'.$resulttransfer[$i][3].'</td>
				<td align="right">'.$resulttransfer[$i][4].'</td>
				<td align="right">'.$resulttransfer[$i][5].'</td>
				<td align="right">'.$resulttransfer[$i][6].'</td>
				<td align="right">'.$resulttransfer[$i][7].'</td>';
			}				
			$count = $i;
		}
    $output.='  
</table></br></br>
	
	<font  align="left" color="red"><b>After System</b></font >
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>SIRV n<u>o</u></th>
        <th>Item Code</th>
		<th>Item Name</th>		
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Tag</th>
		<th>Date</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($result);$i++)
		{
			if($result[$i][3] == 'Grand Total')
			{
				$output.='<tr bgcolor="lightblue">
				<td colspan =4 align="right">'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>';							
			}
			
			else if($result[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';	
				if($result[$i][0] != ''){
					$output.='<td rowspan ='.$sirvarray[$result[$i][0]].'>'.$result[$i][0].'</td>';
				}
				$output.='<td align="left">'.$result[$i][1].'</td>
				<td align="right">'.$result[$i][2].'</td>
				<td align="right">'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td align="right">'.$result[$i][6].'</td>';
			}				
			$count = $i;
		}
    $output.='  
</table></br></br>
<font  align="left" color="red"><b>Before System</b></font >
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>SIRV n<u>o</u></th>
        <th>Item Code</th>
		<th>Item Name</th>		
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Tag</th>
		<th>Date</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($resultbefore);$i++)
		{
			if($resultbefore[$i][3] == 'Grand Total')
			{
				$output.='<tr bgcolor="lightblue">
				<td colspan =4 align="right">'.$resultbefore[$i][3].'</td>
				<td align="right">'.$resultbefore[$i][4].'</td>';							
			}
			
			else if($resultbefore[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';	
				if($resultbefore[$i][0] != ''){
					$output.='<td rowspan ='.$sirvarraybefore[$resultbefore[$i][0]].'>'.$resultbefore[$i][0].'</td>';
				}
				$output.='<td align="left">'.$resultbefore[$i][1].'</td>
				<td align="right">'.$resultbefore[$i][2].'</td>
				<td align="right">'.$resultbefore[$i][3].'</td>
				<td align="right">'.$resultbefore[$i][4].'</td>
				<td align="right">'.$resultbefore[$i][5].'</td>
				<td align="right">'.$resultbefore[$i][6].'</td>';
			}				
			$count = $i;
		}
    $output.='  
</table>';

	return $output;
			
    }
	
	function disposal_by_category($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));			
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsCard');
			$this->ImsCard->recursive = 2;
			$this->ImsCard->unbindModel(array('belongsTo' => array('ImsItem','ImsStore')));
			$conditionsdisp =array('ImsCard.created >=' => $fromdate,'ImsCard.created <' => $tomorrow,'ImsCard.ims_disposal_item_id !=' => 0);
			$disps = $this->ImsCard->find('all', array('conditions' => $conditionsdisp));			
			
			$result = array();
			$count = 0;
			$totalprice = 0;
			$overallcost =0;
			
			$createdby = '';
			$approvedby = '';
			$dispnumber = '';
			$disposalarray = array();
			$countdisposal = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
					
			for($i=0;$i<count($disps);$i++)
			{	
				$countdisp=0;
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$this->ImsItem->recursive = -1;
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
					
					foreach ($items as $item)
					{			
						if($item['ImsItem']['id'] == $disps[$i]['ImsCard']['ims_item_id']){
							$this->loadModel('User');
							$this->User->recursive = 2;
							$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
							$usercreated = $this->User->read(null,$disps[$i]['ImsDisposalItem']['ImsDisposal']['created_by']);	
							$userapproved = $this->User->read(null,$disps[$i]['ImsDisposalItem']['ImsDisposal']['approved_by']);
							
							if($usercreated['User']['id'] != $createdby){
								$result[$count][0] = $usercreated['Person']['first_name'].' '.$usercreated['Person']['middle_name'].' '.$usercreated['Person']['last_name'];
								$createdby = $usercreated['User']['id'];
							}
							if($userapproved['User']['id'] != $approvedby){
								$result[$count][1] = $userapproved['Person']['first_name'].' '.$userapproved['Person']['middle_name'].' '.$userapproved['Person']['last_name'];
								$approvedby = $userapproved['User']['id'];
							}
							if($disps[$i]['ImsDisposalItem']['ImsDisposal']['name'] != $dispnumber)
							{
								$countdisposal =0;
								$result[$count][2] = $disps[$i]['ImsDisposalItem']['ImsDisposal']['name'];
								$dispnumber = $disps[$i]['ImsDisposalItem']['ImsDisposal']['name'];
							}
							else $result[$count][2] ='';
							
							$result[$count][3] = $item['ImsItem']['description'];
							$result[$count][4] = $item['ImsItem']['name'];
							$result[$count][5] = $disps[$i]['ImsDisposalItem']['measurement'];
							$result[$count][6] = $disps[$i]['ImsCard']['disp_quantity'];
							$result[$count][7] = number_format($disps[$i]['ImsCard']['disp_unit_price'],4,'.',',');
							$result[$count][8] = number_format($disps[$i]['ImsCard']['disp_quantity'] * $disps[$i]['ImsCard']['disp_unit_price'],2,'.',',');							
							$totalprice = $totalprice + $disps[$i]['ImsCard']['disp_quantity'] * $disps[$i]['ImsCard']['disp_unit_price'];
							$count++;
							$countdisposal++;
							$disposalarray[$dispnumber] = $countdisposal;
						}
					}						
				}
			}
			if($totalprice != 0)
			{					
				$result[$count][4] = 'Grand Total';
				$result[$count][5] = number_format($totalprice,2,'.',',');
				$overallcost = $overallcost + $totalprice;
				$count++;
			}
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
				/*if($overallcost != 0){
					$result[$count][3] = 'Over All Total';
					$result[$count][4] = number_format($overallcost,2,'.',',');
				}*/
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('disposalarray',$disposalarray);
        }		
    }
	
	function returned_disposal_by_category($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
            $fromdate=$this->data['ImsCard']['from'];
			$todate =$this->data['ImsCard']['to'];
			$date1 = str_replace('-', '/', $todate);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));			
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
			$this->loadModel('ImsReturn');
			$this->ImsReturn->recursive = 1;
					
			$conditionsdisp =array('ImsReturn.modified >=' => $fromdate,'ImsReturn.modified <' => $tomorrow,'ImsReturn.status' => 'disposed');
			$disps = $this->ImsReturn->find('all', array('conditions' => $conditionsdisp));			
			
			$result = array();
			$count = 0;
			$totalprice = 0;
			$overallcost =0;
			
			$createdby = '';
			$approvedby = '';
			$dispnumber = '';
			$disposalarray = array();
			$countdisposal = 0;
			for($j=0;$j<count($itemcategory );$j++){
						$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
					$itemcategory [$j]['child'][] = $itemcategory[$j];
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
					
			for($i=0;$i<count($disps);$i++)
			{	
				$countdisp=0;
				foreach ($itemcategory [$j]['child'] as $child)
				{
					$this->loadModel('ImsItem');
					$this->ImsItem->recursive = -1;
					$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
					$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
					foreach($disps[$i]['ImsReturnItem'] as $returnItem){
						foreach ($items as $item)
						{			
							if($item['ImsItem']['id'] == $returnItem['ims_item_id']){
								$this->loadModel('User');
								$this->User->recursive = 2;
								$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
								$usercreated = $this->User->read(null,$disps[$i]['ImsReturn']['disposed_by']);	
								$userapproved = $this->User->read(null,$disps[$i]['ImsReturn']['disposal_approved_by']);
								
								$this->loadModel('Branch');
								$this->Branch->recursive = -1;
								$branch = $this->Branch->read(null,$disps[$i]['ImsReturn']['returned_from']);	
								
								if($usercreated['User']['id'] != $createdbyy){
									$result[$count][0] = $usercreated['Person']['first_name'].' '.$usercreated['Person']['middle_name'].' '.$usercreated['Person']['last_name'];
									$createdby = $usercreated['User']['id'];
								}
								if($userapproved['User']['id'] != $approvedbyy){
									$result[$count][1] = $userapproved['Person']['first_name'].' '.$userapproved['Person']['middle_name'].' '.$userapproved['Person']['last_name'];
									$approvedby = $userapproved['User']['id'];
								}
								if($disps[$i]['ImsReturn']['name'] != $dispnumberr)
								{
									$countdisposal =0;
									$result[$count][2] = $disps[$i]['ImsReturn']['name'];
									$dispnumber = $disps[$i]['ImsReturn']['name'];
								}
								else $result[$count][2] ='';
								
								$result[$count][3] = $item['ImsItem']['description'];
								$result[$count][4] = $item['ImsItem']['name'];
								$result[$count][5] = $returnItem['measurement'];
								$result[$count][6] = $returnItem['quantity'];
								$result[$count][7] = number_format($returnItem['unit_price'],4,'.',',');
								$result[$count][8] = number_format($returnItem['quantity'] * $returnItem['unit_price'],2,'.',',');	
								$result[$count][9] = $branch['Branch']['name'];
								$result[$count][10] = date_format(date_create($disps[$i]['ImsReturn']['modified']), "F j, Y");
								$totalprice = $totalprice + $returnItem['quantity'] * $returnItem['unit_price'];
								$count++;
								$countdisposal++;
								$disposalarray[$dispnumber] = $countdisposal;
							}
						}
					}
				}
			}
			if($totalprice != 0)
			{					
				$result[$count][4] = 'Grand Total';
				$result[$count][5] = number_format($totalprice,2,'.',',');
				$overallcost = $overallcost + $totalprice;
				$count++;
			}
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
				/*if($overallcost != 0){
					$result[$count][3] = 'Over All Total';
					$result[$count][4] = number_format($overallcost,2,'.',',');
				}*/
				$this->set('result',$result);
				$this->set('itemCategory',$itemcategory[0]['ImsItemCategory']['name']);
				$this->set('disposalarray',$disposalarray);
        }		
    }
	
	function branch_card_individual($id = null) {
		$this->layout = 'ajax';	
			$user = $this->Session->read();	
			$this->loadModel('Employee');
			$this->Employee->recursive =-1;
			$this->Employee->EmployeeDetail->recursive =-1;
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		
            $branchId = $emp_details['EmployeeDetail']['branch_id'];				
						
			$this->loadModel('ImsRequisition'); 
			$this->ImsRequisition->recursive =-1;			
			$conditionsreq =array('ImsRequisition.branch_id' => $branchId,'ImsRequisition.status' => 'completed');  						 
			$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
			
			$result = array();
			$resultbefore = array();
			$count = 0;
			$countbefore = 0;
			$totalprice = 0;
			$totalpricebefore = 0;
			$sirvarray = array();
			$sirvarraybefore = array();
			$sirvname = '';
			$sirvnamebefore = '';
			
			for($j=0;$j<count($requisitions );$j++){						
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsSirv'); 
				$this->ImsSirv->unbindModel(array('belongsTo' => array('ImsRequisition'),'hasMany' => array()));
				$this->ImsSirv->recursive =2;			
				$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
				$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
					
				for($i=0;$i<count($sirvs);$i++)
				{	
					$countsirv = 0;
					if($sirvname = '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
						$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];
						$sirvname = $sirvs[$i]['ImsSirv']['name'];
					}
					foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){ 
						if($sirvitems['ImsItem']['fixed_asset'] == 1){
						
							$this->loadModel('ImsCard'); 
							$this->ImsCard->recursive =-1;			
							$conditionscard =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity >' => 0);  						 
							$card = $this->ImsCard->find('all', array('conditions' => $conditionscard));
							if(empty($card)){
								
								$transferedQuantity = 0;
								$quantity = 0;
								foreach($sirvs[$i]['ImsTransfer'] as $transferItems){ 
									foreach($transferItems['ImsTransferItem'] as $transferItem){ 
										if($transferItem['ims_item_id'] == $sirvitems['ImsItem']['id']){
											$transferedQuantity = $transferItem['quantity'];
										}
									}
								}
								$quantity = $sirvitems['quantity'] - $transferedQuantity;
								
								$returnedQuantity = 0;
								foreach($sirvs[$i]['ImsSirvItem'] as $returnedItems){ 
									foreach($returnedItems['ImsReturnItem'] as $returnedItem){ 
										if($returnedItem['ims_item_id'] == $sirvitems['ImsItem']['id']){
											$returnedQuantity = $returnedItem['quantity'];
										}
									}
								}
								$quantity = $quantity - $returnedQuantity;
								
								if($quantity > 0){	
									$result[$count][1] = $sirvitems['ImsItem']['description'];
									$result[$count][2] = $sirvitems['ImsItem']['name'];
									$result[$count][3] = $quantity;
									$result[$count][4] = $sirvitems['unit_price'];
									$tag_code = null;
									foreach($sirvitems['ImsTag'] as $tag){
										if(!empty($tag_code))
										{
											$tag_code = $tag_code . ', ' . $tag['code'];
										}
										else $tag_code = $tag['code'];
									}
									$result[$count][5] = $tag_code;
									$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
									$totalprice = $totalprice + ($quantity * $sirvitems['unit_price']);
									$count++;
									$countsirv++;
								}
							}
						}
					}
					$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
				}
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
			
	/////////////////////////////////////////////////    Transfer   ///////////////////////////////////////////////////////////////////////////////////
			$this->loadModel('ImsTransfer'); 
			$this->ImsTransfer->recursive = 2;
			$this->ImsTransfer->unbindModel(array('belongsTo' => array('TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
		//	$conditionstra =array( 'or' =>array('ImsTransfer.to_branch' => $branchId));  
      $conditionstra =array('ImsTransfer.to_branch' => $branchId);  
	  //$conditionstra =array('ImsTransfer.from_branch <>' => $branchId); 						 
			$transfers = $this->ImsTransfer->find('all', array('conditions' => $conditionstra)); 
			for($i=0;$i<count($transfers);$i++)
			{	
				$countsirv = 0;
				if($sirvname = '' or $sirvname != $transfers[$i]['ImsSirv']['name']){
					$result[$count][0] = $transfers[$i]['ImsSirv']['name'] . ' <font color="red">(Transfer - '.$transfers[$i]['ImsTransfer']['name'].')</font>';
					
				}
				foreach($transfers[$i]['ImsTransferItem'] as $sirvitems){
						if($sirvitems['ImsItem']['booked'] == 1 && ($sirvitems['ImsTransfer']['from_branch'] != $sirvitems['ImsTransfer']['to_branch'] ) ){
												
						$result[$count][1] = $sirvitems['ImsItem']['description'];
						$result[$count][2] = $sirvitems['ImsItem']['name'];
						$result[$count][3] = $sirvitems['quantity'];
						$result[$count][4] = $sirvitems['unit_price'];
						
						$result[$count][5] = $sirvitems['tag'];
						$result[$count][6] = $sirvitems['ImsTransfer']['created'];
						$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
						$count++;
						$countsirv++;
					}
				}
				$sirvarray[$transfers[$i]['ImsSirv']['name'] . ' <font color="red">(Transfer - '.$transfers[$i]['ImsTransfer']['name'].')</font>'] = $countsirv;
			}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if($totalprice != 0)
			{					
				$result[$count][3] = 'Grand Total';
				$result[$count][4] = number_format($totalprice,2,'.',',');
				$count++;
			}
			
			/////////////////////  SIRV  Before  ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsSirvBefore'); 
				$this->ImsSirvBefore->recursive =2;	
				$this->ImsSirvBefore->unbindModel(array('belongsTo' => array('Branch'),'hasMany' => array()));
				$conditionssirvbefore =array('ImsSirvBefore.branch_id' => $branchId);  						 
				$sirvsbefore = $this->ImsSirvBefore->find('all', array('conditions' => $conditionssirvbefore));
						
				for($i=0;$i<count($sirvsbefore);$i++)
				{	
					$countsirvbefore = 0;
					if($sirvnamebefore = '' or $sirvnamebefore != $sirvsbefore[$i]['ImsSirvBefore']['name']){
						$resultbefore[$countbefore][0] = $sirvsbefore[$i]['ImsSirvBefore']['name'] . '~' .$i;
					}
					foreach($sirvsbefore[$i]['ImsSirvItemBefore'] as $sirvitemsbefore){
						if($sirvitemsbefore['ImsItem']['fixed_asset'] == 1){
							
							$this->loadModel('ImsTransferItemBefore'); 
							$this->ImsTransferItemBefore->recursive =0;
							$conditionstransferitembefore =array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
							$transferitembefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionstransferitembefore));
							
							$this->loadModel('ImsReturnItem'); 
							$this->ImsReturnItem->recursive =0;
							$conditionsreturnitembefore =array('ImsReturnItem.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
							$returnitembefore = $this->ImsReturnItem->find('first', array('conditions' => $conditionsreturnitembefore));
							
							if(empty($returnitembefore)){
								
								if(empty($transferitembefore) or $transferitembefore['ImsTransferBefore']['to_branch'] == $branchId){
									$resultbefore[$countbefore][1] = $sirvitemsbefore['ImsItem']['description'];
									$resultbefore[$countbefore][2] = $sirvitemsbefore['ImsItem']['name'];
									$resultbefore[$countbefore][3] = $sirvitemsbefore['quantity'];
									$resultbefore[$countbefore][4] = $sirvitemsbefore['unit_price'];
									$tag_code = null;
									foreach($sirvitemsbefore['ImsTag'] as $tag){
										if(!empty($tag_code))
										{
											$tag_code = $tag_code . ', ' . $tag['code'];
										}
										else $tag_code = $tag['code'];
									}
									$resultbefore[$countbefore][5] = $tag_code;
									$resultbefore[$countbefore][6] = $sirvsbefore[$i]['ImsSirvBefore']['created'];
									$totalpricebefore = $totalpricebefore + ($sirvitemsbefore['quantity'] * $sirvitemsbefore['unit_price']);
									$countbefore++;
									$countsirvbefore++;
								}
							}
						}
					}
					$sirvarraybefore[$sirvsbefore[$i]['ImsSirvBefore']['name'] . '~' .$i] = $countsirvbefore;
				}
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////  Transfered Before ///////////////////////////////////////////////////////////////////////////////////////////////////
				$this->loadModel('ImsTransferBefore'); 
				$this->ImsTransferBefore->unbindModel(array('belongsTo' => array('TransfferingUser', 'ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
				$this->ImsTransferBefore->recursive =2;			
				$conditionstransferbefore =array('ImsTransferBefore.to_branch' => $branchId);  						 
				$transferbefore = $this->ImsTransferBefore->find('all', array('conditions' => $conditionstransferbefore));
						
				for($i=0;$i<count($transferbefore);$i++)
				{	
					$countsirvbefore = 0;
					if($sirvnamebefore = '' or $sirvnamebefore != $transferbefore[$i]['ImsSirvBefore']['name']){
						$resultbefore[$countbefore][0] = $transferbefore[$i]['ImsSirvBefore']['name'] . ' <font color="red">(Transfer - '.$transferbefore[$i]['ImsTransferBefore']['name'].')</font>';
					}
					foreach($transferbefore[$i]['ImsTransferItemBefore'] as $transferitems){
						if($transferitems['ImsItem']['fixed_asset'] == 1){							
							$resultbefore[$countbefore][1] = $transferitems['ImsItem']['description'];
							$resultbefore[$countbefore][2] = $transferitems['ImsItem']['name'];
							$resultbefore[$countbefore][3] = $transferitems['quantity'];
							$resultbefore[$countbefore][4] = $transferitems['unit_price'];
							$resultbefore[$countbefore][5] = $transferitems['tag'];
							$resultbefore[$countbefore][6] = $transferbefore[$i]['ImsTransferBefore']['created'];
							//$resultbefore[$countbefore][7] = $transferbefore[$i]['TransfferingBranch']['name'];
							$totalpricebefore = $totalpricebefore + ($transferitems['quantity'] * $transferitems['unit_price']);
							$countbefore++;
							$countsirvbefore++;
						}
					}
					$sirvarraybefore[$transferbefore[$i]['ImsSirvBefore']['name'] . ' <font color="red">(Transfer - '.$transferbefore[$i]['ImsTransferBefore']['name'].')</font>'] = $countsirvbefore;
				}
				
				
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
   
			if($totalpricebefore != 0)
			{					
				$resultbefore[$countbefore][3] = 'Grand Total';
				$resultbefore[$countbefore][4] = number_format($totalpricebefore,2,'.',',');
				$countbefore++;
			}
   
			$this->loadModel('Branch');
			$this->Branch->recursive =-1;	
			$branch = $this->Branch->read(null,$branchId);	
			
			$this->set('result',$result);
			$this->set('resultbefore',$resultbefore);
			$this->set('sirvarray',$sirvarray);
			$this->set('sirvarraybefore',$sirvarraybefore);
			$this->set('branch',$branch['Branch']['name']);
    }
	
	function emp_card2($id = null) {
		$this->layout = 'ajax';		
		
		    $user = $this->Session->read();			
			
			$this->loadModel('ImsRequisition'); 
			$this->ImsRequisition->recursive =-1;			
			$conditionsreq =array('ImsRequisition.requested_by' => $user['Auth']['User']['id'],'ImsRequisition.status' => 'completed');  						 
			$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
			
			$result = array();
			$count = 0;
			$totalprice = 0;
			$sirvarray = array();
			$sirvname = '';
			
			
			$this->loadModel('ImsSirv');				
			$this->ImsSirv->recursive =2;	
			
			for($j=0;$j<count($requisitions );$j++){						
						
	/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
						
				$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
				$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
				
				for($i=0;$i<count($sirvs);$i++)
				{	
					$countsirv = 0;
					if($sirvname = '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
						$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];
					}
					foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){
						if($sirvitems['ImsItem']['booked'] == 1){
							
							$transferedQuantity = 0;
							$quantity = 0;
							foreach($sirvs[$i]['ImsTransfer'] as $transferItems){ 
								foreach($transferItems['ImsTransferItem'] as $transferItem){ 
                  //  if($sirvs[$i]['ImsSirv']['name']=='20200907/008'){
                   //   var_dump($sirvs[$i]);die();
                   // }
                    
									if($transferItem['ims_item_id'] == $sirvitems['ImsItem']['id'] and $transferItems['from_user'] == $user['Auth']['User']['id']){
										$transferedQuantity = $transferItem['quantity'];
									}
								}
							}
							$quantity = $sirvitems['quantity'] - $transferedQuantity;
							
							$returnedQuantity = 0;
							foreach($sirvs[$i]['ImsSirvItem'] as $returnedItems){ 
								foreach($returnedItems['ImsReturnItem'] as $returnedItem){ 
									if($returnedItem['ims_item_id'] == $sirvitems['ImsItem']['id']){
										$returnedQuantity .= $returnedItem['quantity'];
									}
								}
							}
							$quantity = $quantity - $returnedQuantity;
							
							if($quantity > 0){							
								$result[$count][1] = $sirvitems['ImsItem']['description'];
								$result[$count][2] = $sirvitems['ImsItem']['name'];
								$result[$count][3] = $quantity;
								$result[$count][4] = $sirvitems['unit_price'];
								$tags = null;
								foreach($sirvitems['ImsTag'] as $tag){
									if(!empty($tags)){
										$tags = $tags.', '.$tag['code'];
									}
									else $tags = $tag['code'];									
								}
								$result[$count][5] = $tags;
								$totalprice = $totalprice + ($quantity * $sirvitems['unit_price']);
								$count++;
								$countsirv++;
							}
						}
					}
					$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
				}
				
				
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			}
			
			
			
/////////////////////////////////////////////////    Transfer   ///////////////////////////////////////////////////////////////////////////////////
			$this->loadModel('ImsTransfer');
			$this->loadModel('ImsTag');
			$this->ImsTransfer->recursive = 2;
			$this->ImsTransfer->unbindModel(array('belongsTo' => array('ReceivingUser', 'TransfferingBranch', 'ReceivingBranch', 'ApprovingUser'),'hasMany' => array()));
			$conditionstra =array('ImsTransfer.to_user' => $user['Auth']['User']['id']);  						 
			$transfers = $this->ImsTransfer->find('all', array('conditions' => $conditionstra)); 
			for($i=0;$i<count($transfers);$i++)
			{
				$countsirv = 0;
				if($sirvname = '' or $sirvname != $transfers[$i]['ImsSirv']['name']){
					$result[$count][0] = $transfers[$i]['ImsSirv']['name'] . ' <font color="red">(Transfered from '. $transfers[$i]['TransfferingUser']['Person']['first_name'].' '. $transfers[$i]['TransfferingUser']['Person']['middle_name'].')</font>';
				}
				foreach($transfers[$i]['ImsTransferItem'] as $sirvitems){
					if($sirvitems['ImsItem']['booked'] == 1){
						$conditionsecondstransfer =array('ImsTransferItem.transfer_id' => $transfers[$i]['ImsTransfer']['id']);  						 
						$secondtransfers = $this->ImsTransfer->ImsTransferItem->find('all', array('conditions' => $conditionsecondstransfer));
						if(empty($secondtransfers)){
							$result[$count][1] = $sirvitems['ImsItem']['description'];
							$result[$count][2] = $sirvitems['ImsItem']['name'];
							$result[$count][3] = $sirvitems['quantity'];
							$result[$count][4] = $sirvitems['unit_price'];						
							$result[$count][5] = $sirvitems['tag'];
							$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
							$count++;
							$countsirv++;
						}
					}
				}
				$sirvarray[$transfers[$i]['ImsSirv']['name']. ' <font color="red">(Transfered from '. $transfers[$i]['TransfferingUser']['Person']['first_name'].' '. $transfers[$i]['TransfferingUser']['Person']['middle_name'].')</font>'] = $countsirv;
			}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			if($totalprice != 0)
			{					
				$result[$count][3] = 'Grand Total';
				$result[$count][4] = number_format($totalprice,2,'.',',');
				$count++;
			}
			
			$this->set('result',$result);
			$this->set('sirvarray',$sirvarray);	
			$this->set('person',$user['Auth']['Person']['first_name'].' '.$user['Auth']['Person']['middle_name'].' '.$user['Auth']['Person']['last_name']);
    }
	
	function category_card($id = null) {
		$this->layout = 'ajax';		
		
        if (!empty($this->data)) {
		
			$this->loadModel('ImsItem');
			$this->loadModel('ImsTag');
            
			
			$this->loadModel('ImsItemCategory'); 
			$this->ImsItemCategory->recursive =-1;			
			$conditions =array('ImsItemCategory.id' => $this->data['ImsCard']['category']);  						 
			$itemcategory = $this->ImsItemCategory->find('all', array('conditions' => $conditions));
			
				$this->loadModel('ImsRequisition'); 
				$this->ImsRequisition->recursive =-1;			
				$conditionsreq =array('ImsRequisition.status' => 'completed');  						 
				$requisitions = $this->ImsRequisition->find('all', array('conditions' => $conditionsreq));
				
				$result = array();
				$resultbefore = array();
				$resulttransfer = array();
				$count = 0;
				$countbefore = 0;
				$counttransfer = 0;
				$totalprice = 0;
				$totalpricebefore = 0;
				$totalpricetransfer = 0;
				$sirvarray = array();
				$sirvarraybefore = array();
				$transferarray = array();
				$sirvname = '';
				$sirvnamebefore = '';
				$transfername = '';
				$this->loadModel('Branch');
				
				for($j=0;$j<100;$j++){						
							
					
					$branchName = $this->Branch->read(null,$requisitions[$j]['ImsRequisition']['branch_id']);
		/////////////////////  SIRV  ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsSirv'); 
					$this->ImsSirv->unbindModel(array('belongsTo' => array('ImsRequisition'),'hasMany' => array()));
					$this->ImsSirv->recursive =1;			
					$conditionssirv =array('ImsSirv.ims_requisition_id' => $requisitions[$j]['ImsRequisition']['id'],'ImsSirv.status' => 'completed');  						 
					$sirvs = $this->ImsSirv->find('all', array('conditions' => $conditionssirv));
							
					for($i=0;$i<count($sirvs);$i++)
					{	
						$countsirv = 0;
						if($sirvname = '' or $sirvname != $sirvs[$i]['ImsSirv']['name']){
							$result[$count][0] = $sirvs[$i]['ImsSirv']['name'];
						}
						foreach($sirvs[$i]['ImsSirvItem'] as $sirvitems){
							for($j=0;$j<count($itemcategory );$j++){
								$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
								$itemcategory [$j]['child'][] = $itemcategory[$j];
								foreach ($itemcategory [$j]['child'] as $child)
									{
										$this->loadModel('ImsItem');
										$this->ImsItem->recursive = -1;
										$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
										$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
										
										foreach ($items as $item)
											{
					
							if($item['ImsItem']['id'] == $sirvitems['ims_item_id']){
							$item_detail = $this->ImsItem->read(null, $sirvitems['ims_item_id']);
							if($item_detail['ImsItem']['fixed_asset'] == 1){
								$this->loadModel('ImsCard'); 
								$this->ImsCard->recursive =-1;							
								$conditionscard =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity >' => 0);  						 
								$card = $this->ImsCard->find('all', array('conditions' => $conditionscard));
								if(empty($card)){
								
									$conditionscardcheck =array('ImsCard.ims_sirv_item_id' => $sirvitems['id'],'ImsCard.in_quantity' => 0);  						 
									$cardcheck = $this->ImsCard->find('first', array('conditions' => $conditionscardcheck));
									$this->loadModel('ImsTransferItem'); 
									$this->ImsTransferItem->recursive =0;
									$conditionstransferitem =array('ImsTransferItem.ims_card_id' => $cardcheck['ImsCard']['id']);  						 
									$transferitem = $this->ImsTransferItem->find('first', array('conditions' => $conditionstransferitem));
									
									if(empty($transferitem)){
									
										$this->loadModel('ImsReturnItem'); 
										$this->ImsReturnItem->recursive =0;
										$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
										$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
										if(empty($returnitem)){
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $sirvitems['quantity'];
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
											$result[$count][7] = $branchName['Branch']['name'];
											$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;
										}
										else if (!empty($returnitem)){										
											$rtnqntsub =0;
											foreach($returnitem as $ret){
												if($ret['ImsReturn']['status'] == 'approved'){
													$rtnqntsub = $rtnqntsub + $ret['ImsReturnItem']['quantity'];
												}
											}
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $sirvitems['quantity'] - $rtnqntsub;
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
											$result[$count][7] = $branchName['Branch']['name'];
											$totalprice = $totalprice + ($sirvitems['quantity'] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;										
										}
									else if($transferitem['ImsTransferItem']['quantity'] <= $sirvitems['quantity']){
										$this->loadModel('ImsReturnItem'); 
										$this->ImsReturnItem->recursive =-1;
										$conditionsreturnitem =array('ImsReturnItem.ims_sirv_item_id' => $sirvitems['id']);  						 
										$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitem));
										if(empty($returnitem)){ 
											$quantity = $sirvitems['quantity'] - $transferitem['ImsTransferItem']['quantity'];
											$result[$count][1] = $item_detail['ImsItem']['description'];
											$result[$count][2] = $item_detail['ImsItem']['name'];
											$result[$count][3] = $quantity . ' <font color = "red">(Transferred = ' . $transferitem['ImsTransferItem']['quantity'].')</font>';
											$result[$count][4] = $sirvitems['unit_price'];
											$tag_code = null;
											$this->ImsTag->recursive = -1;			
											$conditionstag =array('ImsTag.ims_sirv_item_id	' => $sirvitems['id']);  						 
											$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
											foreach($tags_detail as $tag){
												if(!empty($tag_code))
												{
													$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
												}
												else $tag_code = $tag['ImsTag']['code'];
											}
											$result[$count][5] = $tag_code;
											$result[$count][6] = $sirvs[$i]['ImsSirv']['created'];
											$result[$count][7] = $branchName['Branch']['name'];
											$totalprice = $totalprice + ($result[$count][3] * $sirvitems['unit_price']);
											$count++;
											$countsirv++;
										}
									}
								}
							}
							}
							}
							}
							}
						}
						
					}
					$sirvarray[$sirvs[$i]['ImsSirv']['name']] = $countsirv;
					}
	   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				}
				if($totalprice != 0)
				{					
					$result[$count][3] = 'Grand Total';
					$result[$count][4] = number_format($totalprice,2,'.',',');
					$count++;
				}
				
				/////////////////////  SIRV  Before  ///////////////////////////////////////////////////////////////////////////////////////////////////
					$this->loadModel('ImsSirvBefore'); 
					$this->ImsSirvBefore->unbindModel(array('belongsTo' => array('Branch'),'hasMany' => array()));
					$this->ImsSirvBefore->recursive =1;				
					$conditionssirvbefore =array();  						 
					$sirvsbefore = $this->ImsSirvBefore->find('all', array('conditions' => $conditionssirvbefore));
							
					for($i=0;$i<100;$i++)
					{	
						$branchName = $this->Branch->read(null,$sirvsbefore[$i]['ImsSirvBefore']['branch_id']);
						$countsirvbefore = 0;
						if($sirvnamebefore = '' or $sirvnamebefore != $sirvsbefore[$i]['ImsSirvBefore']['name']){
							$resultbefore[$countbefore][0] = $sirvsbefore[$i]['ImsSirvBefore']['name'];
						}
						foreach($sirvsbefore[$i]['ImsSirvItemBefore'] as $sirvitemsbefore){
						
							for($j=0;$j<count($itemcategory );$j++){
								$itemcategory [$j]['child'] = $this->getChild($itemcategory [$j]['ImsItemCategory']['id']);			
								$itemcategory [$j]['child'][] = $itemcategory[$j];
								foreach ($itemcategory [$j]['child'] as $child)
									{
										$this->loadModel('ImsItem');
										$this->ImsItem->recursive = -1;
										$conditionsItem =array('ImsItem.ims_item_category_id' => $child['ImsItemCategory']['id']);
										$items = $this->ImsItem->find('all', array('conditions' => $conditionsItem));
										
										foreach ($items as $item)
											{
					
							if($item['ImsItem']['id'] == $sirvitemsbefore['ims_item_id']){
							
							$item_detail = $this->ImsItem->read(null, $sirvitemsbefore['ims_item_id']);
							if($item_detail['ImsItem']['fixed_asset'] == 1){

								$this->loadModel('ImsTransferItemBefore'); 
								$this->ImsTransferItemBefore->recursive =0;
								$conditionstransferitembefore =array('ImsTransferItemBefore.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
								$transferitembefore = $this->ImsTransferItemBefore->find('first', array('conditions' => $conditionstransferitembefore));
								
								if(empty($transferitembefore)){
									$this->loadModel('ImsReturnItem'); 
									$this->ImsReturnItem->recursive =-1;
									$conditionsreturnitembefore =array('ImsReturnItem.ims_sirv_item_before_id' => $sirvitemsbefore['id']);  						 
									$returnitem = $this->ImsReturnItem->find('all', array('conditions' => $conditionsreturnitembefore));
									if(empty($returnitem)){
										$resultbefore[$countbefore][1] = $item_detail['ImsItem']['description'];
										$resultbefore[$countbefore][2] = $item_detail['ImsItem']['name'];
										$resultbefore[$countbefore][3] = $sirvitemsbefore['quantity'];
										$resultbefore[$countbefore][4] = $sirvitemsbefore['unit_price'];
										$tag_code = null;
										$this->ImsTag->recursive = -1;			
										$conditionstag =array('ImsTag.ims_sirv_item_before_id	' => $sirvitemsbefore['id']);  						 
										$tags_detail = $this->ImsTag->find('all', array('conditions' => $conditionstag));
										foreach($tags_detail as $tag){
											if(!empty($tag_code))
											{
												$tag_code = $tag_code . ', ' . $tag['ImsTag']['code'];
											}
											else $tag_code = $tag['ImsTag']['code'];
										}
										$resultbefore[$countbefore][5] = $tag_code;
										$resultbefore[$countbefore][6] = $sirvsbefore[$i]['ImsSirvBefore']['created'];
										$resultbefore[$countbefore][7] = $branchName['Branch']['name'];
										$totalpricebefore = $totalpricebefore + ($sirvitemsbefore['quantity'] * $sirvitemsbefore['unit_price']);
										$countbefore++;
										$countsirvbefore++;
									}
								}
							}
							}
							}
							}
							}
						}
						$sirvarraybefore[$sirvsbefore[$i]['ImsSirvBefore']['name']] = $countsirvbefore;
					}
					if($totalpricebefore != 0)
					{					
						$resultbefore[$countbefore][3] = 'Grand Total';
						$resultbefore[$countbefore][4] = number_format($totalpricebefore,2,'.',',');
						$countbefore++;
					}
					
	   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
				
				
				$this->loadModel('Branch');
				$this->Branch->recursive =-1;	
				$branch = $this->Branch->read(null,$branchId);	
				
				$this->set('result',$result);
				$this->set('resultbefore',$resultbefore);
				$this->set('resulttransfer',$resulttransfer);
				$this->set('sirvarray',$sirvarray);
				$this->set('sirvarraybefore',$sirvarraybefore);
				$this->set('transferarray',$transferarray);
				$this->set('branch',$branch['Branch']['name']);
				$this->set('type','Branch');
        }			
    }
}

?>