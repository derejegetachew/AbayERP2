<?php
class FaTransactionsController extends AppController {

	var $name = 'FaTransactions';
	
	function index(){

		$b_ids= $this->FaTransaction->find('all',array('fields'=>'DISTINCT FaTransaction.budget_year_id'));
       
       $not_in_list;
        foreach ($b_ids as $key ) {
        	$not_in_list[]= $key['FaTransaction']['budget_year_id'];
        }
         
        
    $budget_years = $this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=>$not_in_list)));

		//$budget_years = $this->FaTransaction->BudgetYear->find('all');
		$this->set(compact('budget_years'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$budgetyear_id = (isset($_REQUEST['budgetyear_id'])) ? $_REQUEST['budgetyear_id'] : -1;
		if($id)
			$budgetyear_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

		if ($budgetyear_id != -1) {

            $conditions['FaTransaction.budget_year_id'] = $budgetyear_id;
        }
		
		$this->set('fa_transactions', $this->FaTransaction->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FaTransaction->find('count', array('conditions' => $conditions)));
	}


 
 	function soldall($id = null, $parent_id = null) {
  
  	$this->autoRender = false;
   $this->loadModel('FaAsset');
    $this->loadModel('BudgetYear');
    /*
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fa asset', true), '');
			$this->redirect(array('action' => 'index'));
		}
   */
      	
     $assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.approved'=>true,'FaAsset.port'=>20231204)));
     //var_dump($assets);die;
      
     foreach($assets as $asset){
            $data;
            $this->BudgetYear->recursive=0;
            $by=$this->BudgetYear->find('first',array('order'=>array('BudgetYear.id DESC')));
      			$data['FaAsset']['sold_maker']="system";//$this->Session->read('Auth.User.username');
      			$d=new DateTime('12/04/2023');
            //$data['FaAsset']['sold_date']=$d->format('Y-m-d');
            $data['FaAsset']['approved']=0;
            $data['FaAsset']['id']=$asset['FaAsset']['id'];
            $data['FaAsset']['reference']=$asset['FaAsset']['reference'];
            $data['FaAsset']['sold']= $asset['FaAsset']['reference'];
            $data['FaAsset']['sold_budget_year'] =$by['BudgetYear']['id'];
            
             $data['FaAsset']['sold_amount']=$asset['FaAsset']['sold_amount'];;
             $data['FaAsset']['sold_date']='2023/12/04';
             $data['FaAsset']['sold_type']='SOLD';  
            
		
			if ($this->FaAsset->save($data)) {
             // var_dump($data);die();
              
                $this->add($data,'SOLD');
                $this->addifrs($data,'SOLD');
            
			} 
      
      //die();
      
      }// foreach end
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fa transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FaTransaction->recursive = 2;
		$this->set('faTransaction', $this->FaTransaction->read(null, $id));
	}
 
 	function sold($id = null, $parent_id = null) {
    $this->loadModel('FaAsset');
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
     
            // if current sold is subjected to depreciation, then proccess the depreciation.
            if($this->data['FaAsset']['sold_type'] == 'SOLD'){
              //var_dump($this->data);die();
                $this->add($this->data,'SOLD');
                $this->addifrs($this->data,'SOLD');
            }
           // die();
        
				//$this->Session->setFlash(__('The fa asset has been saved', true), '');
				//$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa asset could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
      
		}

		$this->set('fa_asset', $this->FaAsset->read(null, $id));
		
			
	}

	function add($id = null,$flag = null) {
 
  
		if (!empty($this->data) || !empty($id)) {
			$this->FaTransaction->create();
			$this->autoRender = false;

    

          
        $b=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=> $this->data['FaTransaction']['budget_year_id'] )));
        
        if( !isset($b) || count($b)<=0 || empty($b) ){
         $b=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=> $id['FaAsset']['sold_budget_year'] )));
        }
        
        
       
        
        
        $this->data['FaTransaction']['budget_year_id']=$b[0]['BudgetYear']['id'];
        
        
     

        $from_date=$b[0]['BudgetYear']['from_date'];
        $to_date=$b[0]['BudgetYear']['to_date'];

         $ref_list=array('000OFEQ200580051');

        $new_cal_start_date=date_create('2016-07-01');

      //Depreciation startes from 2011-2012 budget year.
       if($this->data['FaTransaction']['budget_year_id']==3){
        $assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.book_date >='=>$from_date,'FaAsset.book_date <='=>$to_date,'FaAsset.approved'=>true,'FaAsset.port'=>20233161),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.tax_rate','FaAsset.book_value','FaAsset.sold_date','FaAsset.book_date','FaAsset.tax_cat')));
       }
       if($this->data['FaTransaction']['budget_year_id']!=3){
       
       // For sold
       if(isset($id)){
       $assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.reference'=>$id['FaAsset']['reference'] ),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.tax_rate','FaAsset.book_value','FaAsset.sold_date','FaAsset.book_date','FaAsset.tax_cat')));
       
       }else{
     	$assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.book_date <='=>$to_date,'FaAsset.approved'=>true,'FaAsset.sold_date >'=>'1901/01/01','FaAsset.port'=>20230629),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.tax_rate','FaAsset.book_value','FaAsset.sold_date','FaAsset.book_date','FaAsset.tax_cat')));
      }

       }
       
 //var_dump($assets);die();
       
        foreach ($assets as $asset) {
        	$this->FaTransaction->create();
        	$asset_id=$asset['FaAsset']['id'];
        	$sold_date=$asset['FaAsset']['sold_date'];
            $original_cost=$asset['FaAsset']['original_cost'];
            $tax_rate=$asset['FaAsset']['tax_rate'];
            $c_book_value=$asset['FaAsset']['book_value'];
            $book_date=$asset['FaAsset']['book_date'];
            

           //var_dump($asset_id);die();

          //   this code works for editing prior budget year.
         
        /*  $prior_budget_year=$this->data['FaTransaction']['budget_year_id']-1;
          $c_book_value=$this->FaTransaction->find('first',array('conditions'=>array('FaTransaction.budget_year_id'=>$prior_budget_year,'FaTransaction.fa_asset_id'=>$asset_id),'fields'=>array('FaTransaction.tax_book_value')));
          $c_book_value=$c_book_value['FaTransaction']['tax_book_value'];
         */




          // IF Asset sold exclude it from calculation.
         
          

       $this->data['FaTransaction']['fa_asset_id']=$asset_id;
    
    

	     // Depreciation calculation, for Tax is changed prior to 2016-07-01 <=> 2017-06-30 budget year
	     // After this budget year the calculation will be (OC*rate)*(year).
	     // this change affects only assets purchased after 2016-2017 budget year.

         if(($this->data['FaTransaction']['budget_year_id']>7 && $book_date>='2016-07-01') || $asset['FaAsset']['tax_cat']=='PREMISES'){

        $status="";
        
        if($sold_date!=null && !empty($sold_date)  && $sold_date>'1900/01/01'){
          $status="sold";
        // if item is sold, calculated difference from start of the budget uear to sold date.
          if($book_date>$from_date){
          	 $diff=date_diff(date_create($book_date),date_create($sold_date))->days;
          	 $diff=$diff+1;
          }else{
           $diff=date_diff(date_create($from_date),date_create($sold_date))->days;
           	 $diff=$diff+1;
          }
          
        }else{
        if($book_date>$from_date){
               $status="active";
          	 $diff=date_diff(date_create($book_date),date_create($to_date))->days;
          	 $diff=$diff+1;
          }else{
          	 $diff=365;//date_diff(date_create($from_date),date_create($to_date))->days;
          }
        }
        
        
         // Check leap year.
        $leap=date('L',strtotime($to_date));
        $cal_date=$leap=="0"?$diff/365:$diff/366;
        
       // var_dump($cal_date); var_dump($c_book_value);var_dump($diff);die();
        $this->data['FaTransaction']['tax_depreciated_value']=$original_cost*$tax_rate*$cal_date;
        $negate=$c_book_value-$this->data['FaTransaction']['tax_depreciated_value'];
        $val=$negate<0?0:$negate;
         $c_book_value==null?$this->data['FaTransaction']['tax_book_value']=$original_cost-$this->data['FaTransaction']['tax_depreciated_value']:$this->data['FaTransaction']['tax_book_value']=$val;
      }else{
      
        if($sold_date!=null && !empty($sold_date)  && $sold_date>'1900/01/01'){
        
             if($book_date>$from_date){
              	 $diff=date_diff(date_create($book_date),date_create($sold_date))->days;
              	 $diff=$diff+1;
              }else{
               $diff=date_diff(date_create($from_date),date_create($sold_date))->days;
                $diff=$diff+1;
              }
              
            }else{
            if($book_date>$from_date){
                   $status="active";
              	 $diff=date_diff(date_create($book_date),date_create($to_date))->days;
              	 $diff=$diff+1;
              }else{
              	 $diff=365;//date_diff(date_create($from_date),date_create($to_date))->days;
              }
        }
        
        $leap=date('L',strtotime($to_date));
        $cal_date=$leap=="0"?$diff/365:$diff/366;
      
 //  var_dump($cal_date); var_dump($c_book_value);var_dump($diff);die();
$c_book_value==null?$this->data['FaTransaction']['tax_depreciated_value']=$original_cost*$tax_rate*$cal_date:$this->data['FaTransaction']['tax_depreciated_value']=$c_book_value*$tax_rate*$cal_date;
            $c_book_value==null?$this->data['FaTransaction']['tax_book_value']=$original_cost-($original_cost*$tax_rate):$this->data['FaTransaction']['tax_book_value']=$c_book_value-($c_book_value*$tax_rate*$cal_date);
           
        }
        
        
           // var_dump($this->data);die();
           // If record found update, if not found insert.
           // but the update is only for null nalus, if the existing value is null update is applicable.
         
           $val=$this->find_record($asset_id,$this->data['FaTransaction']['budget_year_id']);
            // var_dump($val);
            //  var_dump($cal_date);die();
            if($val==false){
              if($flag == 'SOLD'){
              $this->FaTransaction->save($this->data['FaTransaction']);
              }else{
               $this->FaTransaction->save($this->data);
              }
            }else{
            	$this->FaTransaction->read(null,$val);
             
            	$this->FaTransaction->set(array(
                 'tax_depreciated_value'=>$this->data['FaTransaction']['tax_depreciated_value'],
                  'tax_book_value'=>$this->data['FaTransaction']['tax_book_value']
            	));
            	$this->FaTransaction->save();
            }

            // update current book_value in asset
            $this->FaTransaction->FaAsset->read(null,$asset_id);
            $this->FaTransaction->FaAsset->set('book_value',$this->data['FaTransaction']['tax_book_value']);
            $this->FaTransaction->FaAsset->save();

        }

		
        $this->Session->setFlash(__('The fa transaction has been saved', true), '');
		$this->render('/elements/success');

		}
		if($id)
			$this->set('parent_id', $id);



	  	/*$b_ids= $this->FaTransaction->find('all',array('fields'=>'DISTINCT FaTransaction.budget_year_id'));
       
       
       $not_in_list;
        foreach ($b_ids as $key){
        	$not_in_list[]= $key['FaTransaction']['budget_year_id'];
        }*/
         
        
         $budget_years = $this->FaTransaction->BudgetYear->find('list');

    $budget_years_id = $this->FaTransaction->find('list',array('fields'=>'FaTransaction.budget_year_id','order'=>array('FaTransaction.budget_year_id desc'),'limit'=>1));
    foreach ($budget_years_id as $key ) {
     $budget_years_id =$key;break;
    }

   
		//$budget_years = $this->FaTransaction->BudgetYear->find('list',array('conditions'=>array('BudgetYear.id >'=>$budget_years_id),'limit'=>1));

		$fa_assets = $this->FaTransaction->FaAsset->find('list');
		$this->set(compact('budget_years','fa_assets'));
		
	}



function addifrs($id = null) {

		if (!empty($this->data)) {
			$this->FaTransaction->create();
			$this->autoRender = false;


	  // loop through assets and calculate depreciation for TAX

        $b=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=>$this->data['FaTransaction']['budget_year_id'])));
       
        if( !isset($b) || count($b)<=0 || empty($b) ){
         $b=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=> $id['FaAsset']['sold_budget_year'] )));
        }
        
        $this->data['FaTransaction']['budget_year_id']=$b[0]['BudgetYear']['id'];
     
        // if book date greaet than the budget start year, calculate the date from book date to budget end date
        // if the book date less than the budget start yeat, then take no days in the given budget year.
        $from_date=$b[0]['BudgetYear']['from_date'];
        $to_date=$b[0]['BudgetYear']['to_date'];

            $ref_list=array('000OFEQ200580051');
      
      
      //Depreciation startes from 2011-2012 budget year.
       if($this->data['FaTransaction']['budget_year_id']==3){
        $assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.book_date >='=>$from_date,'FaAsset.book_date <='=>$to_date,'FaAsset.approved'=>true,'FaAsset.port'=>2023316),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.residual_value_rate','FaAsset.ifrs_useful_age','FaAsset.sold_date','FaAsset.book_date','FaAsset.book_value_ifrs','FaAsset.ifrs_remaining_days')));

       

       }
       if($this->data['FaTransaction']['budget_year_id']!=3){
       
        if(isset($id)){
    	$assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.reference'=> $id['FaAsset']['reference']),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.residual_value_rate','FaAsset.ifrs_useful_age','FaAsset.book_date','FaAsset.book_date_ifrs','FaAsset.book_value_ifrs','FaAsset.sold_date','FaAsset.ifrs_remaining_days')));
       
       }else{
       
       $assets=$this->FaTransaction->FaAsset->find('all',array('conditions'=>array('FaAsset.book_date <='=>$to_date,'FaAsset.approved'=>true,'FaAsset.sold_date <'=>'1901/01/01','FaAsset.reference'=>''),'fields'=>array('FaAsset.id','FaAsset.original_cost','FaAsset.residual_value_rate','FaAsset.ifrs_useful_age','FaAsset.book_date_ifrs','FaAsset.book_date','FaAsset.book_value_ifrs','FaAsset.sold_date','FaAsset.ifrs_remaining_days')));
        
        
           // $assets=$this->FaTransaction->FaAsset->find('count',array('conditions'=>array('FaAsset.book_date <='=>$to_date,'FaAsset.approved'=>true,'FaAsset.sold_date <'=>'1901/01/01')));  
        
        
        }

       	
       }

      //var_dump($assets);die();

        foreach ($assets as $asset) {
        	$this->FaTransaction->create();

        	$asset_id=$asset['FaAsset']['id'];
        	 $this->FaTransaction->FaAsset->read(null,$asset_id);
        	$sold_date=$asset['FaAsset']['sold_date'];
        	$book_date=$asset['FaAsset']['book_date_ifrs'];//$asset['FaAsset']['book_date_ifrs'];
            $book_value=$asset['FaAsset']['book_value_ifrs'];
            $original_cost=$asset['FaAsset']['original_cost'];
            $remaining=$asset['FaAsset']['ifrs_remaining_days'];
            $ifrs_useful_age=$asset['FaAsset']['ifrs_useful_age'];
            $residual_value_rate=$asset['FaAsset']['residual_value_rate'];

            
         // this code works for editing prior budget year.
/*          $prior_budget_year=$this->data['FaTransaction']['budget_year_id']-1;
          $book_value=$this->FaTransaction->find('first',array('conditions'=>array('FaTransaction.budget_year_id'=>$prior_budget_year,'FaTransaction.fa_asset_id'=>$asset_id),'fields'=>array('FaTransaction.ifrs_book_value')));
          $book_value=$book_value['FaTransaction']['ifrs_book_value'];*/
            

           
            $new_date=strtotime($book_date);
            $new_date = strtotime('+ '.$ifrs_useful_age.' years', $new_date);
            $new_date=date('Y-m-d',$new_date);
            $c_age=date_diff(date_create($book_date),date_create($new_date))->days-1;
            $first_year_days=date_diff(date_create($book_date),date_create($to_date))->days; // no of days at first year calculation since the book date



              
 	          
         $ii="";
         // If the item is sold in the budget year.             
         if($sold_date!=null && !empty($sold_date)  && $sold_date>'1900/01/01' ){
         $ii="sold";
              if(false){
                $diff=date_diff(date_create($from_date),date_create($sold_date))->days;
              }else{
               
              
             	if($first_year_days<365){
                $diff=$first_year_days;
                $date_remaining=$c_age-$first_year_days;
               
                $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$date_remaining);
                 $this->FaTransaction->FaAsset->save();
  
            	}if($first_year_days>=365){
             
             $new_budget_year=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=> $id['FaAsset']['sold_budget_year'])));
                    
                // $new_budget_year=$this->FaTransaction->BudgetYear->find('all',array('conditions'=>array('BudgetYear.id'=> 15)));
                    
                 $new_from_year= $new_budget_year[0]['BudgetYear']['from_date'];
                 $new_remaining=date_diff(date_create($new_from_year),date_create($sold_date))->days;
                
                if($remaining>=365){
                	$diff=$new_remaining+1;
                  $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$remaining-$new_remaining);
                }
                 // Final year.
                if($remaining<365 && $remaining>0){
                   
                   // if an asset is sold before the remaining days.
                   if($new_remaining<=$remaining){
                   $diff=$new_remaining-1;
                   }else{
                   $diff=$remaining-1;
                   }
                   
                   // To solve previous calculation mistake, add 1 day if the book date is less than July-01-2023, b/c 1 day was suppose to be add at first year.
                  if($book_date<'2023/07/01'){
                    $diff=$diff+1;
                   }
                   
                   
                   
                   $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$remaining-$remaining);
                }
                if($remaining<=0){
                	$diff=0;
                }
              }
          }
          
           
          
          }else{
          
                 $ii="NOT SOLD";
           
          if($book_date>$from_date){
             
          	 $diff=date_diff(date_create($book_date),date_create($to_date))->days;
             
             $diff=$diff+1;
             
          	  $date_remaining=$c_age-$diff;
              $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$date_remaining);
               $this->FaTransaction->FaAsset->save();
          }else{
            // For First Year days, less than 365.  save the remaining days.
          	if($first_year_days<365){
              $diff=$first_year_days;
              $date_remaining=$c_age-$first_year_days;
             
              $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$date_remaining);
               $this->FaTransaction->FaAsset->save();

          	}if($first_year_days>=365){
              
              if($remaining>=365){
             	$diff=365;
              $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$remaining-365);
              }
               // Final year.
              if($remaining<365 && $remaining>0){
                
                // To solve previous calculation mistake, add 1 day if the book date is less than July-01-2023, b/c 1 day was suppose to be add at first year.
                  if($book_date<'2023/07/01'){
                   $diff=$remaining;
                  }else{
                    $diff=$remaining-1;
                  }
                 
                 
                 $this->FaTransaction->FaAsset->set('ifrs_remaining_days',$remaining-$remaining);
              }
              if($remaining<=0){
              	$diff=0;
              }
            }
          }
          }
          
        

          $cal_date=$diff/365;
          
          //var_dump($new_remaining);
          //var_dump($sold_date);
          //($new_from_year);die();
         
        
          
          // IF Asset sold exclude it from calculation.
          if($sold_date!=null && !empty($sold_date) && $sold_date>'1900/01/01'){
            if($sold_date<=$to_date && $sold_date>='1900-00-00'){
            	//$residual_value_rate=$book_value=$original_cost=0;

            }
          }

       
         
            
          $this->data['FaTransaction']['fa_asset_id']=$asset_id;
          $this->data['FaTransaction']['ifrs_depreciated_value']=(($original_cost-($original_cost*$residual_value_rate))/$ifrs_useful_age)*$cal_date;
          $book_value==null?$this->data['FaTransaction']['ifrs_book_value']=$original_cost-$this->data['FaTransaction']['ifrs_depreciated_value']:$this->data['FaTransaction']['ifrs_book_value']=$book_value-$this->data['FaTransaction']['ifrs_depreciated_value'];

 
 

           // If record found update, if not found insert.
           $val=$this->find_record($asset_id,$this->data['FaTransaction']['budget_year_id']);
            if($val==false){
              if($flag == 'SOLD'){
              $this->FaTransaction->save($this->data['FaTransaction']);
              }else{
               $this->FaTransaction->save($this->data);
              }
            }else{
            	$this->FaTransaction->read(null,$val);
            	$this->FaTransaction->set(array(
                 'ifrs_depreciated_value'=>$this->data['FaTransaction']['ifrs_depreciated_value'],
                  'ifrs_book_value'=>$this->data['FaTransaction']['ifrs_book_value']
            	));
            	$this->FaTransaction->save();
            }

            // update current book_value in asset
            
            $this->FaTransaction->FaAsset->set('book_value_ifrs',$this->data['FaTransaction']['ifrs_book_value']);
            $this->FaTransaction->FaAsset->save();
             

        }

		
        $this->Session->setFlash(__('The fa transaction has been saved', true), '');
		$this->render('/elements/success');

		}
		if($id)
			$this->set('parent_id', $id);

   /*   $b_ids= $this->FaTransaction->find('all',array('fields'=>'DISTINCT FaTransaction.budget_year_id','conditions'=>array('FaTransaction.ifrs_book_value'=>null)));
       
       
       $not_in_list;
        foreach ($b_ids as $key ) {
        	$not_in_list[]= $key['FaTransaction']['budget_year_id'];
        }
         
        
        // $budget_years = $this->FaTransaction->BudgetYear->find('list',array('conditions'=>array('NOT'=>array('BudgetYear.id'=>$not_in_list))));

*/
		$budget_years = $this->FaTransaction->BudgetYear->find('list');


     $budget_years_id = $this->FaTransaction->find('list',array('conditions'=>array('FaTransaction.ifrs_book_value <>'=>null), 'fields'=>'FaTransaction.budget_year_id','order'=>array('FaTransaction.budget_year_id desc'),'limit'=>1));
    foreach ($budget_years_id as $key ) {
     $budget_years_id =$key;break;
    }

   
    //$budget_years = $this->FaTransaction->BudgetYear->find('list',array('conditions'=>array('BudgetYear.id >'=>$budget_years_id),'limit'=>1));

		$fa_assets = $this->FaTransaction->FaAsset->find('list');
		$this->set(compact('budget_years','fa_assets'));
		
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fa transaction', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->FaTransaction->save($this->data)) {
				$this->Session->setFlash(__('The fa transaction has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The fa transaction could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('fa__transaction', $this->FaTransaction->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$budget_years = $this->FaTransaction->BudgetYear->find('list');
		$this->set(compact('budget_years'));
	}

	function delete($id = null) {

		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fa transaction', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->FaTransaction->delete($i);
                }
				$this->Session->setFlash(__('Fa transaction deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Fa transaction was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->FaTransaction->delete($id)) {
				$this->Session->setFlash(__('Fa transaction deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Fa transaction was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function find_record($asset_id,$budget_year){
     $this->autoRender = false;
     $result=$this->FaTransaction->find('first',array('conditions' => array('FaTransaction.fa_asset_id'=>$asset_id,'FaTransaction.budget_year_id'=>$budget_year)));
     
     if($result!=false && $result['FaTransaction']['id']!=''){
        return $result['FaTransaction']['id'];
     }else{
     	return false;
     }
   
	}
}
?>