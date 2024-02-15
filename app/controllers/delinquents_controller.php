<?php
class DelinquentsController extends AppController {

	var $name = 'Delinquents';
	
	function beforeFilter()
	{		
		$this->Auth->allow('*');
	}
	
	function index() {
	}
	

	function search() {
	}
	
	function loop(){
		
			/*
			//update dlq table
			$delcs=$this->Delinquent->query('SELECT * FROM `delinquents` WHERE 1');
			foreach($delcs as $delc){
				$input_words = Array();
				$input_words = explode(" ",$delc['delinquents']['Name']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) {
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				$this->Delinquent->query("UPDATE `delinquents` SET `Soundex_Name`='".$soundex_any."' WHERE `id`=".$delc['delinquents']['id']."");
			}
			
			//update sttm table
			$delcs=$this->Delinquent->query('SELECT * FROM `sttm_cust_account` WHERE 1');
			foreach($delcs as $delc){
				$input_words = Array();
				//$input_words = explode(" ",$this->data['delinquentApplication']['Name']);
				$input_words = explode(" ",$delc['sttm_cust_account']['AC_DESC']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) {
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				$this->Delinquent->query("UPDATE `sttm_cust_account` SET `soundex`='".$soundex_any."' WHERE `id`=".$delc['sttm_cust_account']['id']."");
			}
			
			
					
			//search full text normal
			echo "<table>";
			$delcs=$this->Delinquent->query('SELECT * FROM `delinquents` WHERE 1');
			foreach($delcs as $delc){
				$xx=$this->Delinquent->query("SELECT `BRANCH_CODE`,`CUST_AC_NO`,`AC_DESC`,MATCH (`AC_DESC`) AGAINST ('".trim($delc['delinquents']['Name'])."' IN NATURAL LANGUAGE MODE) AS `relevance` FROM `sttm_cust_account` WHERE MATCH (`AC_DESC`) AGAINST ('".trim($delc['delinquents']['Name'])."' IN NATURAL LANGUAGE MODE) LIMIT 1");
				//Print_r($xx);
				echo "<tr><td>".$delc['delinquents']['Name']."</td><td>".$xx[0]['sttm_cust_account']['AC_DESC']."</td><td>".number_format($xx[0][0]['relevance'])."</td><td>".$xx[0]['sttm_cust_account']['BRANCH_CODE']."</td><td>".$xx[0]['sttm_cust_account']['CUST_AC_NO']."</td></tr>";			
			}
			echo "</table>";
				
			//search exact
			$delcs=$this->Delinquent->query('SELECT * FROM `delinquents` WHERE 1');
			echo "<table>";
			foreach($delcs as $delc){
				$xx = Array();
				$xx=$this->Delinquent->query("SELECT count(*),`BRANCH_CODE`,`CUST_AC_NO` FROM `sttm_cust_account` WHERE `AC_DESC` like '%".trim($delc['delinquents']['Name'])."%'");
				//Print_r($xx);
				if($xx[0][0]['count(*)']==1)
				  echo "<tr><td>".$delc['delinquents']['Name']."</td><td>".$xx[0][0]['count(*)']."</td><td>".$xx[0]['sttm_cust_account']['BRANCH_CODE']."</td><td>".$xx[0]['sttm_cust_account']['CUST_AC_NO']."</td></tr>";	
				elseif($xx[0][0]['count(*)']>0)
				  echo "<tr><td>".$delc['delinquents']['Name']."</td><td>".$xx[0][0]['count(*)']."</td></tr>";	
			}
			echo "</table>";
	*/
			//search soundex nested with full text normal
			echo "<table>";
			$delcs=$this->Delinquent->query('SELECT * FROM `delinquents` WHERE 1');
			foreach($delcs as $delc){
				$xx=$this->Delinquent->query("SELECT `BRANCH_CODE`,`CUST_AC_NO`,`AC_DESC`,MATCH (`soundex`) AGAINST ('".trim($delc['delinquents']['Soundex_Name'])."' IN NATURAL LANGUAGE MODE) AS `relevance` FROM `sttm_cust_account` WHERE MATCH (`soundex`) AGAINST ('".trim($delc['delinquents']['Soundex_Name'])."' IN NATURAL LANGUAGE MODE) LIMIT 6");
				$too_similar="";
				$sm_pc=0;
				$i=0;$j=0;
				foreach($xx as $x){
				similar_text(strtoupper($delc['delinquents']['Name']), strtoupper($x['sttm_cust_account']['AC_DESC']), $similarity_pst);
					if (number_format($similarity_pst, 0) > 80){
						$too_similar=$x['sttm_cust_account']['AC_DESC'];
						$sm_pc=number_format($similarity_pst, 0);
						$j=$i;
					}
						$i++;
				}
				if($too_similar!="")
				echo "<tr><td>".$delc['delinquents']['Name']."</td><td>".$too_similar."</td><td>".number_format($xx[$j][0]['relevance'])."</td><td>".$sm_pc."</td><td>".$xx[$j]['sttm_cust_account']['BRANCH_CODE']."</td><td>".$xx[$j]['sttm_cust_account']['CUST_AC_NO']."</td></tr>";		
			}
			echo "</table>";
		/**/	
			
		}
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('delinquents', $this->Delinquent->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Delinquent->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid delinquent', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Delinquent->recursive = 2;
		$this->set('delinquent', $this->Delinquent->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
                       	$this->Delinquent->create();
			$this->autoRender = false;
			//--------------------------------------------------------------------------------
			$words = Array();
			$words = explode(" ",$this->data['Delinquent']['Name']);
			$soundex_words = Array();
			
			foreach($words as  $key =>$word) {
				$soundex_words[$key] = soundex($word);
			}
			$this->data['Delinquent']['Soundex_Name'] = implode(" ", $soundex_words);
			//--------------------------------------------------------------------------------
			if ($this->Delinquent->save($this->data)) {
				$this->Session->setFlash(__('The delinquent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The delinquent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
                       //var_dump($this->data);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid delinquent', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Delinquent->save($this->data)) {
				$this->Session->setFlash(__('The delinquent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The delinquent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('delinquent', $this->Delinquent->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for delinquent', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Delinquent->delete($i);
                }
				$this->Session->setFlash(__('Delinquent deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Delinquent was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Delinquent->delete($id)) {
				$this->Session->setFlash(__('Delinquent deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Delinquent was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
 
 

 
	
	//--------------------------------------------------------------------------------
		function search_for_branches(){
		$this->autoRender = false;
		if(empty($this->data)){
			if($this->params['url']['name']!=null){
			$this->data['delinquentApplication']['Name'] = $this->params['url']['name'];
		}
		}
		if(!empty($this->data)){
			$this->autoRender = false;
		    $this->loadModel('Delinquent');
			$this->Delinquent->recursive = -1;
			
			//------------------------------------------------------------------------------------------------------------
			$applist = Array();
			$input_words = Array();
			//$input_words = explode(" ",$this->data['delinquentApplication']['Name']);
			$input_words = explode(" ",$this->data['delinquentApplication']['Name']);
			$count = sizeof($input_words);
			
			//-------------------------------------
			foreach($input_words as  $key =>$word) {
				$soundex_words[$key] = soundex($word);
			}
			$soundex_any = implode(" ", $soundex_words);
			$applist = $this->Delinquent->query("SELECT * FROM delinquents WHERE Soundex_Name like '%" . $soundex_any . "%' or name like '%".$this->params['url']['name']."%' " );

			$interapplist = $this->Delinquent->query("SELECT * FROM international_delinquents WHERE soundex_name like '%" . $soundex_any . "%'");
			//print_r($interapplist);
			//-------------------------------------
			//------------------------------------------------------------------------------------------------------------
			
            //$applist = $this->Delinquent->find('all', array('conditions' => $conditions));
            //$applist = $this->Delinquent->query("SELECT * FROM delinquents WHERE SOUNDEX(Name) = SOUNDEX('" . $this->data['delinquentApplication']['Name'] . "')");
			//$applist = $this->Delinquent->query("SELECT * FROM delinquents WHERE First_Name like '%" . $this->data['delinquentApplication']['First_Name'] . "%'");
			//$applist = $this->Delinquent->query("SELECT * FROM delinquents WHERE First_Name SOUNDS LIKE '%" . $this->data['delinquentApplication']['First_Name'] . "%'");
			
			//$applist = $this->Delinquent->query("SELECT * FROM delinquents WHERE SOUNDEX(Name) = SOUNDEX('" . $this->data['delinquentApplication']['Name'] . "') UNION ALL  SELECT * FROM delinquents WHERE SOUNDEX(Father_Name) = SOUNDEX('" . $this->data['delinquentApplication']['First_Name'] . "')");
			
			//print_r($applist);
			//SELECT * FROM `people` where `bio` like '%cardiac%'
			
			//$out = pr($applist, true);
     
			$out ='<div><h3 style="margin-left: 100px;">NBE Delinquent List <span style="margin-left: 650px;color:mediumturquoise">International Sanction & </span></h3>';
			$out .='<h3 style="margin-left: 100px;"><span style="margin-left: 800px;color:mediumturquoise">Politically Exposed Persons list</span></h3>';
			$out.='<table cellspacing=0 border=1 style="margin-left:5px;margin-top:20px;width:500px;float:left;"><tr><td >Name</td>';
			$out.='<td >Closing Bank</td><td >Branch</td><td >Date Account Closed</td><td >Tin</td><td >Type</td></tr>';
			
			$i=1;
			$j=1;
			//$list = $applist[0];
			foreach ($applist as $app) {
      $color='black';
      if($app['delinquents']['type']==1 || $app['delinquents']['type']==null || $app['delinquents']['type']==''){$type='DELINQUENT';}
      if($app['delinquents']['type']==2){$type='PEP';}
      if($app['delinquents']['type']==3){$type='TERMINATED';$color='red';}
      
				$out.='<tr>';
					//$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="margin:0px;padding:2px;">'.$app['delinquents']['Name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['delinquents']['Closing_Bank'].'</td>';
					$out.='<td style="padding:2px;">'.$app['delinquents']['Branch'].'</td>';
					$out.='<td style="padding:2px;">'.$app['delinquents']['Date_Account_Closed'].'</td>';
					$out.='<td  style="padding:2px;">' .$app['delinquents']['Tin'].'</td>';
          $out.='<td   style="padding:2px;color:'.$color.';font-weight:bold">' .$type.'</td>';
					//$out.='<td  style="padding:15px 25px 15px 15px;">' .$app['delinquents']['Reason_For_Closing'].'</td>';
					$out.='</tr>';
					$i++;$j++;
			}
			$out .= '</table>';
			
			
			
			$out.='<table cellspacing=0 border=3 bordercolor="mediumturquoise" style="margin-left:60px;margin-top:20px;width:500px;float:right">';
			$out.='<tr><td>Name</td><td>Nationality</td><td>Date of Birth</td><td >Source</td></tr>';
			
			$i=1;
			$j=1;
			//$list = $applist[0];
			foreach ($interapplist as $app) {
				$out.='<tr>';
					//$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="margin:0px;padding:2px;">'.$app['international_delinquents']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['international_delinquents']['Nationality'].'</td>';
					$out.='<td style="padding:2px;">'.$app['international_delinquents']['BOD'].'</td>';
					$out.='<td style="padding:2px;">'.$app['international_delinquents']['source'].'</td>';
					$out.='</tr>';
					$i++;$j++;
			}
			$out .= '</table></div>';
			
			
			echo $out;
		}
	}
	//--------------------------------------------------------------------------------
}
?>