<?php
class FaAssetsController extends AppController {

	var $name = 'FaAssets';
	
	function index() {
	}

	function approve() {
	}

	function approve_sold() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        
     
		
		$this->set('fa_assets', $this->FaAsset->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		
		$this->set('results', $this->FaAsset->find('count', array('conditions' => $conditions)));
	}

	function list_data_a($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

          $conditions['approved']=0;
		
		$this->set('fa_assets', $this->FaAsset->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		
		$this->set('results', $this->FaAsset->find('count', array('conditions' => $conditions)));
	}
	function list_data_s($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
          
          $conditions['sold_checker']=null;
          $conditions['approved']=0;

		
		$this->set('fa_assets', $this->FaAsset->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		
		$this->set('results', $this->FaAsset->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fa asset', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FaAsset->recursive = 2;
		$this->set('faAsset', $this->FaAsset->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->FaAsset->create();
			$this->autoRender = false;
			if ($this->FaAsset->save($this->data)) {
				$this->Session->setFlash(__('The fa asset has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

 function approveassetsold($id = null) {
		$this->autoRender = false;
       if($id){
       $this->FaAsset->id=$id;
       	$this->FaAsset->read();
       	$asset=$this->FaAsset->data;
	        if( isset($asset['FaAsset']['sold_amount']) && isset($asset['FaAsset']['sold_date']) ){
                if(strcmp($this->Session->read('Auth.User.username'),$asset['FaAsset']['sold_maker'])!=0){
		       	$this->FaAsset->set(array('approved'=>true,'sold_checker'=>$this->Session->read('Auth.User.username')));
		       	if($this->FaAsset->save()){
	       			$this->Session->setFlash(__('The selected asset has been approved', true), '');
					$this->render('/elements/success');
		       	}
		       }else{
		       	$this->Session->setFlash(__('The selected asset has not been approved, this transaction is created by you', true), '');
				$this->render('/elements/failure');
		       }

		    }else{
		    	$this->Session->setFlash(__('The selected asset has not been approved', true), '');
				$this->render('/elements/failure');
		    }

       }
	}
	function approveasset($id = null) {
		$this->autoRender = false;
       if($id){
       $this->FaAsset->id=$id;
       	$this->FaAsset->read();
       	$asset=$this->FaAsset->data;
	        if( isset($asset['FaAsset']['tax_rate']) && isset($asset['FaAsset']['residual_value_rate']) && isset($asset['FaAsset']['ifrs_useful_age']) ){
		       	$this->FaAsset->set(array('approved'=>true,'checker'=>$this->Session->read('Auth.User.username')));
		       	if($this->FaAsset->save()){
	       			$this->Session->setFlash(__('The selected asset has been approved', true), '');
					$this->render('/elements/success');
		       	}
		    }else{
		    	$this->Session->setFlash(__('The selected asset has not been approved', true), '');
				$this->render('/elements/failure');
		    }

       }
	}

	function approveallasset() {
		$this->autoRender = false;

	  $assets=$this->FaAsset->find('all',array('conditions'=>array('FaAsset.approved'=>false),'fields'=>array('FaAsset.id')));
      
      foreach ($assets as $id ) {
      	$this->FaAsset->id=$id['FaAsset']['id'];
       	$this->FaAsset->read();
       	$asset=$this->FaAsset->data;
	        if( isset($asset['FaAsset']['tax_rate']) && isset($asset['FaAsset']['residual_value_rate']) && isset($asset['FaAsset']['ifrs_useful_age']) ){
		       	$this->FaAsset->set(array('approved'=>true,'checker'=>$this->Session->read('Auth.User.username')));
		       	if($this->FaAsset->save()){
	       			
		       	}
		    }
      }
       
	}

	function fetch($id = null) {
		if (!empty($this->data)) {
			
			$from_date=$this->data['FaAsset']['book_date_from'];
			$to_date=$this->data['FaAsset']['book_date_to'];



			$cmd="SELECT round(a.residual_value/a.asset_cost,3) as rate,a.useful_life,a.asset_ref_no,a.category,a.location,a.description,a.asset_cost,
					TO_CHAR(a.booking_date,'YYYY/MM/DD') AS booking_date,nvl(s.asset_ref_no,'not_sold') as sold,nvl(TO_CHAR(s.value_date,'YYYY/MM/DD'),'01-Jan-0001') AS sold_date FROM abyfclive.fatb_sale_wrof_details s RIGHT JOIN
					abyfclive.fatb_contract_master a ON s.asset_ref_no=a.asset_ref_no
					WHERE  a.booking_date BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy') or
             s.value_date BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy') ";

			$fs=fsockopen("10.1.14.26",1521,$errno,$errstr,10);
						
			if($fs){
				$con=oci_connect("sms_notification","Smsnotification#123","10.1.14.26:1521/ABAYDB");
				$res=oci_parse($con,$cmd);
				oci_execute($res);
				$finalResult=array();
				$tax_rate=array('COMP_SOFT'=>0.20,'FURNIFITTI'=>0.15,'MOTORVEH'=>0.15,'MOTOREVH'=>0.15,'OFFANDEQUI'=>0.15,'PREMISES'=>0.05,'INTANGIBLE'=>0.20);
				$cat='';
				while(($r=oci_fetch_array($res,OCI_BOTH+OCI_RETURN_NULLS))!= false ){
					 $this->data=array();

					 	if(substr($r['CATEGORY'],0,5)=='FURN_')
                    		$cat="FURNIFITTI";
                    	else if(substr($r['CATEGORY'],0,4)=='OFF_')
                    		$cat="OFFANDEQUI";
                    	else
                    		$cat=$r['CATEGORY'];

					 // Update the record
                    if($this->exist($r['ASSET_REF_NO'])==0){

                    	// budget_year_id |  sold_budget_year

                    
                    	$this->FaAsset->create();
                    	$this->data['FaAsset']['reference']=$r['ASSET_REF_NO'];
                    	$this->data['FaAsset']['name']=$r['DESCRIPTION'];
                    	$this->data['FaAsset']['ifrs_useful_age']=$r['USEFUL_LIFE'];
                    	$this->data['FaAsset']['residual_value_rate']=$r['RATE'];
                    	$this->data['FaAsset']['book_date']=$r['BOOKING_DATE'];
                    	$this->data['FaAsset']['location']=$r['LOCATION'];
                    	$this->data['FaAsset']['original_cost']=$r['ASSET_COST'];
                    	$this->data['FaAsset']['sold']=$r['SOLD'];
                    	$this->data['FaAsset']['sold_date']=$r['SOLD_DATE'];
                    	$this->data['FaAsset']['tax_cat']=$cat=="INTANGIBLE"?"COMP_SOFT":$cat;  // cat
                    	$this->data['FaAsset']['ifrs_cat']=$cat; // cat
                    	$this->data['FaAsset']['budget_year_id']=15; // cat
                    	$this->data['FaAsset']['tax_rate']=$tax_rate[$cat]; // class
                    	$this->data['FaAsset']['maker']=$this->Session->read('Auth.User.username');
                        $this->FaAsset->save($this->data);
                     }else{

                     	$asset_id=$this->FaAsset->find('all',array('conditions'=>array('FaAsset.reference'=> $r['ASSET_REF_NO']),'fields'=>array('FaAsset.id')));
                     	$asset_id=$asset_id[0]['FaAsset']['id'];
                     	$this->FaAsset->id=$asset_id;
                     	$this->FaAsset->read();
                     	$this->FaAsset->set(array('sold'=>$r['SOLD'],'sold_date'=>$r['SOLD_DATE']));
                      $this->FaAsset->save();
                       
                     }

                  
				}
			}

			    $this->Session->setFlash(__('The fa asset has been saved', true), '');
				$this->render('/elements/success');
			
		
		}
	}

	function edit($id = null, $parent_id = null) {
   
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fa asset', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
    $this->loadModel('FaAssetLog');
   
			$this->autoRender = false;
      $this->data['FaAsset']['approved']=0;
   
      
     $list_asset=$this->FaAsset->find('all',array('conditions'=>array('FaAsset.branch_name'=>$this->data['FaAsset']['branch_name']),'fields'=>array('FaAsset.branch_code'),'limit'=>1 ));
    $this->data['FaAsset']['branch_code']=$list_asset[0]['FaAsset']['branch_code'];
    
    	    $old_date= $this->FaAsset->read(null, $this->data['FaAsset']['id']);
			if ($this->FaAsset->save($this->data)) {
      
        $this->FaAssetLog->create();
        
        $log=array();
        
   //var_dump($old_date);die();
        
         $this->log['FaAssetLog']['fa_asset_id']=$old_date['FaAsset']['id'];
         $this->log['FaAssetLog']['branch_name'] = $old_date['FaAsset']['branch_name'];
         $this->log['FaAssetLog']['branch_code'] = $old_date['FaAsset']['branch_code'];
         $this->log['FaAssetLog']['tax_rate']= $old_date['FaAsset']['tax_rate'];
         $this->log['FaAssetLog']['tax_cat'] = $old_date['FaAsset']['tax_cat'];
         $this->log['FaAssetLog']['class'] = $old_date['FaAsset']['ifrs_class'];
         $this->log['FaAssetLog']['ifrs_cat']= $old_date['FaAsset']['ifrs_cat'];
         $this->log['FaAssetLog']['useful_age'] = $old_date['FaAsset']['ifrs_useful_age'];
         $this->log['FaAssetLog']['residual_value'] = $old_date['FaAsset']['residual_value_rate'];
          $this->log['FaAssetLog']['created_at'] = date("Y/m/d");
        $this->FaAssetLog->save($this->log);
        // var_dump($this->FaAssetLog->save($this->log));die();
        
        
				$this->Session->setFlash(__('The fa asset has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
   
   
    $po=$this->FaAsset->find("list",array('fields'=>array('FaAsset.branch_name')));
    
    
    
    	$pos=array();
        foreach($po as $p){
       
        	$pos[$p]=$p;
		    }
   
 

		$this->set('po',$pos);
		$this->set('fa_asset', $this->FaAsset->read(null, $id));
		
			
	}

	function sold($id = null, $parent_id = null) {
    $this->loadModel('BudgetYear');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fa asset', true), '');
			$this->redirect(array('action' => 'index'));
		}

		
		if (!empty($this->data)) {
      $this->BudgetYear->recursive=0;
      $by=$this->BudgetYear->find('first',array('order'=>array('BudgetYear.id DESC')));
			$this->data['FaAsset']['sold_maker']=$this->Session->read('Auth.User.username');
			$d=new DateTime($this->data['FaAsset']['sold_date']);
            $this->data['FaAsset']['sold_date']=$d->format('Y-m-d');
            $this->data['FaAsset']['approved']=0;
            $this->data['FaAsset']['sold']= $this->data['FaAsset']['reference'];
            $this->data['FaAsset']['sold_budget_year'] =$by['BudgetYear']['id'];

		 
			$this->autoRender = false;
			if ($this->FaAsset->save($this->data)) {
				$this->Session->setFlash(__('The fa asset has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}

		$this->set('fa_asset', $this->FaAsset->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fa asset', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FaAsset->delete($i);
                }
				$this->Session->setFlash(__('Fa asset deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fa asset was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FaAsset->delete($id)) {
				$this->Session->setFlash(__('Fa asset deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fa asset was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function exist($asset_id = null) {
		$this->autoRender = false;

		$asset=$this->FaAsset->find('count', array('conditions' => array('FaAsset.reference'=>$asset_id)));
        return $asset;

	}
}
?>