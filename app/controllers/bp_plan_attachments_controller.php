<?php





class BpPlanAttachmentsController extends AppController {

	var $name = 'BpPlanAttachments';
	
	
	function index() {
		$plans = $this->BpPlanAttachment->BpPlan->find('all');
		$this->set(compact('plans'));
	}
	
	function index2($id = null) {
		//var_dump($id);
		$user = $this->Session->read();
		$this->Session->delete('Person.messatt');
		if($id==0){
			if($this->Session->read('Person.messatt')==null)
			$this->Session->write('Person.messatt', $user['Auth']['User']['id'].'000000');
		
		$id=$this->Session->read('Person.messatt');
		}
	    
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$plan_id = (isset($_REQUEST['plan_id'])) ? $_REQUEST['plan_id'] : -1;
		if($id)
			$plan_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($plan_id != -1) {
            $conditions['BpPlanAttachment.plan_id'] = $plan_id;
        }
	 	
		$this->set('bp_Plan_Attachments', $this->BpPlanAttachment->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BpPlanAttachment->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bp plan attachment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BpPlanAttachment->recursive = 2;
		$this->set('bpPlanAttachment', $this->BpPlanAttachment->read(null, $id));
	}

	function add($id = null) {


	


		if (!empty($this->data)) {
		    $this->layout = 'ajax'; 
			$this->BpPlanAttachment->create();
			$this->autoRender = false;
			
			$file = $this->data['DmsAttachment']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
			//$fname = time(); old time
			$milliseconds = round(microtime(true) * 1000);
            $fname = $milliseconds; // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

            if (!file_exists(FILES_DIR .DS. 'message_attachments'))
                mkdir(FILES_DIR .DS. 'message_attachments', 0777);

            $path=FILES_DIR .DS. 'message_attachments' . DS . $file_name;

            if (!move_uploaded_file($file['tmp_name'], FILES_DIR .DS. 'message_attachments' . DS . $file_name)) {
                $file_name = 'No file';
            }

            $this->SaveCSV(FILES_DIR .DS. 'message_attachments' . DS . $file_name);
            $this->data['file_name'] = $file_name;
            $this->data['path'] = $path;
            $this->data['original'] =basename($file['name']);
			$this->data['plan_id'] = $id;

			//$filetype=IOFactory::identify($file_name);
			/*$reader=IOFactory::createReader($filetype);
			$reader->setReadDataOnly(true);
			$sh=$reader->load($file_name);
			$index=$sh->getActiveSheetIndex();
			$book=$sh->getActiveSheet();*/
		    
			
			if ($this->BpPlanAttachment->save($this->data)) {
				$this->Session->setFlash(__('The attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			
		}
		if($id)
			$this->set('parent_id', $id);

		
        
		//$plans = 'hi';//$this->BpPlanAttachment->BpPlan->find('list');
		//$this->set(compact('plans'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bp plan attachment', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BpPlanAttachment->save($this->data)) {
				$this->Session->setFlash(__('The bp plan attachment has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The bp plan attachment could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('bp__plan__attachment', $this->BpPlanAttachment->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$plans = $this->BpPlanAttachment->Plan->find('list');
		$this->set(compact('plans'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bp plan attachment', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BpPlanAttachment->delete($i);
                }
				$this->Session->setFlash(__('Bp plan attachment deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Bp plan attachment was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BpPlanAttachment->delete($id)) {
				$this->Session->setFlash(__('Bp plan attachment deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Bp plan attachment was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}



	function SaveCSV($filePath){

		$this->loadModel('BpMonth');
		$this->loadModel('BpPlan');
		$this->loadModel('BpPlanDetail');
        $MonthName="NONE";
		try
		{
			    $counter=0;
				$row = 1;
				if (($handle = fopen($filePath, "r")) !== FALSE) {
				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				        
				    // for ($c=0; $c < $num; $c++) {
				   // echo $data[$c] . "<br />\n";
				  // }
                 //
                // July | Augest | September | October | November | December | January | February | March | April | May | June
	           //  03  | 04     |  05       |  06     |  7       |   8      |  9      |   10     |  11   | 12    | 13  |  14

	                if($counter==0){
						
						$one=$this->GetmonthId($data[3]==''?0:$data[3]);
						$two=$this->GetmonthId($data[4]==''?0:$data[4]);
						$three=$this->GetmonthId($data[5]==''?0:$data[5]);
						$four=$this->GetmonthId($data[6]==''?0:$data[6]);
						$five=$this->GetmonthId($data[7]==''?0:$data[7]);
						$six=$this->GetmonthId($data[8]==''?0:$data[8]);
						$seven=$this->GetmonthId($data[9]==''?0:$data[9]);
						$eight=$this->GetmonthId($data[10]==''?0:$data[10]);
						$nine=$this->GetmonthId($data[11]==''?0:$data[11]);
						$ten=$this->GetmonthId($data[12]==''?0:$data[12]);
						$eleven=$this->GetmonthId($data[13]==''?0:$data[13]);
						$twelve=$this->GetmonthId($data[14]==''?0:$data[14]);
						
						$this->BpPlan->read('budget_year_id',$one[1]);
						$budgetYear_id=$this->BpPlan->data;
						//print_r($budgetYear_id);
					}
				   if($counter>0){
				    
                        
				      	$July=$data[3]==''?0:$data[3];
				   	    $Augest=$data[4]==''?0:$data[4];
				   		$September=$data[5]==''?0:$data[5];
				   		$October=$data[6]==''?0:$data[6];
				   		$November=$data[7]==''?0:$data[7];
				   		$December=$data[8]==''?0:$data[8];
				   		$January=$data[9]==''?0:$data[9];
				   		$February=$data[10]==''?0:$data[10];
				   		$March=$data[11]==''?0:$data[11];
				   		$April=$data[12]==''?0:$data[12];
				   		$May=$data[13]==''?0:$data[13];
				   		$June=$data[14]==''?0:$data[14]; 


				        $July=is_numeric($July)==false?0:$July;
				   		$Augest=is_numeric($Augest)==false?0:$Augest;
				   		$September=is_numeric($September)==false?0:$September;
				   		$October=is_numeric($October)==false?0:$October;
				   		$November=is_numeric($November)==false?0:$November;
				   		$December=is_numeric($December)==false?0:$December;
				   		$January=is_numeric($January)==false?0:$January;
				   		$February=is_numeric($February)==false?0:$February;
				   		$March=is_numeric($March)==false?0:$March;
				   		$April=is_numeric($April)==false?0:$April;
				   		$May=is_numeric($May)==false?0:$May;
				   		$June=is_numeric($June)==false?0:$June;



  						$cmd=  " INSERT INTO bp_plan_details (bp_plan_id,bp_item_id,month,amount)".
                               " VALUES ($one[1],$data[0],'$one[0]', $July ),".
                                " ($two[1],$data[0],'$two[0]',   $Augest ),".
                                  " ($three[1],$data[0],'$three[0]', $September ),".
                                " ($four[1],$data[0],'$four[0]', $October ),".
                                 " ($five[1],$data[0],'$five[0]', $November ),".
                                " ($six[1],$data[0],'$six[0]', $December ),".
                                  " ($seven[1],$data[0],'$seven[0]', $January ),".
                                " ($eight[1],$data[0],'$eight[0]',$February ),".
                                 " ($nine[1],$data[0],'$nine[0]', $March ),".
                                " ($ten[1],$data[0],'$ten[0]', $April ),".
                                  " ($eleven[1],$data[0],'$eleven[0]', $May ),".
                                " ($twelve[1],$data[0],'$twelve[0]',$June)";





         			           if(!$this->ItemExistForPlan($data[0],$data[1])){
								  
				     			   $this->BpPlanDetail->query($cmd);
							    }
								
							//insert  Cumulatives for given month and item.
								if(!$this->ckeckMonthForCumulative($one[1],$one[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($one[0],$data[0],$one[1],$July,$July);
								else
									$this->UpdateCumulative($one[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$July,$July);
								
								if(!$this->ckeckMonthForCumulative($two[1],$two[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($two[0],$data[0],$two[1],$Augest,$Augest+$July);
								else
									$this->UpdateCumulative($two[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$Augest,$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($three[1],$three[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($three[0],$data[0],$three[1],$September,$September+$Augest+$July);
								else
									$this->UpdateCumulative($three[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$September,$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($four[1],$four[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($four[0],$data[0],$four[1],$October,$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($four[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$October,$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($five[1],$five[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($five[0],$data[0],$five[1],$November,$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($five[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$November,$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($six[1],$six[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($six[0],$data[0],$six[1],$December,$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($six[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$December,$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($seven[1],$seven[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($seven[0],$data[0],$seven[1],$January,$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($seven[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$January,$January+$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($eight[1],$eight[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($eight[0],$data[0],$eight[1],$February,$February+$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($eight[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$February,$February+$January+$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($nine[1],$nine[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($nine[0],$data[0],$nine[1],$March,$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($nine[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$March,$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($ten[1],$ten[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($ten[0],$data[0],$ten[1],$April,$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($ten[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$April,$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($eleven[1],$eleven[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
								    $this->InsertCumulative($eleven[0],$data[0],$eleven[1],$May,$May+$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($eleven[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$May,$May+$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								
								if(!$this->ckeckMonthForCumulative($twelve[1],$twelve[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id']))
									$this->InsertCumulative($twelve[0],$data[0],$twelve[1],$June,$June+$May+$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								else
									$this->UpdateCumulative($twelve[0],$data[0],$budgetYear_id['BpPlan']['budget_year_id'],$June,$June+$May+$April+$March+$February+$January+$December+$November+$October+$September+$Augest+$July);
								
							  

						}
						$counter++;

				    }


				    fclose($handle);
                   }


		}
		catch(Exception $e){$e->getMessage();}

	}

	public function ItemExistForPlan($Plan_Id,$Item_Id){
		try{
			
               $this->loadModel('BpPlanDetail');
               $cmd="SELECT id FROM bp_plan_details".
                    " WHERE bp_plan_id=$Plan_Id and bp_item_id=$Item_Id";
             $result=$this->BpPlanDetail->find('first',array('conditions'=>array('BpPlanDetail.bp_plan_id'=>$Plan_Id,'BpPlanDetail.bp_item_id'=>$Item_Id) ));
             if($result["BpPlanDetail"]["id"]!=null)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	public function ckeckMonthForCumulative($Plan,$Month_Id,$Item_Id,$budget_year){
		try{
             $this->loadModel('BpCumulative');
              // $cmd="SELECT id FROM bp_cumulatives where bp_month_id=$month_id and bp_item_id=$item_id ";
             $result=$this->BpCumulative->find('first',array('conditions'=>array('BpCumulative.bp_plan_id'=>$Plan,'BpCumulative.bp_month_id'=>$Month_Id,'BpCumulative.bp_item_id'=>$Item_Id,'BpCumulative.budget_year_id'=>$budget_year) ));
             if($result["BpCumulative"]["id"]!=null)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	
	public function InsertCumulative($Month_Id,$Item_Id,$Plan_Id,$Amount,$BBF){
		try{
             $this->loadModel('BpCumulative');
			 $this->loadModel('BpPlan');
             $cmd="SELECT budget_year_id FROM bp_plans where id=$Plan_Id;";
			 $budgt=$this->BpPlan->query($cmd);
			 $budgt=$budgt[0]['bp_plans']['budget_year_id'];
			 $cmd="INSERT INTO bp_cumulatives (bp_plan_id,bp_item_id,bp_month_id,budget_year_id,plan,cumilativePlan)".
			      " VALUES($Plan_Id,$Item_Id,$Month_Id,$budgt,$Amount,$BBF)";
             $result=$this->BpCumulative->query($cmd);
             if($result==1)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	public function UpdateCumulative($Month_Id,$Item_Id,$budget_year,$Amount,$BBF){
		try{
               $this->loadModel('BpCumulative');
             $cmd="UPDATE  bp_cumulatives SET plan=$Amount, cumilativeActual=$BBF where bp_item_id=$Item_Id and budget_year_id=$budget_year and bp_month_id=$Month_Id";
             $result=$this->BpCumulative->query($cmd);
             if($result==1)
             	return true;
             else
             	return false;
		}catch(Exception $e){$e->getMessage();}
	}
	
	public function GetmonthId($MonthName){
		
		try{
			$values=explode('_',$MonthName);
			$MonthName=$values[0];
			$Plan=$values[1];
            $this->loadModel('BpMonth');
           	$cmd="select id from bp_months where name='$MonthName' ";
             $result=$this->BpMonth->query($cmd);
             if($result!=null)
             	return array($result[0]['bp_months']['id'],$Plan);
             else
             	return 0;
		}catch(Exception $e){$e->getMessage();}
		
	}






}
?>