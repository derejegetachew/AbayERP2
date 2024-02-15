<?php
//correct privilage info when uploading
class FrwfmApplicationsController extends AppController {

	var $name = 'FrwfmApplications';
	
	function index() {
		$branches = $this->FrwfmApplication->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index3() {
		$branches = $this->FrwfmApplication->Branch->find('all');
		$this->set(compact('branches'));
	}
	function index4() {
		$branches = $this->FrwfmApplication->Branch->find('all');
		$this->set(compact('branches'));
	}
	function index5() {
		$branches = $this->FrwfmApplication->Branch->find('all');
		$this->set(compact('branches'));
	}
	function index6() {
		$branches = $this->FrwfmApplication->Branch->find('all');
		$this->set(compact('branches'));
	}
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	function reorder(){
	/*to keep from accidental excution
	$conditions['FrwfmApplication.created >='] = '2016-02-15';
	$statarr = array('Accepted', 'Presented for Approval','Approved','Canceled');
	$conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)),$conditions);
	$datas=$this->FrwfmApplication->find('all', array('conditions' => $conditions,'order'=>'FrwfmApplication.initial_order'));
	$i=863;
	foreach($datas as $dt){
		$data['FrwfmApplication']['id']=$dt['FrwfmApplication']['id'];
		$data['FrwfmApplication']['initial_order']=$i;
		//print_r($data);
		$this->FrwfmApplication->save($data);
		$i++;
	}*/
	
	}
	function import(){
	/*to keep from accidental excution
	$row = 1;
	$file='files'.DS . 'ibbd.csv';
	if (($handle = fopen($file, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
				$this->data['FrwfmApplication']['status']='Accepted';
				$this->data['FrwfmApplication']['user_id']='1';
				$this->data['FrwfmApplication']['location_id']='1';
				$this->data['FrwfmApplication']['types_of_goods']='Other';
			for ($c=0; $c < $num; $c++) {
				//echo $data[$c] . "<br />\n";
				if($c==0){
					$this->data['FrwfmApplication']['order']=$data[$c];
					$this->data['FrwfmApplication']['initial_order']=$data[$c];
				}
				if($c==1)
					$this->data['FrwfmApplication']['date']=date("Y-m-d", strtotime($data[$c]));
				if($c==2)
					$this->data['FrwfmApplication']['name']=$data[$c];
				if($c==3)
					$this->data['FrwfmApplication']['currency']=$data[$c];
				if($c==4)
					$this->data['FrwfmApplication']['amount']=trim(str_replace(",","",$data[$c]));
				if($c==5)
					$this->data['FrwfmApplication']['branch_id']=$data[$c];
				if($c==6)
					$this->data['FrwfmApplication']['mode_of_payment']=$data[$c];
				if($c==7)
					$this->data['FrwfmApplication']['desc_of_goods']=$data[$c];	
				if($c==8){
					$this->data['FrwfmApplication']['deposit_amount']=trim(str_replace(",","",$data[$c]));
					if (!is_numeric($this->data['FrwfmApplication']['deposit_amount']))
						$this->data['FrwfmApplication']['deposit_amount']='0';
				}					
				if($c==9)
					$this->data['FrwfmApplication']['relation_with_bank']=$data[$c];	
				if($c==10)
					$this->data['FrwfmApplication']['account_no']=$data[$c];	
				if($c==11)
					$this->data['FrwfmApplication']['remark']=$data[$c];
					
				}
				print_r($this->data);				
				$this->FrwfmApplication->create();
				$this->FrwfmApplication->save($this->data);
				print_r($this->FrwfmApplication->validationErrors, true);
				
					$this->data['FrwfmApplication']['deposit_amount']='';
					$this->data['FrwfmApplication']['remark']='';
					$this->data['FrwfmApplication']['account_no']='';
		}
		fclose($handle);
	}
	*/
	}
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
       // $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

       // eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
          //  $conditions['FrwfmApplication.branch_id'] = $branch_id;
        }
		$user = $this->Session->read();		
		$this->loadModel('Employee');
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
		$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		//$conditions['FrwfmApplication.branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
		$conditions=array("OR" =>array("FrwfmApplication.branch_id" =>$emp_details['EmployeeDetail']['branch_id'],"FrwfmApplication.user_id"=>$user['Auth']['User']['id']));
		
		$this->FrwfmApplication->recursive=2;
		$this->set('frwfm_applications', $this->FrwfmApplication->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->FrwfmApplication->find('count', array('conditions' => $conditions)));
	}
	function process_search(){
			$this->autoRender = false;
			if($this->data['FrwfmApplication']['branch_id']=='All')
				$this->data['FrwfmApplication']['branch_id']='%%';
			if($this->data['FrwfmApplication']['minute']=='')
				$this->data['FrwfmApplication']['minute']='%%';
			if($this->data['FrwfmApplication']['initial_order']!='')
				$this->data['FrwfmApplication']['initial_order']="  AND `initial_order` = ".$this->data['FrwfmApplication']['initial_order'];
				
			if($this->data['FrwfmApplication']['status']=='All')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Accepted%' OR `status` Like '%Presented for Approval%' OR `status` Like '%Approved%')";	
			if($this->data['FrwfmApplication']['status']=='Waiting List')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Accepted%' OR `status` Like '%Presented for Approval%')";	
			if($this->data['FrwfmApplication']['status']=='Approved')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Approved%')";
			if($this->data['FrwfmApplication']['status']=='Posted')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Posted%')";	
			if($this->data['FrwfmApplication']['status']=='Presented for Approval')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Presented for Approval%')";					
				
			$this->data['FrwfmApplication']['amountr']="`amount` ".$this->data['FrwfmApplication']['amountr'];
			
			if($this->data['FrwfmApplication']['datex2']!='' && $this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']='  AND ( `accepted_date` >= "'.$this->data['FrwfmApplication']['datex'].'" AND `accepted_date` <= "'.$this->data['FrwfmApplication']['datex2'].'" ) ';
			else if($this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']=' AND `accepted_date` >= "'.$this->data['FrwfmApplication']['datex'].'"';
			else if($this->data['FrwfmApplication']['datex2']!='')
				$this->data['FrwfmApplication']['datex']=' AND `accepted_date` <= "'.$this->data['FrwfmApplication']['datex2'].'"';
				
	  $data=  $this->FrwfmApplication->query("SELECT * FROM `frwfm_accepted_times` frwfm_applications WHERE ".$this->data['FrwfmApplication']['status']." AND ".$this->data['FrwfmApplication']['amountr']." ".$this->data['FrwfmApplication']['datex']." AND `minute` Like '".$this->data['FrwfmApplication']['minute']."' AND `proforma_invoice_no` Like '%".$this->data['FrwfmApplication']['proforma_invoice_no']."%' AND `branch_id` Like '".$this->data['FrwfmApplication']['branch_id']."' ".$this->data['FrwfmApplication']['initial_order']." AND `relation_with_bank` Like '%".$this->data['FrwfmApplication']['relation_with_bank']."%' AND  `mode_of_payment` Like '%".$this->data['FrwfmApplication']['mode_of_payment']."%' AND `types_of_goods` Like '%".$this->data['FrwfmApplication']['types_of_goods']."%' AND `currency` Like '%".$this->data['FrwfmApplication']['currency']."%'  AND `name` Like '%".$this->data['FrwfmApplication']['namex']."%' Order BY `frwfm_applications`.`".$this->data['FrwfmApplication']['Order']."` ");

	$output='';
	  $i=1;
		foreach($data as $dt){

			$output.= '{  '."\r\n";
			$output.= '"id":"'.$dt['frwfm_applications']['id'].'", '."\r\n";
			$zz=$this->FrwfmApplication->Branch->read(null, $dt['frwfm_applications']['branch_id']);
			$output.= '"branch":"'.$zz['Branch']['name'].'", '."\r\n";
			$output.= '"status":"'.$dt['frwfm_applications']['status'].'", '."\r\n";
			$output.= '"order":"'.$dt['frwfm_applications']['order'].'", '."\r\n";
			$output.= '"name":"'.$dt['frwfm_applications']['name'].'", '."\r\n";
			$output.= '"date":"'.$dt['frwfm_applications']['accepted_date'].'", '."\r\n";
			$output.= '"amount":"'.$dt['frwfm_applications']['amount'].'", '."\r\n";
			$output.= '"currency":"'.$dt['frwfm_applications']['currency'].'", '."\r\n";
			$output.= '"created":"'.$dt['frwfm_applications']['created'].'" },  '."\r\n";
	
		}
			 echo '{	success:true,	rows: [';
			 echo $output;
			 echo ']}';
	}
	function list_data3($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['FrwfmApplication.branch_id'] = $branch_id;
        }
		
		$statarr = array('Pending Acceptance', 'Posted','Pending Rejection');
	    $conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)), $conditions);
		$this->FrwfmApplication->recursive=2;
		$this->set('frwfm_applications', $this->FrwfmApplication->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'FrwfmApplication.date')));
		$this->set('results', $this->FrwfmApplication->find('count', array('conditions' => $conditions)));
	}
	function list_data4($id = null) {
		if(isset($_REQUEST['adv'])){
		$this->autoRender = false;
			if (!empty($this->data)) 
				$this->process_search();		
		}else{
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		if(isset($_REQUEST['conditions']))
			$limit = 500;
        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            //$conditions['FrwfmApplication.status'] = 'Accepted';
        }
		//$conditions['FrwfmApplication.status'] = 'Accepted';
		$statarr = array('Accepted', 'Presented for Approval');
	    $conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)), $conditions);
		$this->FrwfmApplication->recursive=2;
		$this->set('frwfm_applications', $this->FrwfmApplication->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'FrwfmApplication.name')));
		$this->set('results', $this->FrwfmApplication->find('count', array('conditions' => $conditions)));
		}
	}
	function list_data5($id = null) {
		if(isset($_REQUEST['adv'])){
		$this->autoRender = false;
		if (!empty($this->data)) 
			$this->process_search();
	
		}else{
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            //$conditions['FrwfmApplication.status'] = 'Approved';
        }
		//$conditions['FrwfmApplication.status'] = 'Approved';
		$statarr = array('Accepted', 'Presented for Approval','Approved');
	    $conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)), $conditions);
		$this->FrwfmApplication->recursive=2;
		$this->set('frwfm_applications', $this->FrwfmApplication->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'FrwfmApplication.initial_order')));
		$this->set('results', $this->FrwfmApplication->find('count', array('conditions' => $conditions)));
		}
	}
	function list_data6($id = null) {
		if(isset($_REQUEST['adv'])){
		$this->autoRender = false;
		if (!empty($this->data)) 
			$this->process_search();
	
		}else{
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            //$conditions['FrwfmApplication.status'] = 'Approved';
        }
		//$conditions['FrwfmApplication.status'] = 'Approved';
		$statarr = array('Canceled');
	    $conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)), $conditions);
		$this->FrwfmApplication->recursive=2;
		$this->set('frwfm_applications', $this->FrwfmApplication->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'FrwfmApplication.initial_order')));
		$this->set('results', $this->FrwfmApplication->find('count', array('conditions' => $conditions)));
		}
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid frwfm application', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->FrwfmApplication->recursive = 2;
		$this->set('frwfmApplication', $this->FrwfmApplication->read(null, $id));
	}
	function nb_reportoldtable(){
		if(!empty($this->data)){
		  $this->autoRender = false;
			$conditions['FrwfmApplication.date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmApplication.date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			$statarr = array('Accepted', 'Pending Approval');
			$conditions = array_merge(array("OR" => array("FrwfmApplication.status" => $statarr)), $conditions);
			$this->FrwfmApplication->recursive = -1;
            $applist = $this->FrwfmApplication->find('all', array('conditions' => $conditions));
			//print_r($applist);
			
			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>List of Registered Foreign Currency Application From : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td rowspan="2">No</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE Account No</td><td rowspan="2">TIN NO</td><td colspan="4">Proforma Invoice</td></tr>';
			$out.='<tr><td>Date</td><td>No</td><td>FCY</td><td style="text-align: right;margin:0px">Amount</td></tr>';
			$i=1;
			$j=1;
			foreach ($applist as $app) {
					$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmApplication']['license'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmApplication']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['currency'].'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmApplication']['amount'],2).'</td>';
					$out.='</tr>';
					$i++;$j++;
					/*if($j>25){
					$out.='</table></page><page><br><br>';
					$out.='<table cellspacing=0 border=1><tr><td rowspan="2">No</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE<br>Account No</td><td rowspan="2">TIN NO</td><td colspan="3">Proforma Invoice</td></tr>';
					$out.='<tr><td>Date</td><td>No</td><td>Amount</td></tr>';
					$j=1;
					}*/
					
			  }
			  $out.='</table>';
			  //$out.='<br><br><br>Name of Authorized Person ______________<br><br>Signature ______________<br><br>Date ______________</page>';
			  //$out='<table><tr><td>h</td></tr></table>';
				/*require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('L', 'A4', 'en');
                $h2p->writeHTML($out);
                $file = "NBE-Report.pdf";
                $h2p->Output($file);*/
				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	function nb_report(){
		if(!empty($this->data)){
		  $this->autoRender = false;
		  $this->loadModel('FrwfmAcceptedTime');
			$conditions['FrwfmAcceptedTime.accepted_date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmAcceptedTime.accepted_date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			$statarr = array('Accepted', 'Pending Approval','Approved','Canceled');
			$conditions = array_merge(array("OR" => array("FrwfmAcceptedTime.status" => $statarr)), $conditions);
			$this->FrwfmAcceptedTime->recursive = -1;
            $applist = $this->FrwfmAcceptedTime->find('all', array('conditions' => $conditions));
			//print_r($applist);
			
			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>List of Registered Foreign Currency Application From : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td rowspan="2">No</td><td rowspan="2">Order</td><td rowspan="2">Date Application</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE Account No</td><td rowspan="2">TIN NO</td><td colspan="2">Proforma Invoice</td><td rowspan="2">Type of CURR</td><td rowspan="2" style="text-align: right;margin:0px">Amount</td><td colspan="2">Category</td></tr>';
			$out.='<tr><td>Date</td><td>Number</td><td>Priority</td><td>Non Priority</td></tr>';
			$i=1;
			$j=1;
			foreach ($applist as $app) {
					$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$app['FrwfmAcceptedTime']['initial_order'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['accepted_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmAcceptedTime']['license'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmAcceptedTime']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['currency'].'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmAcceptedTime']['amount'],2).'</td>';
					if($app['FrwfmAcceptedTime']['types_of_goods']=='Other')
						$out.='<td></td><td>&#9745;</td>';//$out.='<td></td><td style="padding:2px;">'.$app['FrwfmAcceptedTime']['types_of_goods'].'</td>';
					else
						$out.='<td>&#x2611;</td><td></td>';//$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['types_of_goods'].'</td><td></td>';
					$out.='</tr>';
					$i++;$j++;
					/*if($j>25){
					$out.='</table></page><page><br><br>';
					$out.='<table cellspacing=0 border=1><tr><td rowspan="2">No</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE<br>Account No</td><td rowspan="2">TIN NO</td><td colspan="3">Proforma Invoice</td></tr>';
					$out.='<tr><td>Date</td><td>No</td><td>Amount</td></tr>';
					$j=1;
					}*/
					
			  }
			  $out.='</table>';
			  //$out.='<br><br><br>Name of Authorized Person ______________<br><br>Signature ______________<br><br>Date ______________</page>';
			  //$out='<table><tr><td>h</td></tr></table>';
				/*require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('L', 'A4', 'en');
                $h2p->writeHTML($out);
                $file = "NBE-Report.pdf";
                $h2p->Output($file);*/
				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	function nb_report3(){
		if(!empty($this->data)){
		  $this->autoRender = false;
		  $this->loadModel('FrwfmAcceptedTime');
			$conditions['FrwfmAcceptedTime.accepted_date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmAcceptedTime.accepted_date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			$statarr = array('Accepted', 'Pending Approval','Approved','Canceled');
			$conditions = array_merge(array("OR" => array("FrwfmAcceptedTime.status" => $statarr)), $conditions);
			$this->FrwfmAcceptedTime->recursive = -1;
            $applist = $this->FrwfmAcceptedTime->find('all', array('conditions' => $conditions,'order'=>'FrwfmAcceptedTime.initial_order'));
			//print_r($applist);
			
			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>List of Registered Foreign Currency Application From : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td rowspan="2">Order No</td><td rowspan="2">Status</td><td rowspan="2">Name of Importer</td><td rowspan="2">Date</td><td rowspan="2">NBE Account No</td><td rowspan="2">TIN NO</td><td colspan="4">Proforma Invoice</td></tr>';
			$out.='<tr><td>Date</td><td>No</td><td>FCY</td><td style="text-align: right;margin:0px">Amount</td></tr>';
			$i=1;
			$j=1;
			foreach ($applist as $app) {
					$out.='<tr>';					
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['initial_order'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['status'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['accepted_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmAcceptedTime']['license'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmAcceptedTime']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['currency'].'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmAcceptedTime']['amount'],2).'</td>';
					$out.='</tr>';
					$i++;$j++;
					/*if($j>25){
					$out.='</table></page><page><br><br>';
					$out.='<table cellspacing=0 border=1><tr><td rowspan="2">No</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE<br>Account No</td><td rowspan="2">TIN NO</td><td colspan="3">Proforma Invoice</td></tr>';
					$out.='<tr><td>Date</td><td>No</td><td>Amount</td></tr>';
					$j=1;
					}*/
					
			  }
			  $out.='</table>';
			  //$out.='<br><br><br>Name of Authorized Person ______________<br><br>Signature ______________<br><br>Date ______________</page>';
			  //$out='<table><tr><td>h</td></tr></table>';
				/*require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('L', 'A4', 'en');
                $h2p->writeHTML($out);
                $file = "NBE-Report.pdf";
                $h2p->Output($file);*/
				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	function nb_report4(){  //NB Canceled Report
		if(!empty($this->data)){
		  $this->autoRender = false;
		  $this->loadModel('FrwfmCanceled');
			$conditions['FrwfmCanceled.canceled_date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmCanceled.canceled_date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			//$conditions['FrwfmCanceled.status'] = 'Canceled';
			//$statarr = array('Canceled');
			//$conditions = array_merge(array("OR" => array("FrwfmCanceled.status" => $statarr)), $conditions);
			$this->FrwfmCanceled->recursive = -1;
            $applist = $this->FrwfmCanceled->find('all', array('conditions' => $conditions,'order'=>'FrwfmCanceled.initial_order'));
			//print_r($applist);
			
			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>List of Canceled Foreign Currency Application From : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td rowspan="2">Order No</td><td rowspan="2">Name of Importer</td><td rowspan="2">Removal Date</td><td rowspan="2">NBE Account No</td><td rowspan="2">TIN NO</td><td colspan="4">Proforma Invoice</td></tr>';
			$out.='<tr><td>Date</td><td>No</td><td>FCY</td><td style="text-align: right;margin:0px">Amount</td></tr>';
			$i=1;
			$j=1;
			foreach ($applist as $app) {
					$out.='<tr>';					
					$out.='<td style="padding:2px;">'.$app['FrwfmCanceled']['initial_order'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmCanceled']['name'].'</td>';
					$out.='<td style="padding:2px;">'.date('Y-m-d',strtotime($app['FrwfmCanceled']['canceled_date'])).'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmCanceled']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmCanceled']['license'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmCanceled']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmCanceled']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmCanceled']['currency'].'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmCanceled']['amount'],2).'</td>';
					$out.='</tr>';
					$i++;$j++;
					/*if($j>25){
					$out.='</table></page><page><br><br>';
					$out.='<table cellspacing=0 border=1><tr><td rowspan="2">No</td><td rowspan="2">Name of Importer</td><td rowspan="2">NBE<br>Account No</td><td rowspan="2">TIN NO</td><td colspan="3">Proforma Invoice</td></tr>';
					$out.='<tr><td>Date</td><td>No</td><td>Amount</td></tr>';
					$j=1;
					}*/
					
			  }
			  $out.='</table>';
			  //$out.='<br><br><br>Name of Authorized Person ______________<br><br>Signature ______________<br><br>Date ______________</page>';
			  //$out='<table><tr><td>h</td></tr></table>';
				/*require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('L', 'A4', 'en');
                $h2p->writeHTML($out);
                $file = "NBE-Report.pdf";
                $h2p->Output($file);*/
				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	
	function nb_report2oldtable(){
		if(!empty($this->data)){
		  $this->autoRender = false;
			$conditions['FrwfmApplication.approved_date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmApplication.approved_date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			$conditions["FrwfmApplication.status"]='Approved';
			$this->FrwfmApplication->recursive = 1;
            $applist = $this->FrwfmApplication->find('all', array('conditions' => $conditions,'order'=>'FrwfmApplication.initial_order'));

			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>Foreign Currency Approval List Form : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td>Queue No</td><td>Date FCY approved</td><td>Date application received</td><td>Name of Importer</td><td>NBE Account Number</td><td>Tin Number</td><td>Proforma Invoice Number</td><td>Proforma Invoice Date</td><td>FCY Type</td><td>Amount</td><td>Approved Amount</td><td>Branch</td><td>Payment Term</td><td>Business Category</td><td>Remark</td></tr>';
			$i=1;
			foreach ($applist as $app) {
			$accepted_date=$app['FrwfmApplication']['date'];
			foreach($app['FrwfmEvent'] as $evn){
				if($evn['action']=='Accepted')
					$accepted_date=date('Y-m-d',strtotime($evn['created']));
					
			}
					$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$app['FrwfmApplication']['initial_order'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['approved_date'].'</td>';
					$out.='<td style="padding:2px;">'.$accepted_date.'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['name'].'</p></td>';
					$out.='<td style="padding:2px;">&nbsp;'.$app['FrwfmApplication']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmApplication']['license'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;'.$app['FrwfmApplication']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['currency'].'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmApplication']['amount'],2).'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmApplication']['approved_amount'],2).'</td>';
					$zz=$this->FrwfmApplication->Branch->read(null, $app['FrwfmApplication']['branch_id']);
					$out.='<td style="padding:2px;">'.$zz['Branch']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['mode_of_payment'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmApplication']['types_of_goods'].'</td>';
					$out.='</tr>';
					$i++;

			  }
			  $out.='</table>';

				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	function nb_report2(){
		if(!empty($this->data)){
		  $this->autoRender = false;
		  $this->loadModel('FrwfmAcceptedTime');
			$conditions['FrwfmAcceptedTime.approved_date >='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
            $conditions['FrwfmAcceptedTime.approved_date <='] = date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']));
			$conditions["FrwfmAcceptedTime.status"]='Approved';
			$this->FrwfmAcceptedTime->recursive = 1;
            $applist = $this->FrwfmAcceptedTime->find('all', array('conditions' => $conditions,'order'=>'FrwfmAcceptedTime.initial_order'));

			$out='<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
			$out.="<br><br><br><br><h3>Abay Bank S.C - International Banking Department</h3>Foreign Currency Approval List Form : ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['fromDt']));
			$out.=" To: ".date('Y-m-d', strtotime($this->data['FrwfmApplication']['toDt']))."<br><br><br>";
			$out.='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td>Queue No</td><td>Date FCY approved</td><td>Date application received</td><td>Name of Importer</td><td>NBE Account Number</td><td>Tin Number</td><td>Proforma Invoice Number</td><td>Proforma Invoice Date</td><td>FCY Type</td><td>Approved Amount</td><td>Branch</td><td>Payment Term</td><td>Business Category</td><td>Remark</td><<td>Abay Account No</td>/tr>';
			$i=1;
			$this->loadModel('Branch');
			$this->loadModel('FrwfmEvent');
			foreach ($applist as $app) {
			$accepted_date=$app['FrwfmAcceptedTime']['date'];
			$even = $this->FrwfmEvent->find('all', array('conditions' => array('frwfm_application_id'=>$app['FrwfmAcceptedTime']['id'])));
			foreach($even as $evn){
				if($evn['FrwfmEvent']['action']=='Accepted')
					$accepted_date=date('Y-m-d',strtotime($evn['FrwfmEvent']['created']));
					
			}
			
					$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$app['FrwfmAcceptedTime']['initial_order'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['approved_date'].'</td>';
					$out.='<td style="padding:2px;">'.$accepted_date.'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['name'].'</p></td>';
					$out.='<td style="padding:2px;">&nbsp;'.$app['FrwfmAcceptedTime']['nbe_account_no'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;' .$app['FrwfmAcceptedTime']['license'].'</td>';
					$out.='<td style="padding:2px;">&nbsp;'.$app['FrwfmAcceptedTime']['proforma_invoice_no'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['proforma_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['currency'].'</td>';
					//$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmAcceptedTime']['amount'],2).'</td>';
					$out.='<td style="text-align: right;margin:0px;width:80px;padding:2px">' . number_format($app['FrwfmAcceptedTime']['approved_amount'],2).'</td>';
					$zz=$this->Branch->read(null, $app['FrwfmAcceptedTime']['branch_id']);
					$out.='<td style="padding:2px;">'.$zz['Branch']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['mode_of_payment'].'</td>';
					$out.='<td style="padding:2px;">'.$app['FrwfmAcceptedTime']['types_of_goods'].'</td>';
					$out.='<td style="padding:2px;"></td>';
					
					$this->loadModel('FrwfmAccount');	
					$accts=$this->FrwfmAccount->findAllByfrwfm_application_id($app['FrwfmAcceptedTime']['id']);
					$acc_no='';
						if(count($accts)>0){						 
							$acc_no=$accts[0]['FrwfmAccount']['acc_no'];							
						}
					$out.='<td style="padding:2px;">'.$acc_no.'</td>';
					
					$out.='</tr>';
					$i++;

			  }
			  $out.='</table>';

				
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $out;
		}
	}
	function report2($id = null ){
	//processed in report function
	if($id)
		$this->set('parent_id', $id);
		$branches = $this->FrwfmApplication->Branch->find('list', array('order' => 'name ASC'));
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$this->set(compact('branches', 'users', 'locations'));
	}
	function report($id = null){
		if (!empty($this->data)) {
			$this->autoRender = false;
			if($this->data['FrwfmApplication']['branch_id']=='All')
				$this->data['FrwfmApplication']['branch_id']='%%';
			if($this->data['FrwfmApplication']['minute']=='')
				$this->data['FrwfmApplication']['minute']='%%';
			if($this->data['FrwfmApplication']['initial_order']!='')
				$this->data['FrwfmApplication']['initial_order']=" AND `initial_order` = ".$this->data['FrwfmApplication']['initial_order'];
				
			if($this->data['FrwfmApplication']['status']=='All')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Accepted%' OR `status` Like '%Presented for Approval%' OR `status` Like '%Approved%' OR `status` Like '%Posted%' OR `status` Like '%Canceled%')";	
			if($this->data['FrwfmApplication']['status']=='Waiting List')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Accepted%' OR `status` Like '%Presented for Approval%')";	
			if($this->data['FrwfmApplication']['status']=='Approved')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Approved%')";
			if($this->data['FrwfmApplication']['status']=='Posted')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Posted%')";		
			if($this->data['FrwfmApplication']['status']=='Presented for Approval')
				$this->data['FrwfmApplication']['status']="(`status` Like '%Presented for Approval%')";
			$this->data['FrwfmApplication']['amountr']="`amount` ".$this->data['FrwfmApplication']['amountr'];	
			$this->data['FrwfmApplication']['statusx']=$this->data['FrwfmApplication']['status'];
			if($this->data['FrwfmApplication']['status']=='Canceled'){
				$this->data['FrwfmApplication']['status']="(`status` Like '%Canceled%')";							
			if($this->data['FrwfmApplication']['datex2']!='' && $this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']=' AND ( `canceled_date` >= "'.$this->data['FrwfmApplication']['datex'].'" AND `canceled_date` <= "'.$this->data['FrwfmApplication']['datex2'].'" ) ';
			else if($this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']=' AND `canceled_date` >= "'.$this->data['FrwfmApplication']['datex'].'"';
			else if($this->data['FrwfmApplication']['datex2']!='')
				$this->data['FrwfmApplication']['datex']=' AND `canceled_date` <= "'.$this->data['FrwfmApplication']['datex2'].'"';

      $data=  $this->FrwfmApplication->query("SELECT * FROM `frwfm_canceled` frwfm_applications WHERE ".$this->data['FrwfmApplication']['status']." AND ".$this->data['FrwfmApplication']['amountr']." ".$this->data['FrwfmApplication']['datex']." AND `minute` Like '".$this->data['FrwfmApplication']['minute']."' AND `proforma_invoice_no` Like '%".$this->data['FrwfmApplication']['proforma_invoice_no']."%' AND `branch_id` Like '".$this->data['FrwfmApplication']['branch_id']."' ".$this->data['FrwfmApplication']['initial_order']." AND `relation_with_bank` Like '%".$this->data['FrwfmApplication']['relation_with_bank']."%' AND  `mode_of_payment` Like '%".$this->data['FrwfmApplication']['mode_of_payment']."%' AND `types_of_goods` Like '%".$this->data['FrwfmApplication']['types_of_goods']."%' AND `currency` Like '%".$this->data['FrwfmApplication']['currency']."%'  AND `name` Like '%".$this->data['FrwfmApplication']['namex']."%' Order BY `frwfm_applications`.`".$this->data['FrwfmApplication']['Order']."` ");

			}else{
			if($this->data['FrwfmApplication']['datex2']!='' && $this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']=' AND ( `accepted_date` >= "'.$this->data['FrwfmApplication']['datex'].'" AND `accepted_date` <= "'.$this->data['FrwfmApplication']['datex2'].'" ) ';
			else if($this->data['FrwfmApplication']['datex']!='')
				$this->data['FrwfmApplication']['datex']=' AND `accepted_date` >= "'.$this->data['FrwfmApplication']['datex'].'"';
			else if($this->data['FrwfmApplication']['datex2']!='')
				$this->data['FrwfmApplication']['datex']=' AND `accepted_date` <= "'.$this->data['FrwfmApplication']['datex2'].'"';

			$data=  $this->FrwfmApplication->query("SELECT * FROM `frwfm_accepted_times` frwfm_applications WHERE ".$this->data['FrwfmApplication']['status']." AND ".$this->data['FrwfmApplication']['amountr']." ".$this->data['FrwfmApplication']['datex']." AND `minute` Like '".$this->data['FrwfmApplication']['minute']."' AND `proforma_invoice_no` Like '%".$this->data['FrwfmApplication']['proforma_invoice_no']."%' AND `branch_id` Like '".$this->data['FrwfmApplication']['branch_id']."' ".$this->data['FrwfmApplication']['initial_order']." AND `relation_with_bank` Like '%".$this->data['FrwfmApplication']['relation_with_bank']."%' AND  `mode_of_payment` Like '%".$this->data['FrwfmApplication']['mode_of_payment']."%' AND `types_of_goods` Like '%".$this->data['FrwfmApplication']['types_of_goods']."%' AND `currency` Like '%".$this->data['FrwfmApplication']['currency']."%'  AND `name` Like '%".$this->data['FrwfmApplication']['namex']."%' Order BY `frwfm_applications`.`".$this->data['FrwfmApplication']['Order']."` ");
			}
	  $output= '<table>';
	  if($this->data['FrwfmApplication']['statusx']=='Canceled')
	  $output.= '<tr style="background-color: lightblue;"><td>Sr.No</td><td>Initial Order</td><td>Waiting Order</td><td>Status</td><td>Date of Application</td><td>Canceled Date</td><td>Reason</td><td>Name</td><td>Phone No</td><td>Email</td><td>TIN</td><td>Amount</td><td>Currency</td><td>Branch</td><td>Mode of Payment</td><td>Types of Goods</td><td>Description of Goods</td><td>Relation with Bank</td><td>Deposit Amount</td><td>Account No</td><td>Proforma invoice No</td><td>Proforma Date</td><td>NBE Account No</td><td>Approved Amount</td><td>Remark</td></tr>';
	  else
	  $output.= '<tr style="background-color: lightblue;"><td>Sr.No</td><td>Initial Order</td><td>Waiting Order</td><td>Status</td><td>Date of Application</td><td>Name</td><td>Phone No</td><td>Email</td><td>TIN</td><td>Amount</td><td>Currency</td><td>Branch</td><td>Mode of Payment</td><td>Types of Goods</td><td>Description of Goods</td><td>Relation with Bank</td><td>Deposit Amount</td><td>Account No</td><td>Proforma invoice No</td><td>Proforma Date</td><td>NBE Account No</td><td>Approved Amount</td><td>Remark</td></tr>';
	  $i=1;
		$this->loadModel('FrwfmAccount');
	  	$this->loadModel('FrwfmEvent');
		
		foreach($data as $dt){		
		$accts=$this->FrwfmAccount->findAllByfrwfm_application_id($dt['frwfm_applications']['id']);
		if(count($accts)>0){
		  $dt['frwfm_applications']['account_no']='';
			foreach($accts as $acct){
				$dt['frwfm_applications']['account_no'].='<br>'.$acct['FrwfmAccount']['acc_no'].' = '.$acct['FrwfmAccount']['amount'];
			}
		}	
		/* $appaccs=$this->FrwfmEvent->findAllByfrwfm_application_id($dt['frwfm_applications']['id']);
		if(count($appaccs)>0){
		foreach($appaccs as $evn){
				if($evn['FrwfmEvent']['action']=='Accepted')
					$dt['frwfm_applications']['date']=date('Y-m-d',strtotime($evn['FrwfmEvent']['created']));
				}
		} */
			if($i % 2 == 0 )
			$output.= '<tr>';
			else
			$output.= '<tr style="background-color:#eee">';
			$output.= '<td>'.$i.'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['initial_order'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['order'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['status'].'</td>';
			if($this->data['FrwfmApplication']['statusx']=='Canceled'){
			$output.= '<td>'.$dt['frwfm_applications']['date'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['canceled_date'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['reason'].'</td>';
			}else
			$output.= '<td>'.$dt['frwfm_applications']['accepted_date'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['name'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['mobile_phone'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['email'].'</td>';
			$output.= '<td>&nbsp;'.$dt['frwfm_applications']['license'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['amount'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['currency'].'</td>';
			$zz=$this->FrwfmApplication->Branch->read(null, $dt['frwfm_applications']['branch_id']);
			$output.= '<td>'.$zz['Branch']['name'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['mode_of_payment'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['types_of_goods'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['desc_of_goods'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['relation_with_bank'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['deposit_amount'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['account_no'].'</td>';
			$output.= '<td>&nbsp;'.$dt['frwfm_applications']['proforma_invoice_no'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['proforma_date'].'</td>';
			$output.= '<td>&nbsp;'.$dt['frwfm_applications']['nbe_account_no'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['approved_amount'].'</td>';
			$output.= '<td>'.$dt['frwfm_applications']['remark'].'</td>';
			$output.= '</tr>';
			$i++;
		}
		
			if($id=='excel'){
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $output;
			}else
			 echo $output;
			
		}
		if($id)
		$this->set('parent_id', $id);
		$branches = $this->FrwfmApplication->Branch->find('list', array('order' => 'name ASC'));
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$this->set(compact('branches', 'users', 'locations'));
	}
	function add($id = null) {
		if (!empty($this->data)) {
			$user = $this->Session->read();
			$this->data['FrwfmApplication']['user_id'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			$this->data['FrwfmApplication']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			$this->data['FrwfmApplication']['proforma_invoice_no']=trim($this->data['FrwfmApplication']['proforma_invoice_no']);
			
			$chkprof = $this->FrwfmApplication->find('count',array('conditions'=>array('FrwfmApplication.proforma_invoice_no'=>$this->data['FrwfmApplication']['proforma_invoice_no'])));
			if($this->data['FrwfmApplication']['proforma_invoice_no']=='')
			   $chkprof=0;
			if($chkprof<=0){
			$this->FrwfmApplication->create();
			$this->autoRender = false;
			if ($this->FrwfmApplication->save($this->data)) {
				$this->Session->setFlash(__('The application has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The application could not be saved. Please, try again.<br><br>Possible reason: Invalid session', true), '');
				$this->render('/elements/failure');
			}}
			else {
				$this->Session->setFlash(__('The application could not be saved. Duplicate Proforma Invoice Number', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->FrwfmApplication->Branch->find('list', array('order' => 'name ASC'));
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$this->set(compact('branches', 'users', 'locations'));
	}

	function add2($id = null) {
		if (!empty($this->data)) {
			$user = $this->Session->read();
			$this->data['FrwfmApplication']['user_id'] = $user['Auth']['User']['id'];
			
			$this->loadModel('Employee');
			$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
			$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
			//$this->data['FrwfmApplication']['branch_id'] = $emp_details['EmployeeDetail']['branch_id'];
			$this->data['FrwfmApplication']['proforma_invoice_no']=trim($this->data['FrwfmApplication']['proforma_invoice_no']);
			
			$chkprof = $this->FrwfmApplication->find('count',array('conditions'=>array('FrwfmApplication.proforma_invoice_no'=>$this->data['FrwfmApplication']['proforma_invoice_no'])));
			if($this->data['FrwfmApplication']['proforma_invoice_no']=='')
			   $chkprof=0;
			if($chkprof<=0){
			$this->FrwfmApplication->create();
			$this->autoRender = false;
			if ($this->FrwfmApplication->save($this->data)) {
				$this->Session->setFlash(__('The application has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The application could not be saved. Please, try again.<br><br>Possible reason: Invalid session', true), '');
				$this->render('/elements/failure');
			}}
			else {
				$this->Session->setFlash(__('The application could not be saved. Duplicate Proforma Invoice Number', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->FrwfmApplication->Branch->find('list', array('order' => 'name ASC'));
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$this->set(compact('branches', 'users', 'locations'));
	}
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid frwfm application', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			$chkprof = $this->FrwfmApplication->find('count',array('conditions'=>array('FrwfmApplication.proforma_invoice_no'=>$this->data['FrwfmApplication']['proforma_invoice_no'],'FrwfmApplication.id <>'=>$this->data['FrwfmApplication']['id'])));
			if($this->data['FrwfmApplication']['proforma_invoice_no']=='')
			   $chkprof=0;
			if($chkprof<=0){
			if ($this->FrwfmApplication->save($this->data)) {
				$this->Session->setFlash(__('The application has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The frwfm application could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			}
			else {
				$this->Session->setFlash(__('The application could not be saved. Duplicate Proforma Invoice Number', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('frwfm_application', $this->FrwfmApplication->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->FrwfmApplication->Branch->find('list');
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$this->set(compact('branches', 'users', 'locations'));
	}
	
	function edit2($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid frwfm application', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if($parent_id)//reset button
			if($parent_id=='reset'){
				$this->autoRender = false;
				$this->loadModel('FrwfmApplication2');		
				$reset = $this->FrwfmApplication2->query("delete from frwfm_application2s where fk_id = '".$id."' AND status ='pending'");
				if($reset){
					$this->FrwfmApplication->query("update frwfm_applications SET color = 0 WHERE `id` = '".$id."'");
					$this->Session->setFlash(__('The application has been reset!', true), '');
					$this->render('/elements/success');
				}else{
					$this->Session->setFlash(__('The application could not be reset', true), '');
					$this->render('/elements/failure');
				}
			}
		if (!empty($this->data))
			$id=$this->data['FrwfmApplication']['id'];
			$user = $this->Session->read();
			$this->loadModel('FrwfmApplication2');

				$arr = $this->FrwfmApplication2->query("SELECT *
				FROM  frwfm_applications
				INNER JOIN frwfm_application2s ON frwfm_applications.id = frwfm_application2s.fk_id
				WHERE frwfm_application2s.fk_id = '".$id."' AND frwfm_application2s.status ='pending'");
			if(!empty($arr)){
				$diff = array_diff_assoc($arr[0]['frwfm_application2s'],$arr[0]['frwfm_applications']);
				if($arr[0]['frwfm_application2s']['edited_by'] == $user['Auth']['User']['id']){
					$diff['disable'] = true;
					//$this->FrwfmApplication2->query("update frwfm_application2s SET status = 'Approved'  WHERE `fk_id` = '".$id."'");
				}else{
					$diff['disable'] = true;
				}
			}else
				$diff['disable'] = false;

		if (!empty($this->data)) {
			$this->autoRender = false;
			//debug($this->data);
			if(array_key_exists('edited_by',$this->data['FrwfmApplication'])){
			if($this->data['FrwfmApplication']['edited_by'] != $user['Auth']['User']['id']){
				$ct=$this->FrwfmApplication2->find('count',array('conditions'=>array('FrwfmApplication2.fk_id'=>$diff['fk_id'],'FrwfmApplication2.status'=>'Approved')));
				if($ct==0){//first modificaton
					$row = $this->FrwfmApplication->findById($diff['fk_id']);
					$xx=array();
					foreach($row['FrwfmApplication'] as $key=>$value){
						$xx['FrwfmApplication2'][$key]=$value;						
					}
					$xx['FrwfmApplication2']['status']='Original';
					$xx['FrwfmApplication2']['fk_id']=$diff['fk_id'];
					$xx['FrwfmApplication2']['id'] = NULL;
					$this->FrwfmApplication2->create(); // Create a new record
					$this->FrwfmApplication2->save($xx);
					
				}
				$this->FrwfmApplication2->query("update frwfm_application2s SET status = 'Approved', approved_by='".$user['Auth']['User']['id']."' WHERE `id` = '".$diff['id']."'");
				$updatable_fields=array('branch_id','remark','edited_by','date','name','mobile_phone','license','email','relation_with_bank','location_id','amount','mode_of_payment','types_of_goods','nbe_account_no','currency','proforma_invoice_no','proforma_date','desc_of_goods');
				foreach($diff as $key=>$value){
					if(in_array($key,$updatable_fields))
						$this->datax['FrwfmApplication'][$key]=$value;		
				}
				$this->datax['FrwfmApplication']['id']=$diff['fk_id'];
				
					$this->FrwfmApplication->save($this->datax);
					$this->FrwfmApplication->query("update frwfm_applications SET color = 0 WHERE `id` = '".$id."'");
					$this->Session->setFlash(__('The application has been saved', true), '');
					$this->render('/elements/success');
				}else{
					
				$this->Session->setFlash(__('The application could not be approved by the same person', true), '');
				$this->render('/elements/failure');
				}
			}else{				

			$this->loadModel('FrwfmApplication2');
		
			$this->datax['FrwfmApplication2']['edited_by'] = $user['Auth']['User']['id'];
			$this->datax['FrwfmApplication2']['fk_id'] = $this->data['FrwfmApplication']['id'];
			$this->datax['FrwfmApplication2']['branch_id'] = $this->data['FrwfmApplication']['branch_id'];
			$this->datax['FrwfmApplication2']['date'] = $this->data['FrwfmApplication']['date'];
			$this->datax['FrwfmApplication2']['name'] = $this->data['FrwfmApplication']['name'];
			$this->datax['FrwfmApplication2']['mobile_phone'] = $this->data['FrwfmApplication']['mobile_phone'];
			$this->datax['FrwfmApplication2']['license'] = $this->data['FrwfmApplication']['license'];
			$this->datax['FrwfmApplication2']['location_id'] = $this->data['FrwfmApplication']['location_id'];
			$this->datax['FrwfmApplication2']['email'] = $this->data['FrwfmApplication']['email'];
			$this->datax['FrwfmApplication2']['relation_with_bank'] = $this->data['FrwfmApplication']['relation_with_bank'];
			$this->datax['FrwfmApplication2']['amount'] = $this->data['FrwfmApplication']['amount'];
			$this->datax['FrwfmApplication2']['mode_of_payment'] = $this->data['FrwfmApplication']['mode_of_payment'];
			$this->datax['FrwfmApplication2']['types_of_goods'] = $this->data['FrwfmApplication']['types_of_goods'];
			$this->datax['FrwfmApplication2']['nbe_account_no'] = $this->data['FrwfmApplication']['nbe_account_no'];
			$this->datax['FrwfmApplication2']['currency'] = $this->data['FrwfmApplication']['currency'];
			$this->datax['FrwfmApplication2']['proforma_invoice_no'] = $this->data['FrwfmApplication']['proforma_invoice_no'];
			$this->datax['FrwfmApplication2']['proforma_date'] = $this->data['FrwfmApplication']['proforma_date'];
			$this->datax['FrwfmApplication2']['desc_of_goods'] = $this->data['FrwfmApplication']['desc_of_goods'];
			$this->datax['FrwfmApplication2']['remark'] = $this->data['FrwfmApplication']['remark'];

			$this->FrwfmApplication2->create();
			if($this->FrwfmApplication2->save($this->datax)){
				$this->FrwfmApplication->query("update frwfm_applications SET color = 1 WHERE `id` = '".$id."'");
				$this->Session->setFlash(__('The application has been saved', true), '');
				$this->render('/elements/success');
			}else {
				$this->Session->setFlash(__('The frwfm application could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			
		   }
		}
			
		$this->set('frwfm_application', $this->FrwfmApplication->read(null, $id));
		$this->set('arr2',$diff);
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->FrwfmApplication->Branch->find('list');
		$users = $this->FrwfmApplication->User->find('list');
		$locations = $this->FrwfmApplication->Location->find('list');
		$bra_name = $this->FrwfmApplication->Branch->find('all',array('recursive' => -1));
		$loc_name = $this->FrwfmApplication->Location->find('all',array('recursive' => -1));
		$this->set(compact('branches', 'users', 'locations','bra_name','loc_name'));
	}

	function post($id = null){
		$appls = $this->FrwfmApplication->read(null, $id);
		if($appls['FrwfmApplication']['status']=='Created' || $appls['FrwfmApplication']['status']=='Rejected'){
		$this->autoRender = false;
		$this->data['FrwfmApplication']['id']=$id;
		$this->data['FrwfmApplication']['status']='Posted';
		$this->FrwfmApplication->save($this->data);
		}
	}
	
	function remove($id = null){
	
	$this->set('frwfm_application', $this->FrwfmApplication->read(null, $id));
	
	if (!empty($this->data)) {
		$this->autoRender = false;
		//$this->FrwfmApplication->recursive = 1;
		$id=$this->data['FrwfmApplication']['id'];
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
	
		if($appls['FrwfmApplication']['status']!='Approved'){
			//$this->data['FrwfmApplication']['id']=$id;
			$this->data['FrwfmApplication']['status']='Canceled';
			//print_r($this->data);
			$this->FrwfmApplication->save($this->data);
			
			$returned=  $this->FrwfmApplication->query('UPDATE `frwfm_applications` SET `order`=`order`-1 WHERE `order` > '.$appls['FrwfmApplication']['order'].' AND (`status`=\'Accepted\' OR `status`=\'Presented for Approval\')');
									
			$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
			$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$this->data2['FrwfmEvent']['action']='Canceled';
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			$this->Session->setFlash(__('The request processed', true), '');
			$this->render('/elements/success');
		}
	}
	
	}
	function swap(){
	//hard coded excutable code
	/* uncomment when needed
	$this->autoRender = false;
	$id=927;
	$old=202;
	$appls = $this->FrwfmApplication->read(null, $id);
	$user = $this->Session->read();
	$this->data['FrwfmApplication']['id']=$id;
	$this->data['FrwfmApplication']['order']=0;
	$this->FrwfmApplication->save($this->data);
	
	$returned=  $this->FrwfmApplication->query('UPDATE `frwfm_applications` SET `order`=`order`-1 WHERE `order` > '.$old.' AND (`status`=\'Accepted\' OR `status`=\'Presented for Approval\')');
	
	$new=102;
	$this->data['FrwfmApplication']['id']=$id;
	$this->data['FrwfmApplication']['order']=$new;
	$this->FrwfmApplication->save($this->data);
	$new=$new-1;
	
	$returned=  $this->FrwfmApplication->query('UPDATE `frwfm_applications` SET `order`=`order`+1 WHERE `order` > '.$new.' AND (`status`=\'Accepted\' OR `status`=\'Presented for Approval\')');
	*/
	}
	function batchremove(){
	/*
		$this->autoRender = false;
		$conditions['FrwfmApplication.date <='] = "2015-12-31";
		$conditions["FrwfmApplication.status"]="Accepted";
		$this->FrwfmApplication->recursive=1;
		$apps= $this->FrwfmApplication->find('all', array('conditions' => $conditions,'order'=>'FrwfmApplication.order'));
		print_r($apps);
		$decrement=0;
	foreach($apps as $app){
		if($app['FrwfmApplication']['status']=='Accepted'){
			$this->data['FrwfmApplication']['id']=$app['FrwfmApplication']['id'];
			$this->data['FrwfmApplication']['status']='Canceled';
			$this->data['FrwfmApplication']['reason']='Management Decision Under Minute 8';
			$this->data['FrwfmApplication']['removal_date']="2016-02-03";
			$this->FrwfmApplication->save($this->data);
			
			$returned=  $this->FrwfmApplication->query('UPDATE `frwfm_applications` SET `order`=`order`-1 WHERE `order` > '.($app['FrwfmApplication']['order']-$decrement).' AND (`status`=\'Accepted\' OR `status`=\'Presented for Approval\')');
									
			$this->data2['FrwfmEvent']['frwfm_application_id']=$app['FrwfmApplication']['id'];
			$this->data2['FrwfmEvent']['user_id']='541';//Admin
			$this->data2['FrwfmEvent']['action']='Canceled';
			$this->FrwfmApplication->FrwfmEvent->create();
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			$decrement++;
		}
	 }
	 */
	}
	function approve($id = null){
		
		$creator='false';
		$user = $this->Session->read();
		$appls = $this->FrwfmApplication->read(null, $id);
		if(count($appls['FrwfmEvent'])>=1){
		if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['action']=='Presented for Approval' && $appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['user_id']==$user['Auth']['User']['id'])
		$creator='true';
		$this->set('creator',$creator);
		}
		$this->set('frwfm_application', $this->FrwfmApplication->read(null, $id));
		if (!empty($this->data)) {
		$this->autoRender = false;
		//$this->FrwfmApplication->recursive = 1;
		$id=$this->data['FrwfmApplication']['id'];
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
	
		if($appls['FrwfmApplication']['status']=='Accepted'){
			//$this->data['FrwfmApplication']['id']=$id;
			$this->data['FrwfmApplication']['status']='Presented for Approval';
			$this->FrwfmApplication->save($this->data);
						
			$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
			$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$this->data2['FrwfmEvent']['action']='Presented for Approval';
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			$this->Session->setFlash(__('The request processed', true), '');
			$this->render('/elements/success');
		}
		if($appls['FrwfmApplication']['status']=='Presented for Approval'){
		  if(count($appls['FrwfmEvent'])>=1){
			 if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['action']=='Presented for Approval' && $appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['user_id']!=$user['Auth']['User']['id']){
			$this->data['FrwfmApplication']['id']=$id;
			$this->data['FrwfmApplication']['status']='Approved';
			$this->FrwfmApplication->save($this->data);
			
			$returned=  $this->FrwfmApplication->query('UPDATE `frwfm_applications` SET `order`=`order`-1 WHERE `order` > '.$appls['FrwfmApplication']['order'].' AND (`status`=\'Accepted\' OR `status`=\'Presented for Approval\')');
			
			$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
			$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$this->data2['FrwfmEvent']['action']='Approved';
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			$this->Session->setFlash(__('The request processed', true), '');
			$this->render('/elements/success');
			
			$tel=$appls['FrwfmApplication']['mobile_phone'];
			//$messageEn="Dear Customer :-   Your Foreign currency request is approved. The Approved FCY is Valid until Feb 28, 2018 GC. if not it will be canceled automatically. - Abay Bank";
			//$messageAm="ውድ ደንበኛችን :-  የጠየቁት የውጭ ምንዛሬ የተፈቀደ መሆኑን እያሳወቅን የውጭ ምንዛሬውን መስራት የሚቻለው እስከ የካቲት 21 ቀን 2010 ዓ.ም ሲሆን አስከዚህ ቀን ድረስ ካልሰሩ የሚሰረዝ መሆኑን እናሳውቃለን:: - አባይ ባንክ";
			if($appls['FrwfmApplication']['sms_english']!=""){
			$messageEn=urlencode($appls['FrwfmApplication']['sms_english']);
			file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$messageEn);
			}
			if($appls['FrwfmApplication']['sms_amharic']!=""){
			$messageAm=urlencode($appls['FrwfmApplication']['sms_amharic']);		
			file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$messageAm);
			}
			
			}
			 if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['action']=='Presented for Approval' && $appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['user_id']==$user['Auth']['User']['id']){
					$this->FrwfmApplication->save($this->data);
					$this->Session->setFlash(__('The request processed', true), '');
					$this->render('/elements/success');
			 }
		   }
		  }
		 
		}
	
	}
	function accept($id = null){
			$this->autoRender = false;
		
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
		
	if($appls['FrwfmApplication']['status']=='Posted'){
				
			$statarr = array('Accepted', 'Presented for Approval');
			$conditions = array("OR" => array("FrwfmApplication.status" => $statarr));
			//$conditions['FrwfmApplication.status'] = 'Accepted';
			$accapp = $this->FrwfmApplication->find('count', array('conditions' => $conditions));
			
			$statarr2 = array('Accepted', 'Presented for Approval','Approved','Canceled');
			$conditions2 = array("OR" => array("FrwfmApplication.status" => $statarr2));
			//$conditions['FrwfmApplication.status'] = 'Accepted';
			$accapp2 = $this->FrwfmApplication->find('count', array('conditions' => $conditions2));
			
			$datasource = $this->FrwfmApplication->FrwfmEvent->getDataSource();
			$datasource->begin($this->FrwfmApplication->FrwfmEvent);

			$data2['FrwfmEvent'] = array();
			$data2['FrwfmEvent']['frwfm_application_id']=$id;
			$data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$data2['FrwfmEvent']['action']='Accepted';
			
			$data['FrwfmApplication'] = array();
			$data['FrwfmApplication']['id']=$id;
			$data['FrwfmApplication']['status']='Accepted';
			$data['FrwfmApplication']['order']=$accapp+1;
			$data['FrwfmApplication']['initial_order']=$accapp2+1;
			$data['FrwfmApplication']['approved_date']='2200-01-01';
			
			if($this->FrwfmApplication->FrwfmEvent->save($data2)){
				if($this->FrwfmApplication->save($data)){
					$datasource->commit($this->FrwfmApplication->FrwfmEvent);	
			$tel=$appls['FrwfmApplication']['mobile_phone'];
			$spaceline="                                                                                                                                              ";
			$messageEn="Dear Customer, ".$spaceline."We are very glad to inform you that the registration number of your Foreign currency request value ".$appls['FrwfmApplication']['amount'].$appls['FrwfmApplication']['currency']." is ".$data['FrwfmApplication']['initial_order'].$spaceline." Thank you for choosing us.".$spaceline." Abay Bank S.C.";
			
			$messageEn=urlencode($messageEn);
			
			//file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$messageEn);
			$subject="FC request status update";
			$message="The Forency Currency you requested on AbayERP on ".date('Y-m-d',strtotime($appls['FrwfmApplication']['created']))." for client ".$appls['FrwfmApplication']['name']." is now Accepted. AbayERP ";
			$message=str_replace(":"," ",$message);
			$message=str_replace(";"," ",$message);
			$url='dms/dms_messages/auth_send/'.$user['Auth']['User']['id'].'/'.$appls['FrwfmApplication']['user_id'].'/'.$subject.'/'.$message.'/1';			
			$this->requestAction($url);					
				}else{
					$this->log($this->FrwfmApplication->validationErrors, 'debug');
					 $datasource->rollback($this->FrwfmApplication->FrwfmEvent);
				}
			}
		}
	}
	
	function accept_two_tier($id = null){
		$this->autoRender = false;
		
		//$this->FrwfmApplication->recursive = 1;
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
		
	if($appls['FrwfmApplication']['status']=='Posted'){
	
	if(count($appls['FrwfmEvent'])>=1){
	if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['action']=='Pending Acceptance'){
	if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['user_id']!=$user['Auth']['User']['id']){
				
			$statarr = array('Accepted', 'Presented for Approval');
			$conditions = array("OR" => array("FrwfmApplication.status" => $statarr));
			//$conditions['FrwfmApplication.status'] = 'Accepted';
			$accapp = $this->FrwfmApplication->find('count', array('conditions' => $conditions));
			
			$statarr2 = array('Accepted', 'Presented for Approval','Approved','Canceled');
			$conditions2 = array("OR" => array("FrwfmApplication.status" => $statarr2));
			//$conditions['FrwfmApplication.status'] = 'Accepted';
			$accapp2 = $this->FrwfmApplication->find('count', array('conditions' => $conditions2));
			
			
			$datasource = $this->FrwfmApplication->FrwfmEvent->getDataSource();
			$datasource->begin($this->FrwfmApplication->FrwfmEvent);

			$data2['FrwfmEvent'] = array();
			$data2['FrwfmEvent']['frwfm_application_id']=$id;
			$data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$data2['FrwfmEvent']['action']='Accepted';
			
			
			$data['FrwfmApplication'] = array();
			$data['FrwfmApplication']['id']=$id;
			$data['FrwfmApplication']['status']='Accepted';
			$data['FrwfmApplication']['order']=$accapp+1;
			$data['FrwfmApplication']['initial_order']=$accapp2+1;
			$data['FrwfmApplication']['approved_date']='2200-01-01';
			
	
			if($this->FrwfmApplication->FrwfmEvent->save($data2)){
				if($this->FrwfmApplication->save($data)){
					$datasource->commit($this->FrwfmApplication->FrwfmEvent);	
			$tel=$appls['FrwfmApplication']['mobile_phone'];
			$spaceline="                                                                                                                                              ";
			$messageEn="Dear Customer, ".$spaceline."We are very glad to inform you that the registration number of your Foreign currency request value ".$appls['FrwfmApplication']['amount'].$appls['FrwfmApplication']['currency']." is ".$data['FrwfmApplication']['initial_order'].$spaceline." Thank you for choosing us.".$spaceline." Abay Bank S.C.";
			
			$messageEn=urlencode($messageEn);
			
			//file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$messageEn);
			$subject="FC request status update";
			$message="The Forency Currency you requested on AbayERP on ".date('Y-m-d',strtotime($appls['FrwfmApplication']['created']))." for client ".$appls['FrwfmApplication']['name']." is now Accepted. AbayERP ";
			$message=str_replace(":"," ",$message);
			$message=str_replace(";"," ",$message);
			$url='dms/dms_messages/auth_send/'.$user['Auth']['User']['id'].'/'.$appls['FrwfmApplication']['user_id'].'/'.$subject.'/'.$message.'/1';			
			$this->requestAction($url);					
				}else{
					$this->log($this->FrwfmApplication->validationErrors, 'debug');
					 $datasource->rollback($this->FrwfmApplication->FrwfmEvent);
				}
			}

	}}else goto frst; 
	}else{	
	frst:
		$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
		$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
		$this->data2['FrwfmEvent']['action']='Pending Acceptance';
		$this->FrwfmApplication->FrwfmEvent->save($this->data2);
		
		$subject="FC request status update";
		$message="The Forency Currency you requested on AbayERP on ".date('Y-m-d',strtotime($appls['FrwfmApplication']['created']))." for client ".$appls['FrwfmApplication']['name']." is now on pending acceptance. AbayERP ";
		$message=str_replace(":"," ",$message);
		$message=str_replace(";"," ",$message);
		$url='dms/dms_messages/auth_send/'.$user['Auth']['User']['id'].'/'.$appls['FrwfmApplication']['user_id'].'/'.$subject.'/'.$message;			
		$this->requestAction($url);
	}
	}
	
	}
	function reject_two_tier($id = null){
		$this->autoRender = false;
		
		//$this->FrwfmApplication->recursive = 1;
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
		
		if($appls['FrwfmApplication']['status']=='Posted'){
			//$this->data['FrwfmApplication']['id']=$id;
			//$this->data['FrwfmApplication']['status']='Pending Rejection';
			//$this->FrwfmApplication->save($this->data);
			
			
			$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
			$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$this->data2['FrwfmEvent']['action']='Pending Rejection';
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			
		}elseif($appls['FrwfmApplication']['status']=='Pending Rejection'){
			if(count($appls['FrwfmEvent'])>=1){
				if($appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['action']=='Pending Rejection' && $appls['FrwfmEvent'][count($appls['FrwfmEvent'])-1]['user_id']!=$user['Auth']['User']['id']){
				
					$this->data['FrwfmApplication']['id']=$id;
					$this->data['FrwfmApplication']['status']='Rejected';
					$this->FrwfmApplication->save($this->data);
					
					
					$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
					$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
					$this->data2['FrwfmEvent']['action']='Rejected';
					$this->FrwfmApplication->FrwfmEvent->save($this->data2);
				}
			}
		}
	
	}
	function reject($id = null){
		
		$this->set('frwfm_application', $this->FrwfmApplication->read(null, $id));
		if (!empty($this->data)) {
		$this->autoRender = false;
		
		//$this->FrwfmApplication->recursive = 1;
		$id=$this->data['FrwfmApplication']['id'];
		$appls = $this->FrwfmApplication->read(null, $id);
		
		$user = $this->Session->read();
		
		if($appls['FrwfmApplication']['status']=='Posted'){
			$this->data['FrwfmApplication']['id']=$id;
			$this->data['FrwfmApplication']['status']='Rejected';
			$this->data['FrwfmApplication']['approved_date']='2200-01-01';
			$this->FrwfmApplication->save($this->data);
			
			
			$this->data2['FrwfmEvent']['frwfm_application_id']=$id;
			$this->data2['FrwfmEvent']['user_id']=$user['Auth']['User']['id'];
			$this->data2['FrwfmEvent']['action']='Rejected';
			$this->data2['FrwfmEvent']['remark']=$this->data['FrwfmApplication']['rejection_reason'];
			$this->FrwfmApplication->FrwfmEvent->save($this->data2);
			
			$subject="FC request status update";
			$message="The Forency Currency you requested on AbayERP on ".date('Y-m-d',strtotime($appls['FrwfmApplication']['created']))." for client ".$appls['FrwfmApplication']['name']." is rejected for the following reason - ".$this->data['FrwfmApplication']['rejection_reason']." AbayERP";
			$message=str_replace(":"," ",$message);
			$message=str_replace(";"," ",$message);
			$url='dms/dms_messages/auth_send/'.$user['Auth']['User']['id'].'/'.$appls['FrwfmApplication']['user_id'].'/'.$subject.'/'.$message.'/1';			
			$this->requestAction($url);
			
			$this->Session->setFlash(__('The request is processed', true), '');
			$this->render('/elements/success');
			
		}
		}
	}
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for frwfm application', true), '');
			$this->render('/elements/failure');
		}
		$appls = $this->FrwfmApplication->read(null, $id);
		if($appls['FrwfmApplication']['status']=='Created' || $appls['FrwfmApplication']['status']=='Rejected'){			
			if (stripos($id, '_') !== false) {
				$ids = explode('_', $id);
				try{
					foreach ($ids as $i) {
						$this->FrwfmApplication->delete($i);
					}
					$this->Session->setFlash(__('Frwfm application deleted', true), '');
					$this->render('/elements/success');
				}
				catch (Exception $e){
					$this->Session->setFlash(__('Frwfm application was not deleted', true), '');
					$this->render('/elements/failure');
				}
			} else {
				if ($this->FrwfmApplication->delete($id)) {
					$this->Session->setFlash(__('Frwfm application deleted', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('Frwfm application was not deleted', true), '');
					$this->render('/elements/failure');
				}
			}
		}
	}
}
?>