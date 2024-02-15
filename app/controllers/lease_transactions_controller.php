<?php
class LeaseTransactionsController extends AppController {

	var $name = 'LeaseTransactions';
	
	function index() {
		$leases = $this->LeaseTransaction->Lease->find('all');
		$this->set(compact('leases'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		$lease_id = (isset($_REQUEST['lease_id'])) ? $_REQUEST['lease_id'] : -1;
		if($id)
			$lease_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($lease_id != -1) {
            $conditions['LeaseTransaction.lease_id'] = $lease_id;
        }
		
		$this->set('lease_transactions', $this->LeaseTransaction->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->LeaseTransaction->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid lease transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->LeaseTransaction->recursive = 2;
		$this->set('leaseTransaction', $this->LeaseTransaction->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->LeaseTransaction->create();
			$this->autoRender = false;
			if ($this->LeaseTransaction->save($this->data)) {
				$this->Session->setFlash(__('The lease transaction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The lease transaction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$leases = $this->LeaseTransaction->Lease->find('list');
		$this->set(compact('leases'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid lease transaction', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->LeaseTransaction->save($this->data)) {
				$this->Session->setFlash(__('The lease transaction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The lease transaction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('lease__transaction', $this->LeaseTransaction->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$leases = $this->LeaseTransaction->Lease->find('list');
		$this->set(compact('leases'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for lease transaction', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->LeaseTransaction->delete($i);
                }
				$this->Session->setFlash(__('Lease transaction deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Lease transaction was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->LeaseTransaction->delete($id)) {
				$this->Session->setFlash(__('Lease transaction deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Lease transaction was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function calculat_old($id=null){
		$this->autoRender = false;
	    $this->loadModel('Lease');

	

	    $transaction=array();

	    $lease=$this->Lease->read(null,$id);

	    $total_amount=$lease['Lease']['total_amount'];
	    $paid_amount=$lease['Lease']['paid_amount'];
	    $rent_amount=$lease['Lease']['rent_amount'];
	    $discount=$lease['Lease']['discount'];
	    $contract_years=$lease['Lease']['contract_years'];
	    $paid_years=$lease['Lease']['paid_years'];
	    $is_lease=$lease['Lease']['is_lease'];

	    $s_date=$lease['Lease']['start_date'];
        $s = new DateTime($s_date);
	    $d = new DateTime($s_date ); 
	    $s->modify("-1 month");
	    $d->modify("-1 month");

      

	    $contract_months=$contract_years*12;
	    $paid_months=$paid_years*12;

	    $payment_months=array(0,12,24,36,48,60,72,84,96,108,120,132,144,156,168,180,192,204,216,228,240);



	    if($is_lease){

         $saved=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id)));
       //var_dump(count($saved));die();
      if(count($saved)<=0){
	    	for($i=0;$i<$contract_months;$i++){
	    		$this->LeaseTransaction->create();
                $discount_factor=1/pow(1+$discount/12,$i);

                // First Row insertion.
	    		if($i==0){
                 $transaction['LeaseTransaction']['payment']=$paid_amount;
                 $transaction['LeaseTransaction']['npv']=$paid_amount*$discount_factor;
                 $transaction['LeaseTransaction']['month']=$i;
                 $transaction['LeaseTransaction']['lease_id']=$id;
                 $transaction['LeaseTransaction']['disount_factor']=$discount_factor;
                // $transaction['LeaseTransaction']['from_count_date']=$s_date;
                // $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t' );
                // $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t' )))->days;
                 $this->LeaseTransaction->save($transaction);
	    		}else{

	    			//$s=date_create($s->format('Y-m-t'));
		           // date_add($s,date_interval_create_from_date_string("1 days"));// add number of days 
		            
	    			
	    			$d->modify("+1 month");
                    if($i<$paid_months){
                    	 $transaction['LeaseTransaction']['payment']=0;
		                 $transaction['LeaseTransaction']['npv']=0;
		                 $transaction['LeaseTransaction']['month']=$i;
		                 $transaction['LeaseTransaction']['lease_id']=$id;
		                 $transaction['LeaseTransaction']['disount_factor']=$discount_factor;
		                 $transaction['LeaseTransaction']['from_count_date']=($i==1?$s_date: date_add($s,date_interval_create_from_date_string("1 days")));
               			 $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t');
                 		 $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t')))->days;
		                 $this->LeaseTransaction->save($transaction);
                     
                    }else{
                         
                         if(in_array($i, $payment_months)){
                    	 $transaction['LeaseTransaction']['payment']=$rent_amount*12;
		                 $transaction['LeaseTransaction']['npv']=(12*$rent_amount)*$discount_factor;
		                 }else{
		                 $transaction['LeaseTransaction']['payment']=0;
		                 $transaction['LeaseTransaction']['npv']=0;
		                 }

		                 $transaction['LeaseTransaction']['month']=$i;
		                 $transaction['LeaseTransaction']['lease_id']=$id;
		                 $transaction['LeaseTransaction']['disount_factor']=$discount_factor;
		                 $transaction['LeaseTransaction']['from_count_date']=($i==1?$s_date:  date_add($s,date_interval_create_from_date_string("1 days")));
                 		 $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t' );
                         $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t' )))->days;
		                 $this->LeaseTransaction->save($transaction);


                    }
                    $s->modify("+1 month");

	    		}
	    	}// END OF FOR LOOP
	    }// END OF IF TRANSACTION DOES NOT EXIST CONDITION.

	    	 $saved=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id)));
             $total_npv=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id),'fields'=>array('sum(LeaseTransaction.npv) as total_npv')));;// Sum of npv values.
               $t_npv=$total_npv[0][0]['total_npv'];
               $total_npv=$total_npv[0][0]['total_npv'];


             
	    	 foreach ($saved as $key) {
	    	 	$month=$key['LeaseTransaction']['month'];
	    	 	$c_pay=$key['LeaseTransaction']['payment'];
	    	 	$this->LeaseTransaction->read('null',$key['LeaseTransaction']['id']);
	    	 
        
	    	 	if($month=="0"){
	    	 	 $total_npv=$total_npv-$paid_amount;
                 $this->LeaseTransaction->set('lease_liability',$total_npv);
                 $this->LeaseTransaction->save();
	    	 	}else if($month=="1"){
	    	 	  $inerest_charge=($total_npv)*$discount/12;
	    	 	  $r_lease_value=$total_npv-$c_pay+$inerest_charge;
	    	 	  $asset_nbv_bfwd=$t_npv;
	    	 	  $amortization=$t_npv>0.999?$t_npv/$contract_months:0;
	    	 	  $asset_nbv_cfwd=$asset_nbv_bfwd-$amortization;
                  $this->LeaseTransaction->set(array('interest_charge'=>$inerest_charge,'lease_liability'=>$r_lease_value,'asset_nbv_bfwd'=>$asset_nbv_bfwd,'amortization'=>$amortization,'asset_nbv_cfwd'=>$asset_nbv_cfwd));
                  $this->LeaseTransaction->save();
	    	 	}else{
                  $inerest_charge=($r_lease_value)*$discount/12;
	    	 	  $r_lease_value=$r_lease_value-$c_pay+$inerest_charge;
 				  $asset_nbv_bfwd=$asset_nbv_cfwd;
	    	 	  $amortization=$asset_nbv_bfwd>0.999?$t_npv/$contract_months:0;
	    	 	  $asset_nbv_cfwd=$asset_nbv_bfwd-$amortization;
                  $this->LeaseTransaction->set(array('interest_charge'=>$inerest_charge,'lease_liability'=>$r_lease_value,'asset_nbv_bfwd'=>$asset_nbv_bfwd,'amortization'=>$amortization,'asset_nbv_cfwd'=>$asset_nbv_cfwd));
                  $this->LeaseTransaction->save();

	    	 	}


	    	 }
           
	    }//END OF IF ASSET CONDITION
        
	}
function calculat($id=null){
		$this->autoRender = false;
	    $this->loadModel('Lease');

	

	    $transaction=array();

	    $lease=$this->Lease->read(null,$id);
         
      //var_dump($lease);die();

	    $total_amount=$lease['Lease']['total_amount'];
	    $paid_amount=$lease['Lease']['paid_amount'];
	    $rent_amount=$lease['Lease']['rent_amount'];
	    $discount=$lease['Lease']['discount'];
	    $contract_years=$lease['Lease']['contract_years'];
	    $paid_years=$lease['Lease']['paid_years'];
      $rem_year_payment=$lease['Lease']['rem_year_payment'];
	    $is_lease=$lease['Lease']['is_lease'];
      $xnpv=0;
      $discount_f=0;
	    $s_date=$lease['Lease']['start_date'];
      $header_added=false;
         
     $rem_year=$contract_years-$paid_years;
     
     $s = new DateTime($s_date);
	    $d = new DateTime($s_date); 
	   // $s->modify("-1 month");
	   // $d->modify("-1 month");
       
       $discount_f=pow(1+$discount,(1/365));
       $discount_f=$discount_f-1;
         
         

      

	    $contract_dates=$contract_years*365;
	    $paid_months=$paid_years*12;

	    $payment_dates=array();
         $d_date=$s_date;
         
         for($i=0;$i<$rem_year;$i++){
           $s = new DateTime($s_date);
           $new_year=$paid_years+$i;
           $add=(31536000*$new_year)+86400;//   number og seconds in a year
           $d_date=date('Y-m-d',strtotime($s_date)+$add);
         // $s->modify("+".$new_year." year");
          $payment_dates[]=$d_date;
         }
         
       // var_dump($payment_dates);die();

 
     //$s->modify("-1 day");
     $n_date=date('Y-m-d',strtotime($s_date)-86400);
   
	    if($is_lease){

         $saved=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id)));
       //var_dump(count($saved));die();
       
      if(count($saved)<=0){
      $header_added=true;
	    	for($i=0;$i<$contract_dates;$i++){
	    		$this->LeaseTransaction->create();
                $discount_factor=1/pow(1+$discount/12,$i);
                  $n_date=date('Y-m-d',strtotime($n_date)+86400);
                
        
        
                // First Row insertion.
	    		if($i==0){
                  $xnpv=$paid_amount; 
                   
                 $transaction['LeaseTransaction']['payment']=$paid_amount;
                // $transaction['LeaseTransaction']['npv']=$paid_amount*$discount_factor;
                  $transaction['LeaseTransaction']['lease_date']=$n_date;
                 $transaction['LeaseTransaction']['month']=$i;
                 $transaction['LeaseTransaction']['lease_id']=$id;
                 $transaction['LeaseTransaction']['disount_factor']=$discount_f;
                // $transaction['LeaseTransaction']['from_count_date']=$s_date;
                // $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t' );
                // $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t' )))->days;
                 $this->LeaseTransaction->save($transaction);
	    		}else{
	    			$d->modify("+1 month");
                    if($i<$paid_months){
                    	 $transaction['LeaseTransaction']['payment']=0;
  		                 $transaction['LeaseTransaction']['npv']=0;
                       $transaction['LeaseTransaction']['lease_date']=$n_date;
  		                 $transaction['LeaseTransaction']['month']=$i;
  		                 $transaction['LeaseTransaction']['lease_id']=$id;
  		                 $transaction['LeaseTransaction']['disount_factor']=$discount_f;
  		                 $transaction['LeaseTransaction']['from_count_date']=($i==1?$s_date: date_add($s,date_interval_create_from_date_string("1 days")));
                 			 $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t');
                   		 $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t')))->days;
  		                 $this->LeaseTransaction->save($transaction);
                     
                    }else{
                         
                    if(in_array($n_date, $payment_dates)){
                    
                       $rem=$contract_years-$paid_years;
                       $rent=$rem_year_payment=='YEARLY'?$rent_amount*12:$rent_amount*12*$rem;
                    	 $transaction['LeaseTransaction']['payment']=$rent;
		                  // $transaction['LeaseTransaction']['npv']=(12*$rent_amount)*$discount_factor;
                                          
                       
                      
                       
                       $c_date=$i/365;
                       $d_factor=1+$discount;
                       $ccc=pow($d_factor,$c_date);
                       $ccc=($rent)/$ccc;
                       
                       $xnpv=$xnpv+$ccc;
                       $discount_f=pow($d_factor,(1/365));
                       $discount_f=$discount_f-1;
                      // var_dump($ccc);
                      //  var_dump($discount_factor);die();
                      
                      if($rem_year_payment=='ONE_TIME'){$payment_dates=array(); }
                       
                       
		                 }else{
  		                 $transaction['LeaseTransaction']['payment']=0;
  		                 $transaction['LeaseTransaction']['npv']=0;
		                 }
                     $transaction['LeaseTransaction']['lease_date']=$n_date;
		                 $transaction['LeaseTransaction']['month']=$i;
		                 $transaction['LeaseTransaction']['lease_id']=$id;
		                 $transaction['LeaseTransaction']['disount_factor']=$discount_f;
		                 $transaction['LeaseTransaction']['from_count_date']=($i==1?$s_date:  date_add($s,date_interval_create_from_date_string("1 days")));
                 		 $transaction['LeaseTransaction']['to_count_date']=$d->format( 'Y-m-t' );
                         $transaction['LeaseTransaction']['count_days']=date_diff(date_create($s_date),date_create($d->format( 'Y-m-t' )))->days;
		                 $this->LeaseTransaction->save($transaction);

                    }
                    
	    		}
                             
	    	}// END OF FOR LOOP
	    }// END OF IF TRANSACTION DOES NOT EXIST CONDITION.

	    	 $saved=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id)));
             $total_npv=$this->LeaseTransaction->find('all',array('conditions'=>array('LeaseTransaction.lease_id'=>$id),'fields'=>array('sum(LeaseTransaction.npv) as total_npv')));;// Sum of npv values.
               $t_npv=$total_npv[0][0]['total_npv'];
               $total_npv=$total_npv[0][0]['total_npv'];

        if($header_added){
         
	    	 foreach ($saved as $key) {
                  
	    	 	$month=$key['LeaseTransaction']['month'];
	    	 	$c_pay=$key['LeaseTransaction']['payment'];
	    	 	$this->LeaseTransaction->read('null',$key['LeaseTransaction']['id']);
	    	  

        
	    	 	if($month=="0"){
	    	 	 $total_npv=$total_npv-$paid_amount;
           $lease_liability=$xnpv-$key['LeaseTransaction']['payment'];
           $interest_charge=$lease_liability*$discount_f;
           $amortization=$xnpv/count($saved);
           $next_xnpv=$interest_charge+$lease_liability;
                  $this->LeaseTransaction->set('npv',$xnpv);
                  $this->LeaseTransaction->set('lease_liability',$lease_liability);
                  $this->LeaseTransaction->set('interest_charge',$interest_charge);
                 $this->LeaseTransaction->save();
	    	 	}else if($month=="1"){
	    	 	  $inerest_charge=($total_npv)*$discount/12;
	    	 	  $r_lease_value=$total_npv-$c_pay+$inerest_charge;
	    	 	  $asset_nbv_bfwd=$t_npv;
	    	 	  //$amortization=$t_npv>0.999?$t_npv/$contract_months:0;
	    	 	  $asset_nbv_cfwd=$asset_nbv_bfwd-$amortization;
            $next_lease_liability=$next_xnpv - $key['LeaseTransaction']['payment'];  
            $next_interest_charge=$next_lease_liability*$discount_f;  
                                                     
                  $this->LeaseTransaction->set(array('interest_charge'=>$inerest_charge,'lease_liability'=>$r_lease_value,'asset_nbv_bfwd'=>$asset_nbv_bfwd,'amortization'=>$amortization,'asset_nbv_cfwd'=>$asset_nbv_cfwd,'npv'=>$next_xnpv,'lease_liability'=>$next_lease_liability,'interest_charge'=>$next_interest_charge));
                  $this->LeaseTransaction->save();
                    $next_xnpv=$next_interest_charge+$next_lease_liability;      
	    	 	}else{
                  $inerest_charge=($r_lease_value)*$discount/12;
	    	 	  $r_lease_value=$r_lease_value-$c_pay+$inerest_charge;
 				    $asset_nbv_bfwd=$asset_nbv_cfwd;
	    	 	  //$amortization=$asset_nbv_bfwd>0.999?$t_npv/$contract_months:0;
	    	 	  $asset_nbv_cfwd=$asset_nbv_bfwd-$amortization;
             $next_xnpv=$next_interest_charge+$next_lease_liability;                                                                
            $next_lease_liability=$next_xnpv - $key['LeaseTransaction']['payment'];  
            $next_interest_charge=$next_lease_liability*$discount_f;  
           
                  $this->LeaseTransaction->set(array('interest_charge'=>$inerest_charge,'lease_liability'=>$r_lease_value,'asset_nbv_bfwd'=>$asset_nbv_bfwd,'amortization'=>$amortization,'asset_nbv_cfwd'=>$asset_nbv_cfwd,'npv'=>$next_xnpv,'lease_liability'=>$next_lease_liability,'interest_charge'=>$next_interest_charge));
                  $this->LeaseTransaction->save();
                    
	    	 	}
	    	 }  // FOR EACH
       } // HEADER ADDED
           
	    }//END OF IF ASSET CONDITION
        
	}
	function calculatall($id=null){
		$this->autoRender = false;
	    $this->loadModel('Lease');

	    $transaction=array();

        
        $leases=$this->Lease->find('all',array('fields'=>'Lease.id'));

        foreach ($leases as $key) {
        
          $this->calculat($key['Lease']['id']);
        
        }// END OF FOR EACH LEASE.
        
	}
 
 
}
?>