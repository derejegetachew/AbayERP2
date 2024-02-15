<?php
class BpPlansController extends AppController {

	var $name = 'BpPlans';
	
	function index() {
		$this->BpPlan->recursive=0;
        $this->BpPlan->Branch->recursive=0;
		
		$branches = $this->BpPlan->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index2($id = null){
		$this->set('parent_id', $id);
	}

	function search(){
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
            $conditions['BpPlan.branch_id'] = $branch_id;
			$conditions['BpPlan.status'] = false;
        }
		
		$conditions['BpPlan.status'] = false;

       // $cmd="select p.month,p.budget_year_id,p.branch_id,p.created,p.modified,d.* from bp_plans p inner join bp_plan_details d on p.id=d.bp_plan_id;"
		//$this->set('bp_plans',$this->BpPlan->query($cmd));
		$this->set('bp_plans', $this->BpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlan->find('count', array('conditions' => $conditions)));
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
            $conditions['BpPlan.branch_id'] = $branch_id;
			
        }
          $conditions['BpPlan.status']=0;
       // $cmd="select p.month,p.budget_year_id,p.branch_id,p.created,p.modified,d.* from bp_plans p inner join bp_plan_details d on p.id=d.bp_plan_id;"
		//$this->set('bp_plans',$this->BpPlan->query($cmd));
		$this->set('bp_plans', $this->BpPlan->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlan->find('count', array('conditions' => $conditions)));
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp plan', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpPlan->recursive = 2;
		$this->set('bpPlan', $this->BpPlan->read(null, $id));
	}
	
	function view1($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp plan', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->BpPlan->recursive = 2;
		$this->set('bpPlan', $this->BpPlan->read(null, $id));
		
	}

	function add($id = null) {
		$ok=false;
		$this->loadModel('BpPlanLog');
		$counter=0;
		if (!empty($this->data)) {
			$this->BpPlan->create();
			$this->autoRender=false;
			$this->data['BpPlan']['status']=false;
			$branch=$this->data['BpPlan']['branch_id'];
			$budget=$this->data['BpPlan']['budget_year_id'];
			$this->loadModel('BpMonth');
			$results=$this->BpMonth->find('all');
			$user_id=$this->Session->read('Auth.User.id');
			foreach($results as $result){
				$month=$this->data['BpPlan']['bp_month_id']=$result['BpMonth']['id'];
				
				$cmd="INSERT INTO bp_plans (branch_id,bp_month_id,status,budget_year_id)".
				     " VALUES($branch,$month,0,$budget)";
				//if($this->BpPlan->save($this->data)){
				if($this->BpPlan->query($cmd)==1){
					
					$cmd=" INSERT INTO bp_plan_logs (bp_plan_id,user_id,type,created)".
					     " VALUES(last_insert_id(),$user_id,'Plan Created',CURRENT_TIMESTAMP)"; 
					$this->BpPlanLog->query($cmd);
					$ok=true;
					$counter++;
				}else{
					$ok=false;
				}
		    }
			if($ok){
				$this->Session->setFlash(__('The bp plan has been saved $counter ', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('The bp plan could not be saved. Please, try again.', true), '');
			    $this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->BpPlan->Branch->find('list');
		$bp_items = $this->BpPlan->BpItem->find('list');
		$bp_month = $this->BpPlan->BpMonth->find('list');
		$budget_years = $this->BpPlan->BudgetYear->find('list');
		$this->set(compact('branches', 'bp_items', 'budget_years','bp_month'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpPlan->save($this->data)) {
				$this->Session->setFlash(__('The bp plan has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp plan could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__plan', $this->BpPlan->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->BpPlan->Branch->find('list');
		$bp_items = $this->BpPlan->BpItem->find('list');
		$budget_years = $this->BpPlan->BudgetYear->find('list');
		$this->set(compact('branches', 'bp_items', 'budget_years'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp plan', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpPlan->delete($i);
                }
				$this->Session->setFlash(__('Bp plan deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp plan was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpPlan->delete($id)) {
				$this->Session->setFlash(__('Bp plan deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp plan was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}

	function download($id){
		// Fetch All Items.
		// Build the excel template.
		
		
		$this->autoRender = false;
		$values=explode('_',$id);
		$branch=$values[0];
		$budget=$values[1];
		$this->BpPlan->BpItem->recursive=0;
		$items=$this->BpPlan->BpItem->find('all');
        $name= $this->BpPlan->find('all',array('conditions'=>array('BpPlan.branch_id'=>$branch,'BpPlan.budget_year_id'=>$budget,'BpPlan.status'=>0)));
		
		$July=$name[0]['BpPlan']['id'];
		$August=$name[1]['BpPlan']['id'];
		$September=$name[2]['BpPlan']['id'];
		$October=$name[3]['BpPlan']['id'];
		$November=$name[4]['BpPlan']['id'];
		$December=$name[5]['BpPlan']['id'];
		$January=$name[6]['BpPlan']['id'];
		$February=$name[7]['BpPlan']['id'];
		$March=$name[8]['BpPlan']['id'];
		$April=$name[9]['BpPlan']['id'];
		$May=$name[10]['BpPlan']['id'];
		$June=$name[11]['BpPlan']['id'];
		
              
          header("Content-Type: text/csv;charset=utf-8");
          header('Content-disposition: attachment; filename=Template_Items.csv');


          $output=fopen("php://output", "w");
		  // if plan is for all months.
         		 fputcsv($output, array("Item Id","Account Name","Item Name","July_$July","August_$August","September_$September","October_$October","November_$November","December_$December","January_$January","February_$February","March_$March","April_$April","May_$May","June_$June"));
         
		  // if plan is for specific Month.
         	// fputcsv($output, array("Plan No","Item Id","Account Name","Item Name","$monthName"));
         
		 foreach ($items as $item => $j){
        
          		fputcsv($output, array($j['BpItem']['id'],$j['BpItem']['accoun_no'], $j['BpItem']['name']));
          	  
         }
          fclose($output);


       


        /*
          header("Content-Type: application/vnd.ms-excel");
          header('Content-disposition: attachment; filename=Template_Items.csv');
          echo "<table border='0'>";
          echo "<tr>";
          echo "<th>Account Name</th>";
          echo "<th>Item Name</th>";
          echo "<th>July</th>";
          echo "<th>Augets</th>";
          echo "<th>Septembet</th>";
          echo "<th>October</th>";
          echo "<th>November</th>";
          echo "<th>December</th>";
          echo "<th>January</th>";
          echo "<th>February</th>";
          echo "<th>March</th>";
          echo "<th>April</th>";
          echo "<th>May</th>";
          echo "<th>June</th>";
          echo " </tr>";
		foreach ($items as $item => $j) {
              
			echo "<tr>";
			echo "<td>".$j['BpItem']['accoun_no']."</td>";
			echo "<td>".$j['BpItem']['name']."</td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "</tr>";
			
		}
		echo "</table>";

		*/
		
	}
	
	function export($id){
			$this->autoRender = false;
			
			//$values=explode('_',$id);
			//$branch=$values[0];
			//$budget=$values[1];
			$this->BpPlan->BpItem->recursive=0;
			
			   	$cmd=" select  it.name,pd.bp_item_id as bp_item_id,pd.amount as planAmount,ac.bp_item_id as actualItem,round(sum(ac.amount),4) as ".       " actualAmount,".
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
				" select it.name,ac.bp_item_id as bp_item_id,pd.amount planAmount,ac.bp_item_id,round(sum(ac.amount),4) as actualAmount,".
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

				" select distinct  it.name,bp_item_id,0 as planAmount,null as actualItem,0 as actualAmount,".
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

			// var_dump($cmd);
		      
			  $items=$this->BpPlan->query($cmd);

              
              
			  header("Content-Type: text/csv;charset=utf-8");
			  header('Content-disposition: attachment; filename=Budget_Performance.csv');


			  $output=fopen("php://output", "w");
			  // if plan is for all months.
			fputcsv($output, array("id","name","planAmount","actualAmount","cumulativePlan","cumilativeActual"));
			 
			  // if plan is for specific Month.
				// fputcsv($output, array("Plan No","Item Id","Account Name","Item Name","$monthName"));
			 
			 foreach ($items as $item => $j){
			       
			fputcsv($output, array($j[0]['bp_item_id'], $j[0]['name'], $j[0]['planAmount'],$j[0]['actualAmount'],$j[0]['cumulativePlan'],$j[0]['cumilativeActual']));
			 }
			  fclose($output);

	}
	
	function approve($id=null){
		$this->loadModel('BpPlanLog');
		$this->BpPlan->recursive=0;
        $this->BpPlan->Branch->recursive=0;
	    $msg="";
		if(isset($id)){
			
			$user_id=$this->Session->read('Auth.User.id');
			$cmd="select count(id) c from  bp_actuals  where   bp_plan_id=$id";
			$count=$this->BpPlan->query($cmd);
			$count=$count[0][0]['c'];
			if(true){
			  $cmd="select count(id) c from bp_plans where  bp_month_id<(select bp_month_id from bp_plans where id=$id) and  branch_id=(select branch_id from bp_plans where id=$id) and status=0;";
			  $count=$this->BpPlan->query($cmd);
			  $count=$count[0][0]['c'];
			  
			   if($count==0){
				  $cmd="UPDATE bp_plans set status=1 where id=$id";
				  $this->BpPlan->query($cmd);
				  
				  $cmd=" INSERT INTO bp_plan_logs (bp_plan_id,user_id,type,created)".
					     " VALUES($id,$user_id,'Plan Approved',CURRENT_TIMESTAMP)"; 
				  $this->BpPlanLog->query($cmd);
				  
				  $this->set('msg',"OK");
				  $this->render('/elements/test');
			   }else{
				  $this->set('msg',"Please Approve prior month first.");
				  $this->render('/elements/test');
			  }
			  
			}else{
				$this->set('msg',"Please Add Actual Amount First.");
				$this->render('/elements/test');
			}
		}
		else{
			
		}
		
	
		$branches = $this->BpPlan->Branch->find('all');
		$this->set(compact('branches','msg'));
	}
	function  close_budget(){



		if (!empty($this->data)) {
            $bid=$this->data['BpPlan']['budget_year_id'];
			$cmd="UPDATE bp_plans SET status=1 WHERE budget_year_id=$bid AND id>0;";
			

			if($this->BpPlan->query($cmd)){
				$this->Session->setFlash(__('Budget Year Closed ', true), '');
				$this->render('/elements/success');
			}else{
				$this->Session->setFlash(__('Budget Year closing has failed..', true), '');
			    $this->render('/elements/failure');
			}
		}


	   	$budget_years = $this->BpPlan->BudgetYear->find('list',array('conditions'=>array(' BudgetYear.id'=>$this->BpPlan->find('list',array('fields'=>array('BpPlan.budget_year_id'),'conditions'=>array('BpPlan.status'=>false))))));
		$this->set(compact( 'budget_years'));

	}
}
?>